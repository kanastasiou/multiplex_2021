<?php
if (!defined('ABSPATH'))
    exit;

add_shortcode('plx_grid_1', 'plx_grid_1_func');

function plx_grid_1_func($atts)
{ 
    $plugin_dir = get_template_directory_uri();
    wp_enqueue_script('mtv-shave-js', $plugin_dir . '/scripts/js/shave.min.js', array(), false, true);   
    extract(shortcode_atts(array(
        'taxonomy' => '',
        /* insert taxonomy name*/
        'taxonomy_url_custom_page_id' => '',
        /* if you want the link to send in a custom page*/
        'post_type' => '',
        /* insert post_type*/
        'post_ids' => '',
        /* insert post_ids with comma*/
        'custom_elements' => '',
        /* eg. 'img_id_stop_$title_stop_text_stop_url_next_'...next element */
        'element_width_class' => 'four columns',
        'image_fit' => 'contain',
        /* or contain */
        'style' => 'style_1',
        'button_title' => 'LEARN MORE',
    ), $atts));
    
    $full_array = array();

    if (!empty($taxonomy)) {
        $terms = get_terms(array(
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'post_status' => 'publish'
        ));
        foreach ($terms as $term) {
            if (!empty($taxonomy_url_custom_page_id)) {
                $link = get_permalink($taxonomy_url_custom_page_id);
            } else {
                $link = get_term_link($term->term_id);
            }
            $img = get_term_meta($term->term_id, 'span_icon_class', true) ?: '';
            
            if (empty($img)){
                $img  = get_term_meta($term->term_id, 'plx_category_image', true) ?: '';
                $img = intval($img);
            }
            $full_array[] = array(
                'img' => $img,
                'title' => $term->name,
                'text' => $term->description,
                'link' => $link
            );
        }
    }
    if (!empty($post_type)){
       // $partners = mtv_get_posts_construct('plx_partners', '', '', -1);
        if (!empty($post_ids)){
            $post_ids = explode(',', $post_ids);
        }
        else{
            $post_ids = array();
        }
        $posts  = mtv_get_posts_construct($post_type, '', array('include' => $post_ids), -1);
        foreach ($posts as $post) {
            $img = $post['metas']['span_icon_class'] ?: '';
        if (empty($img)){
            $img = $post['metas']['_thumbnail_id'] ?: '';
            $img = intval($img);
        }
        $full_array[] = array(
            'img' => $img,
            'title' => $post['main']->post_title,
            'text' => strip_tags(strip_shortcodes($post['main']->post_content)),
            'link' => $post['permalink']
        );
        }
    }
    if (!empty($custom_elements)) {
        $custom_elements = explode('_next_', $custom_elements);
        foreach ($custom_elements as $custom_element) {
            $custom_element = explode('_stop_', $custom_element);
            if (!empty($custom_element[3])) {
                $link = get_permalink($custom_element[3]);
            } else {
                $link = '';
            }
            $full_array[] = array(
                'img' => $custom_element[0],
                'title' => $custom_element[1],
                'text' => $custom_element[2],
                'link' => $link
            );
        }
    }
    $msg = '
    <div class="mtv_container mtv_flex plx_section plx_grid">';
    foreach ($full_array as $element) {
        if (is_int($element['img'])){
            $img = mtv_image_element($element['img']);
        }
        else {
            $img = '<div class="plx_grid_icon"><span class="'.$element['img'].'"></span></div>';
        }
        $msg .= '
            <div class="' . $element_width_class . ' plx_grid_item">
                <div class="'.$style.' mtv_flex" >
                    <div class="mtv_container img_wrapper relative over_hidden mtv_center"><div class="img_wrap"><a href="'.$element['link'].'">'.$img.'</a></div></div>
                    <div class="mtv_container mtv_center"><h4><a href="'.$element['link'].'">' . $element['title'] . '</a></h4></div>
                    <div class="mtv_container mtv_center"><p class="mtv_limit_text" data-height="80" data-original_text="'.$element['text'].'">' . strip_tags($element['text']) . '</p></div>
                    <div class="mtv_container mtv_center"><a href="' . $element['link'] . '" class="mtv_button">' . $button_title . '</a></div>
                </div>
            </div>';
    }
    
    $msg .= '
    </div>';
    
    return $msg;
}

add_shortcode('plx_partners_show', 'plx_partners_show_func');

