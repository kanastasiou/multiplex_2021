<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package multiplex
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			$id = get_the_ID();
			$data  = mtv_get_posts_construct('page', '', array(
        	'include' => array(
            	absint($id)
       			 )
    		), 1);

			$small_header = $data[$id]['metas']['plx_small_header'] ?: '';
			if (!empty($data[$id]['metas']['cover_media'])){
				$media_id = $data[$id]['metas']['cover_media'];
			}
			else {
				$media_id = $data[$id]['metas']['_thumbnail_id'];
			}

			$hero = do_shortcode('[plx_hero media_id="'.$media_id.'" title="'.$data[$id]['main']->post_title.'" subtitle="'.$small_header.'"]');
			echo $hero;
			while ( have_posts() ) : the_post();
				
				get_template_part( 'template-parts/content', 'page' );

				/* If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				*/
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();
