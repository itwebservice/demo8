<?php include_once('../../model/model.php');
require_once('../layouts/admin_header.php'); ?>
<script>
function backup_application()
{
	var base_url = $('#base_url').val();
	var status = confirm('Are you sure want to take backup?');
	if(status==false){
		return false;
	}
	var $btn = $('button').button('loading')

	$.ajax({
		type:'post',
		url:'installer/installer_init.php',
		data:{},
		success:function(result){
			msg_alert("Backup done successfully!");	
			$btn.button('reset');
			//window.location = result;
			var element = document.createElement('a');
			element.setAttribute('href', result);
			element.style.display = 'none';
			element.target = '_blank';
			element.setAttribute('download', 'backup');
			document.body.appendChild(element);
			element.click();

			document.body.removeChild(element);
		},
		error:function(result){
			console.log(result.responseText);
		}
	});
}
backup_application();
</script>
<?php require_once('../layouts/admin_footer.php'); ?>
