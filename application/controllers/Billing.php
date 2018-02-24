<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('product','brand','category','billings','accounts'),'',TRUE);

		$cart_check = $this->cart->contents();
		if(!empty($cart)) {
			foreach ($cart as $item){
				if($item['order_type'] != 'S')
				{
					$data = array(
									'rowid' => $item['rowid'],
									'qty' => 0
									);
					// Update cart data, after cancel.
					$this->cart->update($data);
				}
			}
		}
	}


	public function index($error = [])
	{
		if($this->session->userdata('logged_in'))
		{	
			$config = array();
	        $config["base_url"] = base_url() . 'billing/index';
	        $config["total_rows"] = $this->billings->product_count();
	        
	        include APPPATH.'config/pagination.php';
	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['products'] = $this->billings->get_all($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
	 		$data["error"] = $error;
			$data['order_type']= 'S';	
			$this->load->view('order/order',$data);
		}else{
			redirect(base_url());
		}
	}

	public function items()
	{
		if($this->session->userdata('logged_in'))
		{	
			$config = array();
	        $config["base_url"] = base_url() . 'billing/items';
	        $config["total_rows"] = $this->billings->item_count();
	        
	        include APPPATH.'config/pagination.php';
	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['items'] = $this->billings->get_all_items($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
	 
			$data['order_type']= 'P';
			$this->load->view('order/order',$data);
		}else{
			redirect(base_url());
		}
	}

	function add()
	{
		// Set array for send data.
		if($this->session->userdata('logged_in')){
			$insert_data = array(
				'id' => $this->input->post('id'),
				'name' => $this->input->post('name'),
				'price' => $this->input->post('price'),
				'brand_name' => $this->input->post('brand_name'),
				'order_type' => $this->input->post('order_type'),
				'qty' => 1
			);
		
			// This function add items into cart.
			$this->cart->insert($insert_data);
		
			// This will show insert data in cart.
			if($this->input->post('order_type') == 'P')
			{
				redirect('items/purchase');
			}
			else
			{
				redirect('billing');
			}
			
		}
	}

	function update_cart()
	{
		if($this->session->userdata('logged_in'))
		{	
				$cart_info = $_POST['cart'] ;
				$order_type = '';

				

				foreach( $cart_info as $id => $cart)
				{
					$rowid = $cart['rowid'];
					$price = $cart['price'];
					$amount = $price * $cart['qty'];
					$qty = $cart['qty'];
					$brand_name = $cart['brand_name'];
					$order_type = $cart['order_type'];

		
					$data = array(
					'rowid' => $rowid,
					'price' => $price,
					'brand_name' =>$brand_name,
					'order_type' => $order_type,
					'amount' => $amount,
					'qty' => $qty
					);
					
					$this->cart->update($data);
				}

				if($order_type == 'P'){
					redirect('billing/items');
				}
				else{
					redirect('billing');
				}
		}else{
			redirect(base_url(''));
		}		
	}
		
	function remove($rowid) 
	{
					// Check rowid value.
					if ($rowid==="all"){
						// Destroy data which store in session.
						$this->cart->destroy();
					}else{
						// Destroy selected rowid in session.
						$data = array(
						'rowid' => $rowid,
						'qty' => 0
						);
						// Update cart data, after cancel.
						$this->cart->update($data);
					}
					// This will show cancel data in cart.
					redirect('billing');
	}

	

				
	public function reciept()
	{
		if($this->session->userdata('logged_in'))
		{	
			$error = [];
			if ($cart = $this->cart->contents()){
				
				foreach ($cart as $item):
					
					$data = $this->billings->get_product_by_id($item['id']);
					if($data['Quantity'] < $item['qty'])
					{
						$error[] = "product quality is out of stock please reduce by ".($item['qty']- $data['Quantity']);
					}
				endforeach;	

			}
			
			if(count($error) > 0){
				$this->index($error);
			}
			else
				$this->load->view('order/billing');
		}else{
			redirect(base_url(''));
		}		
	}

	public function save_order()
	{
		if($this->session->userdata('logged_in'))
		{
			// This will store all values which inserted from user.

			if($this->input->post('account_id')){
				$cust_id = $this->input->post('account_id');
			}
			else{						
				$cust_id =$this->accounts->registered();
			}
			// And store user information in database.
			
			if ($cart = $this->cart->contents()):
				
			$order_type = 'S';
			$grand_total = 0;	
			foreach ($cart as $item):
				$order_type = $item['order_type'];
				$grand_total = $grand_total + $item['subtotal'];

			endforeach;	
			$vat= $this->input->post('tax') * $grand_total/100;
			$total= $grand_total+$vat;
			

			$order = array(
			'date' => date('Y-m-d'),
			'account_id' => $cust_id,
			'did'=>$this->input->post('did'),
			'payment'=>$this->input->post('payment'),
			'received_amount'=>$this->input->post('received_amount'),
			'total_amount'=>$total,
			'grand_total'=>$grand_total,
			'due_payment'=>$total - $this->input->post('received_amount'),
			'tax'=>$this->input->post('tax'),
			'Eway'=>$this->input->post('Eway'),
			'comment'=>$this->input->post('comment'),
			'duedate'=>$this->input->post('duedate'),
			'delivered_staus'=>$this->input->post('delivered_staus'),
			'payment_status'=>$this->input->post('payment_status'),
			'order_type'=>$order_type
			);

			

			$ord_id = $this->billings->insert_order($order);
				foreach ($cart as $item):

					$order_detail = array(
						'order_id' => $ord_id,
						'product_id' => $item['id'],
						'qty' => $item['qty'],
						'price' => $item['price']
					);

					// Insert product imformation with order detail, store in cart also store in database.

					$cust_id = $this->billings->final_order_detail($order_detail);
				endforeach;
			endif;

			if($order_type == 'S'):
				if ($cart = $this->cart->contents()):
					foreach ($cart as $item):
						$this->db->set('Quantity','Quantity -'.$item['qty'],FALSE);
						$this->db->where('id',$item['id']);
						$this->db->update('product');

					endforeach;
				endif;
			endif;

			if($order_type == 'P'):
				if ($cart = $this->cart->contents()):
					foreach ($cart as $item):
						$this->db->set('Quantity','Quantity +'.$item['qty'],FALSE);
						$this->db->where('id',$item['id']);
						$this->db->update('item');
					endforeach;
				endif;
			endif;
				
			$this->cart->destroy();
			
			redirect('billing/view_id/'.$ord_id);
		}else{
			redirect(base_url(''));
		}	
	}

	public function view()
	{
		if($this->session->userdata('logged_in')){

		$config = array();
        $config["base_url"] = base_url(). 'billing/view';
        $config["total_rows"] = $this->billings->details_count();
        
        include APPPATH.'config/pagination.php';
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->billings->get_details($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
 
				$this->load->view('order/view',$data);
			
		}else{
			redirect(base_url(''));
		}
	
	}

	public function view_id($oid)
	{
		if($this->session->userdata('logged_in')){

		$data['qty'] = $this->billings->get_qty($oid);
		$data['sum'] = $this->billings->get_sum($oid);
		$data['results'] = $this->billings->fetch_order_details($oid);
		$data['customer'] = $this->billings->fetch_account_details($oid);
		$this->load->view('order/order_details',$data);

		}else{
			redirect(base_url(''));
		}	
	}

	public function search()
	{	
		if($this->session->userdata('logged_in')){

		 $delimiters['keyword'] = $this->input->get('keyword');


		if($delimiters['keyword']!=null){
			$config = array();
		        $delimiters['keyword'] = $this->input->get('keyword');
		        $config['first_url'] = base_url() . 'billing/search?keyword=' . $delimiters['keyword'];
		        $config["base_url"] = base_url() . 'billing/search';
       			$config['suffix']      = '?keyword=' . $delimiters['keyword'];
				$config["total_rows"] = $this->billings->search_count($delimiters['keyword']);
				        

				include APPPATH.'config/pagination.php';
		       
		        $this->pagination->initialize($config);
		 
		        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$data['products'] = $this->billings->get_search($config["per_page"], $page,$delimiters['keyword']);
				$data["links"] = $this->pagination->create_links();
		 
					
				
		}else{
			$data['products'] = array();
			$data['links'] = NULL;
			
		}

		$this->load->view('order/search',$data);

		}else{
				redirect(base_url(''));
			}	
	}

	public function search_accaunt()
	{
		if($this->session->userdata('logged_in')){

		 	$term = $this->input->get('term');
		 	$lable = $this->input->get('lable');
		 	$accounts = $this->billings->get_accaunt_search($term,$lable);
		 	if(count($accounts) > 0){
				header('Content-Type: application/json');
				echo json_encode($accounts);
		 	}
			else
			{
				header('HTTP/1.1 500 Internal Server Booboo');
		        header('Content-Type: application/json; charset=UTF-8');
		        die(json_encode(array('message' => 'Not Found', 'code' => '')));
			}
			exit();
		}
		else
		{
			redirect(base_url(''));
		}
	}

	
}