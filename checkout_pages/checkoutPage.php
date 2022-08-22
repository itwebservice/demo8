<?php
include '../../model/model.php';
$b2b_agent_code = $_SESSION['b2b_agent_code'];
$username = $_SESSION['b2b_username'];
$password = $_SESSION['b2b_password'];
$customer_id = $_SESSION['customer_id'];

if(isset($b2b_agent_code)&&isset($username)&&isset($password)){
//Include header
include '../layouts/header.php';
?>
<input type='hidden' name='customer_id' id='customer_id' value='<?= $customer_id ?>'/>
<div class="c-pageTitleSect">
    <div class="container">
        <div class="row">
        <div class="col-md-7 col-12">
            <!-- *** Search Head **** -->
            <div class="searchHeading">
            <span class="pageTitle m0">Shopping Cart</span>
            </div>
            <!-- *** Search Head End **** -->
        </div>

        <div class="col-md-5 col-12 c-breadcrumbs">
            <ul>
            <li>
                <a href="<?= $b2b_index_url ?>">Home</a>
            </li>
            <li class="st-active">
                <a href="javascript:void(0)">Shopping Cart</a>
            </li>
            </ul>
        </div>
        </div>
    </div>
</div>
<!-- ********** Component :: Page Title End ********** -->
<div id='get_checkoutpage' class='c-containerDark'></div>

<?php include '../layouts/footer.php';?>
<script>
get_checkoutpage();
$(document).ready(function () {
    initilizeDropdown();
    index_page_currencies();
});
function get_checkoutpage(){
    var base_url = $('#base_url').val();
	var cart_list_arr = JSON.parse(localStorage.getItem('cart_list_arr'));

    if (typeof Storage !== 'undefined'){
        if (localStorage) {
            var global_currency = localStorage.getItem('global_currency');
        } else {
            var global_currency = window.sessionStorage.getItem('global_currency');
        }
    }
    if (typeof Storage !== 'undefined'){
      if (sessionStorage) {
        var timing_slots = window.sessionStorage.getItem('timing_slots');
        var payment_amount = window.sessionStorage.getItem('payment_amount');
      }
      else {
        var timing_slots = localStorage.getItem('timing_slots');
        var payment_amount = localStorage.getItem('payment_amount');
      }
    }
    $.post(base_url + 'Tours_B2B/checkout_pages/get_checkoutpage.php', { cart_list_arr : cart_list_arr,payment_amount:payment_amount ,global_currency:global_currency, timing_slots:timing_slots}, function (data) {
		$('#get_checkoutpage').html(data);
        $('#country_id').select2();
    });
}
</script>
<?php
}
else{
?>
<script>
window.location.href = "../login.php";
</script>
<?php } ?>