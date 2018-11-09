<?php
	if ( ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' ) && ! is_active_sidebar( 'sidebar-5' ) )
		return;
?>
<!-- <div class="footer-logo">
	<div class="footer-logo-wrapper">
		<img src="/wp-content/uploads/2017/11/logo.png">
	</div>
</div> -->
<div style="background-image: url('http://barrows.youronlinepresence.uk/wp-content/uploads/2017/11/book-valuation.jpg'); padding: 60px 15px!important;" class="book-valuation et_pb_row et_pb_row_8 et_pb_row_fullwidth">
	<div class="et_pb_column et_pb_column_4_4  et_pb_column_11">
		<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center book-valuation-text et_animated et_pb_text_3 slideTop" style="animation-duration: 1000ms; animation-delay: 200ms; opacity: 0; animation-timing-function: ease-in-out; transform: translate3d(0px, -40%, 0px); margin-bottom: 0 !important;">
			<div class="et_pb_text_inner">
				<h2 style="color: #ffffff;" class="big bold">Would you like a <span class="pink_bold">FREE</span> valuation today?</h2>
			</div>
		</div> <!-- .et_pb_text -->
		<div class="et_pb_code et_pb_module green-button et_animated et_pb_code_7 et_pb_text_align_center slideBottom" style="animation-duration: 1000ms; animation-delay: 200ms; opacity: 0; animation-timing-function: ease-in-out; transform: translate3d(0px, 40%, 0px); margin-bottom: 0 !important;">
			<div class="et_pb_code_inner">
				<div class="button-container round-effect green-btn">
					 <a class="button-cta button-effect" href="/free-property-valuation/">Book a valuation</a>
				</div>
			</div> <!-- .et_pb_code_inner -->
		</div> <!-- .et_pb_code -->
	</div> <!-- .et_pb_column -->
</div>
<div class="et_pb_row et_pb_row_4 et_pb_equal_columns et_pb_gutters4 et_pb_row_fullwidth">
	<div id="footer-widgets" class="clearfix">
	<?php
		$footer_sidebars = array( 'sidebar-2', 'sidebar-3', 'sidebar-4', 'sidebar-5' );

		foreach ( $footer_sidebars as $key => $footer_sidebar ) :
			if ( is_active_sidebar( $footer_sidebar ) ) :
				echo '<div class="footer-widget' . ( 3 === $key ? ' last' : '' ) . '">';
				dynamic_sidebar( $footer_sidebar );
				echo '</div> <!-- end .footer-widget -->';
			endif;
		endforeach;
	?>
	</div> <!-- #footer-widgets -->
</div>	<!-- .container -->