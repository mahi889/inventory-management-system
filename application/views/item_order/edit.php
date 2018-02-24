<div class="container">

<div class="well"> 
<h2>Edit Product</h2>
 <?php 

      foreach($records as $data){
        
        ?>
    <?php echo form_open('products/edit/'.$data->pid,array('class'=>'form-horizontal'));?>
    
    <?php 
    $product_name = set_value('product_name') == false ? $data->product_name: set_value('product_name'); 
    $cat_id = set_value('category') == false ? $data->category_id : set_value('category'); 
    
    $item_id = set_value('item_id') == false ? '' : set_value('item_id');
    $price = set_value('price') == false ? $data->price : set_value('price');
    $quantity = set_value('quantity') == false ? '' : set_value('quantity');
    
    $stock = set_value('stock') == false ? $data->stock : set_value('stock');
    $comment = set_value('comment') == false ? $data->comment : set_value('comment');
    $total_price = set_value('total_price') == false ? $data->total_price : set_value('total_price');
    /*echo '<pre>';
    print_r($item_id); 
    echo '</pre>';*/
    ?>

     <input type="text" name="did" id="hide" value="<?php echo $data->pid;?>">
      <div class="form-group">
        <label class="control-label col-sm-2">Product Name</label>
          <div class="col-lg-8">
            <input type="text" name="product_name" class="form-control" value="<?php echo $product_name;?>" disabled>
          </div>
      </div>


   <div class="form-group form-inline">
        <label class="control-label col-sm-2" style="float:left;">Category</label>
          <div class="col-sm-4">
            <div class="input-group">
            <div class="input-group-addon"><?php echo $data->category_name;?></div>
              <select name="category" class="form-control">
              <option value="<?php echo $data->cid;?>"><?php echo $data->category_name;?></option>
                <?php foreach ($category as $key) {
                    if($data->cid==$key->id){}else{?>
                  <option value="<?php echo $key->id;?>"><?php echo $key->category_name;?></option>
                  <?php } }?>
                </select>
            </div>
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
                    <?php if($bnd->brand_name==$data->brand_name) 
                     {}else{?>
                  <option value="<?php echo $bnd->id;?>"><?php echo $bnd->brand_name;?></option>
                  <?php } }?>
                </select>
            </div>
          </div>
      </div>


       <div class="form-group">
        <label class="control-label col-sm-2">Stock(Units) Current:</label>
         <div class="col-sm-2">
            <div class="input-group">
              <div class="input-group-addon"> <?php echo $data->Quantity;?></div>
              <input type="text" name="cstock" id="hide" value=" <?php echo $data->Quantity;?>">
            <input type="text" name="stock" class="form-control" >
            </div>
          </div>
      </div>

       <div class="form-group">
        <label class="control-label col-sm-2">price</label>
          <div class="col-sm-2">
            <div class="input-group">
              <div class="input-group-addon"><?php echo $data->price;?></div>
                 <input type="text" name="price" class="form-control" value="<?php echo $data->price;?>">
            </div>
           
          </div>
      </div>

     <div class="form-group form-inline">
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
      </div>
    
       <div class="form-group">
        <div class="col-lg-2 col-lg-offset-10">
          <input type="submit" name="submit" value="Update" class="btn btn-primary "/>
        </div>
      </div>
    <?php } ?>
           
  <?php echo form_close();?> 

  
</div>
</div>