<div class="well"> <!--container for items-->
	<h1>Items List</h1>
	<table class="table table-hover text-center">
		<tr>
			<td>In Stock</td>
			<td>Name</td>
			<td>brand</td>
			<td>Action</td>
		</tr>
			<?php foreach ($items as $item) {
				$id = $item['iid'];
				$name = $item['item_name'];
				$stock = $item['Quantity'];
				$brand_name = $item['brand_name'];
				?>
				<tr>
					<?php if($stock == 0){?>
						<td><span class="label label-danger">Out of Stock</span></td>
					<?php }else{?>
					<td><?php echo $stock;}?></td>
					<td><?php echo $name;?></td>
					<td><?php echo $brand_name;?></td>
					<td>
<?php 
							echo form_open('items/add');
							echo form_hidden('id', $id);
							echo form_hidden('name', $name);
							echo form_hidden('order_type','P');
							echo form_hidden('brand_name', $brand_name);
							echo form_hidden('price', 0);
							if($stock==0 && FALSE){
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