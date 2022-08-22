<?php

$amount_to_word = new amount_to_word1();

class amount_to_word1 
{




public function convert_number_to_words($number1,$currency_code='') {

  global $currency;
  if($currency_code!=''){

    $number_string = explode(' ',$number1);
    $number = $number_string[1];
    $number = str_replace(',', '', $number);
  }else{
    $number = str_replace(',', '', $number1);
    $number = floatval($number1);
  }
  $no = round(floatval($number));
  $point = round($number - $no, 2) * 100;
  $hundred = null;
  $digits_1 = strlen($no);
  $i = 0;
  $str = array();
  $words = array('0' => '', '1' => 'One', '2' => 'Two',
  '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
  '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
  '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
  '13' => 'Thirteen', '14' => 'Fourteen',
  '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
  '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
  '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
  '60' => 'Sixty', '70' => 'Seventy',
  '80' => 'Eighty', '90' => 'Ninety');
  $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
  while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
      $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
      $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
      $str [] = ($number < 21) ? $words[$number] .
          " " . $digits[$counter] . $plural . " " . $hundred
          :
          $words[floor($number / 10) * 10]
          . " " . $words[$number % 10] . " "
          . $digits[$counter] . $plural . " " . $hundred;
    } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  if($currency_code!=''){
    $currency_logo_d = mysqli_fetch_assoc(mysqlQuery("SELECT `default_currency` FROM `currency_name_master` WHERE id=" . $currency_code));
    $currency_logo1 = html_entity_decode($currency_logo_d['default_currency']);
  }else{
    $currency_logo_d = mysqli_fetch_assoc(mysqlQuery("SELECT `default_currency`,`currency_code` FROM `currency_name_master` WHERE id=" . $currency));
    $currency_logo1 = $currency_logo_d['currency_code'];
  }
  return $currency_logo1.' '.$result . " Only";
}

public function convert_number_to_word_simple($number) {
    
    //$number = 190908100.25;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'One', '2' => 'Two',
    '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
    '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
    '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
    '13' => 'Thirteen', '14' => 'Fourteen',
    '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
    '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
    '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
    '60' => 'Sixty', '70' => 'Seventy',
    '80' => 'Eighty', '90' => 'Ninety');
   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  return $result;
}





	
}

?>