<?php
include '../../config.php';
include BASE_URL.'model/model.php';
include '../../layouts/header.php';

$visa_array = json_decode($_SESSION['visa_array']);
$country_id = ($visa_array[0]->country_id);

if($country_id==''){
  $query = "select * from country_list_master where 1 ";
}
else{
  $sq_city = mysqli_fetch_assoc(mysqlQuery("select country_name from country_list_master where country_id='$country_id'"));
  $query = "select * from country_list_master where country_id='$country_id'";
}
$query .= " order by country_name asc";
//Page Title
if($country_id!=''){
  $page_title = 'Results for '.$sq_city['country_name'];
}else{
  $page_title = 'Visa';
}
?>
      <!-- ********** Component :: Page Title ********** -->
      <div class="c-pageTitleSect">
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-12">

              <!-- *** Search Head **** -->
              <div class="searchHeading">
                <span class="pageTitle"><?= $page_title ?></span>

                <div class="clearfix">
                <?php
                if($country_id!=''){ ?>
                  <div class="sortSection">
                    <span class="sortTitle st-search">
                      <i class="icon it itours-timetable"></i>
                      Country Name: <strong><?= $sq_city['country_name'] ?></strong>
                    </span>
                  </div>
                <?php } ?>
                </div>

                <div class="clearfix">
                  <div class="sortSection">
                    <span class="sortTitle st-search">
                      <i class="icon it itours-search"></i>
                      <span>Showing <span class="results_count"></span></span>
                    </span>
                  </div>
                </div>
              </div>
              <!-- *** Search Head End **** -->
            </div>

            <div class="col-md-5 col-12 c-breadcrumbs">
              <ul>
                <li>
                  <a href="<?= BASE_URL_B2C ?>">Home</a>
                </li>
                <li class="st-active">
                  <a href="javascript:void(0)">Visa Search Result</a>
                </li>
              </ul>
            </div>

          </div>
        </div>
      </div>
      <!-- ********** Component :: Page Title End ********** -->

      <!-- ********** Component :: Visa Listing  ********** -->
      <div class="c-containerDark">
        <div class="container">
           <!-- ********** Component :: Modify Filter  ********** -->
            <div class="row c-modifyFilter">
                <div class="col">
                  <!-- Modified Search Filter -->
                  <form id="frm_visa_search">
                    <div class="row text-center">
                        <input type='hidden' id='page_type' value='search_page' name='search_page'/>
                        <!-- *** City Name *** -->
                        <div class="col-md-4 col-md-offset-3 col-sm-6 col-sm-offset-3 col-12">
                          <div class="form-group">
                            <label>Select Country</label>
                            <div class="">
                              <select id='visa_country_filter' class="full-width js-roomCount" style="width:100%">
                              <?php
                              if($country_id != ''){ ?>
                                <option value="<?= $country_id ?>"><?= $sq_city['country_name'] ?></option>
                              <?php } ?>
                              <option value="">Visa Country</option>
                                <?php
                                $sq_country = mysqlQuery("select * from country_list_master");
                                while ($row_country = mysqli_fetch_assoc($sq_country)) {
                                ?>
                                  <option value="<?= $row_country['country_id'] ?>"><?= $row_country['country_name'] ?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <!-- *** City Name End *** -->
                        <!-- *** Search Rooms *** -->
                        <div class="col-md-3 col-sm-6 col-12">
                        <button class="c-button lg colGrn m26-top">
                            <i class="icon itours-search"></i> SEARCH NOW
                        </button>
                        </div>
                        <!-- *** Search Rooms End *** -->
                    </div>
                  </form>
                  <!-- Modified Search Filter End -->
                </div>
            </div>
            <hr/>
          <div class="row">
            <!-- ***** Visa Listing ***** -->
            <div class="col-md-12 col-sm-12">
            <?php
            $visa_results_array = array();
            $array = array();
            $sq_query = mysqlQuery($query);
            while(($row_query  = mysqli_fetch_assoc($sq_query))){
              $visa_info_arr = array();
              $country_name = addslashes($row_query['country_name']);
              $q1 = "SELECT * FROM `visa_crm_master` WHERE `country_id`='$country_name'";
              $sq_visa = mysqlQuery($q1);
              while($row_visa = mysqli_fetch_assoc($sq_visa)){
                
                array_push($visa_info_arr ,array(
                  "visa_type"=>$row_visa['visa_type'],
                  "time_taken"=>$row_visa['time_taken'],
                  "documents"=>$row_visa['list_of_documents'],
                  "upload_url1"=>$row_visa['upload_url'],
                  "upload_url2"=>$row_visa['upload_url2'],
                ));
              }

              array_push($visa_results_array,array(
                "country_id"=>$row_query['country_id'],
                "country_name"=>$country_name,
                'visa_info'=>$visa_info_arr
              ));
            }
            ?>
              <input type='hidden' value='<?= json_encode($visa_results_array,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>' id='visa_results_array' name='visa_results_array'/>
              <div id='visa_result_block'></div>
            </div>
          </div>
        </div>
      </div>
      <!-- ********** Component :: Visa Listing End ********** -->
<?php include '../../layouts/footer.php'; ?>
<script type="text/javascript" src="../../js/jquery.range.min.js"></script>
<script type="text/javascript" src="../../js/pagination.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL_B2C ?>/view/visa/js/index.js"></script>
<script>
$('#visa_country_filter').select2();

// Get Visa results data
function get_price_filter_data(visa_results_array,type,fromRange_cost,toRange_cost){
  var base_url = $('#base_url').val();
  var selected_value = document.getElementById(visa_results_array).value;
  var JSONItems = JSON.parse(selected_value);
  get_price_filter_data_result(JSONItems);
}
//Display Visa results data 
function get_price_filter_data_result(final_arr){
  var base_url = $('#base_url').val();
  $.post(base_url+'view/visa/visa_results.php', { final_arr: final_arr }, function (data) {
    $('#visa_result_block').html(data);
	});
}
get_price_filter_data('visa_results_array','3','0','0');
</script>