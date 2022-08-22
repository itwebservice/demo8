<?php include "../../../../../model/model.php"; ?>

<?php
$traveler_group_id = $_GET['traveler_group_id'];
$traveler_group_id_arr = json_decode($traveler_group_id);
$count_g = 1;
$count_p = 1;
?>

<div class="modal fade profile_box_modal" id="display_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
  	
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	<!-- Nav tabs -->
				  	<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#package_info" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Package Tours Attended</a></li>
				    	<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
				  	</ul>
		            <div class="panel panel-default panel-body fieldset profile_background">
						<!-- Tab panes1 -->
						<div class="tab-content">
						    <!-- *****TAb1 start -->
							<div role="tabpanel" class="tab-pane active" id="package_info">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-bordered">
											<tr class="table-heading-row">
												<td>Sr. No.</td>
												<td>Booking_id</td>
												<td>Tour Name</td>
												<td>From Date</td>
												<td>To Date</td>
											</tr>
										<?php
										$package_ids = explode(',',$traveler_group_id_arr->package);
										if($package_ids[0] != ""){
											for($i=0; $i<sizeof($package_ids); $i++)
												{

													$sq = mysqli_fetch_assoc(mysqlQuery("select booking_id,tour_name,tour_from_date,tour_to_date from package_tour_booking_master where booking_id='$package_ids[$i]'"));
													$tour_name = $sq['tour_name'];
													$tour_group_from = $sq['tour_from_date'];
													$tour_group_to = $sq['tour_to_date'];
													
													$pass_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$sq[booking_id]'"));
													$cancle_count= mysqli_num_rows(mysqlQuery("select * from package_travelers_details where booking_id='$sq[booking_id]' and status='Cancel'"));
													if($pass_count==$cancle_count){
														$bg="danger";
													}else{
														$bg="#fff";
													}
												?>

												<tr class="<?= $bg ?>">
													<td><?php echo $count_p++ ?></td>
													<td><?php echo get_package_booking_id($sq['booking_id'],$year); ?></td>
													<td><?php echo $tour_name ?></td>
													<td><?php echo date("d-m-Y", strtotime($tour_group_from)) ?></td>
													<td><?php echo date("d-m-Y", strtotime($tour_group_to)) ?></td>
												</tr>	
										<?php
											}
										}
										else{
										?>
											<tr>
												<td class="text-center" colspan=4>No Package Tours Attended</td>
											</tr>
										<?php
										}
										?>

										</table>
									</div>
								</div>
							</div>
						</div>
					</div>		
				</div>
			</div>
		</div>
	</div>


<?php
?>
<script type="text/javascript">
	$('#display_modal').modal('show');
</script>