<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/site.js');?>"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url('assets/swal/sweetalert.min.js');?>"></script>

<script  >


    $(function() {
            $( "#duedate" ).datepicker({ dateFormat: 'yy-mm-dd' });
            
         });
    </script>
    
<!--JS for SWAL-->
<script type="text/javascript">
function getdeleteBrand(id)
{
swal({
title:"Delete",
text: "Hey sir do Want to Delete this Item?",
type:"",
showCancelButton: true,
confirmButtonText:"Aye!",
cancelButtonText:"Nah!",
closeOnConfirm: true
},
function(response)
{

window.location.href="http://localhost/pai_sys/brands/edit/"+ id;

});

}
</script>
</body>
</html>