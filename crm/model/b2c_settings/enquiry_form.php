<?php
class enquiry_master{

	public function actions_enq(){

        global $app_email_id;

        $package_id = $_POST['package_id'];
        $package_type = $_POST['package_type'];
        $type = $_POST['type'];
        $name = $_POST['name'];
        $email_id = $_POST['email_id'];
        $city_place = $_POST['city_place'];
        $country_code = $_POST['country_code'];
        $phone = $_POST['phone'];
        $package_name = $_POST['package_name'];
        $travel_from = $_POST['travel_from'];
        $travel_to = $_POST['travel_to'];
        $adults = $_POST['adults'];
        $chwb = ($_POST['chwb'] == '') ? 0 : $_POST['chwb'];
        $chwob = ($_POST['chwob'] == '') ? 0 : $_POST['chwob'];
        $chwob = ($_POST['chwob'] == '') ? 0 : $_POST['chwob'];
        $infant = ($_POST['infant'] == '') ? 0 : $_POST['infant'];
        $extra_bed = ($_POST['extra_bed'] == '') ? 0 : $_POST['extra_bed'];
        $package_typef = $_POST['package_typef'];
        $specification = ($_POST['specification']=='') ? '-' : $_POST['specification'];
        $enq_data_arr = json_decode($_POST['enq_data_arr']);
        if($type == '1'){
            $service = 'Holiday';
        }
        else if($type == '2'){
            $service = 'Group Tour';
        }
        else if($type == '3'){
            $service = 'Hotel';
        }
        else if($type == '4'){
            $service = 'Activity';
        }
        else if($type == '5'){
            $service = 'Transfer';
        }
        else if($type == '6'){
            $service = 'Visa';
        }
        else if($type == '7'){
            $service = 'Cruise';
        }

        //Mail to Admin
        if($type == '1' || $type == '2'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>Dear Admin,</b></td> 
                </tr>
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Package Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$package_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$travel_from.' To '.$travel_to.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Child Without Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwob.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Child With Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwb.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Extra Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$extra_bed.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Package Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$package_typef.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '3'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>Dear Admin,</b></td> 
                </tr>
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->hotel_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->check_in.' To '.$enq_data_arr[0]->check_out.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Total Rooms</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->total_rooms.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Room Category</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->room_cat.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child Without Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwob.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child With Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwb.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Extra Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$extra_bed.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '4'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>Dear Admin,</b></td> 
                </tr>
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Activity Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->act_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Activity Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->act_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Transfer Option</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->transfer_option.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child(ren)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->child.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '5'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>Dear Admin,</b></td> 
                </tr>
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Transfer Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->trans_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Trip Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->trip_type.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Pickup Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->pickup.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Pickup Date&Time</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->pickup_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Dropoff Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->drop.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Return Date&Time</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->return_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Total Passengers</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->pass.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '6'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>Dear Admin,</b></td> 
                </tr>
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Country Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->country_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->travel_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child(ren)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->child.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '7'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>Dear Admin,</b></td> 
                </tr>
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Cruise Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->cruise_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">From Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->from_location.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">To Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->to_location.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->travel_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child(ren)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->child.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }

        if($type == '1' || $type == '2'){
            $subject = 'New Website Enquiry: '.$package_name.' ('.date('d-m-Y').')';
        }
        else{
            $subject = 'New Website Enquiry for '.$service.' ('.date('d-m-Y').')';
        }
        global $model;
        $model->app_email_master($app_email_id, $content, $subject,'1');

        // Enquiry Save for holiday, group tour, hotel, visa
        if($type == '1' || $type == '2' || $type == '3' || $type == '6'){

            $sq_max_id = mysqli_fetch_assoc(mysqlQuery("select max(enquiry_id) as max from enquiry_master"));
            $enquiry_id = $sq_max_id['max']+1;
    
            $enquiry_date = date("Y-m-d");
            $followup_date = date("Y-m-d H:i");
    
            $name = addslashes($name);
            $enquiry_specification = addslashes($specification);
            $pax = intval($adults) + intval($chwb) + intval($chwob) + intval($extra_bed) + intval($infant);
            //Tour name
            $sq_package = mysqli_fetch_assoc(mysqlQuery("select dest_id from custom_package_master where package_id='$package_id'"));
            $sq_dest = mysqli_fetch_assoc(mysqlQuery("select dest_name from destination_master where dest_id='$sq_package[dest_id]'"));
            $dest_name = $sq_dest['dest_name'];
            //Financial year
            $sq_fin = mysqli_fetch_assoc(mysqlQuery("select financial_year_id from financial_year order by financial_year_id desc"));
            $financial_year_id = $sq_fin['financial_year_id'];
            //Enquiry Content
            $enquiry_content = array();
            
            if($type == '1' || $type == '2'){
                array_push($enquiry_content,array("name"=>"tour_name","value"=>$dest_name),array("name"=>"travel_from_date","value"=>$travel_from),array("name"=>"travel_to_date","value"=>$travel_to),array("name"=>"budget","value"=>""),array("name"=>"total_adult","value"=>($adults+$extra_bed)),array("name"=>"children_with_bed","value"=>$chwb),array("name"=>"children_without_bed","value"=>$chwob),array("name"=>"total_infant","value"=>$infant),array("name"=>"total_members","value"=>$pax),array("name"=>"hotel_type","value"=>""));
            }
            else if($type == '3'){
                $hotel_requirements = 'Check In Date: '.$enq_data_arr[0]->check_in.'<br/>'.'Check Out Date: '.$enq_data_arr[0]->check_out.'<br/>'.'Total Rooms: '.$enq_data_arr[0]->total_rooms.'<br/>'.'Room Category: '.$enq_data_arr[0]->room_cat;

                array_push($enquiry_content,array("name"=>"hotel_requirements","value"=>$hotel_requirements),array("name"=>"budget","value"=>""),array("name"=>"total_adult","value"=>($adults+$extra_bed)),array("name"=>"total_cwb","value"=>$chwb),array("name"=>"total_cwob","value"=>$chwob),array("name"=>"total_infant","value"=>$infant),array("name"=>"total_members","value"=>$pax),array("name"=>"budget","value"=>""));
            }
            else if($type == '6'){
                $child = $enq_data_arr[0]->child;
                $country = explode('(',$enq_data_arr[0]->country_name);
                $country_named = $country[0];
                $visa_type = explode(')',$country[1]);
                $pax = intval($adults) + intval($chwb) + intval($child) + intval($infant);

                array_push($enquiry_content,array("name"=>"country_name","value"=>$country_named),array("name"=>"visa_type","value"=>"$visa_type[0]"),array("name"=>"total_adult","value"=>($adults)),array("name"=>"total_children","value"=>$child),array("name"=>"total_infant","value"=>$infant),array("name"=>"total_members","value"=>$pax),array("name"=>"budget","value"=>""));
            }
            $enquiry_content = json_encode($enquiry_content);
            if($type == '1'){ $enq_type = 'Package Booking'; } 
            else if($type == '2'){ $enq_type = 'Group Booking'; } 
            else if($type == '3'){ $enq_type = 'Hotel'; } 
            else if($type == '6'){ $enq_type = 'Visa'; } 
            //Save
            $sq_enquiry = mysqlQuery("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, country_code,email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content,customer_name ) values ('$enquiry_id', '1', '1','$financial_year_id','$enq_type', 'Strong', '$name', '$phone', '$phone', '$country_code','$email_id','$city_place', '1', '$enquiry_specification', '$enquiry_date', '$followup_date', '2', '$enquiry_content','')");
            //Followup save 
            $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from enquiry_master_entries"));
            $entry_id = $sq_max['max'] + 1;
            $sq_followup = mysqlQuery("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '$followup_date','Strong', '$enquiry_date')");
            $sq_entryid = mysqlQuery("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id'");
        }

        //Enquiry Ack mail to customer
        global $theme_color;
        $subject = 'Enquiry Acknowledgment';
        if($type == '1' || $type == '2'){
            $content = '
            <tr>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr>
                <td colspan=2><b>New enquiry is generated with below details.</b></td> 
            </tr>
            </table>
            <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
            <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Package Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$package_name.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$travel_from.' To '.$travel_to.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Child Without Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwob.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Child With Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwb.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Extra Bed(s)</td> <td style="text-align:left;border: 1px solid #888888;">'.$extra_bed.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Package Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$package_typef.'</td></tr>
            <tr><td style="text-align:left;border: 1px solid #888888;"> Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
            </table>
            </tr>';
        }
        else if($type == '3'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Hotel Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->hotel_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->check_in.' To '.$enq_data_arr[0]->check_out.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;"> Total Rooms</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->total_rooms.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Room Category</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->room_cat.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child Without Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwob.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child With Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$chwb.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Extra Bed(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$extra_bed.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '4'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Activity Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->act_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Activity Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->act_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Transfer Option</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->transfer_option.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child(ren)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->child.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '5'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Transfer Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->trans_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Trip Type</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->trip_type.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Pickup Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->pickup.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Pickup Date&Time</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->pickup_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Dropoff Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->drop.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Return Date&Time</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->return_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Total Passengers</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->pass.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '6'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Country Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->country_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->travel_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child(ren)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->child.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }
        else if($type == '7'){

            $content = '
                <tr>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr>
                    <td colspan=2><b>New enquiry is generated from website with below details.</b></td> 
                </tr>
                </table>
                <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                <tr><td style="text-align:left;border: 1px solid #888888;">Enquiry For</td>   <td style="text-align:left;border: 1px solid #888888;">'.$service.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Email ID</td>   <td style="text-align:left;border: 1px solid #888888;">'.$email_id.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">City Or Place</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$city_place.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Phone</td>   <td style="text-align:left;border: 1px solid #888888;" >'.$country_code.$phone.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Cruise Name</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->cruise_name.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">From Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->from_location.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">To Location</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->to_location.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Travel Date</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->travel_date.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Adult(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$adults.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Child(ren)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$enq_data_arr[0]->child.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Infant(s)</td>   <td style="text-align:left;border: 1px solid #888888;">'.$infant.'</td></tr>
                <tr><td style="text-align:left;border: 1px solid #888888;">Other Specification</td>   <td style="text-align:left;border: 1px solid #888888;">'.addslashes($specification).'</td></tr>
                </table>
                </tr>';
        }

        if($type == '1'){
        
            $from_date = strtotime($travel_from);
            $to_date = strtotime($travel_to);
            $datediff = $to_date - $from_date;
            $total_nights = round($datediff / (60 * 60 * 24));

            $sq_package_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where dest_id = '$sq_package[dest_id]' and total_nights='$total_nights' and package_id!='$package_id'"));
            if($sq_package_count > 0){

                $query_p = "select * from custom_package_master where dest_id = '$sq_package[dest_id]' and total_nights='$total_nights' and package_id!='$package_id'";
            }else{
            
                $sq_package_count = mysqli_num_rows(mysqlQuery("select * from custom_package_master where dest_id = '$sq_package[dest_id]' and package_id!='$package_id' limit 0,2"));
                if($sq_package_count > 0){
                    $query_p = "select * from custom_package_master where dest_id = '$sq_package[dest_id]' limit 0,3";
                }
            }
            if($sq_package_count > 0){

                $sq_package1 = mysqlQuery($query_p);
                $content .= '
                    <tr>
                    <table width="85%" cellspacing="0" cellpadding="5" style="color: #888888;border: 1px solid #888888;margin: 0px auto;margin-top:20px; min-width: 100%;" role="presentation">
                        <tr><td colspan="2" style="color: '.$theme_color.';text-align:left;border: 1px solid #888888;">Discover related packages for '.$dest_name.'</td></tr>';
                        
                    while($row_package = mysqli_fetch_assoc($sq_package1)){

                    $package_id = base64_encode($row_package['package_id']);
                    $enquiry_id1 = base64_encode($enquiry_id);
                    $content .= '<tr><td style="text-align:left;border: 1px solid #888888;">'.$row_package['package_name'].' ('.$row_package['total_nights'].'N / '.$row_package['total_days'].'D)'.'</td>   <td style="text-align:left;border: 1px solid #888888;"><a style="color: '.$theme_color.';text-decoration: none;" href="'.BASE_URL.'model/attractions_offers_enquiry/package_tours_show.php?package_id='.$package_id.'&enquiry_id='.$enquiry_id1.'">View</a></td></tr>';
                    }
                    $content  .= '</table>
                    </tr>';
            }
        }
        if($type == '1' || $type == '2' || $type == '3' || $type == '6'){
            $subject = 'Enquiry Acknowledgment (Enquiry ID : '.$enquiry_id.' ).';
        }
        $model->app_email_send('4',$name,$email_id, $content,$subject,'1');
	}
}