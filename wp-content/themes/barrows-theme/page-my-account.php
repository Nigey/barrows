<?php 

	/* Check if the user is logged in, otherwise re-direct to home page */
	if (!is_user_logged_in())
	{
		wp_redirect('/');
	}

	get_header(); 

?>

	<div class="push_top">
		<div class="row">
			
				
				<h3>Saved Properties</h3>
				<div class="property-results">
					<?php
						$properties = get_saved_properties();
						if ($properties)
						{
							/* If the user has saved properties then display, currently in an array */
							$properties = json_decode(json_encode($properties), True);
							foreach ($properties as $property) {
								$PropertyID = $property['PropertyID'];
								$PropertyName = $property['PropertyName'];
								$PropertyPrice = $property['PropertyPrice'];
								$PropertyPhoto = $property['PropertyPhoto'];
									$output = '

										<div class="col m4">	
											<div class="single_property">
												<div class="property_image" style="background-image: url('.$PropertyPhoto.')"></div>
												<div class="property_content">
													<h2 class="title">'.$PropertyName .'</h2>
													<h3 class="price">£'.$PropertyPrice.'</h3>
													<a href="/property-details/?id='.$PropertyID.'" class="btn waves-effect pink-outline">Details</a>
													'.$save.'
												</div>
											</div>
										</div>
										<a class="delete_saved_property" href="#" id="'.$PropertyID.'"><h2><i class="fa fa-trash-o" aria-hidden="true"></i></h2></a>

									';
								echo $output;
							}
						} else {
							/* User has no saved properties, show "no saved properties" message */
							echo 'No saved properties';
						}
					 ?>
				</div>

</div>

<?php get_footer(); ?>