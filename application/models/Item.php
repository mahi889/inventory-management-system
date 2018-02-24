<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Item extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function add()
	{
		$data =array('item_name'=>$this->input->post('item_name'),
					'status'=>$this->input->post('status'),
					'stock_indicators'=>$this->input->post('stock_indicators'),
					'brand_id'=>$this->input->post('brand'));
		$this->db->insert('item',$data);
	}
	function item_count()
	{
		return $this->db->count_all('item');
		$this->db->select('item.id');
		$this->db->from('item');
		if(isset($search) && $search != null)
		{
			$this->db->like('item.item_name',$search); 
		}
		$this->db->where('item.deleted',1);
		$this->db->order_by('item.id');
		return $this->db->count_all_results();
	}

	function get_items($limit, $start,$search)
	{
		$this->db->limit($limit, $start);
		$this ->db->select('*');
		$this ->db->from('item');
		if(isset($search) && $search != null)
		{
			$this->db->like('item.item_name',$search); 
		}
		$this->db->where('item.deleted',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
			$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	function fetch_item($id)
	{
		$this ->db->select('*,brand.id as bid,item.id as iid');
		$this ->db->from('item');
		$this->db->join('brand','brand.id=item.brand_id','left');
		$this->db->where('item.id',$id);
		// group by item_id for safe perpus
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function edit($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('item',$data);
	}
	function load_item()
	{
		
		$this ->db->select('*,brand.id as bid,item.id as iid');
		$this ->db->from('item');
		$this->db->join('brand','brand.id=item.brand_id','left');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		
		return false;
	}
	function check_item($item_name)
	{
		$this->db->select('*');
		$this->db->from('item');
		$this->db->where('item_name',$item_name);
		$this ->db-> limit(1);
	
		$query = $this ->db-> get();
	
		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}

	public function details_count()
	{
		$this->db->where('order_type','P');
		$this->db->from("order");
		return $this->db->count_all_results();
	}

	public function get_details($limit, $start)
	{
		$this->db->limit($limit, $start);
	   	$this ->db->select("*,account.id as cusid,order.id as oid,concat_ws(' ',account.F_name,account.L_name) AS customer_name", FALSE);
	   	$this ->db->from('order');
	   	$this->db->join('account','account.id=order.account_id')->where('order_type','P');
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

	public function get_search($limit, $start,$search_term)
	{
		$this->db->limit($limit, $start);
		$this->db->select("*,account.id as cusid,order.id as oid,concat_ws(' ',account.F_name,account.L_name) AS customer_name",false);
		$this->db->from('order');
		$this->db->join('account','account.id=order.account_id','right');
		
		$this->db->like('account.F_name',$search_term); 
		$this->db->or_like('account.L_name',$search_term);
		$this->db->or_like('account.father_name',$search_term);
		$this->db->or_like('account.plase',$search_term);
		$this->db->or_like('account.Contacts',$search_term)->where('order_type','P');

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

	public function get_accaunt_search($search_term,$lable){
		$this->db->select('*,'.$lable.' as lable,'.$lable.' as value');
		$this->db->like('F_name',$search_term); 
		$this->db->or_like('L_name',$search_term);
		$this->db->or_like('father_name',$search_term);
		$this->db->or_like('place',$search_term);
		$this->db->or_like('Contacts',$search_term);
		$this->db->from('account');
		$this->db->where('position_id','5');
		return $this->db->get()->result();
	}
}