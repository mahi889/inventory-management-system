<div class="container">
<?php
$grand_total = 0;
// Calculate grand total.
if($cart = $this->cart->contents()):
	foreach ($cart as $item):
		$grand_total = $grand_total + $item['subtotal'];
	endforeach;
endif;
?>
<?php echo form_open('billing/save_order',array('class' => 'form-horizontal'))?>
<div class="panel panel-primary">
	<div class="panel-heading">Billing Info</div>
	<div class="panel-body">
		<div class="col-lg-8 col-lg-offset-2">
			<table class="table table-bordered">
				<tr><td><h4>Total Amount: </td></h4><td><h4>  <?php echo number_format($grand_total, 2); ?></h4></td></tr>
				<tr><td><h4>GST (%):</td></h4>
					<td> 
						<div class="form-group">
							<div class="col-lg-8">
								<input required="" type="number" id="tax" name="tax" class="form-control" onchange="tax_calculate(this)" value="18" placeholder="GST" required="">
							</div>
						</div> 
						<h4 id="toal_tax_amount"><?php $vat= .18 * $grand_total;echo number_format($vat,2);?></h4></td>
					</tr>
				<tr><td><h4>Total Amount:</td></h4><td><h4 id="total_amount">  <?php $total= $grand_total+$vat;
									echo number_format($total,2);?></h4></td></tr>
			</table>
		</div>
	</div>
</div>

 <style>
  .ui-autocomplete-loading {
    background: white url("<?php echo base_url(); ?>assets/ui-anim_basic_16x16.gif") right center no-repeat;
  }
 </style>


 <script>
  	

function dueamountcalc(){

  		var received_amount = $('#received_amount').val();
  		received_amount = parseFloat(received_amount);
  		var total = $('#total').val();
  		total = parseFloat(total);
  		console.log('total',total,'received_amount',received_amount);
  		if(total - received_amount > 0)
  		{
  			$('#dueamount_block').show();
  			$('#dueamount').val(parseFloat(total-received_amount).toFixed(2));
  			$('#duedate_block').show();
  			$('#payment_status_block').show();
  			$('#payment_status').val('due');

  		}
  		else
  		{
  			$('#dueamount_block').hide();
  			$('#dueamount').val(parseFloat(total-received_amount).toFixed(2));
  			$('#duedate_block').hide();
  			$('#payment_status_block').hide();
  			$('#payment_status').val('complete');
  		}
    }

