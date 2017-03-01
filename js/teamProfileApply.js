$(document).ready(function() {
    var teamTitle = document.getElementById("teamTitle");
    var roleName = document.getElementById("roleName");
    var organizerName = document.getElementById("organizerName");
    var sendApp = document.getElementById("sendApp");
    var message = document.getElementById("message");
    //--------------------------text area auto resize----------------------------------   
    var ta = document.querySelector('textarea');
    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;

        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });
    var teamMessageInfo = JSON.parse(localStorage.getItem('teamRoleMessage'));
    console.log(teamMessageInfo)
    teamTitle.innerHTML = teamMessageInfo.teamTitle
    roleName.innerHTML = teamMessageInfo.roleName
    organizerName.innerHTML = teamMessageInfo.teamOrganizer
    //------------------------------Ajax call to send the application to the DB------------------------------   
    sendApp.onclick = function(){
        if(!$.trim($("#message").val())){
            $("#applyError").html("Please complete the message input.");
        }
        else{
            $.ajax({
                url:"teamProfileApplyAjax.php",
                type:"post",
                data:{
                    teamTitle : teamMessageInfo.teamTitle,
                    roleName : teamMessageInfo.roleName,
                    teamOrganizer : teamMessageInfo.teamOrganizer,
                    teamEmail : teamMessageInfo.teamEmail,
                    message : message.value
                },
                dataType:"json",
                success:function(resp){
                    console.log(resp);
                },
                error: function(resp){
                    if (resp.responseText == "success"){
                        console.log("NO ERROR")
                        window.location.href = "home.php"

                    }
                    else{
                        console.log("ERROR")
                        $("#applyError").html("You have applied to one of the roles in this team.");
                    }      
                }
            })   
        }
    }
});