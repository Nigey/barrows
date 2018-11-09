<?php
add_action( 'admin_menu', 'yop_properties_add_admin_menu' );
add_action( 'admin_init', 'yop_properties_settings_init' );


function yop_properties_add_admin_menu(  ) { 

	add_menu_page( 'YOP Properties', 'YOP Properties', 'manage_options', 'yop_properties', 'yop_properties_options_page' );

}


function yop_properties_settings_init(  ) { 

	register_setting( 'pluginPage', 'yop_properties_settings' );

	add_settings_section(
		'yop_properties_pluginPage_section', 
		__( 'Your section description', 'wordpress' ), 
		'yop_properties_settings_section_callback', 
		'pluginPage'
	);
	// Theme Selector
	add_settings_field( 
		'yop_properties_select_field_1', 
		__( 'Theme Selecter description', 'wordpress' ), 
		'yop_properties_select_field_1_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// API Options
	add_settings_field( 
		'yop_properties_select_field_0', 
		__( 'API Options', 'wordpress' ), 
		'yop_properties_select_field_0_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// API keys
	add_settings_field( 
		'yop_properties_text_field_1', 
		__( 'API Key Info', 'wordpress' ), 
		'yop_properties_text_field_1_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// colours
	add_settings_field( 
		'yop_properties_text_field_0', 
		__( 'Colours description', 'wordpress' ), 
		'yop_properties_text_field_0_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Contact Form (Pop Up)
	add_settings_field( 
		'yop_properties_text_field_2', 
		__( 'Contact Form Shortcode Popup & Register Interest', 'wordpress' ), 
		'yop_properties_text_field_2_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Contact Form (Single Prop Page)
	add_settings_field( 
		'yop_properties_text_field_3', 
		__( 'Contact Form Shortcode (For Single Prop Page)', 'wordpress' ), 
		'yop_properties_text_field_3_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Contact Details
	add_settings_field( 
		'yop_properties_text_field_4', 
		__( 'Contact Details', 'wordpress' ), 
		'yop_properties_text_field_4_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Locations Details
	add_settings_field( 
		'yop_properties_text_field_5', 
		__( 'Locations Details', 'wordpress' ), 
		'yop_properties_text_field_5_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Saved Properties + My Profile Active?
	add_settings_field( 
		'yop_properties_radio_field_1', 
		__( 'Saved Properties + My Profile Active?', 'wordpress' ), 
		'yop_properties_radio_field_1_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Footer Link Active?
	add_settings_field( 
		'yop_properties_radio_field_2', 
		__( 'Footer Link Active?', 'wordpress' ), 
		'yop_properties_radio_field_2_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Room Active on Description?
	add_settings_field( 
		'yop_properties_radio_field_3', 
		__( 'Room Active on Description?', 'wordpress' ), 
		'yop_properties_radio_field_3_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Social Media Links
	add_settings_field( 
		'yop_properties_text_field_6', 
		__( 'Social Media Links', 'wordpress' ), 
		'yop_properties_text_field_6_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Burger Menu
	add_settings_field( 
		'yop_properties_radio_field_0', 
		__( 'Burger Field', 'wordpress' ), 
		'yop_properties_radio_field_0_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Hunter Loading Screen Image
	add_settings_field( 
		'yop_properties_text_field_7', 
		__( 'Hunter Loading Screen Image', 'wordpress' ), 
		'yop_properties_text_field_7_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Kennedy Residential Homepage Logo
	add_settings_field( 
		'yop_properties_text_field_8', 
		__( 'Kennedy Residential Homepage Logo', 'wordpress' ), 
		'yop_properties_text_field_8_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Map Styles
	add_settings_field( 
		'yop_properties_text_field_9', 
		__( 'Map Styles', 'wordpress' ), 
		'yop_properties_text_field_9_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);
	// Map Marker
	add_settings_field( 
		'yop_properties_text_field_10', 
		__( 'Map Marker', 'wordpress' ), 
		'yop_properties_text_field_10_render', 
		'pluginPage', 
		'yop_properties_pluginPage_section' 
	);

}


function yop_properties_select_field_1_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<div class="colors plug-card">
		<h1 class="title">Theme Options</h1>
		<div class="plug-card-wrapper">
			<div class="col-6">
				<label class="block" for="theme_select">Theme</label>
				<select  class="input-style block" name='yop_properties_settings[yop_properties_select_field_1]' id="theme_select">
					<option value='craig_james' <?php selected( $options['yop_properties_select_field_1'], 'craig_james' ); ?>>Craig James</option>
					<option value='hunter' <?php selected( $options['yop_properties_select_field_1'], 'hunter' ); ?>>Hunter Estates</option>
					<option value='roberts' <?php selected( $options['yop_properties_select_field_1'], 'roberts' ); ?>>Roberts</option>
					<option value='mason_lee' <?php selected( $options['yop_properties_select_field_1'], 'mason_lee' ); ?>>Mason Lee</option>
					<option value='kennedy_residential' <?php selected( $options['yop_properties_select_field_1'], 'kennedy_residential' ); ?>>Kennedy Residential</option>
					<option value='alexander_estates' <?php selected( $options['yop_properties_select_field_1'], 'alexander_estates' ); ?>>Alexander Estates</option>
				</select>
			</div>
		<?php
		$options = get_option( 'yop_properties_settings' );
		?>
		<div class="col-6 hide">
			<label class="block" for="software_select">Api</label>
			<select class="block input-style" name='yop_properties_settings[yop_properties_select_field_0]' id="software_select">
				<option value='default' <?php selected( $options['yop_properties_select_field_0'], 'default' ); ?>>Default</option>
				<option value='thesaurus' <?php selected( $options['yop_properties_select_field_0'], 'thesaurus' ); ?>>Thesaurus</option>
				<option value='2' <?php selected( $options['yop_properties_select_field_0'], 2 ); ?>>Dezrez</option>
				<option value='3' <?php selected( $options['yop_properties_select_field_0'], 3 ); ?>>Vebra</option>
				<option value='letmc' <?php selected( $options['yop_properties_select_field_0'], 'letmc' ); ?>>LetMC</option>
				<option value='rezi' <?php selected( $options['yop_properties_select_field_0'], 'rezi' ); ?>>Rezi</option>
			</select>
		</div>
			<?php
			$options = get_option( 'yop_properties_settings' );
			?>
			<div class="col-12 hide-until-show">
				<div class="letmc software">
					<div class="col-6">
						<label class="block">API Key</label>
						<input class="block input-style" type='text' placeholder="API Key" name='yop_properties_settings[yop_properties_text_field_1][0]' value='<?php if ( isset ( $options['yop_properties_text_field_1'][0] ) ) echo $options['yop_properties_text_field_1'][0]; ?>'>
					</div>
					<div class="col-6">
						<label class="block">Shortname</label>
						<input class="block input-style" type='text' placeholder="Shortname" name='yop_properties_settings[yop_properties_text_field_1][1]' value='<?php if ( isset ( $options['yop_properties_text_field_1'][1] ) ) echo $options['yop_properties_text_field_1'][1]; ?>'>
					</div>
				</div>
			</div>
			<div class="col-12 hide-until-show">
				<div class="thesaurus software">
					<div class="col-6">
						<label class="block">FTP User Name</label>
						<input class="block input-style" type='text' placeholder="FTP User Name" name='yop_properties_settings[yop_properties_text_field_1][0]' value='<?php if ( isset ( $options['yop_properties_text_field_1'][0] ) ) echo $options['yop_properties_text_field_1'][0]; ?>'>
					</div>
					<div class="col-6">
						<label class="block">FTP User Password</label>
						<input class="block input-style" type='text' placeholder="FTP User Password" name='yop_properties_settings[yop_properties_text_field_1][1]' value='<?php if ( isset ( $options['yop_properties_text_field_1'][1] ) ) echo $options['yop_properties_text_field_1'][1]; ?>'>
					</div>
				</div>
			</div>
		</div>



<?php

}

function yop_properties_select_field_0_render(  ) { 


}

function yop_properties_text_field_1_render(  ) { 




}

function yop_properties_text_field_0_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<div class="colors plug-card">
		<h1 class="title">Colours</h1>
		<div class="updated-note">Colours Updated</div>
		<div class="item-wrapper">
			<div class="item">
				<label for="primary-in">Primary</label>
				<input id="primary-in" type='text' placeholder="Primary Color" name='yop_properties_settings[yop_properties_text_field_0][0]' value='<?php if ( isset ( $options['yop_properties_text_field_0'][0] ) ) echo $options['yop_properties_text_field_0'][0]; ?>'>
			</div>
			<div class="item">
				<label for="secondary-in">Secondary</label>
				<input id="secondary-in" type='text' placeholder="Secondary Color" name='yop_properties_settings[yop_properties_text_field_0][1]' value='<?php if ( isset ( $options['yop_properties_text_field_0'][1] ) ) echo $options['yop_properties_text_field_0'][1]; ?>'>
			</div>
			<div class="item">
				<label for="opacity">Opacity</label>
				<input id="opacity" type='text' placeholder="Opacity" name='yop_properties_settings[yop_properties_text_field_0][2]' value='<?php if ( isset ( $options['yop_properties_text_field_0'][2] ) ) echo $options['yop_properties_text_field_0'][2]; ?>'>
			</div>
		</div>
		<hr>
		<p><b>Craig James</b> - #C2B59D - #000000 - 0.75</p> <a data-theme="craig_james" class="btn color_click">Paste Above</a>
		<hr>
		<p><b>Mason Lee</b> - #C3B49D - #484848</p> <a data-theme="mason_lee" class="btn color_click">Paste Above</a>
		<hr>
		<p><b>Hunter Estates</b> - #6D767B - #2E3837</p> <a data-theme="hunter" class="btn color_click">Paste Above</a>
		<hr>
		<p><b>Kennedy Residential</b> - #354962 - #A26755</p> <a data-theme="kennedy" class="btn color_click">Paste Above</a>
		<hr>
		<p><b>Roberts</b> - #a3ad6e - #CBB9A3</p> <a data-theme="roberts" class="btn color_click">Paste Above</a>
		<hr>
		<p><b>Alexander Estates</b> - #922C3A - #000000</p> <a data-theme="alexander" class="btn color_click">Paste Above</a>
		<hr>
	</div>
	<?php

}


function yop_properties_text_field_2_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<div class="plug-card">
		<h1 class="title">Contact Forms</h1>
		<div class="plug-card-wrapper">
			<div class="col-6">
				<label class="block">Popup Contact form (valuation)</label>
				<input class="block input-style" type='text' placeholder="Popup Contact Form Shortcode" name='yop_properties_settings[yop_properties_text_field_2][0]' value='<?php if ( isset ( $options['yop_properties_text_field_2'][0] ) ) echo $options['yop_properties_text_field_2'][0]; ?>'>
			</div>
			<div class="col-6">
				<label class="block">Contact Page Form</label>
				<input class="input-style block " type='text' placeholder="Contact Form Shortcode" name='yop_properties_settings[yop_properties_text_field_2][1]' value='<?php if ( isset ( $options['yop_properties_text_field_2'][1] ) ) echo $options['yop_properties_text_field_2'][1]; ?>'>
			</div>


	<?php
	$options = get_option( 'yop_properties_settings' );
	?>
			<div class="col-6">
				<label class="block">Contact form on Property details </label>
				<input class="block input-style" type='text' placeholder="Contact Form (single prop) Shortcode" name='yop_properties_settings[yop_properties_text_field_3][0]' value='<?php if ( isset ( $options['yop_properties_text_field_3'][0] ) ) echo $options['yop_properties_text_field_3'][0]; ?>'>
			</div>
			<div class="col-6">
				<label class="block">Review Page Form</label>
				<input class="input-style block " type='text' placeholder="Review Page Form Shortcode" name='yop_properties_settings[yop_properties_text_field_3][1]' value='<?php if ( isset ( $options['yop_properties_text_field_3'][1] ) ) echo $options['yop_properties_text_field_3'][1]; ?>'>
			</div>
		</div>
	</div>
	<?php

}

function yop_properties_text_field_3_render(  ) { 


}

function yop_properties_text_field_4_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<div class="plug-card">
		<h1 class="title">Contact Details</h1>
		<div class="plug-card-wrapper">
			<div class="col-6">
				<label class="block">Company Email</label>
				<input class="block input-style" type='text' placeholder="Email:" name='yop_properties_settings[yop_properties_text_field_4][0]' value='<?php if ( isset ( $options['yop_properties_text_field_4'][0] ) ) echo $options['yop_properties_text_field_4'][0]; ?>'>
			</div>
			<div class="col-6">
				<label class="block">Company Phone</label>
				<input class="block input-style" type='text' placeholder="Phone Number:" name='yop_properties_settings[yop_properties_text_field_4][1]' value='<?php if ( isset ( $options['yop_properties_text_field_4'][1] ) ) echo $options['yop_properties_text_field_4'][1]; ?>'>
			</div>
			<?php
			$options = get_option( 'yop_properties_settings' );
			?>
			<div class="col-12">
				<label class="block">Company Location</label>
				<input class="block input-style"  type='text' placeholder="Location Address:" name='yop_properties_settings[yop_properties_text_field_5][0]' value='<?php if ( isset ( $options['yop_properties_text_field_5'][0] ) ) echo $options['yop_properties_text_field_5'][0]; ?>'>
			</div>
		</div>
	</div>
		<?php

}

function yop_properties_text_field_5_render(  ) { 


}

function yop_properties_radio_field_1_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<div class="plug-card">
		<h1 class="title">Other Details</h1>
		<div class="plug-card-wrapper">
			<div class="col-6">
				<label class="block">Saved properties active / my profile.</label>
				<input class="block" type='checkbox' name='yop_properties_settings[yop_properties_radio_field_1]' <?php if ( isset ( $options['yop_properties_radio_field_1'] ) ) checked( $options['yop_properties_radio_field_1'], 1 ); ?> value='1'>
			</div>
	<?php
			$options = get_option( 'yop_properties_settings' );
			?>
			<div class="col-6">
				<label class="block">Footer link active.</label>
				<input class="block" type='checkbox' name='yop_properties_settings[yop_properties_radio_field_2]' <?php if ( isset ( $options['yop_properties_radio_field_2'] ) ) checked( $options['yop_properties_radio_field_2'], 1 ); ?> value='1'>
			</div>
			<?php
	
			$options = get_option( 'yop_properties_settings' );
			?>
			<div class="col-6">
				<label class="block">Room active on description.</label>
				<input class="block" type='checkbox' name='yop_properties_settings[yop_properties_radio_field_3]' <?php if ( isset ( $options['yop_properties_radio_field_3'] ) ) checked( $options['yop_properties_radio_field_3'], 1 ); ?> value='1'>
			</div>
	<?php
}
function yop_properties_radio_field_2_render(  ) { 



}
function yop_properties_radio_field_3_render(  ) { 



}

function yop_properties_text_field_6_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<p>Please make sure it is full links please.</p>
	<br>
	<input type='text' placeholder="Facebook:" name='yop_properties_settings[yop_properties_text_field_6][0]' value='<?php if ( isset ( $options['yop_properties_text_field_6'][0] ) ) echo $options['yop_properties_text_field_6'][0]; ?>'><br>
	<input type='text' placeholder="Twitter:" name='yop_properties_settings[yop_properties_text_field_6][1]' value='<?php if ( isset ( $options['yop_properties_text_field_6'][1] ) ) echo $options['yop_properties_text_field_6'][1]; ?>'><br>
	<input type='text' placeholder="Google Plus:" name='yop_properties_settings[yop_properties_text_field_6][2]' value='<?php if ( isset ( $options['yop_properties_text_field_6'][2] ) ) echo $options['yop_properties_text_field_6'][2]; ?>'>
	<?php

}

function yop_properties_radio_field_0_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<p>Option only available on: Mason Lee.</p>
	<br>
	<input type='checkbox' name='yop_properties_settings[yop_properties_radio_field_0]' <?php if ( isset ( $options['yop_properties_radio_field_0'] ) ) checked( $options['yop_properties_radio_field_0'], 1 ); ?> value='1'>
	<?php

	

}

function yop_properties_text_field_7_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<p>Hunter loading circle background image. Please enter full image link.</p>
	<p>Default: http://www.staging-site.youronlinepresence.uk/wp-content/themes/YOP%20Properties/assets/img/hunter_default_loader.png</p>
	<br>
	<input type='text' placeholder="Image Link:" name='yop_properties_settings[yop_properties_text_field_7][0]' value='<?php if ( isset ( $options['yop_properties_text_field_7'][0] ) ) echo $options['yop_properties_text_field_7'][0]; ?>'><br>
	<?php

}

function yop_properties_text_field_8_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<p>Kennedy Residential Homepage Logo.</p>
	<br>
	<input type='text' placeholder="Image Link:" name='yop_properties_settings[yop_properties_text_field_8][0]' value='<?php if ( isset ( $options['yop_properties_text_field_8'][0] ) ) echo $options['yop_properties_text_field_8'][0]; ?>'><br>
	<?php

}

function yop_properties_text_field_9_render(  ) { 

	$options = get_option( 'yop_properties_settings' );
	?>
	<div class="colors plug-card">
		<h1 class="title">Map Style</h1>
		<div class="plug-card-wrapper">
		<div class="updated-note2">Map Style Updated</div>
			<div class="col-6">
				<label for="map_style" class="block">Map Style</label>
				<input id="map_style" class="block input-style" type='text' placeholder="Map Style:" name='yop_properties_settings[yop_properties_text_field_9][0]' value='<?php if ( isset ( $options['yop_properties_text_field_9'][0] ) ) echo $options['yop_properties_text_field_9'][0]; ?>'><br>
			</div>
			<?php
			$options = get_option( 'yop_properties_settings' );
			?>
			<div class="col-6">
				<label for="map_pin" class="block">Map Icon</label>
				<input id="map_pin" class="block input-style" type='text' placeholder="Map Marker:" name='yop_properties_settings[yop_properties_text_field_10][0]' value='<?php if ( isset ( $options['yop_properties_text_field_10'][0] ) ) echo $options['yop_properties_text_field_10'][0]; ?>'><br>
			</div>
			<p><b>Craig James</b> - #C2B59D - #000000 - 0.75</p> <a data-theme="craig_james" class="btn map_pin_click">Pin Style</a> <a data-theme="craig_james" class="btn map_style_click">Map Style</a>
			<hr>
			<p><b>Mason Lee</b> - #C3B49D - #484848</p>  <a data-theme="mason_lee" class="btn map_pin_click">Pin Style</a> <a data-theme="mason_lee" class="btn map_style_click">Map Style</a>
			<hr>
			<p><b>Hunter Estates</b> - #6D767B - #2E3837</p> <a data-theme="hunter" class="btn map_pin_click">Pin Style</a> <a data-theme="hunter" class="btn map_style_click">Map Style</a>
			<hr>
			<p><b>Kennedy Residential</b> - #354962 - #A26755</p> <a data-theme="kennedy" class="btn map_pin_click">Pin Style</a> <a data-theme="kennedy" class="btn map_style_click">Map Style</a>
			<hr>
			<p><b>Roberts</b> - #a3ad6e - #CBB9A3</p> <a data-theme="roberts" class="btn map_pin_click">Pin Style</a> <a data-theme="roberts" class="btn map_style_click">Map Style</a>
			<hr>
			<p><b>Alexander Estates</b> - #922C3A - #000000</p> <a data-theme="alexander" class="btn map_pin_click">Pin Style</a> <a data-theme="alexander" class="btn map_style_click">Map Style</a>
		</div>
	</div>
</div>
	<?php

}

function yop_properties_text_field_10_render(  ) { 

	

}

function yop_properties_settings_section_callback(  ) { 

	echo __( 'This section description', 'wordpress' );

}


function yop_properties_options_page(  ) { 

	wp_enqueue_script('settings-js', '/wp-content/plugins/yop-properties/assets/js/settings.js', array('jquery', 'jquery-ui-sortable'));
	wp_enqueue_style('settings-css', '/wp-content/plugins/yop-properties/assets/css/settings.css');

	?>
	<div class="head">
		<img src="/wp-content/plugins/yop-properties/assets/img/logo.png">
	</div>
	<h1>YOP Properties</h1>
	<p>Copyright - Your Online Presence.</p>
	<form action='options.php' method='post'>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<a class="sumbit-button-popup btn color_click left no-mar">Add Pages</a>
	<div class="popup-background">
		<div class="popup">
			<div class="popup-wrapper">
				<div class="popup-text">
					<h2>Are you sure you want to do this?</h2>
					<p>This will Add pages with the chosen theme selected. Make sure you remove the pages from the page tab to the right. <a href="/wp-admin/edit.php?post_type=page">Here</a></p>
				</div>
				<div class="conform">
				 <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" id="add_pages" name="add_pages">
					<?php wp_nonce_field('add_page','add_pages'); ?>
					<input name="action" value="add_page" type="hidden">
					<input class="btn color_click" submit_button" name="submit" type="submit" value="Submit">
				</form>
				<a class="btn color_click left">Cancel</a>
				</div>
			</div>
		</div>
	</div>

	<?php

}
