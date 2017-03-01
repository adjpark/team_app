$(document).ready(function(){
    var categoryMusic = document.getElementById("categoryMusic");
    var categorySport = document.getElementById("categorySport");
    var categoryGame = document.getElementById("categoryGame");
    var contentTeamList = document.getElementById("contentTeamList");
    var searchInput = document.getElementById("searchInput");
    var searchSubmit = document.getElementById("searchSubmit");
    var searchError = document.getElementById("searchError");
    var roleArr = [];
    //----------------------selecting category---------------------------
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
        console.log(window.teamsList)
        console.log(window.rolesList)
    //------------------ search with selected category -------------------------------
        categoryMusic.onclick = function(){
            console.log("music is clicked")
            contentTeamList.innerHTML = "";
            searchError.innerHTML = ""
            for(var i = 0 ;  i < window.teamNumber;i++){
                if(window.teamsList[i]["teamCategory"] == "music"){
                    console.log("list exists")
                    $("#contentTeamList").append("<div style='background-image: url("+window.teamsList[i]['teamImg']+"); background-size: cover;' class='teamList' id='item"+i+"'><span class='titles'>"+window.teamsList[i]['title']+"</span></div>")
                }
            }
        };
        categorySport.onclick = function(){
            console.log("sport is clicked")
            contentTeamList.innerHTML = "";
            searchError.innerHTML = ""
            for(var i = 0 ;  i < window.teamNumber;i++){
                if(window.teamsList[i]["teamCategory"] == "sport"){
                    console.log("list exists")
                    $("#contentTeamList").append("<div style='background-image: url("+window.teamsList[i]['teamImg']+"); background-size: cover;' class='teamList' id='item"+i+"'><span class='titles'>"+window.teamsList[i]['title']+"</span></div>")
                }
            }
        };
        categoryGame.onclick = function(){
            console.log("game is clicked")
            contentTeamList.innerHTML = "";
            searchError.innerHTML = ""
            for(var i = 0 ;  i < window.teamNumber;i++){
                if(window.teamsList[i]["teamCategory"] == "game"){
                    console.log("list exists")
                    $("#contentTeamList").append("<div style='background-image: url("+window.teamsList[i]['teamImg']+"); background-size: cover;' class='teamList' id='item"+i+"'><span class='titles'>"+window.teamsList[i]['title']+"</span></div>")
                }
            }
        };
         //-------------------------------searching by team title-----------------------------   
        searchSubmit.onclick = function(){
            searchError.innerHTML = ""
            contentTeamList.innerHTML = "";
            if(searchInput.value == " " || searchInput.value == ""){
                contentTeamList.innerHTML = "";
                searchError.innerHTML = "Enter a title please."
            }
            else{
                var searchList = [];
                for(var i = 0 ;  i < window.teamNumber;i++){
                    searchList.push(window.teamsList[i]['title']);
                }
                console.log(searchList)
                var search_term = searchInput.value;
                var search = search_term.toUpperCase();
                var result = jQuery.grep(searchList, function(value) {
                    return value.toUpperCase().indexOf(search) >= 0;
                });
                console.log(result)
                if(typeof result == 'undefined' || result.length <= 0){
                    contentTeamList.innerHTML = "";
                    searchError.innerHTML = "Cannot find a team with that title."
                }
                else{
                    for(var a = 0 ;  a < result.length;a++){
                        for(var b = 0 ;  b < window.teamNumber;b++){ 
                            if(result[a] == window.teamsList[b]["title"]){
                                console.log(result[a])
                                $("#contentTeamList").append("<div style='background-image: url("+window.teamsList[b]['teamImg']+"); background-size: cover;' class='teamList' id='item"+b+"'><span class='titles'>"+window.teamsList[b]['title']+"</span></div>")
                            }
                        }
                    }
                    $('[id]').each(function (i) {
                        $('[id="' + this.id + '"]').slice(1).remove();
                    });
                }
            }
        }
    //----------------------------clicking the team searched team--------------------------------   
    var applicantIdObj = JSON.parse(window.applicantId);
    $(document).on('click', '.teamList', function(){
            for(var i =0; i < window.teamNumber; i++){
             if($(this).attr("id") == "item"+i){
                var teamProfileLocal = {
                    "teamTitle": window.teamsList[i].title,
                    "teamOrganizer": window.teamsList[i].organizer,
                    "teamLocation": window.teamsList[i].location,
                    "teamDesc": window.teamsList[i].description,
                    "teamEmail": window.teamsList[i].email,
                    "teamImg": window.teamsList[i].teamImg,
                    "teamCategory":window.teamsList[i].teamCategory
                }  
                localStorage.setItem("teamIndividualProfile",JSON.stringify(teamProfileLocal));
                localStorage.setItem("currentApplicantId",JSON.stringify(applicantIdObj));
            }
        }
         for(var i =0; i < window.roleNumber; i++){
             if($(this).attr("id") == "item"+i){
                 for (z=0; z < window.roleNumber; z++){
                     if(window.teamsList[i].teamId == window.rolesList[z].teams_teamId){
                         var tempArr = [];
                         tempArr.push(window.rolesList[z].roleName);
                         tempArr.push(window.rolesList[z].availability);
                         tempArr.push(window.rolesList[z].applied_user);
                         roleArr.push(tempArr);
                         localStorage.setItem("teamIndividualRoles",JSON.stringify(roleArr));
                     }
                 }
                 
            }
        }
        window.location.href = "teamProfile.php";
 });
});