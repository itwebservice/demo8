<?php
include "../../../../../model/model.php"; 

$branch_id = $_POST['branch_id'];
$sq_query = mysqlQuery("SELECT * FROM branches INNER JOIN enquiry_master on branches.branch_id = enquiry_master.branch_admin_id Inner JOIN enquiry_master_entries on enquiry_master.enquiry_id = enquiry_master_entries.enquiry_id Inner join emp_master on emp_master.emp_id = enquiry_master.assigned_emp_id where branches.branch_id='" . $branch_id . "' and enquiry_master_entries.status != 'False'".$_SESSION['dateqry']);
$sq_count = mysqli_num_rows($sq_query);

?>

<div class="modal fade" id="agent_wise_modal" role="dialog" aria-labelledby="myModalLabel">
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
                                    <th scope="col">Enquiry Id</th>
                                    <th scope="col">Booking Id</th>
                                    <th scope="col">Selling Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($sq_count > 0)
                                    {
                                        $count =1;
                                        $budget=0;
                                       
                                        while($db = mysqli_fetch_assoc($sq_query))
                                        {
                                            if($db['enquiry_type'] == 'Flight Ticket')
                                            {
                                            $tourdetail  = json_decode($db['enquiry_content'],true);
                                                foreach($tourdetail as $detail)
                                                {
                                                    $budget += $detail['budget'];
                                                }
                                            }
                                            else{
                                            $tourdetail  = json_decode($db['enquiry_content'],true);
                                            foreach($tourdetail as $dc)
                                                 {
                                                  if($dc['name'] == 'budget')
                                                  {
                                                      $budget = (int)$dc['value'];
                                                  }  
                                                  if($dc['name'] == 'tour_name')
                                                  {
                                                    
                                                    $tourname = $dc['value'];
                                                  }
                                                  
                                                }
                                            }
                                            $style = "";
                                            if($db['followup_status'] == 'Dropped')
                                            {
                                                $style = 'background:lightpink';
                                            }
                                            if($db['followup_status'] == 'Converted')
                                            {
                                                $style = 'background:lightblue';
                                            }   

                                              
                                        ?>
                                      
                                <tr style="<?php echo $style; ?>">
                                    <td><?php echo $count++;  ?></td>
                                    <td><?php   echo get_date_user($db['enquiry_date']); ?> </td>
                                    <td><?php   echo !empty($db['name']) ?$db['name'] : 'N/A' ; ?></td>
                                   

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
    $('#agent_wise_modal').modal('show');
</script>