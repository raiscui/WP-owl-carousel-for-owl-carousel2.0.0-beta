<?php
/*
  Plugin Name: Owl Carousel
  Description: A simple plugin to include an Owl Carousel in any post
  Author: Pierre JEHAN
  Version: 0.4.2
  Author URI: http://www.pierre-jehan.com
  Licence: GPL2
 */
require_once ( WP_CONTENT_DIR . '/qetag.php' );
add_theme_support('post-thumbnails');

add_action('init', 'owlcarousel_init');
add_action('wp_print_scripts', 'owl_register_scripts');
add_action('wp_print_styles', 'owl_register_styles');
// add_action('widgets_init', 'owl_widgets_init');
add_action('manage_edit-owl-carousel_columns', 'owl_columnfilter');
add_action('manage_posts_custom_column', 'owl_column');
add_action('admin_menu', 'owl_carousel_menu');
add_action('admin_enqueue_scripts', 'owl_carousel_admin_register_scripts');

if(filter_var(get_option('owl_carousel_wordpress_gallery', false), FILTER_VALIDATE_BOOLEAN)) {
    add_filter('post_gallery', 'owl_carousel_post_gallery', 10, 2);
}

/**
 * Initilize the plugin
 */
function owlcarousel_init() {

    $labels = array(
        'name' => __('Owl Carousel', 'owl-carousel-domain'),
        'singular_name' => __('Carousel Item', 'owl-carousel-domain'),
        'add_new' => __('Add New Item', 'owl-carousel-domain'),
        'add_new_item' => __('Add New Carousel Item', 'owl-carousel-domain'),
        'edit_item' => __('Edit Carousel Item', 'owl-carousel-domain'),
        'new_item' => __('Add New Carousel Item', 'owl-carousel-domain'),
        'view_item' => __('View Item', 'owl-carousel-domain'),
        'search_items' => __('Search Carousel', 'owl-carousel-domain'),
        'not_found' => __('No carousel items found', 'owl-carousel-domain'),
        'not_found_in_trash' => __('No carousel items found in trash', 'owl-carousel-domain'),
    );

    register_post_type('owl-carousel', array(
        'public' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'label' => 'Owl Carousel',
        'menu_icon' => plugins_url('/owl-carousel/images/owl-logo-16.png'),
        'labels' => $labels,
        'capability_type' => 'post',
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        )
    ));
    
    register_taxonomy(
		'Carousel',
		'owl-carousel',
		array(
			'label' => __( 'Carousel' ),
			'rewrite' => array( 'slug' => 'carousel' ),
			'hierarchical' => true,
		)
	);

    add_image_size('owl_widget', 180, 100, true);
    add_image_size('owl_function', 600, 280, true);

    // add_shortcode('owl-carousel', 'owl_function');
    // add_filter("mce_external_plugins", "owl_register_tinymce_plugin");
    // add_filter('mce_buttons', 'owl_add_tinymce_button');
    
    // Add Wordpress Gallery option
    add_option('owl_carousel_wordpress_gallery', 'off');
}

function owl_carousel_menu() {
    add_submenu_page('edit.php?post_type=owl-carousel', __('Parameters', 'owl-carousel-domain'), __('Parameters', 'owl-carousel-domain'), 'manage_options', 'owl-carousel-parameters', 'submenu_parameters');
}

function submenu_parameters() {
    
    $isWordpressGallery = (filter_var(get_option('owl_carousel_wordpress_gallery', false), FILTER_VALIDATE_BOOLEAN)) ? 'checked' : '';
    
    echo '<div class="wrap owl_carousel_page">';
    
        echo '<?php update_option("owl_carousel_wordpress_gallery", $_POST["wordpress_gallery"]); ?>';
    
		echo '<h2>' . __('Owl Carousel parameters', 'owl-carousel-domain') . '</h2>';
		
		echo '<form action="' . plugin_dir_url( __FILE__ ) . 'save_parameter.php" method="POST" id="owlcarouselparameterform">';
		
		    echo '<h3>' . __('Wordpress Gallery', 'owl-carousel-domain') . '</h3>';
		    echo '<input type="checkbox" name="wordpress_gallery" ' . $isWordpressGallery . ' />';
		    echo '<label>' . __('Use Owl Carousel with Wordpress Gallery', 'owl-carousel-domain') . '</label>';
		    echo '<br />';
		    echo '<br />';
		    echo '<input type="submit" class="button-primary owl-carousel-save-parameter-btn" value="' . __('Save changes', 'owl-carousel-domain') . '" />';
		    echo '<span class="spinner"></span>';
		
		echo '</form>';
		
	echo '</div>';
}

