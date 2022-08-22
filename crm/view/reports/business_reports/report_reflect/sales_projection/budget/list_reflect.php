<?php
include "../../../../../../model/model.php";
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];

$total_g = $_SESSION['total_g'];
$total_p = $_SESSION['total_p'];
$total_b = $_SESSION['total_b'];
$total_c = $_SESSION['total_c'];
$total_pp = $_SESSION['total_pp'];
$total_h = $_SESSION['total_h'];
$total_v = $_SESSION['total_v'];
$total_t = $_SESSION['total_t'];
$total_f = $_SESSION['total_f'];
$total_f1 = $_SESSION['total_f1'];
$total_ms = $_SESSION['total_ms'];
$total = $_SESSION['total'];
$from_date1 = date('Y-m-d', strtotime($from_date));
$to_date1 = date('Y-m-d', strtotime($to_date));

include('enquiry_budget.php');
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
    
    <table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
        <thead>
            <tr class="table-heading-row">
                <th>Sr.NO.</th>
                <th>ENQUIRY Type</th>
                <th>Budgeted Sales</th> 
                <th>Actuals Sales</th>
                <th>Variance</th>
                <th>% of Actuals on Budgeted</th>
                <th>Expected Probability</th>
                <th>Variance in %</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sq_g = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='59' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_p = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='91' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_f1 = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='50' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_f2 = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='174' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_t = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='133' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_v = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='140' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_h = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='63' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_pp = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='93' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_b = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='10' and date(created_at) between '$from_date1' and '$to_date1'"));
            $sq_c = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='18' and date(created_at) between '$from_date1' and '$to_date1'"));                
            $sq_ms = mysqli_fetch_assoc(mysqlQuery("select sum(payment_amount) as sum from finance_transaction_master where gl_id='169' and date(created_at) between '$from_date1' and '$to_date1'"));
            ?>
            <tr> 
                <td>1</td>
                <td>Group Tour</td>
                <td id="bud_s_g"><?= ($total_g == '') ? '0' : $total_g ?></td>
                <td id="sale_g"><?= ($sq_g['sum'] == '') ? '0' : $sq_g['sum']  ?></td>
                <td id="total_g"></td>
                <td id="act_g"> </td>
                <td id="pro_g"> </td>
                <td id="variance_g"> </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Package Tour</td>
                <td id="bud_s_p"><?= ($total_p == '') ? '0' : $total_p ?></td>
                <td id="sale_p"><?= ($sq_p['sum'] == '') ? '0' : $sq_p['sum'] ?></td>
                <td id="total_p"></td>
                <td id="act_p"></td>
                <td id="pro_p"></td>
                <td id="variance_p"></td>
            </tr>
            <tr>
                <td>3</td>
                <td> Flight(Domestic) </td>
                <td id="bud_s_f"><?= ($total_f == '') ? '0' : $total_f ?></td>
                <td id="sale_f" ><?= ($sq_f1['sum'] == '') ? '0' : $sq_f1['sum'] ?></td>
                <td id="total_f"></td>
                <td id="act_f"></td>
                <td id="pro_f"></td>
                <td id="variance_f"></td>
            </tr>
            <tr>
                <td>4</td>
                <td> Flight(International) </td>
                <td id="bud_s_f1"><?= ($total_f1 == '') ? '0' : $total_f1 ?></td>
                <td id="sale_f1" ><?= ($sq_f2['sum'] == '') ? '0' : $sq_f2['sum'] ?></td>
                <td id="total_f1"></td>
                <td id="act_f1"></td>
                <td id="pro_f1"></td>
                <td id="variance_f1"></td>
            </tr>
            <tr>
                <td>5</td>
                <td>Train Ticket </td>
                <td id="bud_s_t"><?= ($total_t == '') ? '0' : $total_t ?></td>
                <td id="sale_t"><?= ($sq_t['sum'] == '') ? '0' : $sq_t['sum'] ?></td>
                <td id="total_t"></td>
                <td id="act_t"></td>
                <td id="pro_t"></td>
                <td id="variance_t"></td>
            </tr>
            <tr> 
                <td>6</td>
                <td>Visa</td>
                <td id="bud_s_v"><?= ($total_v == '') ? '0' : $total_v ?></td>
                <td id="sale_v"><?= ($sq_v['sum'] == '') ? '0' : $sq_v['sum'] ?></td>
                <td id="total_v"></td>
                <td id="act_v"></td>
                <td id="pro_v"></td>
                <td id="variance_v"></td>
            </tr>
            <tr>
                <td>7</td>
                <td>Hotel</td>
                <td id="bud_s_h"><?= ($total_h == '') ? '0' : $total_h ?></td>
                <td id="sale_h"><?= ($sq_h['sum'] == '') ? '0' : $sq_h['sum'] ?> </td>
                <td id="total_h"></td>
                <td id="act_h"></td>
                <td id="pro_h"></td>
                <td id="variance_h"></td>
            </tr>
            <tr>
                <td>8</td>
                <td>Car Rental </td>
                <td id="bud_s_c"><?= ($total_c == '') ? '0' : $total_c ?></td>
                <td id="sale_c"><?= ($sq_c['sum'] == '') ? '0' : $sq_c['sum'] ?></td>
                <td id="total_c"></td>
                <td id="act_c"></td>
                <td id="pro_c"></td>
                <td id="variance_c"></td>
            </tr>
            <tr>
                <td>9</td>
                <td >Bus </td>
                <td id="bud_s_b"><?= ($total_b == '') ? '0' : $total_b ?></td>
                <td id="sale_b"><?= ($sq_b['sum'] == '') ? '0' : $sq_b['sum'] ?> </td>
                <td id="total_b"></td>
                <td id="act_b"> </td>
                <td id="pro_b"> </td>
                <td id="variance_b"> </td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>