function plx_partners_show_func($atts)
{
    extract(shortcode_atts(array(
        'style' => 'carousel',
        /* or grid*/
    ), $atts));
    extract(shortcode_atts(array(), $atts));
    $partners = mtv_get_posts_construct('plx_partners', '', '', -1);

    switch ($style) {
        case 'carousel':
            $plugin_dir = get_template_directory_uri();
            wp_enqueue_script('sbp-slick-js', $plugin_dir . '/scripts/js/slick/slick.min.js', array(), false, true);
            wp_enqueue_style('sbp-slick-css', $plugin_dir . '/scripts/js/slick/slick.css', true, '1.0.0');
            wp_enqueue_style('sbp-slick-theme-css', $plugin_dir . '/scripts/js/slick/slick-theme.css', true, '1.0.0');
    
            $msg      = '
            <div class="plx_section mtv_container plx_partners_show_wrap mtv_partner_slick_wrap">
                <div class="mtv_partner_slick mtv_partner plx_opac plx_shadow" data-display="carousel" data-columns="5" data-mcolumns="4" data-scolumns="3">';
                    foreach ($partners as $partner) {
                        $img = mtv_image_element($partner['metas']['_thumbnail_id']);
                        $msg .= '
                        <div class="mtv_slick_item_wrap carousel">
                            <div class="mtv_slick_item"><a href="'.$partner['permalink'].'">'.$img.'</a></div>
                        </div>';
                    }
                $msg .= '
                </div>
            </div>';
            break;
        case 'grid':
            $msg = '<div class="plx_section mtv_container plx_partners_show_wrap">';
            foreach ($partners as $partner) {
                        $img = mtv_image_element($partner['metas']['_thumbnail_id']);
                        $msg .= '
                        <div class="mtv_partner mtv_2_col columns grid">
                            <div class="mtv_slick_item_wrap grid">
                                <div class="mtv_slick_item"><a href="'.$partner['permalink'].'">'.$img.'</a></div>
                            </div>
                        </div>';            
            }
            $msg .= '</div>';
            break;
        default:
            # code...
            break;
    }
    
    return $msg;
}

add_shortcode('plx_post_preview', 'plx_post_preview_func');

function plx_post_preview_func($atts)
{
    $plugin_dir = get_template_directory_uri();
    wp_enqueue_script('mtv-shave-js', $plugin_dir . '/scripts/js/shave.min.js', array(), false, true);

    extract(shortcode_atts(array(
        'post_type' => '',
        'id' => '',
        'custom_title' => '',
        'custom_text' => '',
        'image_position' => '', /* left or right */
        'read_more_text' => 'read more'
    ), $atts));
    
    $data  = mtv_get_posts_construct($post_type, '', array(
        'include' => array(
            absint($id)
        )
    ), 1);

    if (!empty($custom_title)){
        $title = $custom_title;    
    }
    else {
        $title = $data[$id]['main']->post_title;
    }
    if (!empty($custom_text)){
        $text = $custom_text;    
    }
    else {
        $text = strip_tags(strip_shortcodes($data[$id]['main']->post_content));
    }

/*
    $data[$id]['metas']['_thumbnail_id'];
    $data[$id]['main']->post_title;
    $data[$id]['permalink'];
*/
    $title = do_shortcode('[plx_title title="'.$title.'" color="yellow" span_color="blue" title_type="h2"]');
    $img = mtv_image_element($data[$id]['metas']['_thumbnail_id']);
    $msg = '
        <div class="mtv_container mtv_flex mtv_margin_bottom plx_preview">';
    switch ($image_position) {
        case 'left':
            $msg .= '
            <div class="six columns plx_img_preview_container">
                <div class="ten columns plx_preview_img_wrap height_100_pc float_right plx_shadow">
                    <div class="mtv_container height_100_pc over_hidden relative plx_preview_img left">'.$img.'
                    </div>
                </div>
            </div>
            <div class="six columns relative left height_100_pc plx_preview_text_container">
                <div class="ten columns mtv_flex height_100_pc">
                    <div class="plx_preview_title mtv_center"><a href="'.$data[$id]['permalink'].'">'.$title.'</a></div>
                    <div class="plx_preview_text">
                        <div class="mtv_limit_text read_more removed" data-height="100" data-more_txt="'.$read_more_text.'" data-link="'.$data[$id]['permalink'].'" data-original_text="'.$text.'">'.$text.'</div>
                    </div>
                </div>
            </div>';
            break;
        case 'right':
            $msg .= '
            <div class="six columns relative right height_100_pc plx_preview_text_container">
                <div class="ten columns mtv_flex height_100_pc float_right">
                    <div class="plx_preview_title mtv_center"><a href="'.$data[$id]['permalink'].'">'.$title.'</a></div>
                    <div class="plx_preview_text">
                        <div class="mtv_limit_text read_more removed" data-height="100" data-more_txt="'.$read_more_text.'" data-link="'.$data[$id]['permalink'].'" data-original_text="'.$text.'">'.$text.'</div>
                    </div>
                </div>
            </div>
            <div class="six columns plx_img_preview_container">
                <div class="ten columns plx_preview_img_wrap height_100_pc plx_shadow">
                    <div class="mtv_container height_100_pc over_hidden relative plx_preview_img right">'.$img.'
                    </div>
                </div>
            </div>';
            break;
    }
    $msg .= '
        </div>';

    return $msg;   
}

