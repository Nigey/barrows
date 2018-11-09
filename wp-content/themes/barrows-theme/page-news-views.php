<?php

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

$args = array(
	'posts_per_page' => 4,
	'paged' => $paged,
	'post_status' => 'publish',
	'post_type' => 'post',
);

$query = new WP_Query($args); 

?>

<div id="main-content">

			<?php //while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<div class="et_pb_section  et_pb_section_0 et_section_regular header">
				
							<div class=" et_pb_row et_pb_row_0">
							
								<div class="et_pb_column et_pb_column_4_4  et_pb_column_0">
							
									<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_0">
							
										<h1 class="primary-color news-padding">News</h1>

									</div> <!-- .et_pb_text -->
								</div> <!-- .et_pb_column -->
								
							</div> <!-- .et_pb_row -->
							
						</div> <!-- .et_pb_section -->
						<!-- <div class=" et_pb_row et_pb_row_1 et_pb_equal_columns"> -->
 
						<div class="et_pb_row et_pb_row_fullwidth feed_container et_pb_gutters1">
							<div class="et_pb_column et_pb_column_3_4">
								<?php 
								
									if($query->have_posts()) : 
										while($query->have_posts()) : 
										$query->the_post();
								
										ob_start();
										//the_content();
										$content = ob_get_clean();

										$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
								?>
										<div class=" et_pb_row et_pb_row_1 et_pb_row_fullwidth et_pb_equal_columns et_pb_gutters1 blog_row">
											<?php if (empty($featured_img_url)): ?>
												<div class="et_pb_column et_pb_column_1_3  et_pb_column_2" style="background-image: url(http://via.placeholder.com/500/323332/ffffff?text=blog_featured_image);">
												</div>
											<?php else: ?>
												<div class="et_pb_column et_pb_column_1_3  et_pb_column_2" style="background-image: url(<?php echo $featured_img_url; ?>);">
												</div>
											<?php endif ?>
											<div class="et_pb_column et_pb_column_2_3  et_pb_column_1">
												<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_center  et_pb_text_1">
													<h3><strong><?php the_title(); ?></strong></h3>
													<p><?php echo substrwords($content, 200); ?></p>
													<div class="info secondary-bg-color">
														By: <?php echo get_the_author(); ?> - <?php echo the_date(); ?>
													</div>
												</div>
												<div class="overlay">
													<a class="overlay-container" style="color: #fff;" href="<?php the_permalink(); ?>">
														<i class="fa fa-external-link" aria-hidden="true"></i>
														<h3>Read More</h3>
													</a>
												</div>
												<!-- .et_pb_text -->
											</div>
											<!-- .et_pb_column -->
										</div>
										<!-- .et_pb_row -->
								<?php
									endwhile;
										
								?>
								<?php
								
									else: 
								?>
									<h3>No Results Found</h3>
									<p>Sorry there are no properties for these search parameters, please re-enter above and try again.</p>
								
								<?php
									endif;
								?>
							</div>
							<div class="et_pb_column et_pb_column_1_4 sidebar">
								<div class="category_sidebar">
<!-- 									<h3 class="primary-color">Categories</h3>
									<?php 
									
										// $categories = get_categories(array(
										// 	'taxonomy' => 'category',
										//     'orderby' => 'name',
										//     'order'   => 'ASC',
										// ));
										// foreach($categories as $category) {
										//    echo '<div class="category"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></div>';
										// }
									
									 ?> -->
									<h3 class="primary-color">Archives</h3>
									<div class="category"><a href="/news/">All Months</a></div>
									<?php $args = array(
										'type'            => 'monthly',
										'limit'           => 8,
										'format'          => 'custom', 
										'before'          => '<div class="category">',
										'after'           => '</div>',
										'show_post_count' => false,
										'echo'            => 1,
										'order'           => 'DESC',
								        'post_type'     => 'post'
									);
									wp_get_archives( $args ); ?>
								</div>
							</div>
						</div>
						<!-- </div> -->
						<div class="et_pb_row et_pb_row_fullwidth pagination_container et_pb_gutters1">
							<div class="et_pb_column et_pb_column_3_4">
								<div class="pagination dark">
								    <?php 
								        echo paginate_links( array(
								            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
								            'total'        => $query->max_num_pages,
								            'current'      => max( 1, get_query_var( 'paged' ) ),
								            'format'       => '?paged=%#%',
								            'show_all'     => false,
								            'type'         => 'plain',
								            'end_size'     => 2,
								            'mid_size'     => 1,
								            'prev_next'    => true,
								            'prev_text'    => sprintf( '<i></i> %1$s', __( '<span>«</span> Prev', 'text-domain' ) ),
								            'next_text'    => sprintf( '%1$s <i></i>', __( 'Next <span>»</span>', 'text-domain' ) ),
								            'add_args'     => false,
								            'add_fragment' => '',
								        ) );
								    ?>
								</div>
							</div>
						</div>

					</div> <!-- .entry-content -->
					
				</article> <!-- .et_pb_post -->

			<?php //endwhile; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>