</div> </div> </div>
<script>
calculate_sale();
function calculate_sale(){
    //Group
    var bud_g = document.getElementById("bud_s_g").innerText;
    var sale_g = document.getElementById("sale_g").innerText;
    var bud_s_g = document.getElementById("bud_strong_g").value;
    var pro_s_g = document.getElementById("pro_s_g").value;
    var pro_h_g = document.getElementById("pro_h_g").value;
    var pro_c_g = document.getElementById("pro_c_g").value;

    if(bud_g==""){ bud_g=0; }
    if(sale_g=="") { sale_g=0; }
    if(bud_s_g==""){ bud_s_g=0;}
    if(pro_s_g==""){ pro_s_g=0; }
    if(pro_h_g=="") {pro_h_g=0; }
    if(pro_c_g==""){pro_c_g=0;}

    avg_g = 0;
    if(pro_s_g>0){
        avg_g++;
    }
    if(pro_h_g>0){
        avg_g++;
    }
    if(pro_c_g>0){
        avg_g++;
    }


    var total_g = parseFloat(sale_g) - parseFloat(bud_g);
    document.getElementById('total_g').innerHTML = total_g.toFixed(2);
 
    var act_g = (bud_s_g > 0 ) ? parseFloat(sale_g)/ parseFloat(bud_s_g) : 0;
    document.getElementById('act_g').innerHTML = act_g.toFixed(2)+'%';

    var pro_g = (avg_g > 0) ? (parseFloat(pro_c_g) + parseFloat(pro_h_g) + parseFloat(pro_s_g))/ avg_g/100 : 0;
    document.getElementById('pro_g').innerHTML = pro_g.toFixed(2);
 
    var variance_g = parseFloat(act_g) - parseFloat(pro_g);
    document.getElementById('variance_g').innerHTML = variance_g.toFixed(2);
 
 //Package
    var bud_p = document.getElementById("bud_s_p").innerText;
    var sale_p = document.getElementById("sale_p").innerText;
    var bud_s_p = document.getElementById("bud_strong_p").value;
    var pro_s_p = document.getElementById("pro_s_p").value;
    var pro_h_p = document.getElementById("pro_h_p").value;
    var pro_c_p = document.getElementById("pro_c_p").value;
 
    if(bud_p==""){ bud_p=0; }
    if(sale_p=="") { sale_p=0; }
    if(bud_s_p==""){ bud_s_p=0;}
    if(pro_s_p==""){ pro_s_p=0; }
    if(pro_h_p=="") {pro_h_p=0; }
    if(pro_c_p==""){pro_c_p=0;}

    avg_p = 0;
    if(pro_s_p>0){
        avg_p++;
    }
    if(pro_h_p>0){
        avg_p++;
    }
    if(pro_c_p>0){
        avg_p++;
    }


    var total_p = parseFloat(sale_p) - parseFloat(bud_p) ;
    document.getElementById('total_p').innerHTML = total_p.toFixed(2);
    var act_p = (bud_s_p > 0 ) ? parseFloat(sale_p)/ parseFloat(bud_s_p) : 0;
    document.getElementById('act_p').innerHTML = act_p.toFixed(2)+'%';

    var pro_p = (avg_p > 0) ? (parseFloat(pro_s_p) + parseFloat(pro_h_p) + parseFloat(pro_c_p))/avg_p/100 : 0;
    document.getElementById('pro_p').innerHTML = pro_p.toFixed(2);
    var variance_p = parseFloat(act_p) - parseFloat(pro_p);
    document.getElementById('variance_p').innerHTML = variance_p.toFixed(2);
    //Flight
    var sale_f = document.getElementById("sale_f").innerText;
    var sale_f1 = document.getElementById("sale_f1").innerText;
    var bud_f = document.getElementById("bud_s_f").innerText;
    var bud_f1 = document.getElementById("bud_s_f1").innerText;
    var bud_s_f = document.getElementById("bud_strong_f").value;
    var bud_s_f1 = document.getElementById("bud_strong_f1").value;
    var pro_s_f = document.getElementById("pro_s_f").value;
    var pro_h_f = document.getElementById("pro_h_f").value;
    var pro_c_f = document.getElementById("pro_c_f").value;
    var pro_s_f1 = document.getElementById("pro_s_f1").value;
    var pro_h_f1 = document.getElementById("pro_h_f1").value;
    var pro_c_f1 = document.getElementById("pro_c_f1").value;

    if(bud_f==""){ bud_f=0; }
    if(sale_f=="") { sale_f=0; }
    if(sale_f1=="") { sale_f1=0; }
    if(bud_s_f==""){ bud_s_f=0;}
    if(bud_s_f1==""){ bud_s_f1=0;}
    if(bud_f1==""){ bud_f1=0;}
    if(pro_s_f==""){ pro_s_f=0; }
    if(pro_s_f1==""){ pro_s_f1=0; }
    if(pro_h_f=="") {pro_h_f=0; }
    if(pro_h_f1=="") {pro_h_f1=0; }
    if(pro_c_f==""){pro_c_f=0;}
    if(pro_c_f1==""){pro_c_f1=0;}

    avg_f = 0;
    if(pro_s_f>0){
        avg_f++;
    }
    if(pro_h_f>0){
        avg_f++;
    }
    if(pro_c_f>0){
        avg_f++;
    }
    avg_f1 = 0;
    if(pro_s_f1>0){
        avg_f1++;
    }
    if(pro_h_f1>0){
        avg_f1++;
    }
    if(pro_c_f1>0){
        avg_f1++;
    }

    var total_f =parseFloat(sale_f) - parseFloat(bud_f);
    var total_f1 =parseFloat(sale_f1) - parseFloat(bud_f1);

    total_f = (parseFloat(total_f) < 0) ? 0 : total_f;
    document.getElementById('total_f').innerHTML = total_f.toFixed(2);
    document.getElementById('total_f1').innerHTML = total_f1.toFixed(2);

    var act_f = (bud_s_f > 0 ) ? parseFloat(sale_f)/ parseFloat(bud_s_f) : 0;
    document.getElementById('act_f').innerHTML = act_f.toFixed(2)+'%';

    var pro_f = (avg_f > 0) ? (parseFloat(pro_c_f) + parseFloat(pro_h_f) + parseFloat(pro_s_f))/avg_f/100 : 0;
    document.getElementById('pro_f').innerHTML = pro_f.toFixed(2);

    var variance_f = parseFloat(act_f) - parseFloat(pro_f);
    document.getElementById('variance_f').innerHTML = variance_f.toFixed(2);

    var act_f1 = (bud_s_f1 > 0 ) ? parseFloat(sale_f1)/ parseFloat(bud_s_f1) : 0;
    document.getElementById('act_f1').innerHTML = act_f1.toFixed(2)+'%';

    var pro_f1 = (avg_f1>0) ? (parseFloat(pro_c_f1) + parseFloat(pro_h_f1) + parseFloat(pro_s_f1))/avg_f1/100 : 0;
    document.getElementById('pro_f1').innerHTML = pro_f1.toFixed(2);

    var variance_f1 = parseFloat(act_f1) - parseFloat(pro_f1);
    document.getElementById('variance_f1').innerHTML = variance_f1.toFixed(2);

 //Train
    var bud_t = document.getElementById("bud_s_t").innerText;
    var sale_t = document.getElementById("sale_t").innerText;
    var bud_s_t = document.getElementById("bud_strong_t").value;
    var pro_s_t = document.getElementById("pro_s_t").value;
    var pro_h_t = document.getElementById("pro_h_t").value;
    var pro_c_t = document.getElementById("pro_c_t").value;
 
    if(bud_t==""){ bud_t=0; }
    if(sale_t=="") { sale_t=0; }
    if(bud_s_t==""){ bud_s_t=0;}
    if(pro_s_t==""){ pro_s_t=0; }
    if(pro_h_t=="") {pro_h_t=0; }
    if(pro_c_t==""){pro_c_t=0;}

    avg_t = 0;
    if(pro_s_t>0){
        avg_t++;
    }
    if(pro_h_t>0){
        avg_t++;
    }
    if(pro_c_t>0){
        avg_t++;
    }


    var total_t = parseFloat(sale_t) - parseFloat(bud_t);

    document.getElementById('total_t').innerHTML = total_t.toFixed(2);
    var act_t = (bud_s_t > 0 ) ?parseFloat(sale_t)/ parseFloat(bud_s_t) : 0;
    document.getElementById('act_t').innerHTML = act_t.toFixed(2)+'%';

    var pro_t = (avg_t>0)?(parseFloat(pro_s_t) + parseFloat(pro_c_t) + parseFloat(pro_h_t))/avg_t/ 100 : 0;
    document.getElementById('pro_t').innerHTML = pro_t.toFixed(2);

    var variance_t = parseFloat(act_t) - parseFloat(pro_t);
    document.getElementById('variance_t').innerHTML = variance_t.toFixed(2);

//Visa
    var bud_v = document.getElementById("bud_s_v").innerText;
    var sale_v = document.getElementById("sale_v").innerText;
    var bud_s_v = document.getElementById("bud_strong_v").value;
    var pro_s_v = document.getElementById("pro_s_v").value;
    var pro_h_v = document.getElementById("pro_h_v").value;
    var pro_c_v = document.getElementById("pro_c_v").value;
 
    if(bud_v==""){ bud_v=0; }
    if(sale_v=="") { sale_v=0; }
    if(bud_s_v==""){ bud_s_v=0;}
    if(pro_s_v==""){ pro_s_v=0; }
    if(pro_h_v=="") {pro_h_v=0; }
    if(pro_c_v==""){pro_c_v=0;}

    avg_v = 0;
    if(pro_s_v>0){
        avg_v++;
    }
    if(pro_h_v>0){
        avg_v++;
    }
    if(pro_c_v>0){
        avg_v++;
    }


    var total_v = parseFloat(sale_v) - parseFloat(bud_v);
    document.getElementById('total_v').innerHTML = total_v.toFixed(2);
    var act_v = (bud_s_v > 0) ? parseFloat(sale_v)/ parseFloat(bud_s_v) : 0;
    document.getElementById('act_v').innerHTML = act_v.toFixed(2)+'%';
    var pro_v = (avg_v>0)?(parseFloat(pro_s_v) + parseFloat(pro_h_v) + parseFloat(pro_c_v))/avg_v/100 : 0;
    document.getElementById('pro_v').innerHTML = pro_v.toFixed(2);

    var variance_v = parseFloat(act_v) - parseFloat(pro_v);
    document.getElementById('variance_v').innerHTML = variance_v.toFixed(2);

      //Hotel
    var bud_h = document.getElementById("bud_s_h").innerText;
    var sale_h = document.getElementById("sale_h").innerText;
    var bud_s_h = document.getElementById("bud_strong_h").value;
    var pro_s_h = document.getElementById("pro_s_h").value;
    var pro_h_h = document.getElementById("pro_h_h").value;
    var pro_c_h = document.getElementById("pro_c_h").value;

    if(bud_h==""){ bud_h=0; }
    if(sale_h=="") { sale_h=0; }
    if(bud_s_h==""){ bud_s_h=0;}
    if(pro_s_h==""){ pro_s_h=0; }
    if(pro_h_h=="") {pro_h_h=0; }
    if(pro_c_h==""){pro_c_h=0;}

    avg_h = 0;
    if(pro_s_h>0){
        avg_h++;
    }
    if(pro_h_h>0){
        avg_h++;
    }
    if(pro_c_h>0){
        avg_h++;
    }


    var total_h = parseFloat(sale_h) - parseFloat(bud_h);

    document.getElementById('total_h').innerHTML = total_h.toFixed(2);
    var act_h = (bud_s_h > 0) ? parseFloat(sale_h)/ parseFloat(bud_s_h) : 0;
    document.getElementById('act_h').innerHTML = act_h.toFixed(2)+'%';

    var pro_h = (avg_h > 0)?(parseFloat(pro_s_h) + parseFloat(pro_c_h) + parseFloat(pro_h_h))/ avg_h/100:0;
    document.getElementById('pro_h').innerHTML = pro_h.toFixed(2);

    var variance_h = parseFloat(act_h) - parseFloat(pro_h);
    document.getElementById('variance_h').innerHTML = variance_h.toFixed(2);

     //Car 
    var bud_c = document.getElementById("bud_s_c").innerText;
    var sale_c = document.getElementById("sale_c").innerText;
    var bud_s_c = document.getElementById("bud_strong_c").value;
    var pro_s_c = document.getElementById("pro_s_c").value;
    var pro_h_c = document.getElementById("pro_h_c").value;
    var pro_c_c = document.getElementById("pro_c_c").value;
 
    if(bud_c==""){ bud_c=0; }
    if(sale_c=="") { sale_c=0; }
    if(bud_s_c==""){ bud_s_c=0;}
    if(pro_s_c==""){ pro_s_c=0; }
    if(pro_h_c=="") {pro_h_c=0; }
    if(pro_c_c==""){pro_c_c=0;}

    avg_c = 0;
    if(pro_s_c>0){
        avg_c++;
    }
    if(pro_h_c>0){
        avg_c++;
    }
    if(pro_c_c>0){
        avg_c++;
    }


    var total_c =  parseFloat(sale_c) - parseFloat(bud_c);

    document.getElementById('total_c').innerHTML = total_c.toFixed(2);
    var act_c = (bud_s_c > 0) ? parseFloat(sale_c)/ parseFloat(bud_s_c) : 0;
    document.getElementById('act_c').innerHTML = act_c.toFixed(2)+'%';

    var pro_c = (avg_c>0)?(parseFloat(pro_h_c) + parseFloat(pro_c_c) + parseFloat(pro_s_c))/avg_c/100:0;
    document.getElementById('pro_c').innerHTML = pro_c.toFixed(2);

    var variance_c = parseFloat(act_c) - parseFloat(pro_c);
    document.getElementById('variance_c').innerHTML = variance_c.toFixed(2);

     //Bus
    var bud_b = document.getElementById("bud_s_b").innerText;
    var sale_b = document.getElementById("sale_b").innerText;
    var bud_s_b = document.getElementById("bud_strong_b").value;
    var pro_s_b = document.getElementById("pro_s_b").value;
    var pro_h_b = document.getElementById("pro_h_b").value;
    var pro_c_b = document.getElementById("pro_c_b").value;
 
    if(bud_b==""){ bud_b=0; }
    if(sale_b=="") { sale_b=0; }
    if(bud_s_b==""){ bud_s_b=0;}
    if(pro_s_b==""){ pro_s_b=0; }
    if(pro_h_b=="") {pro_h_b=0; }
    if(pro_c_b==""){pro_c_b=0;}

    avg_b = 0;
    if(pro_s_b>0){
        avg_b++;
    }
    if(pro_h_b>0){
        avg_b++;
    }
    if(pro_c_b>0){
        avg_b++;
    }


    var total_b = parseFloat(sale_b) - parseFloat(bud_b);

    document.getElementById('total_b').innerHTML = total_b.toFixed(2);
    var act_b = (bud_s_b > 0) ? parseFloat(sale_b)/ parseFloat(bud_s_b):0;
    document.getElementById('act_b').innerHTML = act_b.toFixed(2)+'%';

    var pro_b = (avg_b>0)?(parseFloat(pro_s_b) + parseFloat(pro_c_b) + parseFloat(pro_h_b))/avg_b/100:0;
    document.getElementById('pro_b').innerHTML = pro_b.toFixed(2);

    var variance_b = parseFloat(act_b) - parseFloat(pro_b);
    document.getElementById('variance_b').innerHTML = variance_b.toFixed(2);

}


</script>
