<?php 

/**
 * Class PWElementPosts
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementPosts extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Category', 'pwelement'),
                'param_name' => 'posts_category',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Posts count', 'pwelement'),
                'param_name' => 'posts_count',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Aspect ratio', 'pwelement'),
                'param_name' => 'posts_ratio',
                'description' => __('Default 1/1', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Button link', 'pwelement'),
                'param_name' => 'posts_link',
                'description' => __('Default aktualnosci-news', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Hide posts button', 'pwelement'),
                'param_name' => 'posts_btn',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Display all categories (<= 5 posts)', 'pwelement'),
                'param_name' => 'posts_all_cat',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Display all posts (> 5 posts)', 'pwelement'),
                'param_name' => 'posts_all',
                'description' => __('View all posts in such categories (more than 5 posts)', 'pwelement'),
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Full width', 'pwelement'),
                'param_name' => 'posts_full_width',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementPosts',
                ),
            ),
        );
        return $element_output;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . ' !important;';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '! important; border-width: 0 !important;';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . ' !important;';
        $btn_shadow_color = '9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black') . ' !important;';
        $btn_border = '1px solid ' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . ' !important;';

        extract( shortcode_atts( array(
            'posts_category' => '',
            'posts_count' => '',
            'posts_ratio' => '',
            'posts_link' => '',
            'posts_btn' => '',
            'posts_all_cat' => '',
            'posts_all' => '',
            'posts_full_width' => '',
        ), $atts )); 

        $trade_end = do_shortcode('[trade_fair_enddata]');
        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);

        $posts_title = "";
        if(get_locale() == "pl_PL") {
            $posts_title = ($posts_title == "") ? "Aktualności" : $posts_title;
            $posts_link = ($posts_link == "") ? "/aktualnosci/" : $posts_link;
            $posts_text = "Zobacz wszystkie";
        } else {
            $posts_title = ($posts_title == "") ? "News" : $posts_title;
            $posts_link = ($posts_link == "") ? "/en/news/" : $posts_link;
            $posts_text = "See all";
        }
        $posts_count = ($posts_count == "") ? 5 : $posts_count;
        $posts_ratio = ($posts_ratio == "") ? "1/1" : $posts_ratio;

        $output = '
        <style>
            .pwelement_'.self::$rnd_id.' .pwe-btn {
                color: '. $btn_text_color .';
                background-color:'. $btn_color .';
                box-shadow:'. $btn_shadow_color .';
                border:'. $btn_border .';
            }
            .pwelement_'.self::$rnd_id.' .pwe-btn:hover {
                color: #000000 !important;
                background-color: #ffffff !important;
                border: 1px solid #000000 !important;
            }
            .row-parent:has(.pwelement_'.self::$rnd_id.' .pwe-container-posts) {
                max-width: 100%;
                padding: 0 !important;
            }
            .pwelement_'.self::$rnd_id.' .pwe-posts-wrapper {
                max-width: 1200px; 
                margin: 0 auto; 
                padding: 36px;  
            } 
            .pwelement_'. self::$rnd_id .' .pwe-posts {
                display: flex;
                justify-content: center;
                gap: 18px;
                padding-bottom: 18px;
                opacity: 0;
            }
            .pwelement_'. self::$rnd_id .' .pwe-post-title {
                margin: 0;
                padding: 10px 0 0 10px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-posts-title h4 {
                margin: 0 0 36px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-post-thumbnail .image-container {
                width: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                aspect-ratio: '. $posts_ratio .';
                box-shadow: 9px 9px 0px -6px [trade_fair_main2];
            }
            .pwelement_'. self::$rnd_id .' .pwe-posts .slides {
                align-items: flex-start !important;
                gap: 16px;
            }
            @media (max-width: 1128px) {
                .pwelement_'.self::$rnd_id.' .pwe-posts-wrapper {
                    padding: 36px;  
                } 
            }
        </style>';
    
        // Display all categories across the full width of the page
        if ($posts_full_width === 'true' && $mobile != 1) {
            $output .= '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-posts-wrapper {
                    max-width: 100% !important;  
                    padding: 36px 0 !important; 
                }
                .pwelement_'. self::$rnd_id .' .pwe-posts-title {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding-left: 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-posts .slides {
                    margin-right: 36px !important;
                    gap: 36px !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-post .t-entry-visual,
                .pwelement_'. self::$rnd_id .' .pwe-post .image-container,
                .pwelement_'. self::$rnd_id .' .pwe-post .pwe-post-thumbnail {
                    min-width: 300px !important;
                    max-width: 300px !important;
                }
            </style>';
        }   
        
        $output .= '<div id="pwePosts" class="pwe-container-posts">
                        
            <div class="pwe-posts-wrapper">
        
                <div class="pwe-posts-title main-heading-text">
                    <h4 class="pwe-uppercase"><span>' . $posts_title . '</span></h4>
                </div>  
                <div class="pwe-posts">';
        
                if (strlen($trade_end) <= 10) { // Assuming the date format is 'Y/m/d'
                    $trade_end .= ' 17:00'; // Adding '17:00' to the date
                }
                $trade_end_date = DateTime::createFromFormat('Y/m/d H:i', $trade_end);
                $now = new DateTime();
        
                if ($trade_end_date !== false) {
                    // Getting the year from the end date of the fair
                    $trade_end_year = $trade_end_date->format('Y');
        
                    // Create a category name with the "news-" prefix and the year
                    $category_year = 'news-' . $trade_end_year;

                    // Check if `$posts category` is set and not empty
                    if (!empty($posts_category) && term_exists($posts_category, 'category')) {
                        // We only use categories from `$posts category`
                        $categories = $posts_category;
                    } else {
                        // Create an array for categories
                        $categories_array = [];
                        // Add a categories to the array, if it's exists
                        if (term_exists($category_year, 'category')) {
                            // Check if a category with the "news-" prefix and year exists
                            array_push($categories_array, $category_year);
                        }
                        if (term_exists("current", 'category')) {
                            // Check if category "current" exists
                            array_push($categories_array, "current");
                        }
                       

                        // Transform the category array into a string
                        $categories = implode(',', $categories_array);
                    }
        
                    $max_posts = ($posts_all !== 'true') ? min($posts_count, 5) : -1;
        
                    $args = array(
                        'posts_per_page' => $max_posts,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'category_name' => $categories,
                    );

                    $query = new WP_Query($args);

                    $posts_displayed = $query->post_count;

                    $post_image_urls = array();
                    if ($query->have_posts()) {
                        while ($query->have_posts()) : $query->the_post();
                            $link = get_permalink();
                            $image = has_post_thumbnail() ? get_the_post_thumbnail_url(null, 'full') : '';
                            $title = get_the_title();

                            $post_image_urls[] = array(
                                "img" => $image,
                                "link" => $link,
                                "title" => $title
                            );
                            
                        endwhile;
                    }
        
                    wp_reset_postdata();

                    include_once plugin_dir_path(__FILE__) . '/../scripts/posts-slider.php';
                    $output .= PWEPostsSlider::sliderOutput($post_image_urls);

                } else {
                    echo 'Błąd: Nieprawidłowy format daty.';
                    return;
                }
        
                $output .= '</div>';
                if ($posts_btn !== "true") {
                    $output .= '
                    <div class="pwe-btn-container" style="padding-top: 18px;">
                        <span>
                            <a class="pwe-link btn pwe-btn" href="'. $posts_link .'">'. $posts_text .'</a>
                        </span>
                    </div>';
                }
                
            $output .= '</div>
                        
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const pwePostsElement = document.querySelector(".pwelement_'.self::$rnd_id.' .pwe-posts");
                const pweSliderElement = document.querySelector(".pwe-posts .slides");
                const pwePostsRow = document.querySelector(".row-container:has(.pwe-posts)");
                pwePostsElement.style.opacity = 1;
                pwePostsElement.style.transition = "opacity 0.3s ease";
                if ((pwePostsElement && pwePostsElement.children.length === 0) || (pweSliderElement && pweSliderElement.children.length === 0)) {
                    pwePostsRow.classList.add("desktop-hidden", "tablet-hidden", "mobile-hidden");
                }
            });
        </script>';

        return $output;

    }
}