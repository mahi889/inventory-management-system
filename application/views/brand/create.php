<div class="container">

	<div class="well">
	<h2>Add Brand</h2>
		<?php if(validation_errors()==TRUE){?>
		<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo validation_errors();?>
		</div>
		<?php }?>

		<?php echo form_open('brands/create',array('class' => 'form-horizontal'));?>

			<div class="form-group">
				<label class="control-label col-sm-2">Brand Name</label>
					<div class="col-lg-8">
						<input type="text" name="brand_name" class="form-control">
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Status</label>
					<div class="col-lg-4">
						<select name="status" class="form-control">
							<option value="Active">Active</option>
							<option value="In-active">In-active</option>						
						</select>
					</div>
			</div>

			<div class="form-group">
				<div class="col-lg-2 col-lg-offset-10">
					<input type="submit" name="submit" value="Add" class="btn btn-primary "/>
				</div>
			</div>
		<?php echo form_close();?>
	</div>
</div>