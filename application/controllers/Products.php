<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('product','brand','category','item'),'',TRUE);
	}

	public function index()
	{
		if($this->session->userdata('logged_in')){
		$search = $this->input->get('search');	
		$config = array();
        $config["base_url"] = base_url() . "products/index";
        $config["total_rows"] = $this->product->product_count($search);
        
        include APPPATH.'config/pagination.php';
        $this->pagination->initialize($config);
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->product->get_products($config["per_page"], $page,$search);
        $data["links"] = $this->pagination->create_links();
			$this->load->view('products/view',$data);
		}else{
			redirect(base_url(''));
		}
	}

	public function create()
	{
		if($this->session->userdata('logged_in')){

			$this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean|callback_alpha_dash_space|is_unique[product.product_name]');
			$this->form_validation->set_rules('stock','Stock','trim|xss_clean|numeric');
			$this->form_validation->set_rules('stock_indicators','stock indicator','trim|xss_clean|numeric');

			$this->form_validation->set_rules('price[]','price','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('item_id[]','item_id','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('quantity[]','quantity','required|trim|xss_clean|numeric');

			$this->form_validation->set_rules('total_price','total_price','required|trim|xss_clean|numeric');
			$this->form_validation->set_rules('comment','comment','trim|xss_clean');
			$error = array();
			
			$stock = $this->input->post('stock');
			$stock_indicators = $this->input->post('stock_indicators');
			$item_id = $this->input->post('item_id');
			$quantity = $this->input->post('quantity');

			if(isset($_POST['item_id']) && $_POST['item_id'] && $_POST['stock']){

				$new_item = array();
				foreach ($item_id as $key => $value) {
					if(isset($new_item[$value]))
						$new_item[$value] = $new_item[$value] + $quantity[$key];
					else
						$new_item[$value] = $quantity[$key];
				}

				foreach($new_item as $key => $value) {
					
					$remaining_item = $this->product->get_item_quantity($key);
					if($remaining_item['Quantity'] < ($value*$stock))
					{
						$error[] = $remaining_item['item_name'].' is out of stock. available '.($remaining_item['Quantity']).' items  in stock so plese select accordingly.';
					}

				}
			}
			
			if($this->form_validation->run()==FALSE || count($error) > 0){
				$data['error'] = $error;
				$data['items'] = $this->item->load_item();
				$data['brand'] = $this->brand->load_brand();
				$data['category']=$this->category->load_category();
				$this->load->view('products/create',$data);
			}else{
				
				$id = $this->product->add();
				$this->product->add_item($id);

				foreach ($new_item as $key => $value) {
						$remaining_item = $this->product->get_item_quantity($key);
						$value = $value * $stock;
						$Quantity = $remaining_item['Quantity'] - $value;
						$item_quantity = array('Quantity'=>$Quantity);
						$this->item->edit($key,$item_quantity);
					
				}

				redirect('products');
			}
			
		}else{
			redirect('login');
		}
	}

	public function edit($id)
	{
		if($this->session->userdata('logged_in')){
        
        $data['records'] = $productData = $this->product->fetch_product($id);

        $item_records = $this->product->fetch_product_item($id);
        
        $data['item_records'] = $item_records = json_decode(json_encode($item_records), true);
        
        	

        if($this->input->post('product_name') != $data['records'][0]->product_name) {        $is_unique =  '|is_unique[product.product_name]';     } else {        $is_unique =  '';     }

		$this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean'.$is_unique);
		$this->form_validation->set_rules('stock','Stock','trim|xss_clean|numeric');
		$this->form_validation->set_rules('stock_indicators','stock indicator','trim|xss_clean|numeric');

		$this->form_validation->set_rules('price[]','price','required|trim|xss_clean|numeric');
		$this->form_validation->set_rules('item_id[]','item_id','required|trim|xss_clean|numeric');
		$this->form_validation->set_rules('quantity[]','quantity','required|trim|xss_clean|numeric');

		$this->form_validation->set_rules('total_price','total_price','required|trim|xss_clean|numeric');
		$this->form_validation->set_rules('comment','comment','trim|xss_clean');
		$error = array();
		$stock = $this->input->post('stock');
		$stock_indicators = $this->input->post('stock_indicators');
		$oldStock = $productData[0]->Quantity;
		if(isset($_POST['item_id']) && $_POST['item_id'] && $_POST['stock']){
			

			$item_old_ids = array_column($item_records,'item_id');
			$old_quantity = array_column($item_records,'quantity');
		/*	echo 'old item ';
			print_r($item_old_ids);
			echo 'old_quantity ';
			print_r($old_quantity);*/
			$old_item = array();

			foreach ($item_old_ids as $key => $value) {
				if(isset($old_item[$value]))
				$old_item[$value] = $old_item[$value] + $old_quantity[$key];
				else
				$old_item[$value] = $old_quantity[$key];
			}

			foreach ($old_item as $key => $value) {
				$old_item[$key] = $value * $oldStock;
			}
    
    		/*echo 'old_mix ';
			print_r($old_item);*/

			

			/*ksort($old_item);
			print_r($old_item);*/
			
			$item_id = $this->input->post('item_id');
			$quantity = $this->input->post('quantity');
			/*echo  "new item_id";
			print_r($item_id);
			
			echo  "new quantity";
			print_r($quantity);*/
			$new_item = array();

			foreach ($item_id as $key => $value) {
				if(isset($new_item[$value]))
				$new_item[$value] = $new_item[$value] + $quantity[$key];
				else
				$new_item[$value] = $quantity[$key];
			}

			foreach ($new_item as $key => $value) {
				$new_item[$key] = $value * $stock;
			}



			/*echo 'new_mix ';
			print_r($new_item);
			ksort($new_item);
			print_r($new_item);*/
			
			foreach ($old_item as $key => $value) {
				if(isset($new_item[$key]))
				{
					if($new_item[$key] > $value)
					{
						$extra_new_item = $new_item[$key] - $value ;
						$remaining_item = $this->product->get_item_quantity($key);
						if($remaining_item['Quantity'] < $extra_new_item)
						{
							$error[] = $remaining_item['item_name'].' is out of stock. available '.($remaining_item['Quantity']+$value).' items  in stock so plese select accordingly.';
						}
					}
				}
			}

			foreach ($new_item as $key => $value) {
				if(!isset($old_item[$key]))
				{
					$remaining_item = $this->product->get_item_quantity($key);
					if($remaining_item['Quantity'] < $value)
					{
						$error[] = $remaining_item['item_name'].' is out of stock. available '.$remaining_item['Quantity'].' items  in stock so plese select accordingly.';
					}
				}
			}


		
		}

		

		if($this->form_validation->run()==FALSE || count($error) > 0){
			
			/*print_r($error);*/
			$data['items'] = $this->item->load_item();
			$data['brand'] = $this->brand->load_brand();
			$data['category']=$this->category->load_category();
			$data['error'] = $error;
			//print_r($data);
			//exit('fail');
		  
		    $this->load->view('products/edit',$data);
		}else{

			
			

			
			$id=$this->input->post('pid');
			$cstock = $this->input->post('cstock');
			
			
			//$stock =$cstock+$nstock;
			$data=array(
					 'category_id'=>$this->input->post('category'),
					 'brand_id'=>$this->input->post('brand'),
					 'Quantity'=>$stock,
					 'stock_indicators'=>$stock_indicators,
					 'price'=>$this->input->post('total_price'),
					 //'status'=>$this->input->post('status'),
					 'comment'=>$this->input->post('comment')

					 );
			$this->product->edit($id,$data);

			$this->product->delete_product_item($id);

			$this->product->add_item($id);

			

			foreach ($old_item as $key => $value) {
				if(isset($new_item[$key]))
				{
					$remaining_item = $this->product->get_item_quantity($key);				
					if($new_item[$key] > $value)
					{

						$extra_new_item =$new_item[$key] - $value;
						$Quantity = $remaining_item['Quantity'] - $extra_new_item;
						$item_quantity = array('Quantity'=>$Quantity);
						$this->item->edit($key,$item_quantity); 
					}
					if($new_item[$key] < $value)
					{
						$extra_new_item = $value - $new_item[$key];
						$Quantity = $remaining_item['Quantity'] + $extra_new_item;
						$item_quantity = array('Quantity'=>$Quantity);
						$this->item->edit($key,$item_quantity);
					}
				}

			}

			foreach ($new_item as $key => $value) {
				if(!isset($old_item[$key]))
				{
					$remaining_item = $this->product->get_item_quantity($key);
					$Quantity = $remaining_item['Quantity'] - $value;
					$item_quantity = array('Quantity'=>$Quantity);
					$this->item->edit($key,$item_quantity);
				}
			}

			/*$items = $this->product->get_product_items_quantity($id);

			foreach ($items as $key => $value) {
				$item_result = $this->item->fetch_item($value['item_id']);
				$restore_item = $item_result[0]->Quantity+$value['quantity'];
				$item_data['Quantity'] = $restore_item;
				$this->item->edit($value['item_id'],$item_data);
			}*/

			

			/*$items = $this->product->get_product_items_quantity($id);

			foreach ($items as $key => $value) {
				$item_result = $this->item->fetch_item($value['item_id']);
				$restore_item = $item_result[0]->Quantity-$value['quantity'];
				$item_data['Quantity'] = $restore_item;
				$this->item->edit($value['item_id'],$item_data);
			}*/


			redirect('products');
		}
		}
	}

	function check_item_quantity()
	{

	}

	function alpha_dash_space($str)
	{
	    return ( ! preg_match("/^([-a-z0-9_ ])+$/i", $str)) ? FALSE : TRUE;
	} 

	function update_status()
	{
		$data =$this->input->post('pro_status');
					  
		for($i = 0; $i < sizeof($data); $i++){
			//print_r($data[$i]);
			$this->db->set('status',$this->input->post('status'));
			$this->db->where('id',$data[$i]);
			$this->db->update('product');

		}
		redirect('products');
	}

	function delete()
	{
		$pid =$this->input->post('pid');
					  
		for($i = 0; $i < sizeof($pid); $i++){

			$items = $this->product->get_product_items_quantity($pid[$i]);

			foreach ($items as $key => $value) {
				$item_result = $this->item->fetch_item($value['item_id']);
				$restore_item = $item_result[0]->Quantity+$value['quantity'];
				$item_data['Quantity'] = $restore_item;
				$this->item->edit($value['item_id'],$item_data);
			}

			
			$this->product->delete_product_item($pid[$i]);
			$this->product->delete_product($pid[$i]);
			
		}
		redirect('products');
	}

	

}