<div class="container">

	<div class="panel panel-primary">
		<div class="panel-heading">Products</div>
			<?php echo form_open('products/update_status');?>
			<table class="table table-hover text-center">
				<tr>
				
				<td>
				Option<br>
				<input type="checkbox" id='selecctall' />Select all &nbsp
				<input type="radio" name="status" value="Active" checked/>Active &nbsp
				<input type="radio" name="status" value="In-active"/>In-active
				</td>
				<td>#</td>
				<td>Name</td>
				<td>Brand</td>
				<td>Category</td>
				<td>Status</td>
				<td>Stock</td>
				<td>Action</td>
				</tr>

		
			<?php foreach ($results as $data) {?>
			
				<tr>
				<td><input type="checkbox" class="checkbox1" name="pro_status[]" id="pro_status[]" value="<?php echo $data->pid;?>"/></td>
				<td><?php echo $data->pid;?></td>
				<td><?php echo $data->product_name;?></td>
				<td><?php echo $data->brand_name;?></td>
				<td><?php echo $data->category_name;?></td>
				<td>
					<?php if($data->pstats == 'Active'){?>
						<span class="label label-success"><?php echo $data->pstats;?></span>
					<?php }else{ ?>
						<span class="label label-danger"><?php echo $data->pstats;?></span>
					<?php } ?>
				</td>
				<?php if($data->Quantity!=0){?>
					<td><?php echo $data->Quantity;?></td>
				<?php }else{ ?>
					<td><span class="label label-danger">Out of Stock</span></td>
				<?php }?>
				<td>
				<a href="<?php echo base_url('products/edit/'.$data->pid);?>" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
					</tr>
			<?php 
			 }?>
			<tr>
				<td><input type="submit" value="Update" class="btn btn-info btn-sm"></td>
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
