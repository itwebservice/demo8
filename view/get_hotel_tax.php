<?php
include '../../model/model.php';
$register_id = $_POST['register_id'];
$huuid = $_POST['huuid'];
$id = $_POST['id'];
$city_id = $_POST['city_id'];
$check_indate = $_POST['check_indate'];
$check_outdate = $_POST['check_outdate'];
$room_type_arr = $_POST['room_type_arr'];
$final_arr = $_POST['final_arr'];
$applied_taxes = $_POST['applied_taxes'];

$cart_data_arr = array();
$cart_checkout_data = array();
$sq_reg = mysqli_fetch_assoc(mysqlQuery("select cart_data from b2b_registration where register_id='$register_id'"));
$cart_checkout_data = json_decode($sq_reg['cart_data']);
if($cart_checkout_data != null){
  for($i=0;$i<sizeof($cart_checkout_data);$i++){
    array_push($cart_data_arr,$cart_checkout_data[$i]);
  }
}

$hotel_info_arr = array();
$coupon_info_arr = array();
$sq_hotel = mysqli_fetch_assoc(mysqlQuery("select hotel_name,taxation_type,service_tax from hotel_master where hotel_id='$id'"));

//Hotel Basic
$hotel_info_arr['hotel_name'] = addslashes($sq_hotel['hotel_name']);
$hotel_info_arr['tax'] = $applied_taxes;

//Hotel Image
$sq_singleImage = mysqli_fetch_assoc(mysqlQuery("select hotel_pic_url from hotel_vendor_images_entries where hotel_id='$id'"));
if($sq_singleImage['hotel_pic_url']!=''){
  $image = $sq_singleImage['hotel_pic_url'];
  $newUrl1 = preg_replace('/(\/+)/','/',$image);
  $newUrl1 = explode('uploads', $newUrl1);
  $newUrl = BASE_URL.'uploads'.$newUrl1[1];
}
else{
  $newUrl = BASE_URL.'images/dummy-image.jpg';
}
$hotel_info_arr['newUrl'] = $newUrl;
$hotel_info_arr['date'] = $check_indate;

//Coupon
$sq_app_setting = mysqli_fetch_assoc(mysqlQuery("select * from app_settings where setting_id='1'"));
$currency = $sq_app_setting['currency'];

$check_indate = date("Y-m-d", strtotime($check_indate));
$sq_hotel_offer = mysqlQuery("select * from hotel_offers_tarrif where type='Coupon' and (from_date <='$check_indate' and to_date>='$check_indate') and hotel_id='$id'");
while($row_hotel_offer = mysqli_fetch_assoc($sq_hotel_offer)){

    $arr = array(
    'offer_in' => $row_hotel_offer['offer'],
    'offer_amount' => $row_hotel_offer['offer_amount'],
    'coupon_code' => $row_hotel_offer['coupon_code'],
    'agent_type' => $row_hotel_offer['agent_type'],
    'currency_id' => $currency
    );
    array_push($coupon_info_arr, $arr);
}
$hotel_info_arr['coupon_info_arr'] = $coupon_info_arr;

$cart_arr1 = array(
  'service'=> array(
    'uuid'      => $huuid,
    'name'      => 'Hotel',
    'id'        => $id,
    'city_id'   => $city_id,
    'check_in'  => $check_indate,
    'check_out' => $check_outdate,
    'hotel_arr' => $hotel_info_arr,
    'item_arr'  => $room_type_arr,
    'final_arr' => $final_arr
  )
);
array_push($cart_data_arr, $cart_arr1);
$cart_data_arr = json_encode($cart_data_arr);
$sq_update = mysqlQuery("update b2b_registration set cart_data='$cart_data_arr' where register_id='$register_id'");

echo json_encode($hotel_info_arr);
?>