<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<div id="main-content">
	<div class="entry-content">
		<div class="et_pb_row et_pb_gutters1">
			<form method="get" id="searchform" action="<?php echo site_url(); ?>">
			    <div>
			        <input type="hidden" name="post_type" value="post">
			        <input type="text" name="s" id="s" placeholder="Search Blog">
			    </div>
		    </form>
		    <a href="javascript:history.back()" class="primary-border-color et_pb_button">Back to Results</a>
			<div class="et_pb_column et_pb_column_3_4">
				<?php while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
						<div class="et_post_meta_wrapper">
							<?php
				
									$thumb = '';
				
									$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
				
									$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
									$classtext = 'et_featured_image';
									$titletext = get_the_title();
									$featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); 
				
									$post_format = et_pb_post_format();
				
							?>
							<?php if (empty($featured_img_url)): ?>
								<img src="http://via.placeholder.com/1080x500/323332/ffffff?text=blog_featured_image" alt="">
							<?php else: ?>
								<img src="<?php echo $featured_img_url; ?>" alt="">
							<?php endif ?>
							<h1 class="entry-title"><?php the_title(); ?></h1>
						</div> <!-- .et_post_meta_wrapper -->
				
						<div class="entry-content">
							<?php
								the_content();
				
								et_divi_post_meta();
							?>
						</div> <!-- .entry-content -->
					</article> <!-- .et_pb_post -->
				
				<?php endwhile; ?>
			</div>
			<div class="et_pb_column et_pb_column_1_4 sidebar">
				<div class="category_sidebar">
					<h3 class="primary-color">Categories</h3>
					<?php 
					
						$categories = get_categories(array(
							'taxonomy' => 'category',
						    'orderby' => 'name',
						    'order'   => 'ASC',
						));
						foreach($categories as $category) {
						   echo '<div class="category"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></div>';
						}
					
					 ?>
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
	</div>
</div> <!-- #main-content -->

<?php get_footer(); ?>