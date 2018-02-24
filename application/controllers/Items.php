<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('item','brand','billings','accounts','product'),'',TRUE);

		$cart_check = $this->cart->contents();
		if(!empty($cart)) {
			foreach ($cart as $item){
				if($item['order_type'] != 'P')
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

	public function index()
	{
		if($this->session->userdata('logged_in')){
		$search = $this->input->get('search');		
		$config = array();
        $config["base_url"] = base_url() . 'items/index';
        $config["total_rows"] = $this->item->item_count($search);
        
        include APPPATH.'config/pagination.php';
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->item->
            get_items($config["per_page"], $page,$search);
        $data["links"] = $this->pagination->create_links();
 
				$this->load->view('item/view',$data);
			
			
		}else{
			redirect(base_url(''));
		}
	}

	public function create()
	{
		if($this->session->userdata('logged_in')){

		$this->form_validation->set_rules('item_name','item Name','required|trim|xss_clean|callback_get_item_name');
		$this->form_validation->set_rules('brand','Brand Name','required|trim|xss_clean');
		$this->form_validation->set_rules('stock_indicators','stock indicator','required|trim|xss_clean');

			if($this->form_validation->run()==FALSE){
				$data['brand'] = $this->brand->load_brand();
				$this->load->view('item/create',$data);
			}else{
				$this->item->add();
				redirect('items');
			}
			
		}else{
			redirect('login');
		}


	}

	public function edit($id)
	{
		if($this->session->userdata('logged_in')){

			$this->form_validation->set_rules('item_name','item Name','required|trim|xss_clean');
			$this->form_validation->set_rules('brand','Brand Name','required|trim|xss_clean');
			$this->form_validation->set_rules('stock_indicators','stock indicator','required|trim|xss_clean');
			if($this->form_validation->run()==FALSE){

				$data['records'] = $this->item->fetch_item($id);
				$data['brand'] = $this->brand->load_brand();
				$this->load->view('item/edit',$data);
			}else{
				$id=$this->input->post('did');
				$data=array('item_name'=>$this->input->post('item_name'),
							'status'=>$this->input->post('status'),
							'stock_indicators'=>$this->input->post('stock_indicators'),
							'brand_id'=>$this->input->post('brand'),
					);
				$this->item->edit($id,$data);
				redirect('items');
			}
		}
	}

	function alpha_dash_space($str)
	{
	    return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	} 

	function get_item_name($item_name)
	{
		$result = $this->item->check_item($item_name);
		if($result==TRUE)
			{ 
				$this->form_validation->set_message('get_item_name','That item name is already in use');
				
				return FALSE;
			}else{
					return TRUE;
			}
	}

	function updated_status()
	{
		$data =$this->input->post('item_check');
		$Update = $this->input->post('Update');
		$Delete = $this->input->post('Delete');			  

		for($i = 0; $i < sizeof($data); $i++){
			if(isset($Update))
			{
				$this->db->set('status',$this->input->post('status'));
			}

			if(isset($Delete))
			{
				$this->db->set('deleted',0);
			}
			$this->db->where('id',$data[$i]);
			$this->db->update('item');

		}
		redirect('items');
	}

	public function purchase()
	{
		if($this->session->userdata('logged_in'))
		{	
			$config = array();
	        $config["base_url"] = base_url() . 'items/purchase';
	        $config["total_rows"] = $this->billings->item_count();
	        
	        include APPPATH.'config/pagination.php';
	        $this->pagination->initialize($config);
	 
	        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data['items'] = $this->billings->get_all_items($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
	 
			$data['order_type']= 'P';
			$this->load->view('item/purchase',$data);
		}else{
			redirect(base_url());
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
				redirect('items/purchase');
		}else{
			redirect(base_url(''));
		}		
	}

	function remove($rowid)
	{
		$data = array(
						'rowid' => $rowid,
						'qty' => 0
						);
		// Update cart data, after cancel.
		$this->cart->update($data);

		redirect('items/purchase');
	}

	function remove_all() 
	{
		$this->cart->destroy();
		
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
				'order_type' => 'P',
				'qty' => 1
			);
		
			// This function add items into cart.
			$this->cart->insert($insert_data);
		
			
			redirect('items/purchase');
		}
	}

	public function order_view()
	{
		if($this->session->userdata('logged_in')){

		$config = array();
        $config["base_url"] = base_url() . 'items/order_view';
        $config["total_rows"] = $this->item->details_count();
        
        include APPPATH.'config/pagination.php';
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->item->get_details($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();
 
				$this->load->view('item/order_view',$data);
			
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
		        $config['first_url'] = base_url() . 'items/search?keyword=' . $delimiters['keyword'];
		        $config["base_url"] = base_url() . 'items/search';
       			$config['suffix']      = '?keyword=' . $delimiters['keyword'];
				$config["total_rows"] = $this->billings->search_count($delimiters['keyword']);
				include APPPATH.'config/pagination.php';
		        $this->pagination->initialize($config);
		        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
				$data['products'] = $this->item->get_search($config["per_page"], $page,$delimiters['keyword']);
				$data["links"] = $this->pagination->create_links();
			}else{
				$data['products'] = array();
				$data['links'] = NULL;
			}

			$this->load->view('item/search',$data);

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
		$this->load->view('item/order_details',$data);

		}else{
			redirect(base_url(''));
		}	
	}

	public function reciept()
	{
		if($this->session->userdata('logged_in'))
		{	
			$this->load->view('item/billing');
		}else{
			redirect(base_url(''));
		}		
	}

	public function search_accaunt()
	{
		if($this->session->userdata('logged_in')){

		 	$term = $this->input->get('term');
		 	$lable = $this->input->get('lable');
		 	$accounts = $this->item->get_accaunt_search($term,$lable);
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
				
			$order_type = 'P';	
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

			

			if($order_type == 'P'):
				if ($cart = $this->cart->contents()):
					foreach ($cart as $item):
						$remaining_item = $this->product->get_item_quantity($item['id']);
						$this->db->set('Quantity',$remaining_item['Quantity']+$item['qty'],FALSE);
						$this->db->where('id',$item['id']);
						$this->db->update('item');
						echo $this->db->last_query();
;					endforeach;
				endif;
			endif;
			
			$this->session->set_flashdata('message','Transaction is Finished');
			$this->remove_all();
			
			redirect('items/view_id/'.$ord_id);
			
		}else{
			redirect(base_url(''));
		}	
	}
}