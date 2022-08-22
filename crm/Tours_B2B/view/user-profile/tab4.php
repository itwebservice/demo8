<h2 class="c-heading">
  Quotation Summary
</h2>

<!-- Table -->
<div class="clearfix c-table st-dataTable">
  <div class="clearfix">
    <div class="row">
        <div class="col-md-8">
            <div class="formField">
            <label>Search By Date</label>
            <input type="text" id="qfrom_date_filter" onchange="get_to_date1(this.id,'qto_date_filter');quotlist_reflect();" class="txtBox d-inline-block wAuto" placeholder="From Date" />
            <input type="text" id="qto_date_filter" onchange="validate_validDate1('qfrom_date_filter','qto_date_filter');quotlist_reflect();" class="txtBox d-inline-block wAuto" placeholder="To Date" />
            </div>
        </div>
    </div>
  </div>
  <table class="table" id="quottbl_list">
  </table>
</div>
