<?php
include "../../../../../model/model.php";
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
					<li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Group Tours Attended</a></li>
					<li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
				</ul>
				<div class="panel panel-default panel-body fieldset profile_background">
					<!-- Tab panes1 -->
					<div class="tab-content">
						<!-- *****TAb1 start -->
						<div role="tabpanel" class="tab-pane active" id="basic_information">
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
									
									$group_ids = explode(',',$traveler_group_id_arr->group);
									if($group_ids[0] != ""){
										for($i=0; $i<sizeof($group_ids); $i++)
										{
											$sq = mysqli_fetch_assoc(mysqlQuery("select id,tour_id,tour_group_id,form_date,tour_group_status from tourwise_traveler_details where traveler_group_id='$group_ids[$i]' "));
											
											$pass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$sq[id]'"));
											$cancelpass_count = mysqli_num_rows(mysqlQuery("select * from  travelers_details where traveler_group_id='$sq[id]' and status='Cancel'"));
											
											$bg="";
											if($sq['tour_group_status']=="Cancel"){
												$bg="danger";
											}
											else{
												if($pass_count==$cancelpass_count){
													$bg="danger";
												}
											}
											$tour_id = $sq['tour_id'];
											$tour_group_id = $sq['tour_group_id'];

											$sq3 = mysqli_fetch_assoc(mysqlQuery("select tour_name from tour_master where tour_id='$tour_id'"));
											$tour_name = $sq3['tour_name'];

											$sq2 = mysqli_fetch_assoc(mysqlQuery("select from_date, to_date from tour_groups where tour_id='$tour_id'"));
											$tour_group_from = $sq2['from_date'];
											$tour_group_to = $sq2['to_date'];
											
											$date = $sq['form_date'];
											$yr = explode("-", $date);
											$year = $yr[0];
											?>
											<tr class="<?= $bg ?>">
												<td><?php echo $count_g++ ?></td>
												<td><?php echo get_group_booking_id($sq['id'],$year); ?></td>
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
											<td class="text-center" colspan=4>No Group Tours Attended</td>
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

<script type="text/javascript">
	$('#display_modal').modal('show');
</script>