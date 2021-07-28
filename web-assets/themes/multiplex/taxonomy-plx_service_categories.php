<?php

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php
			$id = get_the_ID();

			$data = get_the_terms($id, 'plx_service_categories');
			$img = get_term_meta($data[0]->term_id, 'plx_category_image', true);

			$small_header = get_term_meta($data[0]->term_id, 'plx_small_header', true) ?: '';

			$hero = do_shortcode('[plx_hero media_id="'.$img.'" title="'.$data[0]->name.'" subtitle="'.$small_header.'"]');
			echo $hero;
			?>
			<div class="plx_partner_main plx_section twelve columns mtv_3_3 mtv_padding">
				<div class="mtv_2_3">
					<div class="twelve columns">
			<?php
					 $msg = do_shortcode('[plx_show_service term_id="'.$data[0]->term_id.'"]');
					 echo $msg;
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
get_footer();
