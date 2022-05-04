$('#login').click(function(){
    var identity = $('#identity').val();
        var password = $('#password').val();


        if(identity == ""){
            document.getElementById('emsg').innerHTML = ('Please Enter Your Username');
        }

        
        else if(password == ""){
            document.getElementById('pmsg').innerHTML = ('Please Enter Your Password');
        } else {
            document.getElementById('emsg').innerHTML = ('');
            document.getElementById('pmsg').innerHTML = ('');
        var dataString = 'identity='+ identity + '&password='+ password;

            $.ajax({
                type: "post",
                url: base_url+"login",
                data: dataString,

              success:function(response){
              var result = JSON.parse(response);

              if(result.status === 'success'){
                    if(result.user === 'professional'){
                        document.getElementById('pmsg').innerHTML = (result.message);
                        $("#pmsg").css("color", "#4CAF50!important");
                        window.location.href=base_url+"professional-dashboard";

                    } else if(result.user === 'member') {
                        document.getElementById('pmsg').innerHTML = (result.message);
                        $("#pmsg").css("color", "#4CAF50!important");
                        window.location.href=base_url;

                    } else if(result.user === 'admin') {
                        document.getElementById('pmsg').innerHTML = (result.message);
                        $("#pmsg").css("color", "#4CAF50!important");
                        window.location.href=base_url+"admin/auth";
                    } else {
                        document.getElementById('pmsg').innerHTML = ('You are a unknown user please create another account.');
                    }   
              } else {
                
                document.getElementById('pmsg').innerHTML = (result.message);
                $("#pmsg").css("color", "#de4437!important");

              }
              
              //location.reload();
             
            }
        }); 
    }
});


/*prevent form submit onclick*/
$('#formid').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});



/*type a head for cities*/
/* $(document).ready(function(){
     $('input.location').typeahead({
         name: 'location',
         remote:base_url+'Home/get_cities?key=%QUERY',
         limit : 10
     });
 });

 

 $(document).ready(function(){
     $('input.service').typeahead({
         name: 'service',
         remote:base_url+'Home/get_services?key=%QUERY',
         limit : 10
     });
 });
*/

 /*select 2*/
 $(document).ready(function() { 
   $(".select2").select2(); 
  

  $(".select2").select2({
       allowClear: true,
       placeholder: 'What service are you looking for?',

   });
});



 /*default Image*/

    function make_default1(arg){
        var data_string = 'image_id='+arg;
            $.ajax({
            type: "POST",
            data: data_string,
            url: base_url + 'professional/Profile/default_image',
            success: function (data) {
                var result = JSON.parse(data);

                if (result.status === "failed") {
                    $("#adult_total_price").text('');

                } else {
                    var data = '';
                    data = result.price;
                    $("#adult_total_price").text("Adults: " + data);
                }
            }
        });
    }



    var response = {
        success: showresp
    }
    //alert(response);
    function showresp(responseText, statusText, xhr, form) {
        console.log(responseText) 
        data = $.parseJSON(responseText);
        if (data.status === 'success') {
             
           swal("Good job!", data.message, "success");
           $(form).find('button[type="submit"]').removeAttr('disabled');
           $(form)[0].reset();

        } else if(data.status === 'destination') {
                swal({
                    title:'Info!',
                    text: data.message,
                    type:'info'
                });
                $('.swal-button').click(function(){
                    window.location.href = base_url+data.destination;
                });

        } else {
            swal("Oops!", data.message, "warning");
           $(form).find('button[type="submit"]').removeAttr('disabled');
        }
    }

   $(document).on('submit', '.ajax-form', function () {

    $(this).find('button[type="submit"]').attr('disabled', 'disabled');
    $(this).ajaxSubmit(response);
    return false;
});



