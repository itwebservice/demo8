<h2 class="c-heading">
  Booking Summary
</h2>

<!-- Table -->
<div class="clearfix c-table st-dataTable">
  <div class="clearfix">
    <div class="row">
        <div class="col-md-8">
            <div class="formField">
            <label>Search By Date</label>
            <input type="text" id="from_date_filter" onchange="get_to_date1(this.id,'qto_date_filter');list_reflect();" class="txtBox d-inline-block wAuto" placeholder="From Date" />
            <input type="text" id="to_date_filter" onchange="validate_validDate1('qfrom_date_filter','qto_date_filter');list_reflect();" class="txtBox d-inline-block wAuto" placeholder="To Date" />
            </div>
        </div>
    </div>
  </div>
  <table class="table" id="tbl_list">
  </table>
</div>

<!-- Table End -->

<!-- Colum totals -->
<!-- <div class="c-tableINfo">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <div class="infoCard">
        <span class="lbl">Total Amount</span>
        <span class="info">INR 34,00,000</span>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <div class="infoCard">
        <span class="lbl">Total CANCEL AMOUNT</span>
        <span class="info">INR 34,00,000</span>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <div class="infoCard">
        <span class="lbl">Total Net Amount</span>
        <span class="info">INR 34,00,000</span>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
      <div class="infoCard">
        <span class="lbl">Total Paid Amount</span>
        <span class="info">INR 34,00,000</span>
      </div>
    </div>
  </div>
</div> -->
<!-- Colum totals End -->
