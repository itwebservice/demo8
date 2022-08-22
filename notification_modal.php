<?php include "config.php";
$message = $_POST['message'];
$class_name = $_POST['class_name'];
?>
<div class="alert <?=$class_name?> alert-dismissible fade show c-alert" role="alert">
  <?= $message ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<script>
setTimeout(function(){
  $('.c-alert').alert('close');
},3000);
</script>