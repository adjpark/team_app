$( document ).ready(function() {
     //---------------------------upload team image---------------------------------   
    window.teamImageLink = "";
    var uploader = new ss.SimpleUpload({
      button: 'upload', 
      url: 'teamImageUpload.php', 
      name: 'uploadfile', 
      allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
      maxSize: 2024,
      onSubmit: function(filename, extension) {
          console.log(filename);
          console.log(extension)
          if(!filename){
              console.log("File doesnt exist.")
          }
      },      
      onComplete: function(filename, response) {
          var newImg = response;
          $('#teamImg').attr('src', newImg + '?' + Math.random());
          window.teamImageLink = response;
        }
    });   
    
});