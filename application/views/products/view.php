<div class="container">

	<div class="panel panel-primary">
		<div class="panel-heading">Products</div>

			<?php echo form_open('products/index', array('method' => 'GET', 'class' => 'navbar-form navbar-left', 'role' => 'Search','style'=>'float:right;')); ?>
			<div class="form-group">
			   <?php echo form_input('search', $this->input->get('search'), 'class="form-control" placeholder="Search"'); ?>
			</div>		
			<?php echo form_close(); ?>

			<?php echo form_open('products/delete');?>
			<table class="table table-hover text-center">
				<tr>
				
				<td>
				Delete option<br>
				<input type="checkbox" id='selecctall' />Select all &nbsp
				
				</td>
				<td>#</td>
				<td>Name</td>
				<td>Brand</td>
				<td>Category</td>
				
				<td>Stock</td>
				<td>Action</td>
				</tr>

		
			<?php if($results){ foreach ($results as $data) {?>
			
				<tr>
				<td><input type="checkbox" class="checkbox1" name="pid[]" id="pid[<?php echo $data->pid;?>]" value="<?php echo $data->pid;?>"/></td>
				<td><?php echo $data->pid;?></td>
				<td><?php echo $data->product_name;?></td>
				<td><?php echo $data->brand_name;?></td>
				<td><?php echo $data->category_name;?></td>
				
				<?php if($data->Quantity!=0){?>
					<td><?php echo $data->Quantity;?></td>
				<?php }else{ ?>
					<td><span class="label label-danger">Out of Stock</span></td>
				<?php } } ?>
				<td>
				<a href="<?php echo base_url('products/edit/'.$data->pid);?>" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
					</tr>
			<?php 
			 }?>
			<tr>
				<td><input type="submit" value="Delete" class="btn btn-danger btn-sm"></td>
				<td>#</td>
				<td>Name</td>
				<td>Brand</td>
				<td>Category</td>
				<td>Status</td>
				<td>Stock</td>
				<td>Action</td>
				</tr>

			</table>
			<?php echo form_close();?>
		<p><?php echo $links;?></p>
			
	</div>

</div>