function tax_calculate(obj)
{
	var tax = obj.value;
	var grand_total = '<?php echo $grand_total; ?>';
	var tax_amount = parseFloat(grand_total)*tax/100;
	$('#toal_tax_amount').html(tax_amount);
	var total_amount = parseFloat(grand_total) + tax_amount;
	$('#total_amount').html(total_amount);
	$('#received_amount').attr('max',total_amount);
	$('#dueamount').attr('max',total_amount);
	$('#total').val(total_amount);
	
	dueamountcalc()
}

  $( function() {
    
    
 
    $( "#search" ).autocomplete({
      //source: "<?php echo site_url('billing/search_accaunt'); ?>",
      source: function (request, response) {
         // request.term is the term searched for.
         // response is the callback function you must call to update the autocomplete's 
         // suggestion list.
         $.ajax({
             url: "<?php echo site_url('billing/search_accaunt'); ?>",
             data: { term: request.term,lable:'F_name' },
             dataType: "json",
             success: response,
             error: function () {
                 response([]);

                $('#year').val('');
		        $('#month').val('');
		        $('#day').val('');

		        $('#contact').val('');
        
		        $('#fname').val('');
		        
		        $('#lname').val('');
		        
		        $('#father_name').val('');
		        
		        $('#address').val('');
		        
		        $('#email').val('');
		        
		        $('#gender').val('');
		        
		        $('#user_id').val('');

		        $('#position_id').val('');

		        $('#MS').val('');

		        $('#contact').removeAttr("readonly");
		        $('#fname').removeAttr("readonly");
		        $('#lname').removeAttr("readonly");
		        $('#father_name').removeAttr("readonly");
		        $('#address').removeAttr("readonly");
		        $('#email').removeAttr("readonly");
		        $('#gender').removeAttr("readonly");
		        $('#position_id').removeAttr("readonly");
		        $('#year').removeAttr("readonly");
       			$('#month').removeAttr("readonly");
        		$('#day').removeAttr("readonly");
        		$('#MS').removeAttr("readonly");
        		

             }
         });
     },
    minLength: 2,
      select: function( event, ui ) {
      	console.log(ui);
        
        $('#contact').val(ui.item.Contacts);
        
        $('#fname').val(ui.item.F_name);
        
        $('#lname').val(ui.item.L_name);
        
        $('#father_name').val(ui.item.father_name);
        
        $('#address').val(ui.item.address);
        
        $('#email').val(ui.item.email);
        
        $('#gender').val(ui.item.gender);
        
        $('#user_id').val(ui.item.id);

        $('#position_id').val(ui.item.position_id);
        
        $('#MS').val(ui.item.MS);
        $('#MS').val(ui.item.MS);

        $('#contact').attr("readonly","");
        $('#fname').attr("readonly","");
        $('#lname').attr("readonly","");
        $('#father_name').attr("readonly","");
        $('#address').attr("readonly","");
        $('#email').attr("readonly","");
        $('#gender').attr("readonly","");
        $('#position_id').attr("readonly","");
        $('#MS').attr("readonly","");

        var dob = ui.item.DOB.split('-');

        $('#year').val(dob[0]);
        $('#year').attr("readonly","");
        $('#month').val(dob[1]);
        $('#month').attr("readonly","");
        $('#day').val(dob[2]);
        $('#day').attr("readonly","");






      }
    });
  } );
  </script>

