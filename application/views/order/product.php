<div class="well"> <!--container for products-->
	<h1>Product List</h1>
	<table class="table table-hover text-center">
		<tr>
			<td>In Stock</td>
			<td>Name</td>
			<td>Price</td>
			<td>Action</td>



		</tr>
			<?php foreach ($products as $product) {
				$id = $product['id'];
				$name = $product['product_name'];
				$stock = $product['Quantity'];
				$price = $product['price'];
				?>
				<tr>
					<?php if($stock == 0){?>
						<td><span class="label label-danger">Out of Stock</span></td>
					<?php }else{?>
					<td><?php echo $stock;}?></td>
					<td><?php echo $name;?></td>
					<td>  <?php echo $price;?></td>
					<td><?php 
							echo form_open('billing/add');
							echo form_hidden('id', $id);
							echo form_hidden('name', $name);
							echo form_hidden('order_type','S');
							echo form_hidden('price', $price);
							if($stock==0){
								$btn = array(
							'class' => 'btn btn-primary form-control',
							'value' => 'Add to Cart',
							'name' => 'action',
							'disabled'=>TRUE
							);
							}else{
								$btn = array(
							'class' => 'btn btn-primary form-control',
							'value' => 'Add to Cart',
							'name' => 'action'
							);
							}
							

							// Submit Button.
							echo form_submit($btn);
							echo form_close();
													?>


				</tr>
				

			<?php }?>
	</table>
	<p><?php echo $links?></p>
	</div>