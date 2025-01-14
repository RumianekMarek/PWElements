<?php

class pweNavMenu extends PWECommonFunctions {

    public function __construct() {

        $pwe_menu_options = get_option('pwe_menu_options');
		if (isset($pwe_menu_options['pwe_menu_active']) && $pwe_menu_options['pwe_menu_active']) {
            // Hook actions
            add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
            add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        }

        // Registering a function
        add_action('wp_head', array($this, 'pwe_nav_menu'), 5);
    }

    // Styles
    public function addingStyles(){
        $css_file = plugins_url('assets/style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/style.css');
        wp_enqueue_style('nav-menu-css', $css_file, array(), $css_version);
    }

    
    // Scripts
    public function addingScripts(){
        $js_file = plugins_url('assets/script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/script.js');
        wp_enqueue_script('nav-menu-js', $js_file, array('jquery'), $js_version, true);
    }

    // Menu generating function
    public function pwe_nav_menu() { 

        // Get menu location
        $locations = get_nav_menu_locations();

        // Check if 'primary' location is set
        if (isset($locations['primary'])) {
            // Menu ID assigned to location 'primary'
            $menu_id = $locations['primary']; 
            // Get menu items
            $menu = wp_get_nav_menu_items($menu_id); 
        } else {
            // If location doesn't exist, no menu
            $menu = null; 
        }

        if ($menu) {
            $menu_items = array();
            // Menu item group (parents and children)
            foreach ($menu as $item) {
                $menu_items[$item->ID] = $item;
            }

            $output = '';
            
            $output .= '
            <div id="pweMenu" class="pwe-menu">
                <div class="pwe-menu__wrapper">

                    <div class="pwe-menu__main-logo">
                        <a class="pwe-menu__main-logo-ptak ' . (file_exists($_SERVER['DOCUMENT_ROOT'] . self::languageChecker('/doc/logo-x-pl.webp', '/doc/logo-x-en.webp')) ? "hidden-mobile" : "") . '" target="_blank" href="https://warsawexpo.eu'. self::languageChecker('/', '/en/') .'" target="_blank">
                            <img data-no-lazy="1" src="/wp-content/plugins/PWElements/media/logo_pwe.webp" alt="logo ptak">
                        </a>
                        <a class="pwe-menu__main-logo-fair" href="'. self::languageChecker('/', '/en/') .'">';
                            if (self::lang_pl()) {
                                $output .= '<img data-no-lazy="1" src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/doc/logo-x-pl.webp") ? "/doc/logo-x-pl.webp" : "/doc/favicon.webp") . '" alt="logo fair">';
                            } else {
                                $output .= '<img data-no-lazy="1" src="' . (file_exists($_SERVER['DOCUMENT_ROOT'] . "/doc/logo-x-en.webp") ? "/doc/logo-x-en.webp" : "/doc/favicon.webp") . '" alt="logo fair">';
                            }
                        $output .= '
                        </a>
                    </div>

                    <div class="pwe-menu__right-side">
                        <div class="pwe-menu__register-btn">
                            <a href="'. self::languageChecker('/rejestracja/', '/en/registration/') .'">'. self::languageChecker('WEŹ UDZIAŁ', 'TAKE A PART') .'</a>
                        </div>
                        
                        <div class="pwe-menu__burger">
                            <input class="pwe-menu__burger-checkbox" type="checkbox">
                            <span></span>
                        </div>
                    </div>

                    <div class="pwe-menu__container">
                        <ul class="pwe-menu__nav">';
                            
                            foreach ($menu_items as $item) {
                                if ($item->menu_item_parent == 0) {
                                    $has_children = !empty(array_filter($menu_items, function($child) use ($item) {
                                        return $child->menu_item_parent == $item->ID;
                                    }));

                                    $target_blank = !empty($item->target) ? 'target="_blank"' : '';

                                    $output .= '<li class="pwe-menu__item' . ($has_children ? ' has-children' : '') . ' ' . $item->button . '">';
                                    $output .= '<a '. $target_blank .' href="' . esc_url($item->url) . '">' . wp_kses_post($item->title) . ($has_children ? '<span class="pwe-menu__arrow">›</span>' : '') . '</a>';
                                    $output .= $this->display_sub_menu($item->ID, $menu_items);
                                    $output .= '</li>';
                                }
                            }

            $output .= '</ul>';
                        
            $socials = ot_get_option('_uncode_social_list');
            if (!empty($socials)) {
                $output .= '<ul class="pwe-menu__social">';
                foreach ($socials as $social) { 
                    $output .= '<li class="pwe-menu__social-item-link social-icon '.$social['_uncode_social_unique_id'].'">
                                    <a href="'.$social['_uncode_link'].'" class="social-menu-link" target="_blank">
                                        <i class="'.$social['_uncode_social'].'"></i>
                                    </a>
                                </li>';
                }
                $output .= '</ul>';
            }

            $output .= '
                    </div>
                </div>
                <div class="pwe-menu__overlay"></div>
            </div>';

            return $output;
        }
    }

