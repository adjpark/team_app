$(document).ready(function(){
    var profileSubmit = document.getElementById("profileSubmit");
    var profileName = document.getElementById("profileName");  
    var profileAge = document.getElementById("profileAge");
    var profileGender = document.getElementById("profileGender");
    var profileBio = document.getElementById("profileBio");
    var profileEmail = document.getElementById("profileEmail");
    var profileLocation = document.getElementById("profileLocation");
    //-----------------------------Textarea auto resize------------------------------
    var ta = document.querySelector('textarea');
    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });
    //-------------------------Ajax for uploading profile to DB----------------------------------
    profileSubmit.onclick = function(){
        var validationChecker = true;
        if ($( "#profileName" ).val().length < 4){
            validationChecker = false;
        }
        if ($( "#profileEmail" ).val().length < 4){
            validationChecker = false;
        }
        if ($( "#profileGender" ).val().length < 4){
            validationChecker = false;
        }
        if ($( "#profileLocation" ).val().length < 3){
            validationChecker = false;
        }
        if ($( "#profileBio" ).val().length < 3){
            validationChecker = false;
        }
        if ($( "#profileAge" ).val() > 100 || $( "#profileEmail" ).val() < 1){
            validationChecker = false;
        }
        if(validationChecker == false){
            $("#submitError").html("<span class='help-block form-error'>Please write correct values for each inputs</span>");
        }
        if(validationChecker == true){
            $.ajax({
                url:"profileUpload.php",
                type:"post",
                data:{
                    profileName : profileName.value,
                    profileAge : profileAge.value,
                    profileGender : profileGender.value,
                    profileLocation : profileLocation.value,
                    profileBio : profileBio.value,
                    profileEmail : profileEmail.value
                },
                success:function(resp){
                    console.log(resp);
                    window.location = "profile.php";
                }
            })
        } 
    }
});