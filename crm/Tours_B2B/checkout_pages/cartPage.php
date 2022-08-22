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
                <a href='javascript:javascript:history.go(-1)' class="backBtn">Continue Shopping</a>
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
      <div id='get_checkoutpage_cart'></div>

<?php include '../layouts/footer.php';?>
<script type="text/javascript" src="../view/hotel/js/index.js"></script>
<script type="text/javascript" src="../js/scripts.js"></script>
<script>
$(document).ready(function () { 
  initilizeDropdown();
  get_checkoutpage_cart();
});
//Remove Item from Cart
function remove_item(id){
    var base_url = $('#base_url').val();
    var register_id = $('#register_id').val();
    var cart_list_arr = JSON.parse(localStorage.getItem('cart_list_arr'));
    for (var i =0; i< cart_list_arr.length; i++) {
        if (cart_list_arr[i]['service']['uuid'] === id) cart_list_arr.splice(i, 1);
    }
    localStorage.setItem("cart_list_arr", JSON.stringify(cart_list_arr));
    get_checkoutpage_cart();
    $('#cart_item_count').html(cart_list_arr.length);
    
    $.post(base_url+'controller/b2b_customer/update_cart.php', { register_id : register_id,cart_list_arr:cart_list_arr }, function (data){
        get_cart_items(cart_list_arr);
        localStorage.setItem("cart_list_arr", JSON.stringify(cart_list_arr));
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