    // Function to display submenu
    private function display_sub_menu($parent_id, $menu_items) {
        // Filter children for a given parent
        $children = array_filter($menu_items, function($item) use ($parent_id) {
            return $item->menu_item_parent == $parent_id;
        });

        if (!empty($children)) {
            $output = '';
            
            $output .= '<ul class="pwe-menu__submenu">';
            foreach ($children as $child) {
                $has_submenu_children = !empty(array_filter($menu_items, function($grandchild) use ($child) {
                    return $grandchild->menu_item_parent == $child->ID;
                }));

                $target_blank = !empty($child->target) ? 'target="_blank"' : '';

                $output .= '<li class="pwe-menu__submenu-item' . ($has_submenu_children ? ' has-children' : '') . '">';
                $output .= '<a '. $target_blank .' href="' . esc_url($child->url) . '">' . wp_kses_post($child->title) . ($has_submenu_children ? '<span class="pwe-menu__arrow">›</span>' : '') . '</a>';
                $output .= $this->display_sub_menu($child->ID, $menu_items);
                $output .= '</li>';
            }
            $output .= '</ul>';

            return $output;
        }

        return ''; // If there are no children
    }


}

// Create a class object
$pwe_nav_menu = new pweNavMenu();

/**
 * Сollapse ADMIN-BAR (Toolbar) into left-top corner.
 *
 * @version 1.0
 */
final class Kama_Collapse_Toolbar {

    public static function init(){
        add_action( 'admin_bar_init', [ __CLASS__, 'hooks' ] );
    }

    public static function hooks(){

        // remove html margin bumps
        remove_action( 'wp_head', '_admin_bar_bump_cb' );

        add_action( 'wp_head', [ __CLASS__, 'collapse_styles' ] );
    }

    public static function collapse_styles(){

        // do nothing for admin-panel.
        // Remove this if you want to collapse admin-bar in admin-panel too.
        if( is_admin() ){
            return;
        }

        ob_start();
        ?>
        <style id="kama_collapse_admin_bar">
            @media screen and ( max-width: 600px ) {
                #wpadminbar{ background:none; float:left; width:auto; height:auto; bottom:0; min-width:0 !important; }
                #wpadminbar > *{ float:left !important; clear:both !important; }
                #wpadminbar .ab-top-menu li{ float:none !important; }
                #wpadminbar .ab-top-secondary{ float: none !important; }
                #wpadminbar .ab-top-menu>.menupop>.ab-sub-wrapper{ top:0; left:100%; white-space:nowrap; }
                #wpadminbar .quicklinks>ul>li>a{ padding-right:17px; }
                #wpadminbar .ab-top-secondary .menupop .ab-sub-wrapper{ left:100%; right:auto; }
                html{ margin-top:0!important; }

                #wpadminbar{ overflow:hidden; width:auto; height:30px; }
                #wpadminbar:hover{ overflow:visible; width:auto; height:auto; background:rgba(102,102,102,.7); }

                /* the color of the main icon */
                #wp-admin-bar-<?= is_multisite() ? 'my-sites' : 'site-name' ?> .ab-item:before{ color:#797c7d; }

                /* hide wp-logo */
                #wp-admin-bar-wp-logo{ display:none; }
                #wp-admin-bar-search{ display:none; }

                /* edit for twentysixteen */
                body.admin-bar:before{ display:none; }

                body.logged-in.admin-bar { padding-top: 0 !important; }

                /* Gutenberg */
                #wpwrap .edit-post-header{ top:0; }
                #wpwrap .edit-post-sidebar{ top:56px; }
                
            }   
        </style>
        <?php
        $styles = ob_get_clean();

        echo preg_replace( '/[\n\t]/', '', $styles ) ."\n";
    }
}

Kama_Collapse_Toolbar::init();

