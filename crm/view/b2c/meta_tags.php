<?php
include '../../model/model.php';
$query = mysqlQuery("SELECT * FROM `b2c_meta_tags` where 1");
$sq_count = mysqli_num_rows(mysqlQuery("SELECT * FROM `b2c_meta_tags` where 1"));
// $meta_tags = ($sq_count == 0) ? json_decode($query['meta_tags']): [];
?>
<form id="section_meta_tags">
    <legend>Define Pagewise Meta Tags</legend>
    <div class="row"> 
        <div class="col-md-4"> <label class="alert-danger">For saving meta tag keep checkbox selected!</label> </div>
        <div class="col-md-8 text-right">
        <button type="button" class="btn btn-excel btn-sm" onclick="addRow('tbl_meta_tags')" title="Add Row"><i class="fa fa-plus"></i></button>
    </div> </div>

    <div class="row mg_bt_20"> <div class="col-md-12"><div class="table-responsive">
    <table id="tbl_meta_tags" name="tbl_meta_tags" class="table border_0 table-hover" style="width:1000px;">
        <?php
        if($sq_count == 0){?>
            <tr>
                <td><input id="chk_meta_tags1" type="checkbox" checked></td>
                <td><input maxlength="15" value="1" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="page-1" id="page-1" title="Select Page" class="form-control app_select2" style="width:150px" class="form-control">
                    <option value="">*Select Page</option>
                    <option value="index">Index Page</option>
                    <option value="hotels-list">Hotel</option>
                    <option value="activities">Activity</option>
                    <option value="Visa">Visa</option>
                    <option value="Car Rental">Car Rental</option>
                    <option value="Cruise">Cruise</option>
                    <option value="services">Services</option>
                    <option value="contact">Contact Us</option>
                    <option value="about">About Us</option>
                    <option value="blog">Blog</option>
                    <option value="blog-inner">Indivisual Blog</option>
                    <option value="Offers">Offers</option>
                    <option value="enquiry">Enquiry</option>
                    <option value="refund-policy">Refund Policy</option>
                    <option value="privacy-policy">Privacy Policy</option>
                    <option value="cancellations-policy">Cancellation Policy</option>
                    <option value="terms">Terms Of Use</option>
                    <option value="testimonials">Testimonials</option>
                    <option value="tips">Tips Before Travels</option>
                    <option value="sitemap">Sitemap</option>
                    <option value="404">404 Error</option>
                    <option value="award">Awards</option>
                    <option value="gallary_new">Gallery</option>
                    <option value="career">Career</option>
                </select></td>
                <td><textarea id="title-1" name="title" title="*Title" placeholder="*Title" onchange="validate_char_size('title-1',120);" rows="1"></textarea></td>
                <td><textarea id="description-1" name="description" title="*Description" placeholder="*Description" onchange="validate_char_size('description-1',200);" rows="1"></textarea></td>
                <td><textarea id="keywords-1" name="keywords" title="*Keywords" placeholder="*Keywords" onchange="validate_char_size('keywords-1',500);" rows="1"></textarea></td>
                <td><input type="hidden" id="entry_id-1" value=''/></td>
            </tr>
            <script>
                $('#page-1').select2();
            </script>
        <?php
        }else{
            $i = 0;
            while($row_query = mysqli_fetch_assoc($query)){
                $i++;
            ?>
            <tr>
                <td><input id="chk_meta_tags1<?=$i?>_u" type="checkbox" checked disabled></td>
                <td><input maxlength="15" value="<?=$i?>" type="text" name="no" placeholder="Sr. No." class="form-control" disabled /></td>
                <td><select name="page-1" id="page-1<?=$i?>_u" title="Select Page" class="form-control app_select2" style="width:150px" class="form-control">
                <?php
                if($row_query['page'] == 'index')
                $page = 'Index Page';
                else if($row_query['page'] == 'hotels-list')
                $page = 'Hotel';
                else if($row_query['page'] == 'activities')
                $page = 'Activity';
                else if($row_query['page'] == 'Visa')
                $page = 'visa';
                else if($row_query['page'] == 'services')
                $page = 'Services';
                else if($row_query['page'] == 'contact')
                $page = 'Contact Us';
                else if($row_query['page'] == 'about')
                $page = 'About Us';
                else if($row_query['page'] == 'blog')
                $page = 'Blog';
                else if($row_query['page'] == 'blog-inner')
                $page = 'Indivisual Blog';
                else if($row_query['page'] == 'Offers')
                $page = 'Offers';
                else if($row_query['page'] == 'enquiry')
                $page = 'Enquiry';
                else if($row_query['page'] == 'refund-policy')
                $page = 'Refund Policy';
                else if($row_query['page'] == 'privacy-policy')
                $page = 'Privacy Policy';
                else if($row_query['page'] == 'cancellations-policy')
                $page = 'Cancellation Policy';
                else if($row_query['page'] == 'terms')
                $page = 'Terms Of Use';
                else if($row_query['page'] == 'testimonials')
                $page = 'Testimonials';
                else if($row_query['page'] == 'tips')
                $page = 'Tips Before Travels';
                else if($row_query['page'] == 'sitemap')
                $page = 'Sitemap';
                else if($row_query['page'] == '404')
                $page = '404 Error';
                else if($row_query['page'] == 'award')
                $page = 'Awards';
                else if($row_query['page'] == 'gallary_new')
                $page = 'Gallery';
                else if($row_query['page'] == 'career')
                $page = 'Career';
                ?>
                    <option value="<?= $row_query['page'] ?>"><?= $page ?></option>
                    <option value="">*Select Page</option>
                    <option value="index">Index Page</option>
                    <option value="hotels-list">Hotel</option>
                    <option value="activities">Activity</option>
                    <option value="Visa">Visa</option>
                    <option value="Car Rental">Car Rental</option>
                    <option value="Cruise">Cruise</option>
                    <option value="services">Services</option>
                    <option value="contact">Contact Us</option>
                    <option value="about">About Us</option>
                    <option value="blog">Blog</option>
                    <option value="blog-inner">Indivisual Blog</option>
                    <option value="Offers">Offers</option>
                    <option value="enquiry">Enquiry</option>
                    <option value="refund-policy">Refund Policy</option>
                    <option value="privacy-policy">Privacy Policy</option>
                    <option value="cancellations-policy">Cancellation Policy</option>
                    <option value="terms">Terms Of Use</option>
                    <option value="testimonials">Testimonials</option>
                    <option value="tips">Tips Before Travels</option>
                    <option value="sitemap">Sitemap</option>
                    <option value="404">404 Error</option>
                    <option value="award">Awards</option>
                    <option value="gallary_new">Gallery</option>
                    <option value="career">Career</option>
                </select></td>
                <td><textarea style="width:200px;" id="title-1<?=$i?>_u" name="title" title="*Title" placeholder="*Title" onchange="validate_char_size('title-1<?=$i?>_u',120);" rows="1"><?= $row_query['title'] ?></textarea></td>
                <td><textarea style="width:200px;" id="description-1<?=$i?>_u" name="description" placeholder="*Description" title="*Description" onchange="validate_char_size('description-1<?=$i?>_u',200);" rows="1"><?= $row_query['descriiption'] ?></textarea></td>
                <td><textarea style="width:200px;" id="keywords-1<?=$i?>_u" name="keywords" placeholder="*Keywords" title="*Keywords" onchange="validate_char_size('keywords-1<?=$i?>_u',500);" rows="1"><?= $row_query['keywords'] ?></textarea></td>
                <td><input type="hidden" id="entry_id-1<?=$i?>_u" value='<?= $row_query['entry_id'] ?>'/></td>
            </tr>
            <script>
                $('#page-1<?=$i?>_u').select2();
            </script>
            <?php
            }
        } ?>
    </table>
    </div> </div></div>
    <div class="row mg_tp_20">
        <div class="col-xs-12 text-center">
            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</form>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$(function(){
$('#section_meta_tags').validate({
    rules:{
    },
    submitHandler:function(form){

    var base_url = $('#base_url').val();

    var images_array = new Array();
    var table = document.getElementById("tbl_meta_tags");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        var page = row.cells[2].childNodes[0].value;
        var title = row.cells[3].childNodes[0].value;
        var desc = row.cells[4].childNodes[0].value;
        var keyword = row.cells[5].childNodes[0].value;
        var entry_id = row.cells[6].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){

            if(page==""){ error_msg_alert("Select page at row "+(i+1)); return false; }
            if(title==""){ error_msg_alert("Enter title at row "+(i+1)); return false;}
            if(desc==""){ error_msg_alert("Enter description at row "+(i+1)); return false; }
            if(keyword==""){ error_msg_alert("Enter keywords at row "+(i+1)); return false; }
            
            var flag1 = validate_char_size(row.cells[3].childNodes[0].id,120);
            if(!flag1){
                return false;
            }
            var flag2 = validate_char_size(row.cells[4].childNodes[0].id,200);
            if(!flag2){
                return false;
            }
            var flag3 = validate_char_size(row.cells[5].childNodes[0].id,500);
            if(!flag3){
                return false;
            }
            images_array.push({
                'entry_id':entry_id,
                'page':page,
                'title':title,
                'desc':desc,
                'keyword':keyword
            });
        }
    }
    console.log(images_array);
    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2c_settings/cms_save.php',
    data:{ section : '18', data : images_array},
        success: function(message){
        $('#btn_save').button('reset');
            var data = message.split('--');
            if(data[0] == 'erorr'){
                error_msg_alert(data[1]);
            }else{
                success_msg_alert(data[1]);
                reflect_data('18');
                update_b2c_cache();
            }
        }
    });
}
});
});
</script>