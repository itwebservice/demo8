<form id="frm_ferry_search">
  <div class="row">
        <input type='hidden' id='page_type' value='search_page' name='search_page'/>
        <!-- *** From Location Name *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>*Select From Location</label>
            <div class="c-select2DD">
              <select id='ffrom_city_filter' title="From Location" class="full-width js-roomCount">
              </select>
            </div>
          </div>
        </div>
        <!-- *** From Location Name End *** -->
        <!-- *** To Location Name *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>*Select To Location</label>
            <div class="c-select2DD">
              <select id='fto_city_filter' title="To Location" class="full-width js-roomCount">
              </select>
            </div>
          </div>
        </div>
        <!-- *** To Location Name End *** -->
        <!-- *** Date *** -->
        <div class="col-md-3 col-sm-6 col-12">
          <div class="form-group">
            <label>*Select Travel Datetime</label>
            <div class="datepicker-wrap">
              <input type="text" name="ftravelDate" title="Travel Datetime" class="input-text full-width" placeholder="mm/dd/yy" id="ftravelDate" required/>
            </div>
          </div>
        </div>
        <!-- *** Date End *** -->
        <!-- *** Adult *** -->
        <div class="col-md-3 col-sm-6 col-12">
        <div class="form-group">
            <label>*Adults</label>
            <input type="number" name="fadults" title="Adults" class="input-text full-width" id="fadults" placeholder="Adults" min="0" required/>
        </div>
        </div>
        <!-- *** Adult End *** -->
        <!-- *** Children *** -->
        <div class="col-md-3 col-sm-6 col-12">
        <div class="form-group">
            <label>Children</label>
            <input type="number" name="fchildren" title="Children" class="input-text full-width" id="fchildren" placeholder="Children" min="0" />
        </div>
        </div>
        <!-- *** Children End *** -->
        <!-- *** Infant *** -->
        <div class="col-md-3 col-sm-6 col-12">
        <div class="form-group">
            <label>Infants</label>
            <input type="number" name="finfant" title="Infants" class="input-text full-width" id="finfant" placeholder="Infants" min="0" />
        </div>
        </div>
        <!-- *** Infant End *** -->
        <div class="col-md-3 col-sm-6 col-12">
            <button class="c-button lg colGrn m26-top">
                <i class="icon itours-search"></i> SEARCH NOW
            </button>
        </div>
    </div>
</form>