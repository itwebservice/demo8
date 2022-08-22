<?php
 include "../../../model/model.php";
// /*======******Header******=======*/
 require_once('../../layouts/admin_header.php');
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$sq = mysqli_fetch_assoc(mysqlQuery("select * from branch_assign where link='reports/reports_homepage.php'"));
$branch_status = $sq['branch_status'];

?>
<input type="hidden" id="branch_status" name="branch_status" value="<?= $branch_status ?>" >
<?= begin_panel('Analysis Reports',96) ?> <span style="font-size: 15px;font-weight: 400;color: #006d6d;margin-left: 15px;" id="span_report_name"></span>

<div class="report_menu main_block">
    <div class="row">
      <div class="col-xs-12">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
          <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <!-- Menu start -->
              <ul class="nav navbar-nav">
              <!-- <li class="dropdown">
                  <a href="#">Business Reports <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">

                  <li><span onclick="show_report_reflect('Group Tour')">Group Tour</span></li>
                  <li class="dropdown_two">
                    <span onclick="show_sub_menu('sub_menu_1')">Gross Sale</span>
	                    <ul class="dropdown_menu_two" id="sub_menu_1">
                          <li><span onclick="show_report_reflect('Gross sale summary')">Summary</span></li>
	                        <li><span onclick="show_report_reflect('Gross sale details')">Details</span></li>
                      </ul>
                    </li> -->
                    <!-- <li><span onclick="show_report_reflect('Refund Gross')">Refund Gross</span></li>
                    <li><span onclick="show_report_reflect('Sale Net')">Sale Net</span></li>
                    <li><span onclick="show_report_reflect('Debit Position')">Debit Position</span></li>
                    <li><span onclick="show_report_reflect('Consolidated Report')">Consolidated Report</span></li>
                    <li><span onclick="show_report_reflect('Comparative Hotels')">Comparative Hotels</span></li>
                    <li><span onclick="show_report_reflect('Comparative Income')">Comparative Income</span></li>
                    <li><span onclick="show_report_reflect('Comparative Liabilities')">Comparative Liabilities</span></li>
                    <li><span onclick="show_report_reflect('Comparative Misc.')">Comparative Misc.</span></li>
                  </ul>
                </li> -->
                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Find Reports <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Branchwise')">Branchwise Report</span></li>
                    <li><span onclick="show_report_reflect('Userwise')">Userwise Report</span></li>
                    <li><span onclick="show_report_reflect('Sourcewise')">Sourcewise Report</span></li>
                    <li><span onclick="show_report_reflect('Servicewise')">Servicewise Report</span></li>
                    <li><span onclick="show_report_reflect('Enquirywise')">Enquirywise Report</span></li>
                    <li><span onclick="show_report_reflect('Userwise_sale')">Userwise Sale Report</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->
                <!-- Single Menu start -->
                <li class="dropdown">
                  <a href="#">Comparative <span class="caret"></span></a>
                  <ul class="dropdown_menu no-pad">
                    <li><span onclick="show_report_reflect('Comparative_hotel')">Comparative Hotel Report</span></li>
                    <li><span onclick="show_report_reflect('Comparative_airlines')">Comparative Airlines Report</span></li>
                    <li><span onclick="show_report_reflect('Comparative_sector')">Comparative Sector Report</span></li>
                    <li><span onclick="show_report_reflect('Repeater_customer_report')">Repeater Customer Report</span></li>
                    <li><span onclick="show_report_reflect('Destination_wise_report')">Destination Wise Report</span></li>
                    <li><span onclick="show_report_reflect('itenary_report')">Itenary Report</span></li> 
                    <li><span onclick="show_report_reflect('Supplier_wise_report')">Supplier Wise Report</span></li>
                    <li><span onclick="show_report_reflect('Agent_wise_query_sale_report')">Agent Wise Query Sale Report</span></li>
                  </ul>
                </li>
                <!-- Single Menu end -->

                
               
              </ul>
            </div>
           </div>
        </nav>
       </div>
    </div>
</div>
    <!-- Main Menu End -->
    <div class="col-xs-12 mg_tp_20">
        <div id="div_report_content" class="main_block">
        </div>
    </div>

</div>
<?= end_panel() ?>
 <script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>                    

<script src="../js/adnary.js"></script>

<script type="text/javascript">

$(function() {
    $("a").on("click", function() {
        if ($(this).parent('li').attr('class')=="dropdown active") {
          $("li.active").removeClass("active");
        }
        else{
          $("li.active").removeClass("active");
          $(this).parent('li').addClass("active");
        }
    });
});

$(function() {
    $("span").on("click", function() {
        $("li.active").removeClass("active");
        $(this).closest('li.dropdown').addClass("active");
    });
});
function show_sub_menu(sub_menu_id){
	$('.dropdown_menu_two').slideUp('slow');
	$('.dropdown_menu_three').slideUp('slow');
	if($('#'+sub_menu_id).css('display') == 'none')
	{
		$('#'+sub_menu_id).slideDown('slow'); 
	}
	else{
		$('#'+sub_menu_id).slideUp('slow'); 
	}
}
function show_report_reflect(report_name){

    $('#span_report_name').html(report_name);

    if(report_name=="Branchwise"){ url = 'report_reflect/branchwise_report/index.php'; }
    if(report_name=="Userwise"){ url = 'report_reflect/userwise_report/index.php'; }
    if(report_name=="Sourcewise"){ url = 'report_reflect/sourcewise_report/index.php'; }
    if(report_name=="Servicewise"){ url = 'report_reflect/servicewise_report/index.php'; }
    if(report_name=="Enquirywise"){ url = 'report_reflect/enquirywise_report/index.php'; }
    if(report_name=="Userwise_sale"){ url = 'report_reflect/userwise_sale_report/index.php'; }
    if(report_name=="Comparative_hotel"){ url = 'report_reflect/comparative_hotel_report/index.php'; }
    if(report_name=="Comparative_airlines"){ url = 'report_reflect/comparative_airlines_report/index.php'; }
    if(report_name=="Comparative_sector"){ url = 'report_reflect/comparative_sector_report/index.php'; }
    if(report_name=="Repeater_customer_report"){ url = 'report_reflect/repeater_customer_report/index.php'; }
    if(report_name=="Destination_wise_report"){ url = 'report_reflect/destination_wise_report/index.php'; }
    if(report_name=="Supplier_wise_report"){ url = 'report_reflect/supplier_wise_report/index.php'; }
    if(report_name=="Agent_wise_query_sale_report"){ url = 'report_reflect/agent_wise_query_sale_report/index.php'; }
    if(report_name=="itenary_report"){ url = 'report_reflect/itenary report/index.php'; }

    

    $.post(url,{}, function(data){
     
        $(".dropdown_menu").addClass('hidden');
        $("li.active").removeClass("active");
        $('#div_report_content').html(data);
        setTimeout(
          function(){
            $(".dropdown_menu").removeClass('hidden'); 
          }, 500);
    });
}
show_report_reflect('Branchwise');
</script>

<script>
	function exportToExcel(tableid) {
		$(document).ready(function () {
    
        TableToExcel.convert(document.getElementById(tableid), {
            name: tableid+".xlsx",
            sheet: {
            name: "Sheet1"
            }
         
        });
  });
	}
</script>
<?php
/*======******Footer******=======*/
require_once('../../layouts/admin_footer.php');
?>