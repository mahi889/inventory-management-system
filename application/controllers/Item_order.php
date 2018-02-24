<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Item_order extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('product','brand','category','item','accounts'),'',TRUE);
	}
	public function index()
	{
		if($this->session->userdata('logged_in')){
			$config = array();
			$config["base_url"] = base_url() . "item_order/index";
			$config["total_rows"] = $this->product->product_count();
			include APPPATH.'config/pagination.php';
			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["results"] = $this->product->get_item_order($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
			$this->load->view('item_order/view',$data);
		}else{
			redirect(base_url(''));
		}
	}
	public function create()
	{
		if($this->session->userdata('logged_in')){
			$this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean|callback_alpha_dash_space');
			
			$this->form_validation->set_rules('seller','Seller','required|trim|xss_clean|decimal');

			$this->form_validation->set_rules('price','price','required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('item_id','item_id','required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('quantity','quantity','required|trim|xss_clean|decimal');

			$this->form_validation->set_rules('total_price','total_price','required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('item_status','item_status','required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('payment','payment','required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('status','status','required|trim|xss_clean|decimal');
			$this->form_validation->set_rules('comment','comment','required|trim|xss_clean|decimal');
		
			if($this->form_validation->run()==FALSE){
				$data['brand'] = $this->brand->load_brand();
				$data['items'] = $this->item->load_item();
				$data['category']=$this->category->load_category();
				$data['sellers']=$this->accounts->load_users(5);
				$this->load->view('item_order/create',$data);
			}else{
				$this->product->add();
				redirect('item_order');
			}
			
		}else{
			redirect('login');
		}
	}
	public function edit($id)
	{
		if($this->session->userdata('logged_in')){
			$this->form_validation->set_rules('stock','Stock','trim|xss_clean|numeric');
			$this->form_validation->set_rules('price','price','required|trim|xss_clean|decimal');
		if($this->form_validation->run()==FALSE){
			$data['brand'] = $this->brand->load_brand();
			$data['category']=$this->category->load_category();
			$data['records'] = $this->product->fetch_product($id);

			$data['item_records'] = $this->product->fetch_product_item($id);
			
			$this->load->view('item_order/edit',$data);
		}else{
			$id=$this->input->post('did');
			$cstock = $this->input->post('cstock');
			$nstock = $this->input->post('stock');
			$stock =$cstock+$nstock;
			$data=array(
					'category_id'=>$this->input->post('category'),
					'brand_id'=>$this->input->post('brand'),
					'Quantity'=>$stock,
					'price'=>$this->input->post('price'),
					'status'=>$this->input->post('status')
					);
			$this->product->edit($id,$data);
			redirect('item_order');
		}
		}
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
		redirect('item_order');
	}
}