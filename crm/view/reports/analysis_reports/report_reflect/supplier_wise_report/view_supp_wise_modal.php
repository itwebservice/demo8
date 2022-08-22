<?php
include "../../../../../model/model.php"; 

$hotel_id = $_POST['hotel_id'];
$sq_query = mysqlQuery("SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER JOIN hotel_booking_entries on hotel_master.hotel_id = hotel_booking_entries.hotel_id INNER JOIN hotel_booking_master on hotel_booking_entries.booking_id = hotel_booking_master.booking_id INNER JOIN customer_master on hotel_booking_master.customer_id = customer_master.customer_id where hotel_master.hotel_id = '".$hotel_id."'");
$sq_query1 = mysqlQuery("SELECT * FROM hotel_master INNER JOIN city_master on hotel_master.city_id = city_master.city_id INNER Join package_hotel_accomodation_master on hotel_master.hotel_id = package_hotel_accomodation_master.hotel_id INNER JOIN package_tour_booking_master on package_hotel_accomodation_master.booking_id = package_tour_booking_master.booking_id INNER JOIN customer_master on package_tour_booking_master.customer_id = customer_master.customer_id where hotel_master.hotel_id = '".$hotel_id."'");
$sq_count = mysqli_num_rows($sq_query);
$sq_count1 = mysqli_num_rows($sq_query1);

?>

<div class="modal fade" id="supp_wise_modal" role="dialog" aria-labelledby="myModalLabel">
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
                                    <th scope="col">Customer Name </th>
                                    <th scope="col">Purchase Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    if($sq_count > 0)
                                    {
                                        $count =1;
                              
                                       
                                        while($db = mysqli_fetch_assoc($sq_query))
                                        {
                                          
                                        ?>
                                      
                                <tr>
                                    <td><?php echo $db['booking_id'];  ?></td>
                                    <td><?php   echo $db['first_name'] .' '.$db['last_name']; ?> </td>
                                    <td><?php   echo $db['check_in']; ?></td>
                                    <td><?php   echo $db['check_out'];?></td>
                                    <td><?php   echo $db['no_of_nights'];?></td>
                                    <td><?php   echo $db['rooms'];?></td>
                                    <td><?php   echo $db['total_fee'];?></td>
                                </tr>
                                <?php  }
                                    }
                                ?>


<?php

if($sq_count1 > 0)
{
   

   
    while($db = mysqli_fetch_assoc($sq_query1))
    {
      
    ?>
  
<tr>
<td><?php echo $db['booking_id'];  ?></td>
<td><?php   echo $db['first_name'] .' '.$db['last_name']; ?> </td>
<td><?php   echo $db['from_date']; ?></td>
<td><?php   echo $db['to_date'];?></td>
<td><?php   echo $db['total_tour_days'];?></td>
<td><?php   echo $db['rooms'];?></td>
<td><?php   echo $db['total_fee'];?></td>
</tr>
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
    $('#supp_wise_modal').modal('show');
</script>