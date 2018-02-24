<div class="container">
	<?php //$this->load->view('layout/inventory_header'); ?>
	<div class="well">
		<h2>Edit item</h2>
		<?php if(validation_errors()==TRUE){?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo validation_errors();?>
		</div>
		<?php }?>
		<?php
			foreach($records as $data){
		?>
		<?php echo form_open('items/edit/'.$data->iid,array('class'=>'form-horizontal'));?>
		
		<input type="text" name="did" id="hide" value="<?php echo $data->iid;?>">
		<div class="form-group">
			<label class="control-label col-sm-2">item Name</label>
			<div class="col-lg-8">
				<input type="text" name="item_name" class="form-control" placeholder="" value="<?php echo $data->item_name;?>">
			</div>
		</div>
                  
		<div class="form-group form-inline">
	      <label class="control-label col-sm-2">Brands</label>
	      <div class="col-sm-4">
	        <div class="input-group">
	          <div class="input-group-addon"><?php echo $data->brand_name;?></div>
	          <select name="brand" class="form-control">
	            <option value="<?php echo $data->bid;?>"><?php echo $data->brand_name;?></option>
	            <?php foreach($brand as $bnd) {?>
	            <?php if($bnd->id==$data->bid)
	            {}else{?>
	            <option value="<?php echo $bnd->id;?>"><?php echo $bnd->brand_name;?></option>
	            <?php } }?>
	          </select>
	        </div>
	      </div>
	    </div>

	    <div class="form-group">
			<label class="control-label col-sm-2">Stock Indicator</label>
			<div class="col-lg-4">
				<input type="text" name="stock_indicators" value="<?php echo $data->stock_indicators;?>" class="form-control">
				
			</div>
		</div>

		<div class="form-group form-inline">
			<label class="control-label col-sm-2" style="float:left;">Status</label>
			<div class="col-sm-4">
				<div class="input-group">
					<div class="input-group-addon"><?php echo $data->status;?></div>
					<select name="status" class="form-control">
						<option value="<?php echo $data->status;?>"><?php echo $data->status;?></option>
						<?php if($data->status=='In-active'){?>
						<option value="Active">Active</option>
						<?php }else{?>
						<option value="In-active">In-active</option>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
		
		
		
		
		<div class="form-group">
			<div class="col-lg-8 col-lg-offset-10">
				<input type="submit" name="sumbit" class="btn btn-primary " value="Submit">
			</div>
		</div>
		<?php } ?>
		<?php echo form_close();?>
		
	</div>
</div>