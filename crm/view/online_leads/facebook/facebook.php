<?php
include '../../../model/model.php';
global $appIdFB;
$query = mysqli_fetch_assoc(mysqlQuery("SELECT popular_hotels FROM `b2c_settings` where setting_id='1'"));
$popular_hotels = json_decode($query['popular_hotels']);
?>
<input type="hidden" id="appIdFB" value="<?= $appIdFB ?>">
 <input type="hidden" id="appSecretFB" value="<?= $appSecretFB ?>">
    <legend>Facebook Pages Subscription List</legend> </div>
    <div class="row mg_bt_20">
        <div class="col-md-10">
            <label class="alert-danger">Keep your account logged in!!</label>
        </div> 
        <div class="col-md-2"> 
            <div id="fb-root"></div>
            <div class="fb-login-button" data-width="" data-size="medium" data-button-type="login_with" data-layout="default" data-auto-logout-link="true" data-onlogin="reloadPage()"  data-scope="public_profile,pages_manage_metadata,leads_retrieval,pages_show_list" data-use-continue-as="true">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="tbl_pages" name="tbl_pages" class="table table-hover">
            
        </table>
     </div> 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>view/online_leads/js/facebook.js"></script>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v11.0&autoLogAppEvents=1" nonce="IMbqPYrF"></script>
<script>
    $('#tbl_pages').DataTable( {
          data: [],
          columns: [
              { title: "Sr No" },
              { title: "Page Name" },
              { title: "Subscription_Status" },
              { title: "Subscribe/Unsubscribe" }
          ]
      } );
      function reloadPage(){
        location.reload();
      }
</script>