/*graphp by niharika */
 $(document).ready(function(){
         $(".dropdown-toggle").dropdown();
         });
         
         

    // Gallery image hover
         $( ".img-wrapper" ).hover(
             function() {
              $(this).find(".img-overlay").animate({opacity: 1}, 600);
             }, function() {
              $(this).find(".img-overlay").animate({opacity: 0}, 600);
             }
         );
         
         // Lightbox
         var $overlay = $('<div id="overlay"></div>');
         var $image = $("<img>");
         var $prevButton = $('<div id="prevButton"><i class="fa fa-chevron-left"></i></div>');
         var $nextButton = $('<div id="nextButton"><i class="fa fa-chevron-right"></i></div>');
         var $exitButton = $('<div id="exitButton"><i class="fa fa-times"></i></div>');
         
         // Add overlay
         $overlay.append($image).prepend($prevButton).append($nextButton).append($exitButton);
         $("#gallery").append($overlay);
         
         // Hide overlay on default
         $overlay.hide();
         
         // When an image is clicked
         $(".img-overlay").click(function(event) {
         // Prevents default behavior
         event.preventDefault();
         // Adds href attribute to variable
         var imageLocation = $(this).prev().attr("href");
         // Add the image src to $image
         $image.attr("src", imageLocation);
         // Fade in the overlay
         $overlay.fadeIn("slow");
         });
         
         // When the overlay is clicked
         $overlay.click(function() {
         // Fade out the overlay
         $(this).fadeOut("slow");
         });
         
         // When next button is clicked
         $nextButton.click(function(event) {
         // Hide the current image
         $("#overlay img").hide();
         // Overlay image location
         var $currentImgSrc = $("#overlay img").attr("src");
         // Image with matching location of the overlay image
         var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
         // Finds the next image
         var $nextImg = $($currentImg.closest(".image").next().find("img"));
         // All of the images in the gallery
         var $images = $("#image-gallery img");
         // If there is a next image
         if ($nextImg.length > 0) { 
          // Fade in the next image
          $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
         } else {
          // Otherwise fade in the first image
          $("#overlay img").attr("src", $($images[0]).attr("src")).fadeIn(800);
         }
         // Prevents overlay from being hidden
         event.stopPropagation();
         });
         
         // When previous button is clicked
         $prevButton.click(function(event) {
         // Hide the current image
         $("#overlay img").hide();
         // Overlay image location
         var $currentImgSrc = $("#overlay img").attr("src");
         // Image with matching location of the overlay image
         var $currentImg = $('#image-gallery img[src="' + $currentImgSrc + '"]');
         // Finds the next image
         var $nextImg = $($currentImg.closest(".image").prev().find("img"));
         // Fade in the next image
         $("#overlay img").attr("src", $nextImg.attr("src")).fadeIn(800);
         // Prevents overlay from being hidden
         event.stopPropagation();
         });
         
         // When the exit button is clicked
         $exitButton.click(function() {
         // Fade out the overlay
         $("#overlay").fadeOut("slow");
         });
         
        
/*professional  request accept modal*/

function showModal(arg1,arg2) {

    $('#myModal').modal();

    data = '<input type="hidden" name="receiver_id" id="receiver_id" value="'+arg1+'"><input type="hidden" name="response_for_proposal_id" id="response_for_proposal_id" value="'+arg2+'">'
    
    $("#element").html(data);
  
  }



  /*image validation*/

function Validate(oForm) {
   $('#send').attr('disabled', 'disabled');
    var media_file = $('#media_file').files[0].name;
        if(media_file){
            document.getElementById('loading').innerHTML = ('<img src="'+base_url+'assets/loader.gif" alt="Loader"><br> Uploading...'); 
            return true;
        }
}


/*file siza validation*/
    function ValidateSize(file) {
        var FileSize = file.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 30) {
            swal("Sorry", "Sorry, Upload file should not be greater then 30 MB");
           // $(file).val(''); //for clearing with Jquery
           
           //document.getElementById('media_file').innerHTML = ('');
           document.getElementById("media_file").value = "";
           return false;

        } else {

            return true;
        }
    }

  