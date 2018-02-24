<div class="container">

	<div class="well">


	<?php echo form_open('items/search', array('method' => 'GET', 'class' => 'navbar-form navbar-left', 'role' => 'Search','style'=>'float:right;')); ?>
			<div class="form-group">
			   <?php echo form_input('keyword', $this->input->get('keyword'), 'class="form-control" placeholder="Search"'); ?>
			</div>		
	<?php echo form_close(); ?>


		<table class="table table-hover text-center">
			<tr>
				<td>Customer Name</td>
				<td>Order Date</td>
				<td>Payment Type</td>
				<td>Action</td>
			</tr>

			<?php  if($results){foreach ($results as $data):?>
				<tr>
					<td><?php echo $data->customer_name;?></td>
					<td><?php echo date("M / d / Y",strtotime($data->date));?></td>
					<td><?php echo $data->payment;?></td>
					<td>
						<a href="<?php echo base_url('items/view_id/'.$data->oid);?>"><i class="fa fa-cart-plus fa-2x"></i></a> &nbsp
					 	<a href="<?php echo base_url('print_pdf/item_dwonload_pdf/'.$data->oid)?>"><i class="fa fa-download fa-2x"></i></a>
					 </td>
				</tr>


			<?php endforeach;}?>
		</table>
		<?php echo $links;?>
	</div>


</div>
