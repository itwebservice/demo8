<?php 
 include "../../../model/model.php";
 $id = $_POST['id'];
 $sql_query = mysqli_fetch_assoc(mysqlQuery("select * from email_template_master where template_id='$id'"));
 $newUrl1 = preg_replace('/(\/+)/','/',$sql_query['template_url']);
$newUrl = explode('uploads', $newUrl1);
$download_url = BASE_URL.'uploads'.$newUrl[1];
?>

<div class="modal fade profile_box_modal" id="view_modal1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="mg_bt_20">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <!-- <h4 class="modal-title" id="myModalLabel">Email Template</h4> -->
    </div>
    <div class="modal-body profile_box_padding">
        
	  	<div>
	  		<img class="img-responsive" src="<?php echo $download_url ?>">
	    </div>
    </div>
	</div>
  </div>
</div>

<script>
$('#view_modal1').modal('show');
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

<script>
  $('#view_modal').modal('show');
</script>  

 

