<?php
include "../../../../../model/model.php"; 

$customer_id = $_POST['customer_id'];
$sq_query = mysqlQuery("SELECT * FROM customer_master where customer_master.customer_id= '".$customer_id."'");
//$sq_query1 = mysqlQuery("SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id INNER JOIN customer_master on package_tour_booking_master.customer_id = customer_master.customer_id where hotel_master.hotel_id = '".$hotel_id."'");
$sq_count = mysqli_num_rows($sq_query);
// $sq_count1 = mysqli_num_rows($sq_query1);

function car_rental($id)
{
    $query1 = "SELECT vendor_estimate.net_total, customer_master.customer_id,booking_id,total_cost,car_rental_booking.created_at FROM Customer_master INNER JOIN car_rental_booking ON customer_master.customer_id = car_rental_booking.customer_id INNER JOIN vendor_estimate On car_rental_booking.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Car Rental' AND customer_master.customer_id='".$id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['booking_id'].'</td>
            <td scope="col">Car Rental</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['total_cost'].'</td>
            <td scope="col">'.$db['total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function visa($id)
{
    $query1 = "SELECT vendor_estimate.net_total, customer_master.customer_id,visa_id,visa_total_cost, visa_master.created_at FROM Customer_master  INNER JOIN visa_master ON customer_master.customer_id = visa_master.customer_id INNER JOIN vendor_estimate On visa_master.visa_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Visa Booking' AND customer_master.customer_id='".$id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['visa_id'].'</td>
            <td scope="col">Visa</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['visa_total_cost'].'</td>
            <td scope="col">'.$db['visa_total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function bus($id)
{
    $query1 = "SELECT bus_booking_master.net_total as total_cost,vendor_estimate.net_total , customer_master.customer_id,booking_id, bus_booking_master.created_at FROM Customer_master  INNER JOIN bus_booking_master ON customer_master.customer_id =  bus_booking_master.customer_id  INNER JOIN vendor_estimate On bus_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Bus Booking' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['booking_id'].'</td>
            <td scope="col">Bus</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['total_cost'].'</td>
            <td scope="col">'.$db['total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function excursion($id)
{
    $query1 = "SELECT vendor_estimate.net_total, customer_master.customer_id,exc_id,exc_total_cost, excursion_master.created_at FROM Customer_master  INNER JOIN excursion_master ON customer_master.customer_id =  excursion_master.customer_id  INNER JOIN vendor_estimate on excursion_master.exc_id = vendor_estimate.estimate_type_id  where vendor_estimate.estimate_type = 'Excursion Booking' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['exc_id'].'</td>
            <td scope="col">Excursion</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['exc_total_cost'].'</td>
            <td scope="col">'.$db['exc_total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function miscellaneous($id)
{
    $query1 = "SELECT vendor_estimate.net_total, customer_master.customer_id,misc_id,misc_total_cost, miscellaneous_master.created_at FROM Customer_master  INNER JOIN miscellaneous_master ON customer_master.customer_id =  miscellaneous_master.customer_id  INNER JOIN vendor_estimate on miscellaneous_master.misc_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Miscellaneous Booking' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['misc_id'].'</td>
            <td scope="col">Miscellaneous</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['misc_total_cost'].'</td>
            <td scope="col">'.$db['misc_total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function hotel($id)
{
    $query1 = "SELECT vendor_estimate.net_total, customer_master.customer_id,booking_id,total_fee, hotel_booking_master.created_at FROM Customer_master  INNER JOIN hotel_booking_master ON customer_master.customer_id =  hotel_booking_master.customer_id INNER JOIN vendor_estimate on hotel_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Hotel Booking' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['booking_id'].'</td>
            <td scope="col">Hotel</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['total_fee'].'</td>
            <td scope="col">'.$db['total_fee'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function ticket($id)
{
    $query1 = "SELECT vendor_estimate.net_total, customer_master.customer_id,ticket_id,ticket_total_cost, ticket_master.created_at FROM Customer_master  INNER JOIN ticket_master ON customer_master.customer_id =  ticket_master.customer_id INNER JOIN vendor_estimate on ticket_master.ticket_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Ticket Booking' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['ticket_id'].'</td>
            <td scope="col">Ticket</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['ticket_total_cost'].'</td>
            <td scope="col">'.$db['ticket_total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function train($id)
{
    $query1 = "SELECT train_ticket_master.net_total as total_cost,vendor_estimate.net_total, customer_master.customer_id,train_ticket_id,train_ticket_master.created_at FROM Customer_master INNER JOIN train_ticket_master ON customer_master.customer_id = train_ticket_master.customer_id INNER JOIN vendor_estimate on train_ticket_master.train_ticket_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Train Ticket Booking' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['train_ticket_id'].'</td>
            <td scope="col">Train Ticket</td>
            <td scope="col">'.$db['created_at'].'</td>
            <td scope="col">'.$db['total_cost'].'</td>
            <td scope="col">'.$db['total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function tourwise($id)
{
    $query1 = "SELECT tourwise_traveler_details.net_total as total_cost,vendor_estimate.net_total, customer_master.customer_id,id, tourwise_traveler_details.form_date FROM Customer_master INNER JOIN tourwise_traveler_details ON customer_master.customer_id = tourwise_traveler_details.customer_id INNER JOIN vendor_estimate on tourwise_traveler_details.id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Group Tour' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['id'].'</td>
            <td scope="col">Tourwise</td>
            <td scope="col">'.$db['form_date'].'</td>
            <td scope="col">'.$db['total_cost'].'</td>
            <td scope="col">'.$db['total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}

function package($id)
{
    $query1 = "SELECT package_tour_booking_master.net_total as total_cost,vendor_estimate.net_total, customer_master.customer_id,booking_id, package_tour_booking_master.booking_date FROM Customer_master INNER JOIN package_tour_booking_master ON customer_master.customer_id = package_tour_booking_master.customer_id INNER JOIN vendor_estimate on package_tour_booking_master.booking_id = vendor_estimate.estimate_type_id where vendor_estimate.estimate_type = 'Package Tour' AND customer_master.customer_id='". $id."'".$_SESSION['dateqry'];
    $res = mysqlQuery($query1);
    $html = ''; 
    $count = mysqli_num_rows($res);
    while($db = mysqli_fetch_array($res))
    {
            $html .= '<tr><td>'.$db['booking_id'].'</td>
            <td scope="col">Package</td>
            <td scope="col">'.$db['booking_date'].'</td>
            <td scope="col">'.$db['total_cost'].'</td>
            <td scope="col">'.$db['total_cost'] - $db['net_total'].'</td> </tr>';
    }
      echo  $html; 
}


?>

<div class="modal fade" id="com_sector_modal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-left" id="myModalLabel">Enquiry Details</h4>
              
            </div>
            <div class="modal-body profile_box_padding">
                <div class="row">
                    <div class="col-md-12">
                      <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Booking Id </th>
                                    <th scope="col">Travel Type </th>
                                    <th scope="col">Travel Date </th>
                                    <th scope="col">Selling Amount</th>
                                    <th scope="col">Profit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    if($sq_count > 0)
                                    {
                                        $count =1;
                              
                                       
                                        while($db = mysqli_fetch_assoc($sq_query))
                                        {
                                            car_rental($db['customer_id']);
                                            visa($db['customer_id']);
                                            bus($db['customer_id']);
                                            excursion($db['customer_id']);
                                            miscellaneous($db['customer_id']);
                                            hotel($db['customer_id']);
                                            ticket($db['customer_id']);
                                            train($db['customer_id']);
                                            tourwise($db['customer_id']);
                                            package($db['customer_id']);
                                        ?>
                                      
                                
                                <?php  }
                                    }
                                ?>



                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#com_sector_modal').modal('show');
</script>