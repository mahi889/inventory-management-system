<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billings extends CI_Model {

	public function __construct()
	{

		parent::__construct();
		$this->load->database();

	}

	public function get_all($limit, $start)
	{
		$this->db->limit($limit, $start);
	   	$query = $this->db->get('product');
	   	return $query->result_array();
	}

	public function get_all_items($limit, $start)
	{
		$this->db->limit($limit, $start);
	   	$this->db->where('item.status','Active');
	   	$this->db->select('*,brand.id as bid,item.id as iid');
		$this->db->from('item');
		$this->db->join('brand','brand.id=item.brand_id','left');
	   	$query = $this->db->get();
	   	return $query->result_array();
	}

	function product_count()
	{
			   $this->db->where('status','Active');
			   $this->db->from('product');
		return $this->db->count_all_results();
	}

	function item_count()
	{
			   $this->db->where('status','Active');
			   $this->db->from('item');
		return $this->db->count_all_results();
	}

	public function insert_account($data)
	{
		$this->db->insert('account', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;
	}

	// Insert order date with account id in "orders" table in database.
	public function insert_order($data)
	{
		$this->db->insert('order', $data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;
	}

	// Insert ordered product detail in "order_detail" table in database.
	public function final_order_detail($data)
	{
		$this->db->insert('order_details', $data);
	}


	public function details_count()
	{
		$this->db->where('order_type','S');
		$this->db->from("order");
		$data = $this->db->count_all_results();
		//return $this->db->count_all_results();
		//$data =  $this->db->count_all('order');
		
		return $data;
		//return $this->db->count_all('order')->where('order_type','S');
	}

	public function get_details($limit, $start)
	{
		$this->db->limit($limit, $start);
		$this ->db->select("*,account.id as cusid,order.id as oid,concat_ws(' ',account.F_name,account.L_name) AS customer_name", FALSE);
		$this ->db->from('order');
		$this->db->join('account','account.id=order.account_id');
		$this->db->order_by('order.date','desc')->where('order_type','S');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}

			return $data;
		}

		return false;
	}

	public function fetch_account_details($oid)
	{
		$this->db->select("*,order.id as oid,concat_ws(' ',account.F_name,account.L_name) AS customer_name",false);
		$this->db->from('order');
		$this->db->join('account','account.id=order.account_id');
		$this->db->where('order.id',$oid);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function fetch_order_details($oid)
	{
		$this->db->select('*,account.id as aid,order_details.price as order_price');
		$this->db->from('order_details');
		$this->db->join('order','order.id=order_details.order_id');
		$this->db->join("product","product.id=order_details.product_id and order.order_type = 'S'","left");
		$this->db->join("item","item.id=order_details.product_id and order.order_type = 'P'","left");
		$this->db->join('account','account.id=order.account_id');
		$this->db->where('order_details.order_id',$oid);
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}

			return $data;
		}
		return false;
	}

	public function get_product_by_id($id)
	{

		$this->db->select('*')->where('id',$id);
		$query = $this->db->get('product');

		return $query->row_array();	
	}

	public function get_sum($oid)
	{
		
		$this->db->select_sum('price')->where('order_id',$oid);
		$query = $this->db->get('order_details');

		return $query->result();
	}

	public function get_qty($oid)
	{
		$this->db->select_sum('qty')->where('order_id',$oid);
		$query = $this->db->get('order_details');
		return $query->result();
	}

	public function get_search($limit, $start,$search_term)
	{
		$this->db->limit($limit, $start);
		$this->db->select("*,account.id as cusid,order.id as oid,concat_ws(' ',account.F_name,account.L_name) AS customer_name",false);
		$this->db->from('order');
		$this->db->join('account','account.id=order.account_id','right');
		
		$this->db->like('account.F_name',$search_term); 
		$this->db->or_like('account.L_name',$search_term);
		$this->db->or_like('account.father_name',$search_term);
		$this->db->or_like('account.place',$search_term);
		$this->db->or_like('account.Contacts',$search_term);
		
		$this->db->or_like('order.payment_status',$search_term);
		$this->db->or_like('order.total_amount',$search_term);
		$this->db->or_like('order.due_payment',$search_term);
		$this->db->or_like('order.comment',$search_term)

		->where('order_type','S');

		$this->db->order_by('order.date','desc');
		$query = $this->db->get();

	    if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}

			return $data;
		}

		return false;
	}

	public function search_count($search_term)
	{					
		$this->db->like('F_name',$search_term); 
		$this->db->or_like('L_name',$search_term);
		$this->db->or_like('father_name',$search_term);
		$this->db->or_like('place',$search_term);
		$this->db->or_like('Contacts',$search_term);
		$this->db->from('account');
		return $this->db->count_all_results();
	}

	public function get_accaunt_search($search_term,$lable){
		$this->db->select('*,'.$lable.' as lable,'.$lable.' as value');
		$this->db->like('F_name',$search_term); 
		$this->db->or_like('L_name',$search_term);
		$this->db->or_like('father_name',$search_term);
		$this->db->or_like('place',$search_term);
		$this->db->or_like('Contacts',$search_term);
		$this->db->from('account');
		$this->db->where('position_id','4');
		return $this->db->get()->result();
	}
}