<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package multiplex
 */

if (!is_front_page()){
	$id = get_the_ID();
	if ($id == 150){
		$carousel = '';
	}
	else {
		$carousel = '<div class="mtv_container plx_section"><div class="mtv_center">[plx_title title="Official Support"]</div>[plx_partners_show style="carousel"]</div>';
	}

$footer_items = do_shortcode($carousel.'<div class="mtv_padding">[plx_post_preview post_type="page" id="80" image_position="left" custom_title="Contact Us"]</div>');
echo '<div class="mtv_container plx_section">'.$footer_items.'</div>';	
}

?>

	</div><!-- #content -->
	</div><!-- # barba content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php
				dynamic_sidebar('footer-widget');
			?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
