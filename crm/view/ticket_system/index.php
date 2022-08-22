<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
require_once('../../classes/tour_booked_seats.php');

$role = $_SESSION['role'];
$role_id = $_SESSION['role_id'];
$login_id = $_SESSION['login_id'];
$reminder_status = (isset($_SESSION['reminder_status'])) ? "true" : "false";
$getClient =  mysqli_fetch_array(mysqlQuery("select client_id from app_settings"))['client_id'];


?>
<!-- tickets -->
<div class="dashboard_table dashboard_table_panel main_block mg_bt_25" style="padding: 40px;">

    <div class="row text-left">

        <div class="col-md-12">
            <div class="dashboard_table_heading main_block">

                <div class="col-md-6 no-pad">

                    <h3>Tickets</h3>


                </div>
                <div class="col-md-6 ">
                    <!-- Button trigger modal -->
                    <div class="text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addmodal">
                            Add New +
                        </button>
                    </div>

                    <!-- Modal -->

                    <div class="modal fade bd-example-modal-lg" data-backdrop="static" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="addmodal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="width: 1200px;" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
                                    <button type="button" class="close" id="closeThisAdd" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="addticketform">
                                    <div class="modal-body">


                                        <!-- row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="client" value="<?php echo $getClient; ?>">

                                            </div>
                                            <div class="col-md-6">
                                                <div style="float:right;">
                                                    <table>
                                                        <tr>

                                                            <td><input type="button" value="+" onclick="addRows()" class="btn btn-primary" /></td>
                                                            <td><input type="button" value="-" onclick="deleteRows()" class="btn btn-danger" /></td>

                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <table id="emptbl">
                                            <tr>
                                                <th>Module</th>
                                                <th>Sub Module</th>
                                                <th>Description</th>
                                                <th>SnapShot Link</th>
                                                <th>Video Link</th>
                                                <th>type</th>
                                            </tr>
                                            <tr>
                                                <td id="col0"><input type="text" name="module[]" id="module" class="form-control" required /></td>
                                                <td id="col1">
                                                    <input type="text" name="submodule[]" id="submodule" class="form-control" required>
                                                </td>

                                                <td id="col2">
                                                    <textarea name="description[]" class="form-control" required></textarea>
                                                </td>
                                                <td id="col3">
                                                    <input type="text" name="sslink[]" class="form-control" required>
                                                </td>
                                                <td id="col4">
                                                    <input type="text" name="videolink[]" class="form-control" required>
                                                </td>
                                                <td id="col5">
                                                    <select name="type[]" class="form-control">
                                                        <option value="Issue">Issue</option>
                                                        <option value="Suggestion">Suggestion</option>
                                                        <option value="Customization">Customization</option>
                                                    </select>
                                                </td>

                                            </tr>
                                        </table>


                                        <!-- row -->
                                        <!-- row script -->

                                        <script type="text/javascript">
                                            function addRows() {
                                                var table = document.getElementById('emptbl');
                                                var rowCount = table.rows.length;
                                                var cellCount = table.rows[0].cells.length;
                                                var row = table.insertRow(rowCount);
                                                for (var i = 0; i <= cellCount; i++) {
                                                    var cell = 'cell' + i;
                                                    cell = row.insertCell(i);
                                                    var copycel = document.getElementById('col' + i).innerHTML;
                                                    cell.innerHTML = copycel;

                                                }
                                            }

                                            function deleteRows() {
                                                var table = document.getElementById('emptbl');
                                                var rowCount = table.rows.length;
                                                if (rowCount > '2') {
                                                    var row = table.deleteRow(rowCount - 1);
                                                    rowCount--;
                                                } else {
                                                    alert('There should be atleast one row');
                                                }
                                            }
                                        </script>



                                        <!-- row script -->

                                    </div>
                                    <div class="modal-footer">
                                        <button name="add_ticket" id="ticketsubmit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



            </div>

            <div class="get_tickets_report" id="get_tickets_report">

                <?php
                $dataAll = file_get_contents('https://itourscloud.com/nikhil-support/model/get-ticket-api.php?cid=' . $getClient);
                echo $dataAll;
                ?>
            </div>

        </div>



    </div>

</div>
<!-- tickets end -->
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php');
?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('#ticketsubmit').click(function(e) {
            $("#ticketsubmit").html('Loading...');
            $("#ticketsubmit").prop('disabled', true);
            e.preventDefault();
            var module = $('input[name="module[]"]').map(function() {
                return this.value;
            }).get();
            var submodule = $('input[name="submodule[]"]').map(function() {
                return this.value;
            }).get();
            var client = $('[name="client"]').val();
            var description = $('textarea[name="description[]"]').map(function() {
                return this.value;
            }).get();
            var type = $('select[name="type[]"]').map(function() {
                return this.value;
            }).get();
            var sslink = $('input[name="sslink[]"]').map(function() {
                return this.value;
            }).get();
            var videolink = $('input[name="videolink[]"]').map(function() {
                return this.value;
            }).get();
            $.ajax({
                type: 'POST',
                url: 'https://itourscloud.com/nikhil-support/model/add-ticket-api.php',
                data: {
                    'module[]': module,
                    'submodule[]': submodule,
                    'client': client,
                    'description[]': description,
                    'type[]': type,
                    'sslink[]': sslink,
                    'videolink[]': videolink
                    // other data
                },
                success: function() {
                    alert('added successfully');
                    document.getElementById('addticketform').reset();
                    $("#ticketsubmit").html('Save Changes');
                    $("#ticketsubmit").prop('disabled', false);
                    $('#closeThisAdd').click();
                    location.reload();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status == 500) {
                        $("#ticketsubmit").html('Save Changes');
                        $("#ticketsubmit").prop('disabled', false);
                        alert('Internal error: ' + jqXHR.responseText);
                    } else {
                        $("#ticketsubmit").html('Save Changes');
                        $("#ticketsubmit").prop('disabled', false);
                        alert('Unexpected error.'+jqXHR.responseText);
                    }
                }
            });

        });
    });
</script>