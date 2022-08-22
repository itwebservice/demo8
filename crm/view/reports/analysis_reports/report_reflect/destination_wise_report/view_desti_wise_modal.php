<?php
include "../../../../../model/model.php"; 

$dest_id = $_POST['dest_id'];
$qry = "select * from package_tour_booking_master inner join destination_master on package_tour_booking_master.dest_id=destination_master.dest_id inner join customer_master on package_tour_booking_master.customer_id=customer_master.customer_id where destination_master.dest_id=".$dest_id." ".$_SESSION['package'];
$qry2 = "select * from tourwise_traveler_details inner join tour_master on tourwise_traveler_details.tour_id=tour_master.tour_id inner join destination_master on tour_master.dest_id=destination_master.dest_id inner join customer_master on tourwise_traveler_details.customer_id=customer_master.customer_id where destination_master.dest_id=".$dest_id." ".$_SESSION['tourwise'];

$sq_query = mysqlQuery($qry);
$sq_query1 = mysqlQuery($qry2);
$sq_count = mysqli_num_rows($sq_query);
$sq_count1 = mysqli_num_rows($sq_query1);

?>

<div class="modal fade" id="des_wise_modal" role="dialog" aria-labelledby="myModalLabel">
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
                                    <th scope="col">Travel Date </th>
                                    <th scope="col">Selling Amount</th>
                                    
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
                                    <td><?php   echo $db['tour_from_date']; ?></td>
                                    <td><?php   echo $db['subtotal'];?></td>
                                
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
<td><?php echo $db['id'];  ?></td>
<td><?php   echo $db['first_name'] .' '.$db['last_name']; ?> </td>
<td><?php   echo $db['form_date']; ?></td>
<td><?php   echo $db['basic_amount'];?></td>
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
    $('#des_wise_modal').modal('show');
</script>