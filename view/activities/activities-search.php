<form id="frm_activities_search">

  <div class="row">

        <input type='hidden' id='page_type' value='search_page' name='search_page'/>

        <!-- *** City Name *** -->

        <div class="col-md-3 col-sm-6 col-12">

          <div class="form-group">

            <label>Select City</label>

            <div class="c-select2DD">

              <select id='activities_city_filter' class="full-width js-roomCount" onchange="activities_names_load(this.id);">

              </select>

            </div>

          </div>

        </div>

        <!-- *** City Name End *** -->

        <!-- *** Activities Name *** -->

        <div class="col-md-3 col-sm-6 col-12">

          <div class="form-group">

            <label>Select Activity</label>

            <div class="c-select2DD">

              <select id='activities_name_filter' class="full-width js-roomCount">

                <option value=''>Activity Name</option>

                <?php

                $query = "select entry_id, excursion_name from excursion_master_tariff where 1";

                $sq_act = mysqlQuery($query);

                while($row_act = mysqli_fetch_assoc($sq_act)){

                ?>

                <option value="<?php echo $row_act['entry_id'] ?>"><?php echo $row_act['excursion_name'] ?></option>

                <?php } ?>

              </select>

            </div>

          </div>

        </div>

        <!-- *** Activities Name End *** -->

        

        <!-- *** Date *** -->

        <div class="col-md-3 col-sm-6 col-12">

          <div class="form-group">

            <label>*Select Date</label>

            <div class="datepicker-wrap">

              <input type="text" name="checkDate" class="input-text full-width" placeholder="mm/dd/yy" id="checkDate" required/>

            </div>

          </div>

        </div>

        <!-- *** Date End *** -->

        

        <!-- *** Adult *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>*Adults</label>

            <div class="selector">

            <select name="adult" id='adult' class="full-width" required>

                <?php for($i=0;$i<=20;$i++){ ?>

                    <option value="<?= $i ?>"><?= $i ?></option>

                <?php } ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Adult End *** -->

        <!-- *** Child *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>Children(2-12 Yrs)</label>

            <div class="selector">

            <select name="child" id='child' class="full-width">

                <?php for($i=0;$i<=20;$i++){ ?>

                    <option value="<?= $i ?>"><?= $i ?></option>

                <?php } ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Child End *** -->

        <!-- *** Infant *** -->

        <div class="col-md-3 col-sm-6 col-12">

        <div class="form-group">

            <label>Infants(0-2 Yrs)</label>

            <div class="selector">

            <select name="infant" id='infant' class="full-width">

                <?php for($i=0;$i<=20;$i++){ ?>

                    <option value="<?= $i ?>"><?= $i ?></option>

                <?php } ?>

            </select>

            </div>

        </div>

        </div>

        <!-- *** Infant End *** -->

        <div class="col-lg-3 col-md-4 col-sm-6 col-12">

            <button class="c-button lg colGrn m26-top m15-top">

                <i class="icon itours-search"></i> SEARCH NOW

            </button>

        </div>

    </div>

</form>