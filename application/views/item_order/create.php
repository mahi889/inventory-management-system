<div class="container">
  <?php //$this->load->view('layout/inventory_header'); ?>
  <div class="well">
    <h2>Purchase Item</h2>
    <?php if(validation_errors()==TRUE){?>
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo validation_errors();?>
    </div>
    <?php }?>
    <?php echo form_open('item_order/create',array('class'=>'form-horizontal'));?>
      <div class="form-group">
        <label class="control-label col-sm-2">Seller</label>
        <div class="col-lg-4">
          <select name='seller' class="form-control">
            <?php foreach($sellers as $seller){?>
            <option value="<?php echo $seller->empid ?>" class="form-control"><?php echo $seller->F_name.' '.$seller->L_name.' S/O '.$seller->father_name ?></option>
            <?php }?>
          </select>
        </div>
      </div>
    <div id="items">
      
      <div class="form-group  after-add-more">
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
          <input type="number" name="price[]" required onchange="calc()" class="form-control price" placeholder="Price" >
        </div>
        <label class="control-label col-sm-1">Quantity</label>
        <div class="col-lg-2">
          <div class="input-group control-group">
            <input type="number" name="quantity[]" required onchange="calc()" class="form-control quantity" placeholder="Quantity" >
            <div class="input-group-btn">
              <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    
    
    <div class="form-group form-inline has-primary">
      <label class="control-label col-sm-2" for="inputGroupSuccess3">Price</label>
      <div class="col-lg-2">
        <div class="input-group">
          <span class="input-group-addon">$</span>
          <input type="text" class="form-control" id="total_price" name="total_price" placeholder="Amount">
        </div>
      </div>
    </div>

    <div class="form-group form-inline">
      <label class="control-label col-sm-2" >Item Status</label>
      <div class="col-sm-2">
        <div class="input-group">
          <div class="input-group-addon"></div>
          <select name="item_status" class="form-control">
            <option value="delivered">Delivered</option>
            <option value="no-delivered">Not Delivered</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2">Payment Type</label>
      <div class="col-lg-2">
        <select name="payment" class="form-control">
          <option value="cash">Cash</option>
          <option value="loan">Loan</option>
          <option value="check">Check</option>
        </select>
      </div>
    </div>
    
    <div class="form-group form-inline">
      <label class="control-label col-sm-2" style="float:left;">Payment Status</label>
      <div class="col-sm-2">
        <div class="input-group">
          <div class="input-group-addon"></div>
          <select name="status" class="form-control">
            <option value="complete">Complete</option>
            <option value="due">Due</option>
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
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

    <div class="form-group">
      <label class="control-label col-sm-2">Due Amount</label>
      <div class="col-lg-2">
        
          <input type="number" id="dueamount" max="<?php echo number_format($total,2); ?>" name="duedate"  class="form-control">
          
        </div>
      </div>
    </div>


    
    
    <div class="form-group">
      <label class="control-label col-sm-2">Comment</label>
      <div class="col-lg-4">
        <textarea name="comment" class="form-control comment" placeholder="Comment"></textarea>
      </div>
    </div>
    
    
    
    <div class="form-group">
      <div class="col-lg-2 col-lg-offset-10">
        <input type="submit" name="submit" value="Add" class="btn btn-primary "/>
      </div>
    </div>
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
              <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> </button>
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