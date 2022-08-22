<form id="frm_tours_search">
  <div class="row">
        <input type='hidden' id='page_type' value='search_page' name='search_page'/>
        <!-- *** Destination Name *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>Select Destination</label>
            <div class="c-select2DD">
              <select id='tours_dest_filter' class="full-width js-roomCount" onchange="package_dynamic_reflect(this.id);">
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
        <!-- *** tours Name *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>Select Tour</label>
            <div class="c-select2DD">
              <select id='tours_name_filter' class="full-width js-roomCount">
                <option value=''>Tour Name</option>
                <?php
                $query = "select package_id, package_name from custom_package_master where 1 and status!='Inactive'";
                $sq_tours = mysqlQuery($query);
                while($row_tours = mysqli_fetch_assoc($sq_tours)){
                ?>
                <option value="<?php echo $row_tours['package_id'] ?>"><?php echo $row_tours['package_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <!-- *** tours Name End *** -->
        
        <!-- *** Date *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>*Select Travel Date</label>
            <div class="datepicker-wrap">
              <input type="text" name="travelDate" class="input-text full-width" placeholder="mm/dd/yy" id="travelDate" required/>
            </div>
          </div>
        </div>
        <!-- *** Date End *** -->
        
        <!-- *** Adult *** -->
        <div class="col-md-3 col-sm-6 col-12">
        <div class="form-group">
            <label>*Adults</label>
            <div class="selector">
            <select name="tadult" id='tadult' class="full-width" required>
                <?php for($i=0;$i<=10;$i++){ ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
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
            <select name="child_wobed" id='child_wobed' class="full-width">
                <?php for($i=0;$i<=10;$i++){ ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
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
            <select name="child_wibed" id='child_wibed' class="full-width">
                <?php for($i=0;$i<=10;$i++){ ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
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
            <select name="extra_bed" id='extra_bed' class="full-width">
                <?php for($i=0;$i<=10;$i++){ ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
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
            <select name="tinfant" id='tinfant' class="full-width">
                <?php for($i=0;$i<=10;$i++){ ?>
                    <option value="<?= $i ?>"><?= $i ?></option>
                <?php } ?>
            </select>
            </div>
        </div>
        </div>
        <!-- *** Infant End *** -->
        <div class="col-md-3 col-sm-6 col-12">
            <button class="c-button lg colGrn m20-top">
                <i class="icon itours-search"></i> SEARCH NOW
            </button>
        </div>
    </div>
</form>