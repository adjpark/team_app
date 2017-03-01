//---------------------------fb window object--------------------------------
window.fbUser = {
    userID: "",
    userName: "",
    userPicture:"",
    email:"",
    age:"",
    gender:""
}
//-----------------------------fb api connect------------------------------
window.fbAsyncInit = function() {
    FB.init({
      appId      : '1321198337925465',
      xfbml      : true,
      version    : 'v2.8'
    });
    console.log(FB);
    var fbLogin = document.getElementById("fbLogin");
      fbLogin.onclick = function(){
          FB.login(function(resp){
              if(resp.status == "connected"){
                      FB.api("/me?fields=id,name,picture,email,age_range,gender",
                        function(uresp){
                          window.fbUser.userID = uresp.id;  
                          window.fbUser.userName = uresp.name;
                          window.fbUser.userPicture = uresp.picture.data.url;
                          window.fbUser.email = uresp.email;
                          window.fbUser.age = uresp.age_range.min;
                          window.fbUser.gender = uresp.gender;
                          $.ajax({
                            url:"fbLogin.php",
                            type:"post",
                            data:{
                                userID : fbUser.userID,
                                userName : fbUser.userName,
                                userPicture : fbUser.userPicture,
                                userEmail : fbUser.email,
                                userAge : fbUser.age,
                                userGender : fbUser.gender,
                                userLocation : fbUser.location
                                
                            },
                            success:function(resp){
                                console.log("success")
                                window.location.href = "index.php";
                            }   
                        })
                    });
              }
          })
      }
};
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));