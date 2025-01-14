<?php
add_action('admin_menu', 'pwe_elements_page');

function pwe_elements_page() {
    add_menu_page(
        'PWE Elements',
        'PWE Elements',
        'manage_options',
        'pwe-elements',
        'pwe_elements_render',
        'dashicons-layout',
        8
    );

    // Podmenu dla "Menu Settings"
    add_submenu_page(
        'pwe-elements', // Parent slug
        'Menu Settings', // Page title
        'Menu Settings', // Menu title
        'manage_options', // Capability
        'pwe-elements-menu', // Menu slug
        'pwe_menu_settings_render' // Callback function
    );
}

function pwe_elements_render() {
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'menu';
    echo '
    <div class="wrap">
        <h1>Settings PWE</h1>
        <h2 class="nav-tab-wrapper">
            <a href="?page=pwe-elements&tab=menu" class="nav-tab '. ($active_tab === 'menu' ? 'nav-tab-active' : '') .'">Menu</a>
            <!-- <a href="?page=pwe-elements&tab=other" class="nav-tab '. ($active_tab === 'other' ? 'nav-tab-active' : '') .'">Other</a> -->
        </h2>
        <form method="post" action="options.php">';
            if ($active_tab === 'menu') {
                settings_fields('pwe_menu_options_group');
                do_settings_sections('pwe-menu-settings');
            } 
            // elseif ($active_tab === 'other') {
            //     settings_fields('pwe_other_options_group');
            //     do_settings_sections('pwe-other-settings');
            // }
            submit_button();
            echo '
        </form>
    </div>';
}

function pwe_menu_settings_render() {
    echo '
    <div class="wrap">
        <h1>Menu Settings</h1>
        <form method="post" action="options.php">';
            settings_fields('pwe_menu_options_group');
            do_settings_sections('pwe-menu-settings');
            submit_button();
    echo '
        </form>
    </div>';
}

