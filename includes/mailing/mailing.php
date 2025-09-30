<?php
/**
 * Plugin Name: PWE Mailing
 */

if ( ! defined('ABSPATH') ) exit;

define('PWEM_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('PWEM_NOTIF_DIR', rtrim(PWEM_PLUGIN_DIR, '/\\') . '/notifications');

require_once __DIR__ . '/core/NotificationProcessor.php';
require_once __DIR__ . '/config/NotificationPresets.php';

class PWEMailing extends PWECommonFunctions {

    public function __construct() {
        // Uruchom po załadowaniu Gravity Forms
        add_action('gform_loaded', [ $this, 'register_resend' ], 20);

        add_action('gform_loaded', [ $this, 'register_resend_platyna' ], 20);
    }

    public function register_resend() {
        if ( defined('DOING_CRON') && DOING_CRON ) return;

        $params = PWE_NotificationPresets::resend([
            'template_dir'      => PWEM_NOTIF_DIR,
            'option_key_prefix' => 'gf_notification_resend_',
            'period'            => 'minutes:1',   // inne: 'daily' | 'weekly' | 'monthly' | 'hourly' | 'minutes:10' | 'hours:6' | 'ttl:900'
        ]);

        PWE_NotificationProcessor::apply($params);
    }

    public function register_resend_platyna() {
        if ( defined('DOING_CRON') && DOING_CRON ) return;

        $params = PWE_NotificationPresets::resend_platyna([
            'template_dir'      => PWEM_NOTIF_DIR,
            'option_key_prefix' => 'gf_notification_resend_platyna_',
            'period'            => 'minutes:1',
        ]);

        PWE_NotificationProcessor::apply($params);
    }
}