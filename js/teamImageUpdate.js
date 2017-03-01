$( document ).ready(function() {
     //----------------------------update team profile image--------------------------------   
    window.teamImageLinkUpdate = "";
    var imgPath = $("#teamImg").attr("src");
    var imgName = imgPath.replace(/^.*[\\\/]/, '');
    var imgNoExt = imgName.substr(0, imgName.lastIndexOf('.')) || imgName;
    var uploader = new ss.SimpleUpload({
      button: 'upload', 
      url: 'teamImageUpdate.php', 
      name: imgNoExt, 
      allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
      maxSize: 2024, 
      onComplete: function(filename, response) {
          var newImg = response;
          $('#teamImg').attr('src', newImg + '?' + Math.random());
          window.teamImageLinkUpdate = response;
        
          $.ajax({
            url:"teamImageUpdateDB.php",
            type:"post",
            data:{
                teamId : JSON.stringify(window.currentTeamId),
                newImgLink : JSON.stringify(window.teamImageLinkUpdate)
            },
            dataType:"json",
            success:function(resp){
                console.log(resp);
            }
        })
          window.location.href = "manage.php";
        }
    });   
    
});