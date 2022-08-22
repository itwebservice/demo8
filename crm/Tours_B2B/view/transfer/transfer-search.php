<form id="frm_transfer_search">

<div class="row">
  <div class="col-12">
    <div class="radioCheck">
      <div class="sect s1">
        <input type="radio" value="oneway" id="oneway" name="transfer_type" class="radio_txt transfer_type" onclick="fields_enable_disable()" checked />
        <label for="oneway" role="button" class="radio_lbl">One Way</label>
      </div>
      <div class="sect s2">
        <input type="radio"value="roundtrip" id="roundtrip" name="transfer_type" class="radio_txt transfer_type" onclick="fields_enable_disable()"  />
        <label for="roundtrip" role="button" class="radio_lbl">Round Trip</label>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Pickup Location</label>
        <div class="c-select2DD">
        <select id='pickup_location' class="full-width js-roomCount">
            <option value="">Select Pickup Location</option>
            <optgroup value='city' label="City Name">
            <?php get_cities_dropdown('1'); ?>
            </optgroup>
            <optgroup value='airport' label="Airport Name">
            <?php get_airport_dropdown(); ?>
            </optgroup>
            <optgroup value='hotel' label="Hotel Name">
            <?php get_hotel_dropdown(); ?>
            </optgroup>
        </select>
        </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Pickup Date&Time</label>
        <div class="datepicker-wrap">
            <input type="text" name="pickup_date" class="input-text full-width" placeholder="mm/dd/yy H:i" id="pickup_date"/>
        </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-12">
    <div class="form-group">
      <label>Total Passengers</label>
      <input type="number" name="passengers" class="input-text full-width" placeholder="Total Passengers" id="passengers"/>
    </div>
  </div>

  <div class="col-md-4 col-sm-6 col-12">
    <div class="form-group">
      <label>Drop-Off Location</label>
        <div class="c-select2DD">
        <select id='dropoff_location' class="full-width js-roomCount">
            <option value="">Select Drop-Off Location</option>
            <optgroup value='city' label="City Name">
            <?php get_cities_dropdown('1'); ?>
            </optgroup>
            <optgroup value='airport' label="Airport Name">
            <?php get_airport_dropdown(); ?>
            </optgroup>
            <optgroup value='hotel' label="Hotel Name">
            <?php get_hotel_dropdown(); ?>
            </optgroup>
        </select>
        </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-6 col-12">
    <div class="form-group">
        <label>Return Date&Time</label>
        <div class="datepicker-wrap">
            <input type="text" name="return_date" class="input-text full-width" placeholder="mm/dd/yy H:i" id="return_date"/>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-12">
    <button class="c-button lg colGrn m26-top">
      <i class="icon itours-search"></i> SEARCH NOW
    </button>
  </div>
</div>

</form>