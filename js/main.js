$(document).ready(function(){
    var select_file = false;
    $(".img-file").on('click',(function(e) {
        $("#file").trigger("click");
    }));
    $(".img-uploader input[type='button']").on('click',(function(e) {
        select_file = false;
        $(".img-gallery").show();
        $(".img-uploader").hide();
    }));
    $("#file").on("change", (function(e) {
        var file = this.files[0];
        var imagefile = file.type;
        var match= ["image/jpeg","image/png","image/jpg"];	
        if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))) {
            $('.toast .toast-body').text("Please select a valid image file. Only jpeg, jpg and png images type allowed.");
            $('.toast').toast({delay: 2000});
            $('.toast').toast('show');
            return false;
        } else {
            $(".img-gallery").hide();
            $(".img-uploader").show();
            var reader = new FileReader();	
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            select_file = true;
        }		
    }));
    function imageIsLoaded(e) {
        $('#previewing').attr('src', e.target.result);
    };
    
    $("#uploadimage").on('submit',(function(e) {
        e.preventDefault();
        var action_type = $(".ajax-action").val();
        if(action_type=="upload"){
            if(!select_file) {
                $('.toast .toast-body').text("Please select a image file.");
                $('.toast').toast({delay: 2000});
                $('.toast').toast('show');
                return;
            }
            if($(".img-url").val() == ""){
                $('.toast .toast-body').text("Please input image url.");
                $('.toast').toast({delay: 2000});
                $('.toast').toast('show');
                return;
            }
            if($(".img-desc").val() == ""){
                $('.toast .toast-body').text("Please input image description.");
                $('.toast').toast({delay: 2000});
                $('.toast').toast('show');
                return;
            }
            $('#loading').show();
        } 

        $.ajax({
            url: "ajax_php_file.php",   	// Url to which the request is send
            type: "POST",      				// Type of request to be send, called as method
            data:  new FormData(this), 		// Data sent to server, a set of key/value pairs representing form fields and values 
            contentType: false,       		// The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            cache: false,					// To unable request pages to be cached
            processData:false,  			// To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
            success: function(data)  		// A function to be called if request succeeds
            {
                //alert(data);
                if(data == 0) {
                    location.reload();	
                } else {
                    if(data == 1)
                        $('.toast .toast-body').text("Upload Error.");
                    else if(data == 2)
                        $('.toast .toast-body').text("Insert into Table Error.");
                    else if(data == 3)
                        $('.toast .toast-body').text("Invalid File Size or Type.");
                    else if(data == 4)
                        $('.toast .toast-body').text("Delete Error.");
                    else if(data == 5)
                        $('.toast .toast-body').text("Update Error.");
                    else if(data == 6)
                        $('.toast .toast-body').text("Error Happens.");
                    $('.toast').toast({delay: 2000});
                    $('.toast').toast('show');
                }
                $('#loading').hide();
            }	        
        });
        
    }));
    
    $(document).on("click", ".img-submit", function(){
        $(".ajax-action").val("upload");
        $("#uploadimage").submit();
    });

    $(document).on("click", ".img-delete", function(){
        $(".ajax-action").val("delete");
        $("#uploadimage").submit();
    });

    $(document).on("click", ".img-update", function(){
        $(".ajax-action").val("update");
        $("#uploadimage").submit();
    });

    $(document).on("click", ".gallery-item", function(){
        $(".gallery-item").removeClass('active');
        $(this).addClass('active');
        $(".side-bar .img-url").val($(this).data('url'));
        $(".side-bar .img-desc").val($(this).data('description'));
        $(".side-bar .active-img").val($(this).data('id'));
    });

    $(document).on("dblclick", ".gallery-item", function(){
        var url = $(this).data('url');
        window.open(url);
    });
});