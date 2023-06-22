

<form id="frm_group_tours_search">

  <div class="row">

        <input type='hidden' id='page_type' value='search_page' name='search_page'/>

        <!-- *** Destination Name *** -->

        <div class="col-md-3 col-sm-6 col-12">

          <div class="form-group">

            <label>*Select Destination</label>

            <div class="c-select2DD">

              <select id='gtours_dest_filter' class="full-width js-roomCount" onchange="group_tours_reflect(this.id);">

                <option value="">Destination</option>

                <?php 

                $sq_query = mysqlQuery("select * from destination_master where status != 'Inactive'"); 

                while($row_dest = mysqli_fetch_assoc($sq_query)){ ?>

                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>

                <?php } ?>

              </select>

            </div>

          </div>

        </div>

        <!-- *** Destination Name End *** -->

        <!-- *** Tour Name *** -->

        <div class="col-md-3 col-sm-6 col-12">

          <div class="form-group">

            <label>*Select Tour</label>

            <div class="selector">

                <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" title="Tour Name" onchange="tour_group_reflect(this.id);"> 

                    <option value="">*Tour Name</option>

                    <?php

                        $sq = mysqlQuery("select tour_id,tour_name from tour_master where active_flag = 'Active' and dest_id = '$dest_id' and tour_id!='$tour_id' order by tour_name asc");

                        while($row=mysqli_fetch_assoc($sq)){



                          echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";

                        }

                    ?>

                </select>

            </div>

          </div>

        </div>

        <!-- *** Destination Name End *** -->

        <!-- *** tours date *** -->

        <div class="col-md-3 col-sm-6 col-12">

          <div class="form-group">

            <label>*Select Tour Date</label>

            <div class="selector">

              <select class="form-control" id="cmb_tour_group" Title="Tour Date" name="cmb_tour_group" onchange="seats_availability_reflect();">

                <?php

                echo "<option value=''>*Tour Date</option>";

                $today_date = strtotime(date('Y-m-d'));

                $sq = mysqlQuery("select * from tour_groups where tour_id='$tour_id' and status!='Cancel' ");

                while($row=mysqli_fetch_assoc($sq))

                {

                    $group_id=$row['group_id'];

                    $from_date=$row['from_date'];

                    $to_date=$row['to_date'];

              

                    $from_date=date("d-m-Y", strtotime($from_date));  

                    $to_date=date("d-m-Y", strtotime($to_date)); 

                

                    $date1_ts = strtotime($from_date);

                    if($flag == "false"){

                        $val = (int)date_diff(date_create(date("d-m-Y")),date_create($to_date))->format("%R%a");

                        if($val <= 0)  continue; // skipping the ended group tours (only used group quotation)

                    }

              

                    if($today_date < $date1_ts){

                      echo "<option value='$group_id'>".$from_date." to ".$to_date."</option>";

                    }

                } ?>

              </select>

            </div>

          </div>

        </div>

        <!-- *** tours Name End *** -->

        

        <!-- *** Adult *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>*Adults</label>

            <div class="selector">

            <select name="gtadult" id='gtadult' class="full-width" required>

                <?php for($m=0;$m<=10;$m++){

                ?>

                    <option value="<?= $m ?>"><?= $m ?></option>

                <?php } ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Adult End *** -->

        <!-- *** Child W/o Bed *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>Child Without Bed(2-5 Yrs)</label>

            <div class="selector">
              <select name="gchild_wobed" id='gchild_wobed' class="full-width">
                  <?php for($m=0;$m<=10;$m++){
                    ?>
                    <option value="<?= $m ?>"><?= $m ?></option>
                  <?php } ?>
              </select>
            </div>

        </div>

        </div>

        <!-- *** Child W/o Bed End *** -->

        <!-- *** Child With Bed *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>Child With Bed(5-12 Yrs)</label>

            <div class="selector">

            <select name="gchild_wibed" id='gchild_wibed' class="full-width">

                <?php for($m=0;$m<=10;$m++){

                ?>

                    <option value="<?= $m ?>"><?= $m ?></option>

                <?php } ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Child With Bed End *** -->

        <!-- *** Extra Bed *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>Extra Bed</label>

            <div class="selector">

            <select name="gextra_bed" id='gextra_bed' class="full-width">

                <?php for($m=0;$m<=10;$m++){

                  ?>

                    <option value="<?= $m ?>"><?= $m ?></option>

                <?php } ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Extra Bed End *** -->

        <!-- *** Infant *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>Infants(0-2 Yrs)</label>

            <div class="selector">

            <select name="gtinfant" id='gtinfant' class="full-width">

                <?php for($m=0;$m<=10;$m++){

                  ?>

                    <option value="<?= $m ?>"><?= $m ?></option>

                <?php }  ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Infant End *** -->

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">

            <button class="c-button lg colGrn m20-top">

                <i class="icon itours-search"></i> SEARCH NOW

            </button>

        </div>

        <div class="col-md-6 col-sm-6 col-12">

          <div class="form-group">

            <div id="seats_availability" class="m20-top"><?= $seats_availability ?></div>

          </div>

        </div>

    </div>

</form>