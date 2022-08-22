<?php
include '../model/model.php';
global $currency;
$sq_curr = mysqli_fetch_assoc(mysqlQuery("select id from currency_name_master where id='$currency'"));
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login</title>
    <meta
      name="description"
      content="Author: ITWEB Services-iTours, Category: Tours & Travels Product"
    />
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/css-styles.css" />

    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/bootstrap-4.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery.wysiwyg.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/jquery-labelauty.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/dynforms.vi.css">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>css/vi.alert.css">
    <link id="main-style" rel="stylesheet" href="<?php echo BASE_URL ?>Tours_B2B/css/itours-styles.css" />
  </head>
  <body>
  <input type='hidden' id='base_url' value='<?= BASE_URL ?>'/>
  <input type='hidden' id='global_currency' value='<?= $sq_curr['id'] ?>'/>
    <!-- ********** Login Page :: Start ********** -->
    <div class="c-loginContainer">

      <!-- ******** Login Window :: Start ******** -->
      <div class="login_modal">

        <!-- ****** Login Form :: Start ****** -->
        <form id="frm_login" method='post'>
        <div class="login_form">

          <!-- **** Headings :: Start **** -->
          <span class="login_heading">Login</span>
          <span class="login_subheading">Discover a competitive pricing</span>
          <!-- **** Headings :: End **** -->

          <!-- **** Form Field :: Start **** -->
          <div class="formField">
            <input
              type="text"
              class="input-txtbox"
              placeholder="Enter Agent Code"
              title="Please Enter Agent Code"
              id='agent_code' name='agent_code' required
            />
          </div>
          <div class="formField">
            <input
              type="text"
              class="input-txtbox"
              placeholder="Enter User Name"
              title="Please Enter User Name"
              id='user_name' name='user_name' required
            />
          </div>
          <div class="formField">
            <input
              type="password"
              class="input-txtbox pass"
              placeholder="Enter Password"
              title="Please Enter Password"
              id='password' name='password' required
            /><a onclick="show_password('password')" target="_BLANK" class="btn app_btn" title="View Password"><i class="fa fa-eye"></i></a>
          </div>
          <!-- **** Form Field :: End **** -->

          <!-- ****  forgot password Button :: Start **** -->
          <div class="btnContainer type-link text-right">
          <input type='button' class="btn-link bold underline" id='send_btn' onclick="open_modal();" value='Forgot Password?'/>
          </div>
          <!-- ****  forgot password Button :: End **** -->
          <div id="site_alert"></div>

          <!-- **** Sign In Button :: Start **** -->
          <div class="btnContainer">
            <button class="btn-submit" type='submit' id='sign_in'>Sign In</button>
          </div>
          <!-- **** Sign In Button :: End **** -->

          <!-- **** Register Button :: Start **** -->
          <div class="btnContainer type-link text-center">
            <span class="beforeText">Not a member Yet..?</span>
            <!-- <button class="btn-link bold underline">Register Here</button> -->
            <a class="btn-link bold underline" target='_blank' href="../view/b2b_customer/registration/index.php">Register Here</a> 
          </div>
          <!-- **** Register Button :: End **** -->

        </div>
        </form>
        <!-- ****** Login Form :: End ****** -->
          <div id='div_modal'></div>
      </div>
      <!-- ******** Login Window ::   End ******** -->

    </div>
    <!-- ********** Login Page :: End ********** -->
  </body>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL ?>Tours_B2B/js/bootstrap-4.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.wysiwyg.js"></script>  
    <script src="<?php echo BASE_URL ?>js/script.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery-labelauty.js"></script>
    <script src="<?php echo BASE_URL ?>js/dynforms.vi.js"></script>
    <script src="<?php echo BASE_URL ?>js/jquery.validate.min.js"></script>
    <script src="<?php echo BASE_URL ?>js/vi.alert.js"></script>
    <script src="js/scripts.js"></script>
</html>
<Script>
//(Local+Seesion)Storage Data clearance
window.onload = function () {
  if (typeof Storage !== 'undefined') {
    if (localStorage) {
      localStorage.clear();
    } if (sessionStorage) {
      sessionStorage.clear();
    }
  }
};
function show_password(password) {
	var x = document.getElementById(password);
	if (x.type === 'password') {
		x.type = 'text';
	}
	else {
		x.type = 'password';
	}
}
function open_modal(){
	$.post('../view/b2b_customer/registration/forgot_password_link.php', { }, function(data){
			$('#div_modal').html(data);
	});
} 
$('#frm_login').validate({
  rules:{
  },
  submitHandler:function(form){
    var agent_code = $('#agent_code').val();
    var username = $('#user_name').val();
    var password = $('#password').val();
    $('#sign_in').button('loading');
    $.post('../controller/b2b_customer/login/login_verify.php', { agent_code:agent_code,username : username, password : password }, function(data){
        var data1 = data.split('--');
        if(data1[0]=="valid"){
          var global_currency = $('#global_currency').val();
          if (typeof Storage !== 'undefined') {
            if (localStorage) {
              localStorage.setItem(
                'global_currency', global_currency
              );
            } else {
              window.sessionStorage.setItem(
                'global_currency', global_currency
              );
            }
          }
          if (typeof Storage !== 'undefined') {
            console.log(JSON.parse((data1[1])));
            if (localStorage) {
              var cart_list_arr = (JSON.parse(data1[1]) == "") ? JSON.stringify([]) : JSON.parse(data1[1]);
              localStorage.setItem('cart_list_arr',cart_list_arr);
              var cart_item_list = [];
              localStorage.setItem('cart_item_list',JSON.stringify(cart_item_list));
            }
          }
          window.location.href = "view/index.php";
        } 
        else{
          $('#sign_in').button('reset');
          error_msg_alert(data1[0]);
        }
    });
  }
});
</script>
