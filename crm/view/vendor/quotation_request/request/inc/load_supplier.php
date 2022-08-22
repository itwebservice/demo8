<?php
include "../../../../../model/model.php";
$quotation_for = $_POST['quotation_for'];

if($quotation_for=="Transport"){
    $city=mysqlQuery("select distinct(city_id) from transport_agency_master where active_flag='Active'");
    while($sq_city=mysqli_fetch_assoc($city)){
        $getCity=mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id=$sq_city[city_id]"));
        ?>
        <optgroup value='<?= $getCity['city_id'];?>' label="<?= $getCity['city_name'];?>">
        <?php
        $hotel=mysqlQuery("select transport_agency_name , transport_agency_id from transport_agency_master where city_id=$sq_city[city_id] and active_flag='Active'");
        while($sq_hotel=mysqli_fetch_assoc($hotel)){
        ?>
            <option value="<?= $sq_hotel['transport_agency_id'];?>"><?= $sq_hotel['transport_agency_name']; ?></option>
        <?php
        }
        ?>
        </optgroup>
    <?php
    }
}

if($quotation_for=="Hotel"){
    $city=mysqlQuery("select distinct(city_id) from hotel_master where active_flag='Active'");
    while($sq_city=mysqli_fetch_assoc($city)){
        $getCity=mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id=$sq_city[city_id]"));
	?>
        <optgroup value='<?= $getCity['city_id'];?>' label="<?= $getCity['city_name'];?>">
        <?php
        $hotel=mysqlQuery("select hotel_name , hotel_id from hotel_master where city_id=$sq_city[city_id] and active_flag='Active'");
        while($sq_hotel=mysqli_fetch_assoc($hotel)){
        ?>
            <option value="<?= $sq_hotel['hotel_id'];?>"><?= $sq_hotel['hotel_name']; ?></option>
        <?php
        }
        ?>
        </optgroup>
	<?php
    }
}

if($quotation_for=="DMC"){
    $city=mysqlQuery("select distinct(city_id) from dmc_master where active_flag='Active'");
    while($sq_city=mysqli_fetch_assoc($city)){
        $getCity=mysqli_fetch_assoc(mysqlQuery("select city_name,city_id from city_master where city_id=$sq_city[city_id]"));
	?>
        <optgroup value='<?= $getCity['city_id'];?>' label="<?= $getCity['city_name'];?>" value="<?= $getCity['city_id'];?>">
        <?php
        $hotel=mysqlQuery("select company_name , dmc_id from dmc_master where city_id=$sq_city[city_id] and active_flag='Active'");
        while($sq_hotel=mysqli_fetch_assoc($hotel)){
        ?>
            <option value="<?= $sq_hotel['dmc_id'];?>"><?= $sq_hotel['company_name']; ?></option>
        <?php
        }
        ?>
        </optgroup>
	<?php
}
}
?>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

