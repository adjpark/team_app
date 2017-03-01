$(document).ready(function() {
    var roleArr = [];
    var tempArr = window.teamsList;
    var teamListObj = JSON.stringify(tempArr);
    var teamListObj = JSON.parse(teamListObj);
    var tempArr2 = window.rolesList;
    var roleListObj = JSON.stringify(tempArr2);
    var roleListObj = JSON.parse(roleListObj);
    var applicantIdObj = JSON.parse(window.applicantId);
    //-----------------------identifying which team is clicked on homepage------------------------------------
    var teamOnclick = document.getElementsByClassName("teamList");
    for (var i = 0 ; i < teamOnclick.length; i++) {
    teamOnclick[i].addEventListener("click", function(){   
         for(var i =0; i < window.teamNumber; i++){
             if($(this).attr("id") == "item"+i){
                var teamProfileLocal = {
                    "teamTitle": teamListObj[i].title,
                    "teamOrganizer": teamListObj[i].organizer,
                    "teamLocation": teamListObj[i].location,
                    "teamDesc": teamListObj[i].description,
                    "teamEmail": teamListObj[i].email,
                    "teamImg": teamListObj[i].teamImg,
                    "teamCategory":teamListObj[i].teamCategory
                }  
                localStorage.setItem("teamIndividualProfile",JSON.stringify(teamProfileLocal));
                localStorage.setItem("currentApplicantId",JSON.stringify(applicantIdObj));
            }
        }
         for(var i =0; i < window.roleNumber; i++){ 
             if($(this).attr("id") == "item"+i){
                 for (z=0; z < window.roleNumber; z++){
                     if(teamListObj[i].teamId == roleListObj[z].teams_teamId){
                        var tempArr = [];
                        tempArr.push(roleListObj[z].roleName);
                        tempArr.push(roleListObj[z].availability);
                        tempArr.push(roleListObj[z].applied_user);
                        roleArr.push(tempArr);
                        localStorage.setItem("teamIndividualRoles",JSON.stringify(roleArr));
                     }
                 }
                 
            }
        }
        window.location.href = "teamProfile.php";
 });
}
});