/**
 * List of JavaScript / CSS files for admin
 */
function owl_carousel_admin_register_scripts() {
    wp_enqueue_style('owl_carousel_admin_styles', plugin_dir_url( __FILE__ ) . 'css/admin_styles.css');
    
    wp_enqueue_script( 'owl_carousel_admin_script', plugin_dir_url( __FILE__ ) . 'js/admin_script.js' );
}

/**
 * List of JavaScript files
 */
function owl_register_scripts() {
    // wp_register_script('js.owl.carousel', plugins_url('/owl-carousel/js/owl.carousel.js'));
    wp_register_script('js.owl.carousel', plugins_url('/owl-carousel/owl.carousel.js'),array('jquery'),null,true);
    wp_register_script('js.owl.carousel.script', plugins_url('/owl-carousel/js/script.js'),array('jquery','js.owl.carousel'),null,true);

    wp_register_script('js.owl.carousel.plugins.animate', plugins_url('/owl-carousel/plugins/owl.animate.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.autoheight', plugins_url('/owl-carousel/plugins/owl.autoheight.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.autoplay', plugins_url('/owl-carousel/plugins/owl.autoplay.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.autorefresh', plugins_url('/owl-carousel/plugins/owl.autorefresh.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.hash', plugins_url('/owl-carousel/plugins/owl.hash.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.lazyload', plugins_url('/owl-carousel/plugins/owl.lazyload.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.navigation', plugins_url('/owl-carousel/plugins/owl.navigation.js'),array('jquery','js.owl.carousel'),null,true);
    wp_register_script('js.owl.carousel.plugins.video', plugins_url('/owl-carousel/plugins/owl.video.js'),array('jquery','js.owl.carousel'),null,true);
   


    // wp_enqueue_script('jquery');
    wp_enqueue_script('js.owl.carousel');
    wp_enqueue_script('js.owl.carousel.script');

    wp_enqueue_script('js.owl.carousel.plugins.animate');
    wp_enqueue_script('js.owl.carousel.plugins.autoheight');
    wp_enqueue_script('js.owl.carousel.plugins.autoplay');
    wp_enqueue_script('js.owl.carousel.plugins.autorefresh');
    wp_enqueue_script('js.owl.carousel.plugins.hash');
    wp_enqueue_script('js.owl.carousel.plugins.lazyload');
    wp_enqueue_script('js.owl.carousel.plugins.navigation');
    wp_enqueue_script('js.owl.carousel.plugins.video');


}

/**
 * List of CSS files
 */
function owl_register_styles() {
    // wp_register_style('style.owl.carousel', plugins_url('/owl-carousel/css/owl.carousel.css'));
    wp_register_style('style.owl.carousel', plugins_url('/owl-carousel/assets/owl.carousel.css'));
    // wp_register_style('style.owl.carousel.theme', plugins_url('/owl-carousel/css/owl.theme.css'));
    wp_register_style('style.owl.carousel.theme', plugins_url('/owl-carousel/assets/owl.theme.default.css'));
    // wp_register_style('style.owl.carousel.transitions', plugins_url('/owl-carousel/css/owl.transitions.css'));
    // wp_register_style('style.owl.carousel.styles', plugins_url('/owl-carousel/css/styles.css'));


    wp_enqueue_style('style.owl.carousel');
    wp_enqueue_style('style.owl.carousel.theme');
    // wp_enqueue_style('style.owl.carousel.transitions');
    // wp_enqueue_style('style.owl.carousel.styles');
}

function owl_register_tinymce_plugin($plugin_array) {
    $plugin_array['owl_button'] = plugins_url('/owl-carousel/js/owl-tinymce-plugin.js');
    return $plugin_array;
}

function owl_add_tinymce_button($buttons) {
    $buttons[] = "owl_button";
    return $buttons;
}

/*
 * Initialize Owl Widget
 */
function owl_widgets_init() {
    register_widget("owl_Widget");
}

class owl_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct('owl_Widget', 'Owl Carousel', array('description' => __('A Owl Carousel Widget', 'text_domain')));
    }

    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Widget Carousel', 'text_domain');
        }
        if (isset($instance['category'])) {
            $carousel = $instance['category'];
        } else {
            $carousel = 'Uncategorized';
        }
        ?>  
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>  
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />  
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Carousel:'); ?></label>  
            <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($carousel); ?>" />  
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);

        return $instance;
    }

    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;
        echo owl_function(array(category => $instance['category'], singleItem => "true", autoPlay => "true", pagination => "false"));
        echo $after_widget;
    }

}

