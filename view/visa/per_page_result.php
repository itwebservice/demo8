<?php
include '../../config.php';
$visa_results_array = ($_POST['data']!='') ? $_POST['data'] : [];
if(sizeof($visa_results_array)>0){

    for($visa_i=0;$visa_i<sizeof($visa_results_array);$visa_i++){
        
        $visa_enq_data = array();
        $country_name = $visa_results_array[$visa_i]['country_name'];

        array_push($visa_enq_data,$country_name);
        ?>
        <!-- ***** Visa Card ***** -->
        <div class="c-cardList type-hotel">
        <div class="c-cardListTable"
        role="button"
        data-toggle="collapse"
        href="#collapseExample<?=$visa_results_array[$visa_i]['country_id'] ?>"
        aria-expanded="false"
        aria-controls="collapseExample">
            <!-- *** Visa Card image *** -->
            <div class="cardList-image">
            <img src="<?= BASE_URL_B2C.'images/visa-icon.jpg' ?>" loading="lazy" alt="<?php echo $visa_results_array[$visa_i]['visa_name']; ?>" />
            </div>
            <!-- *** Visa Card image End *** -->

            <!-- *** Visa Card Info *** -->
            <div class="cardList-info" role="button">

            <button class="expandSect">View Details</button>

            <div class="dividerSection type-1 noborder">
                <div class="divider s1">
                <h4 class="cardTitle">
                    <?php echo $visa_results_array[$visa_i]['country_name']; ?>
                </h4>

                <div class="c-aminityListBlock">
                    <ul>
                    <?php
                    $visa_types = ($visa_results_array[$visa_i]['visa_info']!='' && $visa_results_array[$visa_i]['visa_info']!=null)? ($visa_results_array[$visa_i]['visa_info']) :[];
                    if(sizeof($visa_types) > 0){ ?>
                    <li>
                        <div class="amenity st-last  st-lasts">
                        <span class="num">+<?= sizeof($visa_types) ?></span>
                        <span class="txt">more visa types</span>
                        </div>
                    </li>
                    <?php } ?>
                    </ul>
                </div>
                </div>
                <div class="divider s2">
                    <div class="priceTag">
                    <div class="p-old">
                        <span class="o_lbl"></span>
                        <span class="price_main">
                        <span class="p_currency currency-icon"></span>
                        <span class="p_cost"><?= 'Price On Request' ?></span>
                        </span>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- *** Visa Card Info End *** -->
        </div>

        <!-- *** Visa Details Accordian *** -->
        <div class="collapse" id="collapseExample<?=$visa_results_array[$visa_i]['country_id'] ?>">
            <div class="cardList-accordian">
            <!-- ***** Visa Info Tabs ***** -->
            <div class="c-compTabs">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item active">
                    <a
                    class="nav-link active"
                    id="visa_type_all-tab<?= $visa_results_array[$visa_i]['country_id'] ?>"
                    data-toggle="tab"
                    href="#visa_type_all<?=$visa_results_array[$visa_i]['country_id'] ?>"
                    role="tab"
                    aria-controls="visa_type_all"
                    aria-selected="true"
                    >All</a
                    >
                </li>
                <?php
                if(sizeof($visa_types) > 0){
                    for($v = 0;$v < sizeof($visa_types); $v++){ ?>
                        <li class="nav-item">
                            <a
                            class="nav-link"
                            id="type-tab<?= $visa_results_array[$visa_i]['country_id'].$v ?>"
                            data-toggle="tab"
                            href="#type<?= $visa_results_array[$visa_i]['country_id'].$v ?>"
                            role="tab"
                            aria-controls="type"
                            aria-selected="true"
                            ><?= $visa_types[$v]['visa_type'] ?></a
                            >
                        </li>
                    <?php 
                    }
                } ?>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <!-- **** Tab Visa Listing **** -->

                    <!-- **** Tab Description **** -->
                    <div class="tab-pane fade show active" id="visa_type_all<?=$visa_results_array[$visa_i]['country_id'] ?>" role="tabpanel" aria-labelledby="visa_type_all-tab<?=$visa_results_array[$visa_i]['country_id'] ?>">
                        <!-- **** all **** -->
                        <?php
                        if(sizeof($visa_types) > 0){
                            for($v = 0;$v < sizeof($visa_types); $v++){
                                ?>
                                <div class="c-cardListHolder">
                                    <div class="c-cardListTable type-2" role="button">
                                        <input class="btn-radio" type="radio" id="<?= $visa_results_array[$visa_i]['country_id'].$v ?>" name="result_day-<?=$visa_results_array[$visa_i]['country_id'] ?>" value='<?php echo $visa_types[$v]['visa_type']; ?>'>
                                        <!-- *** Visa Card Info *** -->
                                        <label class="cardList-info" for="<?=$visa_results_array[$visa_i]['country_id'].$v?>" role="button">
                                            <div class="flexGrid">

                                                <div class="gridItem">
                                                    <div class="infoCard">
                                                    <span class="infoCard_data">
                                                    <?php echo $visa_types[$v]['visa_type'];?>
                                                    </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </label>
                                        <!-- *** Visa Card Info End *** -->
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        <?php } ?>
                        <!-- **** all End **** -->
                    </div>
                <?php
                if(sizeof($visa_types) > 0){
                    for($v = 0;$v < sizeof($visa_types); $v++){ ?>
                    <div class="tab-pane fade" id="type<?=$visa_results_array[$visa_i]['country_id'].$v ?>" role="tabpanel" aria-labelledby="type-tab<?=$visa_results_array[$visa_i]['country_id'].$v ?>">
                        <!-- **** types **** -->
                        <h3 class="c-heading">
                            Time Taken
                        </h3>
                        <div class="clearfix">
                            <?php echo $visa_types[$v]['time_taken'] ?>
                        </div>
                        <h3 class="c-heading">
                            List of documents
                        </h3>
                        <div class="custom_texteditor">
                            <?php echo $visa_types[$v]['documents'] ?>
                        </div>
                        <?php
                        if($visa_types[$v]['upload_url1'] != ''){
                            $url = preg_replace('/(\/+)/','/',$visa_types[$v]['upload_url1']);
                            $newUrl1 = explode('uploads', $url);
                            $newUrl = BASE_URL.'uploads'.$newUrl1[1];  ?>
                            <h3 class="c-heading">
                                Form-1
                                <a href="<?php echo $newUrl; ?>" download title="Download Form-1"><i class="fa fa-file-text"></i></a>
                            </h3>
                        <?php } ?>
                        <?php
                        if($visa_types[$v]['upload_url2'] != ''){
                            $url = preg_replace('/(\/+)/','/',$visa_types[$v]['upload_url2']);
                            $newUrl1 = explode('uploads', $url);
                            $newUrl = BASE_URL.'uploads'.$newUrl1[1];  ?>
                            <h3 class="c-heading">
                                Form-2
                                <a href="<?php echo $newUrl; ?>" download title="Download Form-2"><i class="fa fa-file-text"></i></a>
                            </h3>
                        <?php } ?>
                        <!-- **** all End **** -->
                    </div>
                <?php } 
                } ?>
                </div>
            <div class="clearfix text-right">
                <button type="button" class="c-button md" id='<?=$visa_results_array[$visa_i]['country_id']?>' onclick='enq_to_action_page("6",this.id,<?= json_encode($visa_enq_data)?>)'><i class="fa fa-phone-square" aria-hidden="true"></i>  Enquiry</button>
            </div>
            <!-- ***** Visa Info Tabs End***** -->
            </div>
        </div>
        <!-- *** Visa Details Accordian End *** -->
        </div>
        </div>
        <!-- ***** Visa Card End ***** -->
        <?php
    }
} //Visa arrays for loop
?>
<script>
$(document).ready(function () {
    if ($('.js-photoGallery').length > 0) {

		$('.js-photoGallery').owlCarousel({
			loop       : false,
			margin     : 16,
			nav        : true,
			dots       : false,
            lazyLoad   : true,
            checkVisible : true,
			slideBy    : 2,
			navText    : [
				'<i class="icon it itours-arrow-left"></i>',
				'<i class="icon it itours-arrow-right"></i>'
			],
			responsive : {
				0   : {
					items : 1
				},
				768 : {
					items : 2
                }
            },
		});
    }

});
// $(document).ready(function () {
//     hotel_page_currencies();
// });
</script>