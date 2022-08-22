<?php
include "../../../../../model/model.php";
$fromdate = !empty($_POST['fromdate']) ? get_date_db($_POST['fromdate']) : null;
$todate = !empty($_POST['todate']) ? get_date_db($_POST['todate']) : null;


class supplier
{
    public $count = 1;
    public $fromdate, $todate, $supplierType;
    public $array_s = array();
    public function __construct($fromdate, $todate, $supplierType)
    {
        $this->fromdate = $fromdate;
        $this->todate = $todate;
        $this->supplierType = $supplierType;
    }
    function generalQuery($joinTable, $on, $where)
    {
        return $gnQuery = "select * from vendor_estimate inner join $joinTable on vendor_estimate.vendor_type_id=$on where $where";
    }
}
class transport extends supplier
{
    function getTransportSupplier($id)
    {
        $this->generalQuery('transport_agency_master', '', '');
    }
}
class carRental extends supplier
{
    function getCarRental()
    {
        $result =  mysqlQuery($this->generalQuery('car_rental_vendor', 'car_rental_vendor.vendor_id', '1=1'));
        while ($data = mysqli_fetch_assoc($result)) {
            $temparr = array("data" => array(
                (int) ($this->count++),
                $data['vendor_name'],
                '0',
                '0',
                '<button class="btn btn-info btn-sm" onclick="view_supp_wise_modal(' . $data['branch_id'] . ')" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></button>'


            ), "bg" => '');
            array_push($this->array_s, $temparr);
        }
        return $this->array_s;
    }
}

$all_data = array();
$car = new carRental($fromdate,$todate,'car rental');
array_push($all_data, $car->getCarRental());








$footer_data = array("footer_data" => array(
	'total_footers' => 0,   
	)
);
array_push($all_data, $footer_data);
echo json_encode($all_data);