/**
 * Add custom column filters in administration
 * @param array $columns
 */
function owl_columnfilter($columns) {
    $thumb = array('thumbnail' => 'Image');
    $columns = array_slice($columns, 0, 2) + $thumb + array_slice($columns, 2, null);

    return $columns;
}

/**
 * Add custom column contents in administration
 * @param type $columnName
 */
function owl_column($columnName) {
    global $post;
    if ($columnName == 'thumbnail') {
        echo edit_post_link(get_the_post_thumbnail($post->ID, 'thumbnail'), null, null, $post->ID);
    }
}

/**
 * Plugin main function
 * @param type $atts Owl parameters
 * @param type $content
 * @return string Owl HTML code
 */
function owl_function($atts, $content = null) {
  //   extract(shortcode_atts(array(
  //       'category' => 'Uncategoryzed'
  //                   ), $atts));

  //   $data_attr = "";
  //   foreach ($atts as $key => $value) {
  //       if ($key != "category") {
  //           $data_attr .= ' data-' . $key . '="' . $value . '" ';
  //       }
  //   }

  //   $args = array(
  //       'post_type' => 'owl-carousel',
  //       'tax_query' => array(
  //           array(
  //               'taxonomy' => 'Carousel',
  //               'field' => 'slug',
  //               'terms' => $atts['category']
  //           )
  //       ),
		// 'nopaging' => true
  //   );

  //   $result = '<div id="owl-carousel-' . rand() . '" class="owl-carousel" ' . $data_attr . '>';

  //   $loop = new WP_Query($args);
  //   while ($loop->have_posts()) {
  //       $loop->the_post();

  //       $the_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), get_post_type());
  //       $result .= '<div class="item">';
  //       if ($the_url[0])
  //       {
  //           $result .= '<div>';
  //               if ($the_url[0])
  //               {
  //                   $result .= '<img title="' . get_the_title() . '" src="' . $the_url[0] . '" alt="' . get_the_title() . '"/>';
  //               }
  //               $result .= '<div class="owl-carousel-item-imgoverlay">';
  //                   $result .= '<div class="owl-carousel-item-imgtitle">' . get_the_title() . '</div>';
  //                   $result .= '<div class="owl-carousel-item-imgcontent">' . get_the_content() . '</div>';
  //               $result .= '</div>';
  //           $result .= '</div>';
  //       }
  //       else
  //       {
  //           $result .= '<div class="owl-carousel-item-text">' . get_the_content() . '</div>';
  //       }
  //       $result .= '</div>';
  //   }
  //   $result .= '</div>';
    $result='';
    return $result;
}


/**
 * Owl Carousel for Wordpress image gallery
 * @param string $output Gallery output
 * @param array $attr Parameters
 * @return string Owl HTML code
 */
