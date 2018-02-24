<?php if($position=='Administrator'||$position=='Accounting'){?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventory System</title>
     <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
    <![endif]-->
    <script src = "<?php echo base_url('assets/js/jquery-1.10.2.js');?>"></script>
    <script src = "<?php echo base_url('assets/js/jquery-ui.js');?>"></script>
      
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" rel="stylesheet">
    
    <link href = "<?php echo base_url('assets/js/jquery-ui.css');?>"
         rel = "stylesheet">
      

    <!-- Custom CSS -->
    <link href="<?php echo base_url('assets/bootstrap/css/logo-nav.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/swal/sweetalert.css');?>" rel="stylesheet">
    <script type="text/javascript">
        // To conform clear all data in cart.
        function clear_cart() {
            var result = confirm('Are you sure want to clear all bookings?');

            if (result) {
            window.location = "<?php echo base_url(); ?>billing/remove/all";
            } else {
            return false; // cancel button
            }
        }

        function clear_purchase_cart() {
            var result = confirm('Are you sure want to clear all bookings?');

            if (result) {
                window.location = "<?php echo base_url(); ?>items/remove_all";
            } else {
                return false; // cancel button
            }
        }
    </script>

    

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="<?php echo base_url('assets/logo/logo.png') ?>" alt="">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav nav-tabs">
    <li><a href="<?php echo base_url('account/inventory')?>"><i class="fa fa-home"></i> Home</a></li>
       
    <li role="presentation" class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
      Brands <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
       <li><a href="<?php echo base_url('brands')?>"><i class="fa fa-simplybuilt"></i> Manage Brands</a></li>
       <li><a href="<?php echo base_url('brands/create')?>"><i class="fa fa-simplybuilt"></i> Add New Brands</a></li>
    </ul>
  </li>

  <li role="presentation" class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
      Items <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
       <li><a href="<?php echo base_url('items')?>"><i class="fa fa-simplybuilt"></i> Manage Item</a></li>
       <li><a href="<?php echo base_url('items/create')?>"><i class="fa fa-simplybuilt"></i> Add New Item</a></li>
    </ul>
  </li>
  <li role="presentation" class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
      Category <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="<?php echo base_url('categories');?>"><i class="fa fa-simplybuilt"></i> Manage Category</a></li>
    <li><a href="<?php echo base_url('categories/create');?>"><i class="fa fa-simplybuilt"></i> Add New Category</a></li>

    </ul>
  </li>
    <li role="presentation" class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
      Products <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
      <li><a href="<?php echo base_url('products')?>"><i class="fa fa-simplybuilt"></i> Manage Products</a></li>
  <li><a href="<?php echo base_url('products/create');?>"><i class="fa fa-simplybuilt"></i> Add New Products</a></li>

    </ul>
  </li>

<li role="presentation" class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
        Item Purchase <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url('items/order_view')?>"><i class="fa fa-simplybuilt"></i> Item Order</a></li>
        <li><a href="<?php echo base_url('items/purchase')?>"><i class="fa fa-simplybuilt"></i> Purchase New Item</a></li>
      </ul>
    </li>
    <li role="presentation" class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
        Product Sell <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li><a href="<?php echo base_url('billing/view')?>"><i class="fa fa-simplybuilt"></i> Product Order</a></li>
        <li><a href="<?php echo base_url('billing')?>"><i class="fa fa-simplybuilt"></i> Sell New Product</a></li>
      </ul>
    </li>

                <ul class=" nav navbar-right navbar-nav">
                    <li>
                      
                           <li class="dropdown">
                             <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                              <i class="fa fa-cog"></i>   My Profile<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                   <li><a href="<?php echo base_url('account/edit/'. $eid);?>"><span class="glyphicon glyphicon-user"></span> User Profile</a></li>
                                     <?php if($position=='Administrator'){?>
                                  
                                  <li class="divider"></li>
                                  <li><a href="<?php echo base_url('account/view_employees');?>"><i class="fa fa-simplybuilt"></i> User Management</a></li>
                                    <?php }?>
                                   
                                   <li class="divider"></li>
                                   <li>  <a href="<?php echo base_url('logout')?>"><span class="glyphicon glyphicon-remove"></span> Logout</a></li>
                                </ul>
                        </li>
                     
                </li>
                    </ul>
                  
            </div>
            <!-- /.navbar-collapse -->      
        </div>
        <!-- /.container -->
    </nav>
    <?php }else{
    redirect(base_url(''));
}?>