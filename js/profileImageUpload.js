$( document ).ready(function() {
    //----------------------------upload new profile image-------------------------------------
    var uploader = new ss.SimpleUpload({
      button: 'upload', 
      url: 'profileImageUpload.php', 
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
          $('#profileImg').attr('src', newImg + '?' + Math.random());
        }
    });   
});