function owl_carousel_post_gallery($output, $attr) {
  

  

    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'dl',
        'icontag' => 'dt',
        'captiontag' => 'dd',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => ''
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) $orderby = 'none';

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) return '';
    

    // Add item number if not defined
    if(!isset($attr['items'])) {
        if (isset($attr['columns'])){
            $attr['items'] = $attr['columns'];
        }else{
            
            $attr['items'] = '1';
        }
    }

    if(!isset($attr['height']) && !isset($attr['noHeight'])) {
      $attr['height'] = '250';
        
    }


    $data_attr = "";
    foreach ($attr as $key => $value) {
        if ($key != "category") {
            $data_attr .= ' data-' . $key . '="' . $value . '" ';
        }
    }

    if(isset($attr['name'])){
      $output .= '<div id="owl-carousel-' . $attr['name'] . '" class="owl-carousel" ' . $data_attr . '>';
    }else{
      $output .= '<div id="owl-carousel-' . rand() . '" class="owl-carousel" ' . $data_attr . '>';
    }
    
    foreach ($attachments as $id => $attachment) {
        $img = wp_get_attachment_image_src($id, 'full');
        
        $title = $attachment->post_title;


          // $output .= "<div class=\"item\" style=\"height:" . $attr['height'] . "; width:auto;\">";


        $output .= "<div class=\"item\">";
        $lazyImgStr="";
        if(isset($attr['lazyload']) || isset($attr['lazyLoad'])){

          // $lazyImgStr="class=\"owl-lazy\" data-src=\"{$img[0]}\"";

        }
          

        $a_logoResize= "http://cge-uploadfile.qiniudn.com/images/lwlogo.png?imageView/2/h/" . strval(intval($img[2]*0.05)) . "";

        $output .= "<a rel=\"prettyPhoto\" href=\"" . $img[0] . "?watermark/1/image/" . URLSafeBase64Encode( $a_logoResize ) . "/dissolve/50/gravity/SouthEast/dx/35/dy/10" . "\">";

        if (isset($attr['height'])){

          // $output .= "<img src=\"{$img[0]}\" alt=\"$title\" style=\"height:" . $attr['height'] . "; width:" . intval($attr['height']*$img[1]/$img[2]) . "px;\" />\n";
          // $output .= "<img " . $lazyImgStr . " src=\"{$img[0]}\" alt=\"$title\" style=\"height: " . $attr['height'] . "; width: auto; margin: auto;\" />\n";
          $maxWidth = intval(floatval($attr['height'])*$img[1]/$img[2]);
          $logoResize= "http://cge-uploadfile.qiniudn.com/images/lwlogo.png?imageView/2/h/" . strval(intval($attr['height']*0.06)) . "";
          // echo $logoHash;
          $imgTmHash = $img[0] . "?imageView/2/h/" . $attr['height'] . "/q/85/format/JPG" . "|" . "watermark/1/image/" . URLSafeBase64Encode( $logoResize ) . "/dissolve/35/gravity/SouthEast/dx/35/dy/5";
          $output .= "<img " . $lazyImgStr . " src=\"" . $imgTmHash . "\" alt=\"$title\" style=\"max-height:" . $attr['height'] . "px; max-width:" . $maxWidth . "px; margin: auto;\" />\n";


        }else{

          // $output .= "<img " . $lazyImgStr . " src=\"{$img[0]}\" alt=\"$title\" style=\"margin: auto;\"/>\n";
          $output .= "<img " . $lazyImgStr . " src=\"{$img[0]}\" alt=\"$title\" />\n";
          
        }
        $output .= "</a>";

        
        // $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"$title\" />\n";
        // $output .= "<img data-src=\"{$img[0]}\" src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"$title\" />\n";
        // $output .= "<img src=\"{$img[0]}\" alt=\"$title\" />\n";
        $output .= "</div>";


        // $output .= "<img class=\"owl-lazy\" data-src=\"{$img[0]}\" src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"$title\" />\n";


    }

    $output .= "</div>";

    return $output;
}


/**
 * Version 0.3 to 0.4 fix for custom taxonomy
 */
// if ( WP_DEBUG ) {
//             $con = mysqli_connect( 'sqld.duapp.com', DB_USER, DB_PASSWORD, DB_NAME, '4050','' );
//         } else {
//             $con = @mysqli_connect( 'sqld.duapp.com', DB_USER, DB_PASSWORD, DB_NAME, '4050', '' );
//         }
// $con = mysqli_connect( 'sqld.duapp.com', DB_USER, DB_PASSWORD, DB_NAME, '4050','' );
// $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// mysqli_query($con, "UPDATE " . $wpdb->prefix . "term_taxonomy SET taxonomy = 'Carousel' WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM " . $wpdb->prefix . "posts INNER JOIN " . $wpdb->prefix . "term_relationships ON " . $wpdb->prefix . "term_relationships.object_id = " . $wpdb->prefix . "posts.ID WHERE post_type = 'owl-carousel') ");

?>
