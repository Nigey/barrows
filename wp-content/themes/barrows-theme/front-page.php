<?php



get_header();



$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

$url_link = "property.xml";

$url_data = simplexml_load_file($url_link);

?>







	<div id="main-content">





		<?php while ( have_posts() ) : the_post(); ?>



			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



				<div class="entry-content">


					<div class="introduction-wrapper">

						<div class="introduction">

							<div class="introduction-item item-1">

								<div class="introduction-content">

									<ul class="stars">

										<li><i class="fa fa-star" aria-hidden="true"></i></li>

										<li><i class="fa fa-star" aria-hidden="true"></i></li>

										<li><i class="fa fa-star" aria-hidden="true"></i></li>

										<li><i class="fa fa-star" aria-hidden="true"></i></li>

										<li><i class="fa fa-star" aria-hidden="true"></i></li>

									</ul>

									<h3>Higly Trusted Property Experts</h3>

									<h2 class="bold">Welcome to Barrows & Forrester</h2>

								</div>

							</div>

							<div class="introduction-item item-2">

								<div class="introduction-content">

									<h3>Tailored Approach</h3>

									<h2 class="bold">Experts in West Midlands Property Market</h2>

								</div>

							</div>

							<div class="introduction-item item-3">

								<div class="introduction-content">

									<h3>Ask about our Fixed Price Guarantees</h3>

									<h2 class="bold">No Hidden Fees</h2>

								</div>

							</div>

						</div>

						<div class="home-search">

							<div class="row">

								<div class="search-content">

									<form action="../wp-content/themes/barrows-theme/includes/search.php" method="post" name="searchForm_home">

										<div class="search-wrapper card">

											<div class="search-input">

								        		<input name="location" placeholder="Location ( Example: Birmingham )" id="search" class="search-home" tabindex="1">

								       			<!-- <div class="search-results"></div> -->

								    		</div>

							      		</div>

							      		<div class="btn_right">

											<input placeholder="Rent" type="submit" name="group1" value="rent" class="search_button btn green">

											<input placeholder="Sale" type="submit" name="group1" value="sale" class="search_button btn pink">

										</div>

										<!-- <div class="btn green">Buy</div> -->

										<!-- <div class="btn pink">Rent</div> -->

									</form>

								</div>

							</div>

						</div>

					</div>


					<?php

						the_content();

					?>

				</div> <!-- .entry-content -->



			</article> <!-- .et_pb_post -->



		<?php endwhile; ?>





	</div> <!-- #main-content -->







<?php get_footer(); ?>