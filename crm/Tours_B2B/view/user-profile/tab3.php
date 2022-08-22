
  <h2 class="c-heading">
    Account Ledgers
  </h2>
  <!-- Table -->
  <div class="clearfix c-table st-dataTable">
    <div class="clearfix">
      <div class="row">
      <div class="col-md-8">
        <div class="formField">
            <label>Search By Date</label>
            <input type="text" id="from_date_f" onchange="get_to_date1(this.id,'to_date_f');" class="txtBox d-inline-block wAuto" placeholder="From Date" />
            <input type="text" id="to_date_f" onchange="validate_validDate1('from_date_f','to_date_f');" class="txtBox d-inline-block wAuto" placeholder="To Date" />
            <button type="button" onclick="acc_list_reflect();" class="c-button colGrn" >Proceed</button>
          </div>
        </div>
      </div>
    </div>
    <table class="table" id="acc_table"></table>
  </div>
  <!-- Table End -->