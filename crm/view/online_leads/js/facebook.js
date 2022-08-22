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
};