add_shortcode('plx_hero', 'plx_hero_func');

function plx_hero_func($atts)
{
    extract(shortcode_atts(array(
        'title' => 'Corfu Electricians',
        'subtitle' => 'Proud official partners of Marina Gouvia - Specialized in yachts and boats',
        'media_id' => '109',
    ), $atts));

    $link = wp_get_attachment_url($media_id);

    if (wp_attachment_is_image($media_id)){
        $img = mtv_image_element($media_id);
        $msg = '
        <div class="plx_hero_wrap plx_hero_img_wrap">
            <div class="mtv_container plx_header plx_header_bg_img mtv_center">'.$img.'
                <div class="hero_text">
                    <h1>'.$title.'</h1>
                    <h5>'.$subtitle.'</h5>
                </div> 
            </div>
        </div>';
    }
    else {
        $video = '
        <video loop autoplay muted playsinline>
            <source src="'.$link.'" type="video/mp4">
        </video>';

        $msg = '
        <div class ="plx_hero_wrap">
            <div class="plx_header plx_home_video_container mtv_center">
                '.$video.'
                <div class="hero_text">
                    <h1>'.$title.'</h1>
                    <h5>'.$subtitle.'</h5>
                </div> 
                <div class="scroll_4_more">
                    <a href="#plx_section_1">Learn More<br><span class="icon mx_icon-triangle"></span></a>
                </div>
            </div>
        </div>';
    }


    return $msg;
}

add_shortcode( 'plx_title', 'plx_title_func' );

function plx_title_func( $atts )
{
        extract( shortcode_atts( array(
                 "title" => "",
                 "color" => "white",
                 "span_color" => "yellow",
                 "title_type" => 'h2' /* h1,h3,p etc*/,
        ), $atts ) );

    $msg = '
    <div class="plx_title_wrap">
        <div class="plx_title '.$title_type.'" data-color="'.$color.'" data-span_color="'.$span_color.'">
        <'.$title_type.'>'.$title.'</'.$title_type.'>
        <span class="icon mx_icon-triangle"></span> 
        </div>
    </div>';

    return $msg;
}

add_shortcode( 'plx_show_service', 'plx_show_service_func' );

function plx_show_service_func( $atts )
{
        extract( shortcode_atts( array(
                 'taxonomy_name' => 'plx_service_categories',
                 'term_id' => ''
        ), $atts ) );

    $msg = '';

    $extra_array['tax_query']=array(
        array(
            'taxonomy' => $taxonomy_name,
            'field' => 'term_id',
            'terms' => absint($term_id)
            )
        );

    $services = apply_filters('mtv_get_some_posts', 'plx_services', '', $extra_array,'');

    foreach ($services as $service) {
        $msg .= '<div class="mtv_container">';
        $msg .= do_shortcode('[plx_title title="'.$service['main']->post_title.'" color="yellow" span_color="blue" title_type="h3"]<div class="mtv_section_padding mtv_container">'.$service['main']->post_content.'</div>');
        $msg .= '</div>';
    }
    return $msg;
}

add_shortcode( 'plx_map', 'plx_map_func' );

function plx_map_func( $atts )
{
    extract( shortcode_atts( array(
        'lat' => '',
        'lon' => '',
        'to_lat' => '39.625947',
        'to_lon' => '19.906646',
        'icon_id' => '',
        'direction' => '',
    ), $atts ) );

    if (!empty($icon_id)){
        $url = wp_get_attachment_url( $icon_id ) ;
    }
    else {
        $url = '';
    }


    $msg = '
    <div class="plx_section mtv_container">
        <div class="plx_map_container" data-direction="'.$direction.'" data-lat="'.$lat.'" data-lon="'.$lon.'" data-target_lon="'.$to_lon.'" data-target_lat="'.$to_lat.'" id="plx_map" data-icon="'.$url.'">
        </div>
    </div>';

    return $msg;

}
