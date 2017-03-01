$(document).ready(function() {
    var teamTitle = document.getElementById("teamTitle");
    var teamOrganizer = document.getElementById("teamOrganizer");
    var teamLocation = document.getElementById("teamLocation");
    var teamDesc = document.getElementById("teamDesc");
    var teamEmail = document.getElementById("teamEmail");
    var teamRoles = document.getElementById("teamRoles");
    var teamKeys = document.getElementById("teamKeys");
    var teamImg = document.getElementById("teamImg");
    var teamCategory = document.getElementById("teamCategory");
    var msgView = document.getElementById("msgView");
    var teamApply = document.getElementById("teamApply");
    var roleApply = document.getElementById("roleApply");
    var roleEmail = document.getElementById("roleEmail");
    var teamView = document.getElementById("teamView");
    var myTeamList = document.getElementById("teamlist");
    var msgView = document.getElementById("msgView");
    var teamProfileObj = JSON.parse(localStorage.getItem('teamIndividualProfile'));
    var applicantIdObj = JSON.parse(localStorage.getItem('currentApplicantId'));
    //---------------------------setting team data in to the html---------------------------------   
    teamTitle.innerHTML = teamProfileObj.teamTitle
    teamOrganizer.innerHTML = teamProfileObj.teamOrganizer
    teamLocation.innerHTML = teamProfileObj.teamLocation
    teamDesc.innerHTML = teamProfileObj.teamDesc
    teamEmail.innerHTML = teamProfileObj.teamEmail
    teamImg.src = teamProfileObj.teamImg
    teamCategory.innerHTML = teamProfileObj.teamCategory
    var teamRolesArr = JSON.parse(localStorage.getItem('teamIndividualRoles'));
    console.log(teamRolesArr)
    //--------------------------print all the roles if it is unavailable make it unclickable----------------------------------   
    for(i=0; i < teamRolesArr.length; i++){
        var rolesBut = document.createElement("button");
        rolesBut.id = "apply"+i;
        rolesBut.className = "applyrole";
        
        if(teamRolesArr[i][1] == "closed"){
           rolesBut.innerHTML = teamRolesArr[i][0]+" &#40;Unavailable&#41;";
           rolesBut.style.backgroundColor = "crimson";
           rolesBut.disabled = true;
           teamRoles.appendChild(rolesBut);
        }
        else{
           rolesBut.innerHTML = teamRolesArr[i][0]
           teamRoles.appendChild(rolesBut); 
        }
    }
    //--------------------------applying to the clicked roles----------------------------------   
    $(":button").click(function() {
        for(var z =0; z < teamRolesArr.length; z++){
            if($(this).attr("id") == "apply"+z){
                var appliedStatus = false;
                for(var i = 0; i < teamRolesArr.length; i++ ){
                    if(teamRolesArr[i][2] == applicantIdObj){
                        var appliedStatus = true;
                        $("#appStatus").html("You have been accepted as one of the roles.")
                    }
                }
                if(appliedStatus == false){
                    var applicationInfo = {
                        teamTitle : teamProfileObj.teamTitle,
                        roleName : teamRolesArr[z][0],
                        teamOrganizer : teamProfileObj.teamOrganizer,
                        teamEmail : teamProfileObj.teamEmail
                    }
                    localStorage.setItem("teamRoleMessage",JSON.stringify(applicationInfo));
                    window.location.href = "teamProfileApply.php";
                }
                }
            }
         }
    )
});