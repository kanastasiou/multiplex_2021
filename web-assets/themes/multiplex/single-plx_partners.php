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

			$hero = do_shortcode('[plx_hero media_id="131" title="'.$data[$id]['main']->post_title.'" subtitle="'.$data[$id]['metas']['plx_small_header'].'"]');
			echo $hero;
    		$img = wp_get_attachment_image_src($data[$id]['metas']['_thumbnail_id'], 'medium');

    		$small_title = '';
    		if (!empty($data[$id]['metas']['plx_small_title'])){
    			$small_title = '
    			<div class="twelve columns plx_title_wrap">'
    				.do_shortcode('[plx_title title="'.$data[$id]['metas']['plx_small_title'].'" color="yellow" span_color="blue" title_type="h3"]').
    			'</div>';
    		}


    		?>
    		<div class="plx_partner_name mtv_hidden"><?php echo $data[$id]['main']->post_title; ?></div>
			<div class="plx_partner_main plx_section twelve columns mtv_3_3 mtv_padding">
				<div class="mtv_2_3">
					<?php echo $small_title; ?>
					<div class="twelve columns">
						<div class="five columns">
							<div class="partner_img_wrap mtv_center plx_shadow">
								<img src="<?php echo $img[0]; ?>">
							</div>
						</div>
						<div class="seven columns">
							<p><?php echo $data[$id]['main']->post_content; ?></p>
						</div>
					</div>
					<div class="twelve columns plx_section official_support_form">
						<div class="plx_cf7_title"><h3><?php echo __('Official Support for','multiplex').' '.$data[$id]['main']->post_title.' '.__('in Corfu, Ionian Sea, Greece:', 'multiplex'); ?></h3></div>
						<?php
						$cf7 = do_shortcode('[contact-form-7 id="161" title="'.__('Official Support', 'multiplex').'"]');
						echo $cf7;
						?>
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
