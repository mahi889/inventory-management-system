<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {

	public function __construct()
	{

		parent::__construct();
		$this->load->database();

	}

	function add()
	{
		$data =array('product_name'=>$this->input->post('product_name'),
					 'category_id'=>$this->input->post('category'),
					 'Quantity'=>$this->input->post('stock'),
					 'stock_indicators'=>$this->input->post('stock_indicators'),
					 'price'=>$this->input->post('total_price'),
					 'comment'=>$this->input->post('comment')
					);
		$this->db->insert('product',$data);
		$id = $this->db->insert_id();
		return (isset($id)) ? $id : FALSE;

	}

	function add_item($id)
	{
		$item_id = $this->input->post('item_id');
		$price = $this->input->post('price');
		$quantity = $this->input->post('quantity');

		foreach ($item_id as $key => $value) {
			$data =array('product_id'=>$id,
					 'item_id'=>$item_id[$key],
					 'price'=>$price[$key],
					 'quantity'=>$quantity[$key]);
			$this->db->insert('product_items',$data);
			//$id = $this->db->insert_id();
			//return (isset($id)) ? $id : FALSE;
		}
		

	}

	function product_count($search)
	{

		
		

		$this->db->select('product.id');
		$this->db->from('product');
		$this->db->join('brand','brand.id=product.brand_id','left');
		$this->db->join('category','category.id=product.category_id','left');
		
		

		if(isset($search) && $search != null)
		{
			$this->db->like('product.product_name',$search); 
			$this->db->or_like('category.category_name',$search);
			$this->db->or_like('brand.brand_name',$search);
		}
		$this->db->order_by('product.id');
		return $this->db->count_all_results();
		
	}

	function get_products($limit, $start,$search)
	{
	   $this->db->limit($limit, $start);
	   $this->db->select('*,product.id as pid,product.status as pstats,category.id as cid');
	   $this->db->from('product');
	   $this->db->join('brand','brand.id=product.brand_id','left');
	   $this->db->join('category','category.id=product.category_id','left');
	   if(isset($search)  && $search != null)
		{
			$this->db->like('product.product_name',$search); 
			$this->db->or_like('category.category_name',$search);
			$this->db->or_like('brand.brand_name',$search);
		}
	   $this->db->order_by('product.id');

	   $query = $this->db->get();
	   if ($query->num_rows() > 0) {
		foreach ($query->result() as $row) {
		$data[] = $row;
		}

		return $data;
		}
		return false;
	}

	function edit($id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update('product',$data);
	}

	function fetch_product($id)
	{
	   $this->db->select('*,product.id as pid,product.status as pstats,category.id as cid,product.price as total_price');
	   $this->db->from('product');
	   //$this->db->join('brand','brand.id=product.brand_id','left');
	   $this->db->join('category','category.id=product.category_id','left');
	   $this->db->where('product.id',$id);
	   $query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->result();
		}else{
			return FALSE;
		}
	}

	function fetch_product_item($id)
	{

		$this->db->select('*,product_items.price as item_price,product.id as pid,product.status as pstats,category.id as cid,product.price as total_price');
	   $this->db->from('product');
	   $this->db->join('product_items','product.id=product_items.product_id','left');
	   $this->db->join('category','category.id=product.category_id','left');
	   $this->db->where('product.id',$id);
	   $query = $this->db->get();
	   
		if($query->num_rows() > 0)
		{
			return $query->result();
		}else{
			return FALSE;
		}
	}

	function get_product_items_quantity($id)
	{
		$this->db->select('sum(PI.quantity) as quantity,PI.item_id as item_id',FALSE);
 		$this->db->from('product_items PI');
 		$this->db->where('PI.product_id',$id);
 		$this->db->group_by('PI.item_id');
 		$query = $this->db->get();
 		return $query->result_array();
	}

	function get_item_quantity($id)
	{
		$this->db->select('Quantity,item_name');
 		$this->db->from('item');
 		$this->db->where('id',$id);
 		$query = $this->db->get();
 		return $query->row_array();
	}

	function delete_product_item($id)
	{
		$this->db->where('product_id', $id);
		$this->db->delete('product_items');

	}

	function delete_product($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('product');

	}



}