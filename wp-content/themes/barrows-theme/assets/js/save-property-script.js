jQuery(document).ready(function ($) {
	// Perform AJAX login/register on form submit
	  $('.save_property').on('click', function (e) {
	  	var button = $(this);

	      action = 'saved_property';
	      $userid = $(this).parent().find('.user_id').text();
	      $propid = $(this).parent().find('.property-id').text();
	      $name = $(this).parent().find('.property-name').text();
	      $price = $(this).parent().find('.property-price').text();
	      $photo = $(this).parent().find('.property-img').text();
	      ctrl = $(this);

	      // $("#save-button"+propid).html('<button class="btn waves-effect blue save-button save_property" disabled><i class="fa fa-spinner fa-spin"></i></button>').fadeIn();

	       //console.log(propertyid);

	      $.ajax({
			action: action,
	          type: 'POST',
	          dataType: 'text',
	          url: saved_property_object.ajaxurl,
	          data: {
	              // 'propid': propid,
	              'name': $name,
	              'price': $price,
	              'photo': $photo,
	              'propid': $propid,
	              'userid': $userid,
	          },
	          success: function (data) {

				console.log('successfully posted');
				console.log($propid);
				console.log($name);
				console.log($price);
				console.log($photo);

	              //console.log(data);

	              	// if (data == 0) {
	              		
	              	// 	/* Property has been saved */
	              	// 	$("#save-button"+propid).html('<button class="btn waves-effect blue save-button save_property" disabled>SAVED</button>').fadeIn();

	              	// }else if (data > 0) {
	              	// 	message = "SAVED ALREADY";
	              	// 	alert('already saved');
	              	// }

					// if ( $( button ).is( ".button" ) ) {
					//     $( button ).removeClass("save_property").html('<span>'+message+'</span>');
					// }else if ($( button ).is( ".tab_property_save" )) {
					//     $( button ).removeClass("save_property").html('<span>'+message+'</span>');
					// }else{
			  //           $(button).removeClass(".save_property");
			  //           $(button).next().addClass('active');
					// }

                  // document.location.href = saved_property_object.redirecturl;
	          }, 
	          error: function(jqXHR, textStatus, errorThrown) {
	          	$("#save-button"+propid).html('<a class="btn waves-effect blue save_property">Save</a>').fadeIn();
                        console.log('Error: ' + textStatus + ' ' + errorThrown);
                  } 
	      });
	      e.preventDefault();
	  });

	  // Perform AJAX login/register on form submit
	  $('.delete_saved_property').on('click', function (e) {
	      action = 'delete_saved_property';
	      post_id =  $(this).attr('id');
	      $.ajax({
	          type: 'POST',
	          dataType: 'json',
	          url: saved_property_object.ajaxurl,
	          data: {
	              'action': action,
	              'post_id': post_id,
	          },
	          success: function (data) {
	              console.log(data);
                  document.location.href = saved_property_object.redirecturl;
	          }
	      });
	      e.preventDefault();
	  });
});