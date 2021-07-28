<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package multiplex
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
			$hero = do_shortcode('[plx_hero media_id="250" title="" subtitle=""]');
			echo $hero;
			?>
			<section class="error-404 not-found">
								<div class="mtv_section_padding mtv_flex">
											<div>
												<?php	dynamic_sidebar( '404-content' ); ?>
											</div>
							</div>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
