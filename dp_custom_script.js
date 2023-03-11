let ajax_url = dp_ajax_object.ajax_url;

function IsEmail(email) {
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (!regex.test(email)) {
		return false;
	} else {
		return true;
	}

}


/*==== Profile contact code =======*/   

   jQuery(document).on('click', '#dp_contact_form', function () { 

		var dp_name = document.getElementById('dp_name').value;
		var dp_email = document.getElementById('dp_email').value;
		var dp_message = document.getElementById('dp_message').value; 
		var dp_owner = document.getElementById('dp_owner').value; 
		
		console.log('dp_name');   
		console.log('dp_email');
		console.log('dp_owner');
		if (dp_name =='' || dp_email =='' || dp_message =='' ) {

			jQuery('#con_error_message').text('All above Fields are Required');

		}else {  
			jQuery.ajax({
				url: ajax_url,
				type: "POST",
        //dataType: "json",
				cache: false,
				data: {
					'action':'vendor_personal_email', 
					'dp_name' : dp_name,
					'dp_email' : dp_email,
					'dp_message' : dp_message,
					'dp_owner' : dp_owner
				},
				success:function(data) {
					
					if(data=='Message sent successfully'){
						console.log(data);
                //jQuery('#dp_name').val('');
                //jQuery('#dp_email').val('');
                //jQuery('#dp_message').val('');
						jQuery('#bs_error_message').text(data);
						jQuery("form").trigger("reset");
					}else{
						jQuery('#bs_error_message').text(data);
						jQuery("form").trigger("reset");
					}
				},
				error: function(errorThrown){
					console.log(errorThrown);
				}
				
			});
		}    

	});



/*==== Survey Contact form =======*/   



   jQuery(document).on('click', '#sv_form', function () { 
    var timeliness = jQuery('input[name="timeliness"]:checked').val();
    console.log(timeliness);
    
    var courtesy = jQuery('input[name="courtesy"]:checked').val();
    console.log(courtesy);
    
    var quality = jQuery('input[name="quality"]:checked').val();
    console.log(quality);
    
	var sv_name = document.getElementById('sv_name').value;
	var sv_email = document.getElementById('sv_email').value; 
	var sv_message = document.getElementById('sv_message').value; 
	var sv_storename = document.getElementById('sv_storename').value; 
	var sv_vendor = document.getElementById('sv_vendor').value; 
	
	
	console.log(sv_vendor);
	
    if (timeliness == '' || courtesy == '' || quality == '' || sv_name =='' || sv_email =='' || sv_message =='' || sv_storename =='' ) {

	jQuery('#valida_error_message').text('All above Fields are Required');

	}else {  
        
	jQuery.ajax({
		url: ajax_url,
		type: "POST",
        //dataType: "JSON",
       // cache: false,
		data: {
            'action':'vendor_survey_form', 
            'timeliness' : timeliness,
            'courtesy' : courtesy,
            'quality' : quality,
            'sv_name' : sv_name,
            'sv_email' : sv_email,
            'sv_message' : sv_message,
            'sv_vendor' : sv_vendor,
            'sv_storename' :sv_storename
        },
        success:function(data) {
            if(data=='Message sent successfully'){
              
               jQuery('#survey_success_message').text(data);
              // document.getElementById("survey").reset();
               jQuery("form").trigger("reset");
            
            }else{
                jQuery('#survey_error_message').text(data);
                jQuery("form").trigger("reset");
            }
        // This outputs the result of the ajax request (The Callback)
        console.log(data);
        },
        error: function(errorThrown){
        	console.log(errorThrown);
        }

    });
  }    

});