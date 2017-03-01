$(document).ready(function() {
    console.log(window.teamListInfo)
    teamListJS = window.teamListInfo;
    //---------------------------identifying which team is clicked for editing--------------------------------
    $(document).on('click', '.myTeam', function(){
        for(var i =0; i < teamListJS.length; i++){
            if($(this).attr("id") == "myTeam"+i){
                console.log(teamListJS[i]);
                localStorage.setItem("myTeamListSelect",JSON.stringify(teamListJS[i]));
                window.location.href = "myTeamEdit.php";
            }
        }
    })
    console.log(window.appList)
    appListJS = window.appList;
    console.log(appListJS.length)
    var applicationList = document.getElementById("applicationList");
    var applicationForm = document.getElementById("applicationForm");
    $( "#noneBackBut" ).click(function() {
       $("#applicationForm").hide();
       $("#applicationList").show();
       $("#noneBackBut").hide();
       $("#initialBack").show();
    });
    //-------------------------identifying which application is clicked----------------------------------
    $(document).on('click', '.appStyle', function(){
        $("#initialBack").hide();
        $("#noneBackBut").show();
        for(var i =0; i < appListJS.length; i++){
            if($(this).attr("id") == "app"+i){
                console.log(i+" button");
                applicationList.style.display = "none";
                applicationForm.style.display = "block";
                $("#teamName").html(appListJS[i][1][0]["title"]);
                $("#roleName").html(appListJS[i][0][0]["roleName"]);
                $("#profileImg").attr("src",appListJS[i][2][0]["userImg"]);
                $("#appName").html(appListJS[i][2][0]["userName"]);
                $("#appAge").html(appListJS[i][2][0]["userAge"]);
                $("#appGender").html(appListJS[i][2][0]["userGender"]);
                $("#appLocation").html(appListJS[i][2][0]["userLocation"]);
                $("#appBio").html(appListJS[i][2][0]["userBio"]);
                $("#appEmail").html(appListJS[i][2][0]["userEmail"]);
                $("#appDesc").html(appListJS[i][3]["message"]);
                var selectedApp = appListJS[i][3];
                console.log(selectedApp);
                var selectedRole = appListJS[i][0];
                console.log(selectedRole);     
    //---------------------------Accepting the application--------------------------------         
                $( "#applicationAccept" ).click(function() {
                  $.ajax({
                        url:"manageApplicationAjax.php",
                        type:"post",
                        data:{
                            accepted : "yes",
                            selectedApp: selectedApp,
                            selectedRole: selectedRole
                        },
                        dataType:"json",
                        success:function(resp){
                            console.log(resp);
                        }
                    })
                    window.location.href = "manage.php";
                });
                
        //--------------------------Declining the application---------------------------------  
                $( "#applicationDecline" ).click(function() {
                  $.ajax({
                        url:"manageApplicationAjax.php",
                        type:"post",
                        data:{
                            accepted : "no",
                            selectedApp: selectedApp
                        },
                        dataType:"json",
                        success:function(resp){
                            console.log(resp);
                        }
                    })
                    window.location.href = "manage.php";
                });
                
            }
        }     
        
    })
    
})