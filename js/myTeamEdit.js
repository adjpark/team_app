$(document).ready(function() {
    var teamProfileObj = JSON.parse(localStorage.getItem('myTeamListSelect'));
    var teamTitle = document.getElementById("teamTitle");
    var teamOrganizer = document.getElementById("teamOrganizer");
    var teamLocation = document.getElementById("teamLocation");
    var teamDesc = document.getElementById("teamDesc");
    var teamEmail = document.getElementById("teamEmail");
    var teamImg = document.getElementById('teamImg');
    var teamUpdate = document.getElementById("teamUpdate");
    var teamDelete = document.getElementById("teamDelete");
    var displayDiv = document.getElementById("displayDiv");
    var teamRoles = document.getElementById("teamRoles");
    var submitRoles = document.getElementById("submitRoles");
    var rolesList = document.getElementById("rolesList");
    var categoryMusic = document.getElementById("categoryMusic");
    var categorySport = document.getElementById("categorySport");
    var categoryGame = document.getElementById("categoryGame");
    var categoryList = document.getElementById("categoryList");
    categoryList.innerHTML = teamProfileObj[0]["teamCategory"];
    teamOrganizer.innerHTML = teamProfileObj[0]["organizer"];
    teamLocation.innerHTML = teamProfileObj[0]["location"];
    teamEmail.innerHTML = teamProfileObj[0]["email"];
    window.currentTeamId = teamProfileObj[0]["teamId"];
    teamImg.src = teamProfileObj[0]["teamImg"];
    teamTitle.value = teamProfileObj[0]["title"];
    teamDesc.innerHTML = teamProfileObj[0]["description"];
    //--------------------------textarea auto resize---------------------------------
    var ta = document.querySelector('textarea');
    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;
        
        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });
    //------------------------------editing team category-----------------------------------
    $(".dropbtn").click(function dropDownFunc() {
        document.getElementById("myDropdown").classList.toggle("show");
    });
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
    categoryGame.onclick = function(){
        teamProfileObj[0]["teamCategory"] = "game";
        categoryList.innerHTML = "Game"
    };
    categoryMusic.onclick = function(){
        teamProfileObj[0]["teamCategory"] = "music";
        categoryList.innerHTML = "Music"
    };
    categorySport.onclick = function(){
        teamProfileObj[0]["teamCategory"] = "sport";
        categoryList.innerHTML = "Sport"
    };
    //-----------------------------updating existing roles------------------------------------
    var OldRolesArr = [];
    var OldRoleCounter = 0;
    for(var i = 0 ; i <  teamProfileObj[1].length; i++){
        OldRolesArr.push(teamProfileObj[1][i]);
        var teamButton2 = document.createElement("button");
        if(teamProfileObj[1][i]["availability"] == "closed"){
            teamButton2.style.backgroundColor = "crimson";
            teamButton2.style.color = "white";
        }
        teamButton2.innerHTML = teamProfileObj[1][i]["roleName"];
        teamButton2.className = "teamRolesStyle";
        teamButton2.dataset.teamRolesNum = OldRoleCounter;
        rolesList.appendChild(teamButton2);
        teamButton2.onclick = function(){
            OldRolesArr[this.dataset.teamRolesNum]["availability"] = "deleted";
            this.parentNode.removeChild(this);
        }
        OldRoleCounter++;
    }
    //--------------------------------adding new roles---------------------------------
    var NewRolesArr = [];
    var NewRoleCounter = 0;
    submitRoles.onclick = function(){
        if(teamRoles.value == ""){
            $("#roleError").html("<span class='help-block form-error'>Please fill out role input</span>");
        }
        else{
            $("#roleError").html("");
            var teamButton = document.createElement("button");
            teamButton.innerHTML = teamRoles.value;
            teamButton.className = "teamRolesStyle";
            teamButton.dataset.teamRolesNum = NewRoleCounter;
            rolesList.appendChild(teamButton)
            NewRolesArr.push(teamRoles.value);
            console.log(NewRolesArr)
            teamRoles.value = "";
            teamButton.onclick = function(){
                NewRolesArr[this.dataset.teamRolesNum] = "";
                console.log(NewRolesArr)
                this.parentNode.removeChild(this);
            }
            NewRoleCounter++;
        }
    }
    //---------------------------Runs add role button on enter click--------------------------------
    $('#teamRoles').keypress(function(e){
        if(e.which == 13){
            $('#submitRoles').click();
        }
    });
    //------------------------------submit the updated data to DB-----------------------------------
    teamUpdate.onclick = function(){
        var validationChecker = true;
        if ($( "#teamTitle" ).val().length < 4 || $( "#teamDesc" ).val().length < 4) {
            $("#TDerror").html("<span class='help-block form-error'>Please enter in title and description</span>");
            validationChecker = false;
        }else{
            $("#TDerror").html("");
        }
        var oldArrSame = true;
        for(var i=0; i < OldRolesArr.length ; i++){
            if(OldRolesArr[i]["availability"] != OldRolesArr[0]["availability"]){
                oldArrSame = false;
            }
        }
        var oldRolesChecker = true;
        if(oldArrSame == true){
            if(OldRolesArr[0]["availability"] == "deleted"){
                oldRolesChecker = false;
            }
        }
        var newRolesChecker = true;
        if(NewRolesArr.length == 0){
            newRolesChecker = false;
        }
        var newArrSame = true;
        for(var i = 0; i < NewRolesArr.length; i++){
            if(NewRolesArr[i] != NewRolesArr[0]){
                newArrSame = false;
            }
        }
        if(newArrSame == true){
            if(NewRolesArr[0] == ""){
                newRolesChecker = false;
            }
        }
        if(newRolesChecker == false && oldRolesChecker == false){
            validationChecker = false;
            $("#roleError").html("<span class='help-block form-error'>There must be a minimum of one role per team</span>");
        }else{
            $("#roleError").html("");
        }

        if(validationChecker == true){
            teamProfileObj[0]["title"] = teamTitle.value;
            teamProfileObj[0]["organizer"] = teamOrganizer.innerHTML;
            teamProfileObj[0]["location"] =  teamLocation.innerHTML;
            teamProfileObj[0]["description"] = teamDesc.value;
            teamProfileObj[0]["email"] = teamEmail.innerHTML;
            $.ajax({
                url:"myTeamEditAjax.php",
                type:"post",
                data:{
                    actionType : "update",
                    updatedTeam : teamProfileObj[0],
                    updatedRoles : OldRolesArr,
                    newRoles : NewRolesArr
                },
                dataType:"json",
                success:function(resp){
                    console.log(resp);
                }
            })
            window.location.reload();
            window.location.href = "manage.php";
        }
    }
    //-------------------------------deleting team from DB----------------------------------
    teamDelete.onclick = function(){
        $.ajax({
            url:"myTeamEditAjax.php",
            type:"post",
            data:{
                actionType : "delete",
                deletedTeam : teamProfileObj
            },
            dataType:"json",
            success:function(resp){
                console.log(resp);
            }
        })
        window.location.href = "manage.php";
    }
});