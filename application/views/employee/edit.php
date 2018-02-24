<div class="container">
	
<div class="well">
	<?php if(validation_errors()==TRUE){?>
		<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo validation_errors();?>
		</div>
		<?php }?>
		<?php 
			foreach($records as $data){
				?>
		<?php echo form_open('account/edit_process',array('class'=>'form-horizontal'));?>
		
			<input type="text" name="did" id="hide" value="<?php echo $data->empid;?>">
			<div class="form-group">
				<label class="control-label col-sm-2">First Name</label>
					<div class="col-lg-8">
						<input type="text" name="fname" class="form-control" placeholder="First Name" value="<?php echo $data->F_name;?>" >
					</div>
			</div>

			

			<div class="form-group">
				<label class="control-label col-sm-2">Last Name</label>
					<div class="col-lg-8">
						<input type="text" name="lname" class="form-control" placeholder="Last Name" value="<?php echo $data->L_name;?>" >
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Father Name</label>
					<div class="col-lg-8">
						<input type="text" name="father_name" class="form-control" placeholder="Father Name" value="<?php echo $data->father_name;?>" >
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Contact No.</label>
					<div class="col-lg-8">
						<input type="text" name="contact" class="form-control" placeholder="Contact No." value="<?php echo $data->Contacts;?>">
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Place</label>
				<div class="col-lg-8">
					<input type="text" id="place" name="place" class="form-control" placeholder="Place">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Address.</label>
					<div class="col-lg-8">
						
						<textarea class="form-control" placeholder="Address" name="address"><?php echo $data->address;?></textarea>
					</div>
			</div>


			<!-- <div class="form-group form-inline">
				<label class="control-label col-sm-2" style="float:left;">Gender</label>
					<div class="col-sm-4">
					  <div class="input-group">
						<div class="input-group-addon"><?php echo $data->gender;?></div>
								<select name="gender" class="form-control">
								<option value="<?php echo $data->gender;?>"><?php echo $data->gender;?></option>
					 			<?php if($data->gender=='male'){?>
								<option value="female">Female</option>
								<?php }else{?>
								<option value="male">Male</option>
								<?php }?>
							</select>
						</div>
					</div>
			</div> -->

			<!-- <div class="form-group">
				<label class="control-label col-sm-2">Age</label>
					<div class="col-xs-2">
						<input type="text" name="age" class="form-control" placeholder="Age" value="<?php 
						$odob = date('Y',strtotime($data->DOB));
						$dtod = date('Y');


						echo  $age = $dtod-$odob;?>" disabled>
					</div>
			</div> -->

			<!-- <div class="form-group form-inline">
				<label class="control-label col-sm-2">Date of Birth</label>
					<div class="col-xs-2">
						<input type="text" name="age" class="form-control" placeholder="" value="<?php //echo date('M.d,Y',strtotime($data->DOB));?>" disabled>
					</div>
			</div> -->

			<div class="form-group"> 
				<label class="control-label col-sm-2">Email</label>
					<div class="col-lg-8">
						<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $data->email;?>" disabled>
					</div>
			</div>

			

			

			<!-- <div class="form-group">
				<label class="control-label col-sm-2" style="float:left;">Marital Status</label>
					<div class="col-sm-4">
					 	<select name="MS" class="form-control">
					 		<option value="<?php echo $data->MS;?>">(Current)<?php echo $data->MS;?></option>
					 	<?php if($data->MS=='married'){?>
					 		<option value="single">Single</option>
							<option value="divorced">Divorced</option>
						<?php }elseif($data->MS=='single'){?>
							<option value="married">Married</option>
							<option value="divorced">Divorced</option>
						<?php }elseif($data->MS=='divorced'){?>
							<option value="single">Single</option>
							<option value="married">Married</option>
							<?php } ?>
						</select>
					</div>
			</div> -->


			<div class="form-group form-inline">
				<label class="control-label col-sm-2" style="float:left;">Statuts</label>
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


		

		
	
			<div class="form-group form-inline">
				<label class="control-label col-sm-2" style="float:left;">Position</label>
					<div class="col-sm-4">
					  <div class="input-group">
						<div class="input-group-addon"><?php echo $data->position;?></div>
							<select name="position" class="form-control">
							<option value="<?php echo $data->position_id;?>"><?php echo $data->position;?></option>
								<?php foreach ($position as $key) {
										if($data->position_id==$key->id){}else{?>
									<option value="<?php echo $key->id;?>"><?php echo $key->position;?></option>
									<?php } }?>
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

