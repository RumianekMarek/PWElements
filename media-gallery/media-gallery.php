<?php

class PWEMediaGallery {
    public static $rnd_id;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$rnd_id = rand(10000, 99999);

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        // add_action('vc_before_init', array($this, 'inputRange'));
        add_action('init', array($this, 'initVCMapMediaGallery'));
        add_shortcode('pwe_media_gallery', array($this, 'PWEMediaGalleryOutput'));
    }

    /**
     * Initialize VC Map Elements.
     */
    public function initVCMapMediaGallery() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __('PWE Media Gallery', 'pwe_media_gallery'),
                'base' => 'pwe_media_gallery',
                'category' => __('PWE Elements', 'pwe_media_gallery'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                'admin_enqueue_js' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendscript.js',
                'params' => array(
                    array(
                        'type' => 'attach_images',
                        'heading' => __('Select Images', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_images',
                        'description' => __('Choose images from the media library.', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Gallery Catalog', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_catalog',
                        'description' => __('Set a catalog name in /doc/', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),  
                    array(
                        'type' => 'textfield',
                        'heading' => __('Unique ID', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_id',
                        'description' => __('This value has to be unique. Change it in case it`s needed.', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Gallery name', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_name',
                        'description' => __('Set a name that will by displayed at the top of gallery', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),  
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Images clicked', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_clicked',
                        'description' => __('Action after clicking on the image', 'pwe_media_gallery'),
                        'save_always' => true,
                        'value' => array(
                            'Fullscreen' => 'fullscreen',
                            'Linked' => 'linked',
                            'Nothing' => 'nothing',
                        ),
                    ),
                    array(
                        'type' => 'param_group',
                        'heading' => __('Set link', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_links',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => __('Filename(ex. file.png)', 'pwe_media_gallery'),
                                'param_name' => 'media_gallery_filename',
                                'save_always' => true,
                                'admin_label' => true
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Link', 'pwe_media_gallery'),
                                'param_name' => 'media_gallery_link',
                                'save_always' => true,
                                'admin_label' => true
                            ),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Layout', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_layout',
                        'description' => __('Action after clicking on the image', 'pwe_media_gallery'),
                        'param_holder_class' => 'media_gallery_layout',
                        'save_always' => true,
                        'value' => array(
                            'Columns' => 'columns',
                            'Grid' => 'grid',
                            'Justify' => 'flex',
                            'Carousel' => 'carousel',
                            'Slider with thumbnails' => 'slider',
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Aspect Ratio', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_aspect_ratio',
                        'description' => __('Set an aspect ratio for the images', 'pwe_media_gallery'),
                        'save_always' => true,
                        'value' => array(
                            'Default' => '',
                            '1:1' => '1/1',
                            '2:1' => '2/1',
                            '3:2' => '3/2',
                            '4:3' => '4/3',
                            '5:4' => '5/4',
                            '10:3' => '10/3',
                            '16:9' => '16/9',
                            '1:2' => '1/2',
                            '2:3' => '2/3',
                            '3:4' => '3/4',
                            '4:5' => '4/5',
                            '3:0' => '3/10',
                            '9:16' => '9/16',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Gap', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_gap',
                        'description' => __('Set the items gap.', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),  
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Full width', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_full_width',
                        'description' => __('overflow: visible;', 'pwe_media_gallery'),
                        'save_always' => true,
                        'value' => array(__('True', 'pwe_media_gallery') => 'true',),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Thumbnail width (desktop', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_thumbnails_width_desktop',
                        'description' => __('Specify the thumbnail width for desktop.', 'pwe_media_gallery'),
                        'param_holder_class' => 'backend-area-one-third-width thumbnails_width_columns',
                        'save_always' => true,
                        'value' => array(
                            'Default' => '',
                            '12 columns' => '12',
                            '11 columns' => '11',
                            '10 columns' => '10',
                            '9 columns' => '9',
                            '8 columns' => '8',
                            '7 columns' => '7',
                            '6 columns' => '6',
                            '5 columns' => '5',
                            '4 columns' => '4',
                            '3 columns' => '3',
                            '2 columns' => '2',
                            '1 column' => '1',
                        ),
                    ), 
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Thumbnail width (tablet)', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_thumbnails_width_tablet',
                        'description' => __('Specify the thumbnail width for tablet.', 'pwe_media_gallery'),
                        'param_holder_class' => 'backend-area-one-third-width thumbnails_width_columns',
                        'save_always' => true,
                        'value' => array(
                            'Default' => '',
                            '12 columns' => '12',
                            '11 columns' => '11',
                            '10 columns' => '10',
                            '9 columns' => '9',
                            '8 columns' => '8',
                            '7 columns' => '7',
                            '6 columns' => '6',
                            '5 columns' => '5',
                            '4 columns' => '4',
                            '3 columns' => '3',
                            '2 columns' => '2',
                            '1 column' => '1',
                        ),
                    ), 
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Thumbnail width (mobile)', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_thumbnails_width_mobile',
                        'description' => __('Specify the thumbnail width for mobile.', 'pwe_media_gallery'),
                        'param_holder_class' => 'backend-area-one-third-width thumbnails_width_columns',
                        'save_always' => true,
                        'value' => array(
                            'Default' => '',
                            '12 columns' => '12',
                            '11 columns' => '11',
                            '10 columns' => '10',
                            '9 columns' => '9',
                            '8 columns' => '8',
                            '7 columns' => '7',
                            '6 columns' => '6',
                            '5 columns' => '5',
                            '4 columns' => '4',
                            '3 columns' => '3',
                            '2 columns' => '2',
                            '1 column' => '1',
                        ),
                    ),   
                    array(
                        'type' => 'textfield',
                        'heading' => __('Thumbnail height (desktop)(200px def)', 'pwe_media_gallery'),
                        'param_name' => 'thumbnails_height_desktop',
                        'param_holder_class' => 'backend-area-one-third-width thumbnails_height_flex',
                        'description' => __('Write the thumbnail height for desktop.', 'pwe_media_gallery'),
                        'save_always' => true,
                    ), 
                    array(
                        'type' => 'textfield',
                        'heading' => __('Thumbnail height (tablet)(200px def)', 'pwe_media_gallery'),
                        'param_name' => 'thumbnails_height_tablet',
                        'param_holder_class' => 'backend-area-one-third-width thumbnails_height_flex',
                        'description' => __('Write the thumbnail height for tablet.', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),        
                    array(
                        'type' => 'textfield',
                        'heading' => __('Thumbnail height (mobile)(200px def)', 'pwe_media_gallery'),
                        'param_name' => 'thumbnails_height_mobile',
                        'param_holder_class' => 'backend-area-one-third-width thumbnails_height_flex',
                        'description' => __('Write the thumbnail height for mobile.', 'pwe_media_gallery'),
                        'save_always' => true,
                    ),           
                    array(
                        'type' => 'textfield',
                        'heading' => __('Breakpoint for tablet', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_breakpoint_tablet',
                        'description' => __('Set a breakpoint for tablet (default 959px)', 'pwe_media_gallery'),
                        'param_holder_class' => 'backend-area-half-width',
                        'save_always' => true,
                    ),  
                    array(
                        'type' => 'textfield',
                        'heading' => __('Breakpoint for mobile', 'pwe_media_gallery'),
                        'param_name' => 'media_gallery_breakpoint_mobile',
                        'description' => __('Set a breakpoint for mobile (default 480px)', 'pwe_media_gallery'),
                        'param_holder_class' => 'backend-area-half-width',
                        'save_always' => true,
                    ), 
                ),
            ));
        }
    }

    /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('media-gallery.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'media-gallery.css');
        wp_enqueue_style('pwe-media-gallery-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts(){
        $js_file = plugins_url('media-gallery.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'media-gallery.js');
        wp_enqueue_script('pwe-media-gallery-js', $js_file, array('jquery'), $js_version, true);
    }
    
    /**
     * Output method for PWEMediaGallery shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWEMediaGalleryOutput($atts, $content = null) {
        extract(shortcode_atts(array(
            'media_gallery_images' => '',
            'media_gallery_catalog' => '',
            'media_gallery_id' => '',
            'media_gallery_name' => '',
            'media_gallery_clicked' => '',
            'media_gallery_links' => '',
            'media_gallery_layout' => '',
            'media_gallery_aspect_ratio' => '',
            'media_gallery_gap' => '',
            'media_gallery_full_width' => '',
            'media_gallery_thumbnails_width_desktop' => '',
            'media_gallery_thumbnails_width_tablet' => '',
            'media_gallery_thumbnails_width_mobile' => '',
            'thumbnails_height_desktop' => '',
            'thumbnails_height_tablet' => '',
            'thumbnails_height_mobile' => '',
            'media_gallery_breakpoint_tablet' => '',
            'media_gallery_breakpoint_mobile' => '',
        ), $atts));
    
        $media_gallery_images = explode(',', $atts['media_gallery_images']);
        $media_gallery_catalog_url = glob($_SERVER['DOCUMENT_ROOT'] . '/doc/' . $media_gallery_catalog . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);  
        
        $media_gallery_array = [];

        // Add the URLs of the gallery images to the array, if they exist
        foreach ($media_gallery_images as $image_id) {
            $media_gallery_image_url = wp_get_attachment_url($image_id);
            if ($media_gallery_image_url) {
                $media_gallery_array[] = $media_gallery_image_url;
            }
        }

        // Add the URLs of the images from the directory to the array, if they exist
        if (!empty($media_gallery_catalog)) {
            if (!empty($media_gallery_catalog_url)) {
                foreach ($media_gallery_catalog_url as $catalog_image_url) {
                    $media_gallery_array[] = substr($catalog_image_url, strpos($catalog_image_url, '/doc/'));
                }
            }
        }

        // Create unique id for element
        $unique_id = rand(10000, 99999);
        $element_unique_id = 'pweMediaGallery-' . $unique_id;
        $media_gallery_id = ($media_gallery_id == '') ? $element_unique_id : $media_gallery_id;

        // Extracting data from param group
        $media_gallery_links_urldecode = urldecode($media_gallery_links);
        $media_gallery_links_json = json_decode($media_gallery_links_urldecode, true);
        $media_gallery_filename_array = array();
        $media_gallery_link_array = array();
        foreach ($media_gallery_links_json as $media_file) {
            $media_gallery_filename_array[] = $media_file["media_gallery_filename"];
            $media_gallery_link_array[] = $media_file["media_gallery_link"];  
        }
        // Remap the array to use filenames as keys and links as values
        $media_gallery_links_map = array_column($media_gallery_links_json, 'media_gallery_link', 'media_gallery_filename');

        // Set aspect ratio for images
        $aspect_ratio_style = (!empty($media_gallery_aspect_ratio)) ? 'aspect-ratio: ' . $media_gallery_aspect_ratio . '; object-fit: cover;' : '';

        // Set breakpoints fo gallery
        $media_gallery_breakpoint_tablet = ($media_gallery_breakpoint_tablet == '') ? '959' : $media_gallery_breakpoint_tablet;
        $media_gallery_breakpoint_mobile = ($media_gallery_breakpoint_mobile == '') ? '480' : $media_gallery_breakpoint_mobile;

        // Set gap for images
        $media_gallery_gap = (empty($media_gallery_gap)) ? '5' : $media_gallery_gap;

        // Removing px if it exists
        $media_gallery_breakpoint_tablet = str_replace("px", "", $media_gallery_breakpoint_tablet);
        $media_gallery_breakpoint_mobile = str_replace("px", "", $media_gallery_breakpoint_mobile);
        $media_gallery_gap = str_replace("px", "", $media_gallery_gap);
        
        $output = '';

        if (!empty($media_gallery_array)) {

            $layouts = explode(',', $media_gallery_layout);
            $layout_types = ['columns', 'grid', 'flex', 'carousel', 'slider'];
            foreach ($layout_types as $type) {
                if (in_array($type, $layouts)) {
                    switch ($type) {
                        case 'columns':

                            // Set the number of columns in the gallery
                            $columns_thumbnails_desktop = ($media_gallery_thumbnails_width_desktop == '') ? '3' : $media_gallery_thumbnails_width_desktop;
                            $columns_thumbnails_tablet = ($media_gallery_thumbnails_width_tablet == '') ? '2' : $media_gallery_thumbnails_width_tablet;
                            $columns_thumbnails_mobile = ($media_gallery_thumbnails_width_mobile == '') ? '2' : $media_gallery_thumbnails_width_mobile;

                            $output .=  '<style>
                                            /* Columns */
                                            #'. $media_gallery_id .' .pwe-media-gallery {
                                                column-gap: 0;
                                            }
                                            #'. $media_gallery_id .' .pwe-media-gallery-image {
                                                padding: '. $media_gallery_gap .'px;
                                            }
                                            @media (min-width: '. ($media_gallery_breakpoint_tablet + 1) .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery {
                                                    column-count: '. $columns_thumbnails_desktop .';
                                                }
                                            }
                                            @media (max-width: '. $media_gallery_breakpoint_tablet .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery {
                                                    column-count: '. $columns_thumbnails_tablet .';
                                                }
                                            }
                                            @media (max-width: '. $media_gallery_breakpoint_mobile .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery {
                                                    column-count: '. $columns_thumbnails_mobile .';
                                                }
                                            } 
                                        </style>';
                            break;
                        case 'grid':

                            // Set the number of columns in the gallery
                            $grid_thumbnails_desktop = ($media_gallery_thumbnails_width_desktop == '') ? '3' : $media_gallery_thumbnails_width_desktop;
                            $grid_thumbnails_tablet = ($media_gallery_thumbnails_width_tablet == '') ? '2' : $media_gallery_thumbnails_width_tablet;
                            $grid_thumbnails_mobile = ($media_gallery_thumbnails_width_mobile == '') ? '2' : $media_gallery_thumbnails_width_mobile;

                            $output .=  '<style>
                                            /* Grid */
                                            #'. $media_gallery_id .' .pwe-media-gallery {
                                                display: grid;
                                                gap: '. $media_gallery_gap .'px;
                                            } 
                                            @media (min-width: '. ($media_gallery_breakpoint_tablet + 1) .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery {
                                                    grid-template-columns: repeat('. $grid_thumbnails_desktop .', 1fr);
                                                }
                                            }
                                            @media (max-width: '. $media_gallery_breakpoint_tablet .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery {
                                                    grid-template-columns: repeat('. $grid_thumbnails_tablet .', 1fr);
                                                }
                                            }
                                            @media (max-width: '. $media_gallery_breakpoint_mobile .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery {
                                                    grid-template-columns: repeat('. $grid_thumbnails_mobile .', 1fr);
                                                }
                                            }
                                        </style>';
                            break;
                        case 'flex':

                            // Set the height of if images in the gallery
                            $thumbnails_height_desktop = ($thumbnails_height_desktop == '') ? '200px' : $thumbnails_height_desktop;
                            $thumbnails_height_tablet = ($thumbnails_height_tablet == '') ? '200px' : $thumbnails_height_tablet;
                            $thumbnails_height_mobile = ($thumbnails_height_mobile == '') ? '200px' : $thumbnails_height_mobile;

                            $output .=  '<style>
                                            /* Flexbox */
                                            #'. $media_gallery_id .' .pwe-media-gallery {
                                                display: flex;
                                                flex-wrap: wrap;
                                                gap: '. $media_gallery_gap .'px;
                                            }
                                            #'. $media_gallery_id .' .pwe-media-gallery-image {
                                                flex-grow: 1;
                                            }
                                            #'. $media_gallery_id .' .pwe-media-gallery-image img {
                                                width: 100%;
                                                height: 100%;
                                                object-fit: cover;
                                                object-position: top;
                                            }
                                            @media (min-width: '. ($media_gallery_breakpoint_tablet + 1) .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery-image {
                                                    height: '. $thumbnails_height_desktop .';
                                                }
                                            }
                                            @media (max-width: '. $media_gallery_breakpoint_tablet .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery-image {
                                                    height: '. $thumbnails_height_tablet .';
                                                }
                                            }
                                            @media (max-width: '. $media_gallery_breakpoint_mobile .'px) {
                                                #'. $media_gallery_id .' .pwe-media-gallery-image {
                                                    height: '. $thumbnails_height_mobile .';
                                                }
                                            } 
                                        </style>';
                            break;
                        case 'carousel':

                            // Set the width of if images in the carousel
                            $carousel_thumbnails_desktop = ($media_gallery_thumbnails_width_desktop == '') ? '3' : (string) $media_gallery_thumbnails_width_desktop;
                            $carousel_thumbnails_tablet = ($media_gallery_thumbnails_width_tablet == '') ? '2' : (string) $media_gallery_thumbnails_width_tablet;
                            $carousel_thumbnails_mobile = ($media_gallery_thumbnails_width_mobile == '') ? '2' : (string) $media_gallery_thumbnails_width_mobile;

                            $output .=  '<style>
                                            /* Carousel */
                                            #'. $media_gallery_id .' .slides {
                                                gap: '. $media_gallery_gap .'px;
                                            }
                                        </style>';
                            break;
                        case 'slider':

                            break;
                    }
                    break;
                }
            }

            $output .= '
            <div id="'. $media_gallery_id .'" class="pwe-container-media-gallery">
                <div class="pwe-media-gallery-wrapper">';

                    if ($media_gallery_name != '') {
                        $output .= '<div class="pwe-media-gallery-title main-heading-text" style="display: flex; padding-bottom: 36px;">
                                        <h4 class="pwe-uppercase" style="margin: 0;">
                                            <span>'. $media_gallery_name .'</span>
                                        </h4>
                                    </div>';
                    }

                    $simple_layout_types = ['columns', 'grid', 'flex'];
                    if (array_intersect($simple_layout_types, $layouts)) { // Gallery <--------------------------------------<
                        $output .= '<div class="pwe-gallery-container pwe-media-gallery">';
                        foreach ($media_gallery_array as $image_url) {
                            $path_parts = pathinfo($image_url);
                            $image_filename = $path_parts['basename'];
                            
                            if ($media_gallery_clicked === 'linked' && isset($media_gallery_links_map[$image_filename])) {
                                $output .= '<a href="'. $media_gallery_links_map[$image_filename] .'">
                                                <div class="pwe-media-gallery-image">
                                                    <img src="' . $image_url . '" style="' . $aspect_ratio_style . '">
                                                </div>
                                            </a>';
                            } else { 
                                $output .= '<div class="pwe-media-gallery-image">
                                                <img src="' . $image_url . '" style="' . $aspect_ratio_style . '">
                                            </div>';
                            }
                        }
                        $output .= '</div>';  
                    } elseif (in_array('carousel', $layouts)) { // Carousel <--------------------------------------<
                        $aspect_ratio_style = ($aspect_ratio_style == '') ? 'aspect-ratio: 4/3; object-fit: cover;' : $aspect_ratio_style;
                        $output .= '<div class="pwe-gallery-container pwe-media-gallery-carousel">';
                            foreach ($media_gallery_array as $image_url) {
                                $path_parts = pathinfo($image_url);
                                $image_filename = $path_parts['basename'];

                                $media_gallery_urls[] = array(
                                    "img"          => $image_url,
                                    "link"         => $media_gallery_links_map[$image_filename],
                                    "aspect-ratio" => $aspect_ratio_style,
                                    "count-visible-thumbs-desktop" => $carousel_thumbnails_desktop,
                                    "count-visible-thumbs-tablet" => $carousel_thumbnails_tablet,
                                    "count-visible-thumbs-mobile" => $carousel_thumbnails_mobile,
                                    "breakpoint-tablet" => $media_gallery_breakpoint_tablet,
                                    "breakpoint-mobile" => $media_gallery_breakpoint_mobile,
                                );
                            }
                            include_once plugin_dir_path(__FILE__) . '/../scripts/gallery-slider.php';
                            $output .= PWEMediaGallerySlider::sliderOutput($media_gallery_urls);
                        $output .= '</div>';  
                    } elseif (in_array('slider', $layouts)) { // Slider <--------------------------------------<
                        $output .= '<div class="pwe-gallery-container pwe-media-gallery-slider" style="margin: 0 auto; max-width: 1000px;">
                    
                            <link href="/wp-content/plugins/PWElements/media-gallery/fotorama/fotorama.css" rel="stylesheet">

                            <div class="pwe-media-gallery-slider-wrapper" >
                                <div 
                                    id="galleryContainer"
                                    class="fotorama" 
                                    data-allowfullscreen="native" 
                                    data-nav="thumbs" 
                                    data-navposition="middle"
                                    data-thumbwidth="144"
                                    data-thumbheight="96"
                                    data-transition="crossfade" 
                                    data-loop="true" 
                                    data-autoplay="true" 
                                    data-arrows="true" 
                                    data-click="true"
                                    data-swipe="false">';

                                    foreach ($media_gallery_array as $image_url) {
                                        $output .= '<img src="' . $image_url . '" alt="galery image">';
                                    }
                                
                                    $output .= '
                                </div>
                            </div>

                            <script src="/wp-content/plugins/PWElements/media-gallery/fotorama/fotorama.js"></script>
                        
                        </div>';  
                    }

                    $output .= '
                </div>
            </div>';

            if ($media_gallery_clicked !== 'linked' && $media_gallery_clicked !== 'nothing') {
                $output .= '
                    <script>
                    {
                        let enableScrolling = true;
                        window.isDragging = false;

                        const imagesArray = Array.from(document.querySelectorAll("#'. $media_gallery_id .' .pwe-media-gallery-image img"));
                
                        imagesArray.forEach((image, index) => {
                            image.addEventListener("click", (e) => {

                                if (window.isDraggingMedia) {
                                    e.preventDefault(); // Block the opening of the modal if there was movement
                                    window.isDraggingMedia = false; // Reset the flag after the click is handled
                                    return;
                                }

                                // Create popup
                                const popupDiv = document.createElement("div");
                                popupDiv.className = "pwe-media-gallery-popup";

                                // Left arrow for previous image
                                const leftArrow = document.createElement("span");
                                leftArrow.innerHTML = "&#10094;"; // HTML entity for left arrow
                                leftArrow.className = "pwe-media-gallery-left-arrow pwe-media-gallery-arrow";
                                popupDiv.appendChild(leftArrow);

                                // Right arrow for next image
                                const rightArrow = document.createElement("span");
                                rightArrow.innerHTML = "&#10095;"; // HTML entity for right arrow
                                rightArrow.className = "pwe-media-gallery-right-arrow pwe-media-gallery-arrow";
                                popupDiv.appendChild(rightArrow);
                        
                                // Close btn
                                const closeSpan = document.createElement("span");
                                closeSpan.innerHTML = "&times;";
                                closeSpan.className = "pwe-media-gallery-close";
                                popupDiv.appendChild(closeSpan);
                        
                                const popupImage = document.createElement("img");
                                popupImage.src = image.getAttribute("src");
                                popupImage.alt = "Popup Image";
                                popupDiv.appendChild(popupImage);
                        
                                // Add popup to <body>
                                document.body.appendChild(popupDiv);
                                popupDiv.style.display = "flex";

                                disableScroll();
                                enableScrolling = false;

                                // Function to change image in popup
                                let currentIndex = index; // Przechowuj bieżący indeks jako zmienną zewnętrzną

                                const changeImage = (direction) => {
                                    // Zastosowanie klasy fade-out przed zmianą źródła obrazu
                                    popupImage.classList.add("fade-out");
                                    popupImage.classList.remove("fade-in");

                                    setTimeout(() => {
                                        currentIndex += direction;

                                        if (currentIndex >= imagesArray.length) {
                                            currentIndex = 0; // Wraca do pierwszego obrazka
                                        } else if (currentIndex < 0) {
                                            currentIndex = imagesArray.length - 1; // Przechodzi do ostatniego obrazka
                                        }

                                        popupImage.src = imagesArray[currentIndex].getAttribute("src");

                                        // Usunięcie klasy fade-out i dodanie fade-in po zmianie źródła obrazu
                                        popupImage.classList.remove("fade-out");
                                        popupImage.classList.add("fade-in");
                                    }, 100);
                                };

                                leftArrow.addEventListener("click", () => changeImage(-1));
                                rightArrow.addEventListener("click", () => changeImage(1));

                                // Remove popup when clicking the close button
                                closeSpan.addEventListener("click", () => {
                                    popupDiv.remove();
                                    enableScroll();
                                    enableScrolling = true;
                                });

                                // Remove popup when clicking outside the image
                                popupDiv.addEventListener("click", (event) => {
                                    if (event.target === popupDiv) { // Checks if the clicked element is the popupDiv itself
                                        popupDiv.remove();
                                        enableScroll();
                                        enableScrolling = true;
                                    }
                                });
                            });
                        });

                        // Prevent scrolling on touchmove when enableScrolling is false
                        document.body.addEventListener("touchmove", (event) => {
                            if (!enableScrolling) {
                                event.preventDefault();
                            }
                        }, { passive: false });

                        // Disable page scrolling
                        function disableScroll() {
                            document.body.style.overflow = "hidden";
                            document.documentElement.style.overflow = "hidden";
                        }

                        // Enable page scrolling
                        function enableScroll() {
                            document.body.style.overflow = "";
                            document.documentElement.style.overflow = "";
                        }
                }
                </script>';
            }

            $output .= '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let pweMediaGallery = document.querySelectorAll(".pwe-container-media-gallery");
                    pweMediaGallery.forEach((element) => {
                        if (element) {
                            element.style.opacity = 1;
                            element.style.transition = "opacity 0.3s ease";
                        }
                    });
                });
            </script>';

        }

        $output .= '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let pweElement = document.querySelector(".pwelement_'. self::$rnd_id .'");
                let pweElementRow = document.querySelector(".row-container:has(.pwelement_'. self::$rnd_id .')");
                let pweMediaGalleryContainer = pweElement.querySelector(".pwe-container-media-gallery") !== null;

                if (pweMediaGalleryContainer == false) {
                    pweElementRow.classList.add("desktop-hidden", "tablet-hidden", "mobile-hidden");
                }
            });
        </script>';
    
        $output = do_shortcode($output);
        
        $file_cont = '<div class="pwelement pwelement_'. self::$rnd_id .'">' . $output . '</div>';
    
        return $file_cont;

    }
    
}