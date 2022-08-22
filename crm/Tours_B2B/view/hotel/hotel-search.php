<form id="frm_hotel_search">
  <div class="row">
        <input type='hidden' id='page_type' value='search_page' name='search_page'/>
        <!-- *** City Name *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>Select City</label>
            <div class="c-select2DD">
              <select id='hotel_city_filter' class="full-width js-roomCount" onchange="hotel_names_load(this.id);">
              </select>
            </div>
          </div>
        </div>
        <!-- *** City Name End *** -->
        <!-- *** Hotel Name *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>Select Hotel Name</label>
            <div class="c-select2DD">
              <select id='hotel_name_filter' class="full-width js-roomCount">
              <option value="">Hotel Name</option>
                <?php 
                $query = "select hotel_id, hotel_name from hotel_master where 1";
                $sq_hotel = mysqlQuery($query);
                while($row_hotel = mysqli_fetch_assoc($sq_hotel)){ ?>
                <option value="<?php echo $row_hotel['hotel_id'] ?>"><?php echo $row_hotel['hotel_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <!-- *** Hotel Name End *** -->
        
        <!-- *** Check in Date *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>*Check In</label>
            <div class="datepicker-wrap">
              <input type="text" name="date_from" class="input-text full-width" placeholder="mm/dd/yy" id="checkInDate" onchange='get_to_date("checkInDate","checkOutDate")' required/>
            </div>
          </div>
        </div>
        <!-- *** Check in Date End *** -->
        
        <!-- *** Check Out Date *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>*Check Out
              <span class="nytCount" id='total_stay' style='display:none;'></span>
            </label>
            <div class="datepicker-wrap">
              <input type="text" name="date_to" class="input-text full-width" placeholder="mm/dd/yy" id="checkOutDate" onchange='total_nights_reflect();' required/>
            </div>
          </div>
        </div>
        <!-- *** Check Out Date End *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group clearfix">
            <label>Hotel Star Category</label>
              <div class="form-check form-check-inline c-checkGroup">
              <input class="form-check-input" type="checkbox" id="c1" value="1" name='star_category'>
              <label class="form-check-label" role="button" for="c1">
                1 <i class="icon-star"></i>
              </label>
            </div>
              <div class="form-check form-check-inline c-checkGroup">
              <input class="form-check-input" type="checkbox" id="c2" value="2" name='star_category'>
              <label class="form-check-label" role="button" for="c2">
                2 <i class="icon-star"></i>
              </label>
            </div>
              <div class="form-check form-check-inline c-checkGroup">
              <input class="form-check-input" type="checkbox" id="c3" value="3" name='star_category'>
              <label class="form-check-label" role="button" for="c3">
                3<i class="icon-star"></i>
              </label>
            </div>
              <div class="form-check form-check-inline c-checkGroup">
              <input class="form-check-input" type="checkbox" id="c4" value="4" name='star_category'>
              <label class="form-check-label" role="button" for="c4">
                4 <i class="icon-star"></i>
              </label>
            </div>
              <div class="form-check form-check-inline c-checkGroup">
              <input class="form-check-input" type="checkbox" id="c5" value="5" name='star_category'>
              <label class="form-check-label" role="button" for="c5">
                5<i class="icon-star"></i>
              </label>
            </div>
          </div>
        </div>

    <div class='block blue' id='display_addRooms_modal'></div>
    <!-- *** Add Rooms *** -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="form-group">
        <label>Add Rooms</label>
        <div class="c-addRoom">
          <a class="roomInfo" onclick='display_addRooms_modal()'>
            <strong id='total_pax'></strong> Person in
            <strong id='room_count'></strong>
          </a>
        </div>
      </div>
    </div>
    <!-- *** Nationality *** -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="form-group">
        <label>Nationality</label>
        <div class="c-select2DD">
          <select name="nationality" id='nationality' class="full-width js-roomCount">
            <option value="AL">India</option>
            <option value="WY">Dubai</option>
          </select>
        </div>
      </div>
    </div>
    <!-- *** Nationality End *** -->
    <input type='hidden' id='adult_count' name='adult_count'/>
    <input type='hidden' id='child_count' name='child_count'/>
    <input type='hidden' value='1' id='dynamic_room_count' name='dynamic_room_count'/>
    <!-- *** Search Rooms *** -->
    <div class="col-md-3 col-sm-6 col-12">
      <button class="c-button lg colGrn m26-top">
          <i class="icon itours-search"></i> SEARCH NOW
      </button>
    </div>
    <!-- *** Search Rooms End *** -->
    </div>
</form>