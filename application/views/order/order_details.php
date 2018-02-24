<?php 
	$sum = $sum[0]->price;
	$qty = $qty[0]->qty;
	$total = $sum * $qty;

?>

<div class="container">
	<div class="well">
	<a href="<?php echo base_url('billing/view')?>" class="btn btn-primary">Back</a>
	<?php foreach($customer as $data):?>
			<a href="<?php echo base_url('print_pdf/reciept_pdf/'.$data->oid)?>" class="btn btn-info">View in PDF</a>
			<a href="<?php echo base_url('print_pdf/download_pdf/'.$data->oid)?>" class="btn btn-warning">Download PDF</a>
			<table class="table table-bordered">
				<br>
				<tr>
					<td>Customer Name:</td>
					<td><?php echo $data->customer_name;?></td>
					<td>Date Ordered:</td>
					<td><?php echo $data->date;?></td>
				</tr>
				<tr>
					<td>Payment:</td>
					<td><?php echo $data->payment;?></td>
					<td></td>
					<td></td>
				</tr>
	<?php endforeach;	?>
			<tr>
				<td>Item</td>
				<td>Qty.</td>
				<td>Amout</td>
				<td>Sub Amout</td>
			</tr>
	<?php foreach($results as $data): ?>
			<tr>	
				<td><?php echo $data->product_name;?></td>
				<td><?php echo $data->qty;?></td>
				<td><?php echo $data->price;?></td>
				<td><?php echo number_format($data->qty * $data->price,2);?></td>
			</tr>
	<?php endforeach;	?>

		 	<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>Total Sale</td>
				<td><?php echo number_format($data->grand_total,2) ;?></td>
			</tr>

			<tr>
				
				<td>GST - <?php echo $data->tax ?>%</td>
				<td><?php echo number_format($vat = $data->tax * $data->grand_total/100,2) ;?></td>
				<td>Add:GST</td>
				<td> <?php echo number_format($vat = $data->tax * $data->grand_total/100,2) ;?></td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>Net Amount</td>
				<td><?php echo number_format($data->total_amount,2);?></td>
			</tr>
			 <tr>
				<td></td>
				<td></td>
				<td>Paid Payment</td>
				<td><?php echo number_format($data->received_amount,2);?></td>
			</tr>
			<tr>
				<td>Due Date</td>
				<td><?php echo  $data->duedate; ?></td>
				<td>Payment Due</td>
				<td><?php  echo number_format($data->due_payment,2);?></td>
			</tr>

			<tr>
				<td>Eway</td>
				<td><?php echo $data->Eway;  ?></td>
				<td></td>
				<td></td>
			</tr> 

			  

			</table>
			<div class="row">
				<div class="col-md-6">
					<h4>DELIVERED BY: <?php echo $data->L_name.",".$data->F_name." S/O ".$data->father_name?></h4>

				</div>
				
			</div>
	</div>

</div>