
// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
console.log('statusChangeCallback');
console.log(response);

// The response object is returned with a status field that lets the
// app know the current login status of the person.
// Full docs on the response object can be found in the documentation
// for FB.getLoginStatus().
    $.ajax({
      type : 'post',
      url  : base_url+'customer/Auth/loggin',

          success:function(responses){
            var result = JSON.parse(responses);
            if(result.status==="login"){
              console.log(result.status);
            }else{
               
                if (response.status === 'connected') {
                // Logged into your app and Facebook.
                 //console.log('test');
                  //  testAPI();
                } else if (response.status === 'not_authorized') {
                    console.log('notauth');
                // The person is logged into Facebook, but not your app.
                document.getElementById('status').innerHTML = 'Login with Facebook ';
                
                } else {
                    console.log("response.status");
                // The person is not logged into Facebook, so we're not sure if
                // they are logged into this app or not.
                document.getElementById('status').innerHTML = 'Login with Facebook ';
                }

            }
          }
     });
  
    
    
   


}
// This function is called when someone finishes with the Login
// Button. See the onlogin handler attached to it in the sample
// code below.

function fb_login(){
    FB.login(function(response) {
    if (response.authResponse) {
     console.log('Welcome!  Fetching your information.... ');
     FB.api('/me', { locale: 'en_US', fields: 'name, email' }, function(response) {
         
   // document.getElementById("status").innerHTML = '<p>Welcome '+response.name+'! <a href=login.php?name='+ response.name.replace(" ", "_") +'&email='+ response.email +'>Continue with facebook login</a></p>'
      window.location.href = base_url+'customer/auth/facebook_login?name='+ response.name.replace(" ", "_") +'&email='+ response.email
     });
    } else {
     console.log('User cancelled login or did not fully authorize.');
    }
},{'scope':'email'});
}

function checkLoginState() {


    FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
    });

}
window.fbAsyncInit = function() {
FB.init({
appId : '765059730537749',
cookie : true, // enable cookies to allow the server to access
// the session
xfbml : true, // parse social plugins on this page
version : 'v2.2' // use version 2.2
});
// Now that we've initialized the JavaScript SDK, we call
// FB.getLoginStatus(). This function gets the state of the
// person visiting this page and can return one of three states to
// the callback you provide. They can be:
//
// 1. Logged into your app ('connected')
// 2. Logged into Facebook, but not your app ('not_authorized')
// 3. Not logged into Facebook and can't tell if they are logged into
// your app or not.
//
// These three cases are handled in the callback function.

FB.getLoginStatus(function(response) {
statusChangeCallback(response);
});
};
// Load the SDK asynchronously
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/en_US/sdk.js";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful. See statusChangeCallback() for when this call is made.
function testAPI() {
console.log('Welcome! Fetching your information.... ');
FB.api('/me?fields=name,email', function(response) {
    
//console.log('Successful login for: ' + response.name);
     
window.location.href = base_url+'customer/auth/facebook_login?name='+ response.name.replace(" ", "_") +'&email='+ response.email});

//document.getElementById("status").innerHTML = '<p>Welcome '+response.name+'! <a href=login.php?name='+ response.name.replace(" ", "_") +'&email='+ response.email +'>Continue with facebook login</a></p>'

}
