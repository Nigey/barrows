<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<footer id="main-footer">
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="et_pb_row_fullwidth">
						<?php							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="et_pb_row_fullwidth clearfix">
				<?php
					if ( false !== et_get_option( 'show_footer_social_icons', true ) ) {
						get_template_part( 'includes/social_icons', 'footer' );
					}

					echo et_get_footer_credits();
				?>
<script src="https://myaccount.fragra.co.uk/js/tracker.js" id="5b6c0e5095ca7"></script>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
	
<!-- 	<?php //if (is_page('contact-us')) { ?>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfFHeOm95nJqEbXftLeuOcNYh4JdMhMiY&callback=initMap" async defer></script>
	<?php// } ?> -->
<!--
<!-- WhatsHelp.io widget -->



<!-- /WhatsHelp.io widget --> 

   
	
	<script src="/wp-content/themes/barrows-theme/assets/js/map-scripts.js"></script>

	<script src="/wp-content/themes/barrows-theme/assets/js/materialize.min.js"></script>
	<script src="/wp-content/themes/barrows-theme/assets/js/wow.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
		function myMap() {
			var myLatlng = new google.maps.LatLng(52.487554,-1.907277);
			var image = 'http://barrows.youronlinepresence.uk/wp-content/uploads/2018/04/marker.png';
		    var mapOptions = {
		        center: myLatlng,
		        zoom: 17,
		    }
			var map = new google.maps.Map(document.getElementById("map"), mapOptions);
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: 'Barrows & Forrester',  
		        icon: image
			});
			marker.setMap(map);	
		}
		new WOW().init();
		jQuery(document).ready(function($) {
		    $('.log-in-toggle-popup, .popup_login_wrapper .close').on('click', function() {
		        $('.popup_login_wrapper').toggleClass('active');
		    });
		    $( "#draggable" ).draggable({containment: "#containment-wrapper"});
			$('.register-toggle-popup, .popup_register_wrapper .close ').on('click', function() {
		        $('.popup_register_wrapper').toggleClass('active');
		    });
			$('.password-toggle-popup, .popup_password_wrapper .close ').on('click', function() {
		        $('.popup_password_wrapper').toggleClass('active');
		    });
		    $('.toggle_duty').on('click', function(){
		        $('.stamp-calculator').toggleClass('active');
		    });
		});
	</script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgx_pudG317XqWjLkk96q2qgqTHP5Qeec&callback=myMap"></script>
</body>
</html>