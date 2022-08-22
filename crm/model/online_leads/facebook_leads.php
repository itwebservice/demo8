<?php 

class facebook_leads{
    public function webhook(){
        $token = "testinghook";
        $challenge = $_REQUEST['hub_challenge'];
        $verify_token = $_REQUEST['hub_verify_token'];
      
        if ($verify_token === $token) {
          echo $challenge;
        }
        $this->grab_json();
    }
    public function grab_json()
    {
        $leadId = "";
        $jsonData = json_decode(file_get_contents('php://input'));
        foreach($jsonData->entry as $entries){
            foreach($entries->changes as $changes){
                if($changes->field == "leadgen")
                    $leadId = $changes->value->leadgen_id;
            }
        }
        if($leadId != ""){
            $this->getFormData($leadId);
        }

        
    }
    public function getFormData($leadId){
        $tokenQuery = mysqlQuery("SELECT `access_token` FROM `facebook_access_token` order by `token_id` DESC");
        
        while($tokens = mysqli_fetch_assoc($tokenQuery)){
            $url = "https://graph.facebook.com/v11.0/".$leadId."?access_token=".$tokens['access_token'];
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
            $response = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            
            if($httpcode == "200"){
                $this->saveFormData($response);
            }
        }
    }
    public function saveFormData($response){


        $cur_date = date('Y-m-d');
        $sq_fin = mysqli_fetch_assoc(mysqlQuery("select financial_year_id from financial_year where `from_date` <= '$cur_date' and `to_date` >= '$cur_date' order by `financial_year_id` desc"));
        $financial_year_id = $sq_fin['financial_year_id'];
        $enquiry = 'Strong';
        $total_members = 0;

        $followup_date =  date("Y-m-d H:i");
        $enquiry_date = date("Y-m-d");
        $login_id = 1;  //Enquiry done by admin
        $assigned_emp_id = 1; //Assigned to Admin by default
        $branch_admin_id = 1;
        $enquiry_type = "Package Booking";
        $reference_id = 1; //Reference as social media

        $jsonResp = json_decode($response, true);
        
        $name = "";
        $email = "";
        $mobile_no = "";


        foreach($jsonResp['field_data'] as $key => &$field){
            $field['value'] = $field['values'][0];
            
            if($field['name'] != "0" && $field['name'] != "1" && $field['name'] != "2" && $field['name'] != "3" && $field['name'] != "4" && $field['name'] != "FULL_NAME" && $field['name'] != "EMAIL" && $field['name'] != "PHONE"){
                unset($jsonResp['field_data'][$key]);
            }
        
            if($field['name'] == "0"){
                $field['name'] = "tour_name";
                 unset($field['values']);
            }
            if($field['name'] == "1"){
                $field['name'] = "total_adult";
                $total_members += $field['value'];
                unset($field['values']);
            }
            if($field['name'] == "2"){
                $field['name'] = "children_with_bed";
                $total_members += $field['value'];
                unset($field['values']);
            }
            if($field['name'] == "3"){
                $field['name'] = "children_without_bed";
                $total_members += $field['value'];
                 unset($field['values']);
            }
            if($field['name'] == "4"){
                $field['name'] = "total_infant";
                $total_members += $field['value'];
                 unset($field['values']);
            }
            if($field['name'] == "FULL_NAME"){
                $field['name'] = "name";
                $name = $field['value'];
                unset($jsonResp['field_data'][$key]);
            }
            if($field['name'] == "EMAIL"){
                $field['name'] = "mail";
                $email_id = $field['value'];
                unset($jsonResp['field_data'][$key]);
            }
            if($field['name'] == "PHONE"){
                $field['name'] = "phone";
                $mobile_no = $field['value'];
                unset($jsonResp['field_data'][$key]);
            }  
        }
        // $jsonResp['field_data'] = 
        $enquiry_content = json_encode($jsonResp['field_data']);

        $sq_max_id = mysqli_fetch_assoc(mysqlQuery("select max(enquiry_id) as max from enquiry_master"));
        $enquiry_id = $sq_max_id['max']+1;

        $sq_enquiry = mysqlQuery("insert into enquiry_master (enquiry_id, login_id,branch_admin_id,financial_year_id, enquiry_type,enquiry, name, mobile_no, landline_no, country_code,email_id,location, assigned_emp_id, enquiry_specification, enquiry_date, followup_date, reference_id, enquiry_content ) values ('$enquiry_id', '$login_id', '$branch_admin_id','$financial_year_id', '$enquiry_type','$enquiry', '$name', '$mobile_no', '', '','$email_id','', '$assigned_emp_id', '', '$enquiry_date', '$followup_date', '$reference_id', '$enquiry_content')");

        $sq_max = mysqli_fetch_assoc(mysqlQuery("select max(entry_id) as max from enquiry_master_entries"));
        $entry_id = $sq_max['max'] + 1;

        $sq_followup = mysqlQuery("insert into enquiry_master_entries(entry_id, enquiry_id, followup_reply,  followup_status,  followup_type, followup_date, followup_stage, created_at) values('$entry_id', '$enquiry_id', '', 'Active','', '$followup_date','$enquiry', '$enquiry_date')");
        $sq_entryid = mysqlQuery("update enquiry_master set entry_id='$entry_id' where enquiry_id='$enquiry_id'");
    }
}