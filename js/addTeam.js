$(document).ready(function(){
    var teamTitle = document.getElementById("teamTitle");
    var teamOrganizer = document.getElementById("teamOrganizer");
    var teamLocation = document.getElementById("teamLocation");
    var teamDesc = document.getElementById("teamDesc");
    var teamEmail = document.getElementById("teamEmail");
    var teamSubmit = document.getElementById("teamSubmit");
    var teamRoles = document.getElementById("teamRoles");
    var rolesList = document.getElementById("rolesList");
    var rolesArr = [];
    var ta = document.querySelector('textarea');
    //-------------------------Auto resize text area function----------------------------------
    jQuery.each(jQuery('textarea[data-autoresize]'), function(){
        var offset = this.offsetHeight - this.clientHeight;
        var resizeTextarea = function(el){
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input',function(){resizeTextarea(this); }).removeAttr('data-autoresize');
    });
    //---------------------------Add roles to array--------------------------------
    var rolecounter = 0;
    $('#submitRoles').click(function(){
        if(teamRoles.value == ""){
            $("#roleError").html("<span class='help-block form-error'>Please fill out role input</span>");
        }
        else{
            $("#roleError").html("");
            var teamButton = document.createElement("button");
            teamButton.innerHTML = teamRoles.value;
            teamButton.className = "teamRolesStyle";
            teamButton.dataset.teamRolesNum = rolecounter;
            rolesList.appendChild(teamButton)
            rolesArr.push(teamRoles.value);
            console.log(rolesArr)
            teamRoles.value = "";

            teamButton.onclick = function(){
                rolesArr[this.dataset.teamRolesNum] = "";
                console.log(rolesArr)
                this.parentNode.removeChild(this);
            }
            rolecounter++;
        }
    });
    //---------------------------Runs add role button on enter click--------------------------------
    $('#teamRoles').keypress(function(e){
        if(e.which == 13){
            $('#submitRoles').click();
        }
    });
    //----------------------------Select category function-------------------------------
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
    var categoryMusic = document.getElementById("categoryMusic");
    var categorySport = document.getElementById("categorySport");
    var categoryGame = document.getElementById("categoryGame");
    var categoryList = document.getElementById("categoryList");
    var teamCategory = "";
    categoryGame.onclick = function(){
        teamCategory = "game";
        categoryList.innerHTML = "Game"
        $("#categoryError").html("");
    };
    categoryMusic.onclick = function(){
        teamCategory = "music";
        categoryList.innerHTML = "Music"
        $("#categoryError").html("");
    };
    categorySport.onclick = function(){
        teamCategory = "sport";
        categoryList.innerHTML = "Sport"
        $("#categoryError").html("");
    };
    //--------------------------AJAX call for DB upload---------------------------------
    teamSubmit.onclick = function(){
         var validationChecker = true;
            if ($( "#teamTitle" ).val().length < 4 || $( "#teamDesc" ).val().length < 4) {
                $("#TDerror").html("<span class='help-block form-error'>Please enter in title and description</span>");
                validationChecker = false;
            }else{
                $("#TDerror").html("");
            }
            if($("#categoryList").html() == ""){
                $("#categoryError").html("<span class='help-block form-error'>Please select a category</span>");
                validationChecker = false;
            }
            var rolesChecker = true;
            if(rolesArr.length == 0){
                rolesChecker = false;
            }
            var arrSame = true;
            for(var i = 0; i < rolesArr.length; i++){
                if(rolesArr[i] != rolesArr[0]){
                    arrSame = false;
                }
            }
            if(arrSame == true){
                if(rolesArr[0] == ""){
                    rolesChecker = false;
                }
            }
            if(rolesChecker == false){
                validationChecker = false;
                $("#roleError").html("<span class='help-block form-error'>There must be a minimum of one role per team</span>");
            }else{
                $("#roleError").html("");
            }
            if(validationChecker == true){
                rolesArr = rolesArr.filter(Boolean)
                if(window.teamImageLink == ""){
                    window.teamImageLink = "./img/defaultteam.png"
                }
                $.ajax({
                url:"teamUpload.php",
                type:"post",
                data:{
                    teamTitle : teamTitle.value,
                    teamOrganizer : teamOrganizer.innerHTML,
                    teamLocation : teamLocation.innerHTML,
                    teamDesc : teamDesc.value,
                    teamEmail : teamEmail.innerHTML,
                    teamImg : JSON.stringify(window.teamImageLink),
                    teamCategory : teamCategory,
                    teamRoles : rolesArr
                },
                dataType:"json",
                success:function(resp){
                    console.log(resp);
                }
            })
               window.location.href = "home.php";
        }
    };
});