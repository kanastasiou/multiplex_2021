<?php
/**
 * The template for displaying partners
 *
 *
 * @package multiplex
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
  
			$id = get_the_ID();
			$data  = mtv_get_posts_construct($post_type, '', array(
        	'include' => array(
            	absint($id)
       			 )
    		), 1);
    		$img = wp_get_attachment_image_src($data[$id]['metas']['_thumbnail_id'], 'medium');

			$hero = do_shortcode('[plx_hero media_id="'.$data[$id]['metas']['_thumbnail_id'].'" title="'.$data[$id]['main']->post_title.'" subtitle="'.$data[$id]['metas']['plx_small_header'].'"]');
			echo $hero;

    		$small_header = '';
    		if (!empty($data[$id]['metas']['plx_small_header'])){
    			$small_header = '
    			<div class="twelve columns plx_title_wrap">'
    				.do_shortcode('[plx_title title="'.$data[$id]['metas']['plx_small_header'].'" color="yellow" span_color="blue" title_type="h3"]').
    			'</div>';
    		}


    		?>
			<div class="plx_partner_main plx_section twelve columns mtv_3_3 mtv_padding">
				<div class="mtv_2_3">
					<div class="twelve columns">
						<?php echo do_shortcode($data[$id]['main']->post_content); ?>
					</div>
				</div>
				<div class="mtv_1_3">
					<?php get_sidebar(); ?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
//get_sidebar();
get_footer();