<div class="panel panel-primary">
<div class="panel-heading">Customer Info</div>

	<div class="panel-body">
	
	<?php if(validation_errors()==TRUE){?>
		<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo validation_errors();?>
		</div>
	<?php } ?>
		
	
		<input type="hidden" name="command" />
		<input type="text" name="did" id='hide'value="<?php echo $eid?>">

		
		<?php //echo form_open('account/create',array('class'=>'form-horizontal'));?>

			<div class="form-group">
				<label class="control-label col-sm-2">Search By</label>
					<div class="col-lg-8">
						<input type="text" id="search" required="" name="search" class="form-control" placeholder="Search by First Name Last Name Contact No">
						<input type="hidden" id="user_id" name="account_id" />
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">First Name</label>
					<div class="col-lg-8">
						<input type="text" required="" id="fname" required="" name="fname" class="form-control" placeholder="First Name">
					</div>
			</div>

			

			<div class="form-group">
				<label class="control-label col-sm-2">Last Name</label>
					<div class="col-lg-8">
						<input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name">
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Father Name</label>
					<div class="col-lg-8">
						<input type="text" required="" id="father_name" name="father_name" class="form-control" placeholder="Father Name">
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Contact No.</label>
					<div class="col-lg-8">
						<input type="text" name="contact" id="contact" class="form-control" placeholder="Contact No.">
					</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Place</label>
				<div class="col-lg-8">
					<input type="text" id="place" required="" name="place" class="form-control" placeholder="Place">
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-2">Address.</label>
					<div class="col-lg-8">
						
						<textarea class="form-control" id="address" placeholder="Address" name="address"></textarea>
					</div>
			</div>

			<!-- <div class="form-group">
				<label class="control-label col-sm-2">Gender</label>
					<div class="col-lg-2">
						<select name="gender" id="gender" class="form-control">
							<option value="male">Male</option>
							<option value="female">Female</option>
							</select>
					</div>
			</div> -->

			

			<div class="form-group">
				<label class="control-label col-sm-2" required="">Role</label>
					<div class="col-lg-2">
						<select name="position_id" id="position_id" class="form-control">
							<option value="1">Administrator</option>
							<option value="2">Accounting</option>
							<option value="3">Employee</option>
							<option selected="selected" value="4">Customer</option>
							<option value="5">Seller</option>
						</select>
					</div>
			</div>



			<!-- <div class="form-group form-inline">
				<label for="selectUser" class="control-label col-sm-2" style="float:left;">Date of Birth</label>
				<?php $this->load->helper('dob');?>
					<div style="float:left;padding: 6px 12px 2px 16px;">
						<select name="year" id="year" style="width:auto;" class="form-control">
						<option value="0">Year</option><?php echo generate_options(1963,2015)?>
						</select>

						<select name="month"  id="month" style="width:auto;" class="form-control">
						<option value="0">Month</option><?php echo generate_options(1,12)?>
						</select>

						<select name="day"  id="day" style="width:auto;" class="form-control">
						<option value="0">Day</option><?php echo generate_options(1,31)?>
						</select>
					</div>
			</div> -->

			<div class="form-group"> 
				<label class="control-label col-sm-2">Email</label>
					<div class="col-lg-8">
						<input type="text" id="email" name="email" class="form-control" placeholder="Email">
					</div>
			</div>

			

			

			<!-- <div class="form-group">
				<label class="control-label col-sm-2">Marital Status</label>
					<div class="col-lg-8">
						<select name="MS" id="MS" class="form-control">
							<option value="married">Married</option>
							<option value="single">Single</option>
							<option value="divorced">Divorced</option>
						</select>
					</div>
			</div> -->

			

			

			<!-- order form data start -->
	<div class="form-group">
		<label class="control-label col-sm-2">Eway</label>
		<div class="col-lg-2">
			<input type="text" id="Eway"  value="<?php echo strtotime("now") ?>" 
			 maxlength="16" required="" name="Eway" class="form-control">
		</div>
	</div>		
	<div class="form-group form-inline">
      <label class="control-label col-sm-2" >Item Status</label>
      <div class="col-sm-2">
        <div class="input-group">
          <div class="input-group-addon"></div>
          <select required="" name="delivered_staus" class="form-control">
            <option value="delivered">Delivered</option>
            <option value="no-delivered">Not Delivered</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Payment Type</label>
      <div class="col-lg-2">
        <select required="" name="payment" class="form-control">
          <option value="cash">Cash</option>
          <option value="loan">Loan</option>
          <option value="check">Check</option>
        </select>
      </div>
    </div>
    <input type="hidden" id="total" name="total" value="<?php echo number_format($total,2); ?>" >
    <div class="form-group">
      <label class="control-label col-sm-2">Amount Received</label>
      <div class="col-lg-2">
        
          <input type="number" required="" id="received_amount" step=".01" max="<?php echo number_format($total,2); ?>" name="received_amount" onkeyup="dueamountcalc();"   class="form-control">
          
        </div>
      </div>
    
    
    <div id="payment_status_block" class="form-group form-inline">
      <label class="control-label col-sm-2" required="" style="float:left;">Payment Status</label>
      <div class="col-sm-2">
        <div class="input-group">
          <div class="input-group-addon"></div>
          <select id="payment_status" required="" name="payment_status" class="form-control">
            <option value="complete">Complete</option>
            <option value="due">Due</option>
          </select>
        </div>
      </div>
    </div>
    <div id="duedate_block" class="form-group">
      <label class="control-label col-sm-2">Due Date</label>
      <div class="col-lg-2">
        <div class="input-group " >
          <input type="text" id="duedate" name="duedate"  class="form-control">
          <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
          </div>
        </div>
      </div>
    </div>

    <div id="dueamount_block" class="form-group">
      <label class="control-label col-sm-2">Due Amount</label>
      <div class="col-lg-2">
          <input type="number" id="dueamount" step=".01" min="0" max="<?php echo number_format($total,2); ?>" name="duedate"  class="form-control">
       </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2">Comment</label>
      <div class="col-lg-4">
        <textarea name="comment" class="form-control comment" placeholder="Comment"></textarea>
      </div>
    </div>

			<!-- order form data end -->

	<a href="<?php echo base_url('billing');?>" class="btn btn-danger">Back</a>
	<input class ='btn btn-primary' type="submit" value="Place Order" />


	

</div>
</div>
<?php echo form_close();?>
</div>