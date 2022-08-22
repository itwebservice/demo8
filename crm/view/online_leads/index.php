<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('Online Leads Settings','') ?>

<div class="div_left type-02">
    <ul class="nav nav-pills">
        <li role="presentation" class="dropdown active">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('1')">
            Facebook
            </a>
        </li>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('2')">
            Instagram
            </a>
        </li>
        <li role="presentation" class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('3')">
            Twitter
            </a>
        </li>          
    </ul>
</div>
<div class="div_right type-02">
    <div id="section_data_form"></div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script type="text/javascript">
function reflect_data(section,dest_id1=''){

    if(section === '1'){
        $.post('facebook/facebook.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '2'){
        $.post('package_tours/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '3'){
        $.post('hotels/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }

    $('.type-02 .dropdown .dropdown-toggle').on('click',function(){
        $(this).parent('.dropdown').addClass('active').siblings().removeClass('active');
    })
}
reflect_data('1');

</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>