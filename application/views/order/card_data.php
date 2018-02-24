<?php 
echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
?>
<tr>
<td>
<?php echo $i++; ?>
</td>
<td>
<?php echo $item['name']; ?>
</td>
<td>
Php <?php echo number_format($item['price'],2); ?>
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