
<?php

if($order_type == 'P'){
	$this->load->view('order/order_item');
}else{
	$this->load->view('order/order_product');
}

$cart_check = $this->cart->contents();

// If cart is empty, this will show below message.
if(empty($cart_check)) {
		echo 'To add products to your shopping cart click on "Add to Cart" Button';
}
?>

<?php 
	if(count($error)){ foreach($error as $er){
?>
		<div class="alert alert-warning alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<?php echo $er ?>
		</div>
 <?php } }

 ?>



	<table class="table table-striped text-center">
	<?php
	// All values of cart store in "$cart".
	if ($cart = $this->cart->contents()): ?>
		<tr>
			<td>ID</td>
			<td>Name</td>
			<?php echo $order_type == 'P' ? '<td>Brand</td>' : ''; ?>
			<td>Price</td>
			<td>Qty</td>
			<td>Amount</td>
			<td>Cancel Product</td>
		</tr>


		<?php
			// Create form and send all values in "shopping/update_cart" function.
			echo form_open('billing/update_cart');
			$grand_total = 0;
			$i = 1;

			foreach ($cart as $item):
			// echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
			// Will produce the following output.
			// <input type="hidden" name="cart[1][id]" value="1" />
				if($item['order_type'] == $order_type):
					//$card_data =  array('item'=>$item);
					//$this->load->view('order/card_data',$card_data);
					echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
					echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
					echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
					
					echo $order_type == 'P' ? form_hidden('cart[' . $item['id'] . '][brand_name]', $item['brand_name']) : '';
					
					echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
					echo form_hidden('cart[' . $item['id'] . '][order_type]', $item['order_type']);
					echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
					
				?>
				<tr>
					<td>
						<?php echo $i++; ?>
					</td>
					<td>
						<?php echo $item['name']; ?>
					</td>

					<?php echo $order_type == 'P' ? '<td>'.$item['brand_name'].'</td>' : ''; ?>

					<td>
						<?php echo $order_type == 'S' ? number_format($item['price'],2) : form_input('cart[' . $item['id'] . '][price]', $item['price'], 'maxlength="6" " style="text-align: right"'); ?>
					</td>
					<td>
						<?php echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'], 'maxlength="3" size="1" style="text-align: right"'); ?>
					</td>
						<?php $grand_total = $grand_total + $item['subtotal']; ?>
					<td>
					 	<?php echo number_format($item['subtotal'],2) ?>
					</td>
					<td>

					<?php
					// cancel image.
					$path =  "<i class='fa fa-remove'></i>";
					echo anchor('billing/remove/' . $item['rowid'],$path); ?>
					</td>


					<?php endif; endforeach; ?>
				</tr>
				<tr>
					<td><b>Order Total: <?php

					//Grand Total.
					echo number_format($grand_total,2); ?></b></td>

					<?php // "clear cart" button call javascript confirmation message ?>
					<td colspan="6" align="right">
						<input  class ='btn btn-danger' type="button" value="Clear Cart" onclick="clear_cart()">
						<input class ='btn btn-primary'  type="submit" value="Update Cart">
						<?php echo form_close(); ?>

						<!-- "Place order button" on click send "billing" controller -->
						<input class ='btn btn-primary' type="button" value="Place Order" onclick="window.location = 'billing/reciept'">
					</td>
				</tr>
		
			<?php endif; ?>
		</table>





	</div>

	<?php 
		if($order_type == 'P'){
			$this->load->view('order/items');
		}else{
			$this->load->view('order/product');	
		}
	?>

</div>