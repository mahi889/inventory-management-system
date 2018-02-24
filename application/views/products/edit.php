<div class="container">
  <?php //$this->load->view('layout/inventory_header'); ?>
  <div class="well">
    <h2>Edit Product</h2>
    <?php echo validation_errors(); ?>
    <?php 
      if(count($error) > 0) { 
        foreach ($error as $key => $value) {
    ?> 
        <div class="alert alert-danger">
           <?php echo $value; ?>
        </div>
    <?php
        }
      } 
    ?>

    <?php
    //$item_records = json_decode(json_encode($item_records), true);
    $item_ids = array_column($item_records,'item_id');
    $quantity = array_column($item_records,'quantity');
    $item_prices = array_column($item_records,'item_price');
    

    foreach($records as $data){

      $product_name = set_value('product_name') == false ? $data->product_name: set_value('product_name'); 
      $cat_id = set_value('category') == false ? $data->category_id : set_value('category'); 
      
      $item_id = set_value('item_id') == false ? $item_ids : set_value('item_id');
      //$item_olds_id = $item_ids;
      $price = set_value('price') == false ? $item_prices : set_value('price');
      $quantity = set_value('quantity') == false ? $quantity : set_value('quantity');
      
      $stock = set_value('stock') == false ? $data->Quantity : set_value('stock');
      $stock_indicators = set_value('stock_indicators') == false ? $data->stock_indicators : set_value('stock_indicators');
      $comment = set_value('comment') == false ? $data->comment : set_value('comment');
      $total_price = set_value('total_price') == false ? $data->total_price : set_value('total_price');
      
      ?>

    

    <?php echo form_open('products/edit/'.$data->pid,array('class'=>'form-horizontal'));?>
    
    <input type="text" name="pid" id="hide" value="<?php echo $data->pid;?>">
    <div class="form-group">
      <label class="control-label col-sm-2">Product Name</label>
      <div class="col-lg-8">
        <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>" >
      </div>
    </div>

    <div class="form-group form-inline">
      <label class="control-label col-sm-2" style="float:left;">Category</label>
      <div class="col-sm-4">
        <div class="input-group">
          <!-- <div class="input-group-addon"><?php echo $data->category_name;?></div> -->
          <select name="category" class="form-control">
            <?php foreach ($category as $key) { ?>
            <option value="<?php echo $key->id;?>" <?php echo $key->id == $cat_id ? 'selected':''; ?> ><?php echo $key->category_name;?></option>
            <?php  } ?>
          </select>
        </div>
      </div>
    </div>

    
      <div id="items">
        <?php if($item_id != ''){ foreach ($item_id as $key => $value) { ?>
        <div class="form-group <?php echo $key == 0 ?'after-add-more':''; ?>">

          <label class="control-label col-sm-2">Item</label>
          <div class="col-lg-4">
            <select name='item_id[]' class="form-control">
              <?php foreach($items as $item){?>
              <option <?php echo $value == $item->iid ? 'selected':''; ?> value="<?php echo $item->iid ?>" class="form-control"><?php echo $item->item_name.' ( '.$item->brand_name.' )' ?></option>
              <?php }?>
            </select>
          </div>
          <label class="control-label col-sm-1">Price</label>
          <div class="col-lg-2">
            <input type="number" name="price[]" value="<?php echo $price[$key]; ?>" required onchange="calc()" class="form-control price" placeholder="Price" >
          </div>
          <label class="control-label col-sm-1">Quantity</label>
          <div class="col-lg-2">
            <div class="input-group control-group">
              <input type="number" name="quantity[]" value="<?php echo $quantity[$key]; ?>" required onchange="calc()" class="form-control quantity" placeholder="Quantity" >
              <?php if($key == 0){ ?>
              <div class="input-group-btn">
                <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i></button>
              </div>
              <?php } ?>
              <?php if($key != 0){ ?>
              <div class="input-group-btn">
                <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
              </div>
              <?php } ?>
            </div>
          </div>

        </div>
        <?php } } ?>

      </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Price</label>
      <div class="col-sm-2">
        <div class="input-group">
          <div class="input-group-addon">INR</div>
          <input type="text" class="form-control" id="total_price" value="<?php echo $total_price; ?>" name="total_price" placeholder="Amount">
        </div>
        
      </div>
    </div>  
      
    <div class="form-group">
      <label class="control-label col-sm-2">Stock(Units) Current:</label>
      <div class="col-sm-2">
        <div class="input-group">
          <!-- <div class="input-group-addon"> <?php echo $data->Quantity;?></div> -->
           <input type="text" name="stock" value=" <?php echo $stock;?>" class="form-control" >
           <input type="text" name="cstock" id="hide" value=" <?php echo $data->Quantity;?>">
          
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2">Stock Indicator</label>
      <div class="col-sm-2">
        <div class="input-group">
          <!-- <div class="input-group-addon"> <?php echo $data->stock_indicators;?></div> -->
           <input type="text" name="stock_indicators" value=" <?php echo $stock_indicators;?>" class="form-control" >
           
          
        </div>
      </div>
    </div>

     
    
    <!-- <div class="form-group form-inline">
      <label class="control-label col-sm-2">Status</label>
      <div class="col-sm-4">
        <div class="input-group">
          <div class="input-group-addon"><?php echo $data->pstats;?></div>
          <select name="status" class="form-control">
            <option value="<?php echo $data->pstats;?>"><?php echo $data->pstats;?></option>
            <?php if($data->pstats=='In-active'){?>
            <option value="Active">Active</option>
            <?php }else{?>
            <option value="In-active">In-active</option>
            <?php }?>
          </select>
        </div>
      </div>
    </div> -->

    <div class="form-group">
      <label class="control-label col-sm-2">Comment</label>
      <div class="col-lg-4">
        <textarea name="comment" class="form-control comment" placeholder="Comment"><?php echo $comment; ?></textarea>
      </div>
    </div>
    
    <div class="form-group">
      <div class="col-lg-2 col-lg-offset-10">
        <input type="submit" name="submit" value="Update" class="btn btn-primary "/>
      </div>
    </div>
    <?php } ?>
    
    <?php echo form_close();?>

    <!-- Copy Fields-These are the fields which we get through jquery and then add after the above input,-->
    <div class="copy-fields  hide">
      <div class="form-group ">
        <label class="control-label col-sm-2">Item</label>
        <div class="col-lg-4">
          <select name='item_id[]' class="form-control">
            <?php foreach($items as $item){?>
            <option value="<?php echo $item->iid ?>" class="form-control"><?php echo $item->item_name.' ( '.$item->brand_name.' )' ?></option>
            <?php }?>
          </select>
        </div>
        <label class="control-label col-sm-1">Price</label>
        <div class="col-lg-2">
          <input type="number" name="price[]" required="" onchange="calc()" class="form-control price" placeholder="Price" >
        </div>
        <label class="control-label col-sm-1">Quantity</label>
        <div class="col-lg-2">
          <div class="input-group control-group">
            <input type="number" name="quantity[]" required="" onchange="calc()" class="form-control quantity" placeholder="Quantity" >
            <div class="input-group-btn">
              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- copy end -->
    
  </div>
</div>


<script type="text/javascript">
function calc()
{

var prices = [];
var quantity = [];

$('#items').find('.price').each(function(){
prices.push($(this).val());
});
$('#items').find('.quantity').each(function(){
quantity.push($(this).val());
});
var total = 0;

$.each( prices, function( key, value ) {
if(value != '' && quantity[parseInt(key)] != '' ){
total += (parseInt(value))*(parseInt(quantity[parseInt(key)]));
}
});
$('#total_price').val(total);
}
$(document).ready(function() {

//here first get the contents of the div with name class copy-fields and add it to after "after-add-more" div class.
$(".add-more").click(function(){
var html = $(".copy-fields").html();
$(".after-add-more").after(html);
calc();
});
//here it will remove the current value of the remove button which has been pressed
$("body").on("click",".remove",function(){
$(this).parents(".form-group").remove();
calc();
});

});
</script>