<div class="container">

	<div class="panel panel-primary">
		<div class="panel-heading">Categories</div>
		<?php echo form_open('categories/index', array('method' => 'GET', 'class' => 'navbar-form navbar-left', 'role' => 'Search','style'=>'float:right;')); ?>
		<div class="form-group">
		   <?php echo form_input('search', $this->input->get('search'), 'class="form-control" placeholder="Search"'); ?>
		</div>		
		<?php echo form_close(); ?>
		<?php echo form_open('categories/update_status');?>
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
				
				<td>Status</td>
				
				<td>Action</td>
				
				</tr>

		
			<?php foreach ($results as $data) {?>
			
				<tr>
				<td><input type="checkbox" class="checkbox1" name="cat_status[]" id="cat_status[]" value="<?php echo $data->id;?>"/></td>
				<td><?php echo $data->id;?></td>
				<td><?php echo $data->category_name;?></td>
				<td>
					<?php if($data->status == 'Active'){?>
						<span class="label label-success"><?php echo $data->status;?></span>
					<?php }else{ ?>
						<span class="label label-danger"><?php echo $data->status;?></span>
					<?php } ?>
				</td>
				<td>
				<?php if($position=='Administrator'){?>
				<a href="<?php echo base_url('categories/edit/'.$data->id);?>" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-2x"></i></a>&nbsp;
					</tr>
			<?php }
			 }?>
			<tr>
				<td><input type="submit" name="Update" class="btn btn-info btn-sm" value="Update"/>
					<input type="submit" name="Delete" class="btn btn-danger btn-sm" value="Delete"/></td>
				<td>#</td>
				<td>Name</td>
				<td>Status</td>
				<td>Action</td>
				</tr>

			</table>
			<?php echo form_close();?>
		<p><?php echo $links;?></p>
			
	</div>

</div>
