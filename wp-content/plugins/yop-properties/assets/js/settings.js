jQuery(document).ready(function($) {

	// function outputUpdate(vol) {
	// 	console.log('hello')
	// 	// $('#stars').val(vol);
	// }

    software = $("#software_select").find("option:selected").attr('value');
    $("."+software).text("active");
    
	$('#software_select').change(function(){
        software = $(this).find("option:selected").attr('value');
        $(".software").removeClass("active");
        $("."+software).addClass("active");
    });

    $('#property-postcode').change(function() {
    	var postcode = $('#property-postcode').val();
        console.log(postcode);
	    $.get('http://api.postcodes.io/postcodes/'+postcode, function(data) {
	        // $("#data").text(data);
	        console.log(data['result']['latitude']);
	        console.log(data['result']['longitude']);
	        $('#property-latitude').val(data['result']['latitude']);
			$('#property-longitude').val(data['result']['longitude']);
	    });
	});
	$('#branch-postcode').change(function() {
    	var postcode = $('#branch-postcode').val();
        console.log(postcode);
	    $.get('http://api.postcodes.io/postcodes/'+postcode, function(data) {
	        // $("#data").text(data);
	        console.log(data['result']['latitude']);
	        console.log(data['result']['longitude']);
	        $('#branch-latitude').val(data['result']['latitude']);
			$('#branch-longitude').val(data['result']['longitude']);
	    });
	});

		// $('.item input').change(function(){
		// 	if( $(this).val().length < 6 ) {
		//         $('#primary-in').css({
		//         	'border-color': $(this).val()
		//         })
		//     }
		// });

	$('.color_click').click(function(){
		$data_this = $(this).attr('data-theme');
		click_if_colors($data_this);
		$('.updated-note').fadeIn(200).delay(1000).fadeOut(500);
	});

	function click_if_colors($is_theme){
		if ($is_theme == "craig_james") {
			$('#primary-in').val('#C2B59D');
			$('#secondary-in').val('#000000');
			$('#opacity').val('0.75');
		} else if ($is_theme == "mason_lee") {
			$('#primary-in').val('#C3B49D');
			$('#secondary-in').val('#484848');
			$('#opacity').val('1');
		} else if ($is_theme == "hunter") {
			$('#primary-in').val('#6D767B');
			$('#secondary-in').val('#2E3837');
			$('#opacity').val('1');
		} else if ($is_theme == "kennedy") {
			$('#primary-in').val('#354962');
			$('#secondary-in').val('#A26755');
			$('#opacity').val('1');
		} else if ($is_theme == "roberts") {
			$('#primary-in').val('#a3ad6e');
			$('#secondary-in').val('#CBB9A3');
			$('#opacity').val('1');
		} else if ($is_theme == "alexander") {
			$('#primary-in').val('#922C3A');
			$('#secondary-in').val('#000000');
			$('#opacity').val('1');
		} else {
			$('#primary-in').val('#565656');
			$('#secondary-in').val('#565656');
			$('#opacity').val('1');
		}
	};

	$('.map_style_click').click(function(){
		$data_this = $(this).attr('data-theme');
		click_if_style($data_this);
		$('.updated-note2').fadeIn(200).delay(1000).fadeOut(500);
	});

	function click_if_style($is_theme){
		if ($is_theme == "craig_james") {
			$('#map_style').val(
				'[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"administrative.country","elementType":"geometry","stylers":[{"visibility":"on"},{"hue":"#ff0000"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#ded4cb"},{"lightness":"57"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#dec6b9"},{"saturation":"-36"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#ede6e1"},{"lightness":"75"}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"visibility":"off"},{"color":"#ede6e1"},{"lightness":"62"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"on"},{"hue":"#ff0000"},{"saturation":"-100"},{"lightness":"1"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#d2cece"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#3f3938"},{"visibility":"on"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"}]}]'
				);
		} else if ($is_theme == "mason_lee") {
			$('#map_style').val(
				'[{"featureType":"administrative.country","elementType":"geometry","stylers":[{"visibility":"simplified"},{"hue":"#ff0000"}]}]'
				);
		} else if ($is_theme == "hunter") {
			$('#map_style').val(
				'[{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]'
				);
		} else if ($is_theme == "kennedy") {
			$('#map_style').val(
				'[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]}]'
				);
		} else if ($is_theme == "roberts") {
			$('#map_style').val(
				'[{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]'
				);
		} else if ($is_theme == "alexander") {
			$('#map_style').val(
				'[{"stylers":[{"hue":"#dd0d0d"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]}]'
				);
		} else {
			$('#map_style').val('#[{"featureType":"administrative.country","elementType":"geometry","stylers":[{"visibility":"simplified"},{"hue":"#ff0000"}]}]');
		}
	};

	$('.map_pin_click').click(function(){
		$data_this = $(this).attr('data-theme');
		click_if_pin($data_this);
		$('.updated-note2').fadeIn(200).delay(1000).fadeOut(500);
	})


	function click_if_pin($is_theme){
		if ($is_theme == "craig_james") {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/craig_james_marker.png'
				);
		} else if ($is_theme == "mason_lee") {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/mason_lee_marker.png'
				);
		} else if ($is_theme == "hunter") {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/hunter_marker.png'
				);
		} else if ($is_theme == "kennedy") {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/kennedy_marker.png'
				);
		} else if ($is_theme == "roberts") {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/roberts_marker.png'
				);
		} else if ($is_theme == "alexander") {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/alexander_marker.png'
				);
		} else {
			$('#map_pin').val(
				'/wp-content/themes/YOP%20Properties/assets/img/craig_james_marker.png'
			);
		}
	};

	$('.sumbit-button-popup').on("click", function() {
		$('.popup-background').fadeIn(500);
	});
	$('.submit-cancel, .popup-background').on("click", function() {
		$('.popup-background').fadeOut(500);
	});

});