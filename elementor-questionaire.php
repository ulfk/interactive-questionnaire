<?php
/**
 * @package Interactive Questionaire
 */
/*
Plugin Name: Interactive Questionaire
Plugin URI: https://ulf-kuehnle.de
Description: Interactive questionaire as Elementor widget.
Version: 1.0.0
Author: Ulf Kuehnle
Author URI: https://ulf-kuehnle.de/
License: GPLv2
*/


//add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);
add_action('elementor/widgets/widgets_registered', function() {
    include_once "widgets/questionaire-widget.php";
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Questionnaire_Widget());
});


// AJAX Handler für das Speichern der Ergebnisse

// add_action('wp_ajax_save_questionnaire_results', 'handle_questionnaire_results');
// add_action('wp_ajax_nopriv_save_questionnaire_results', 'handle_questionnaire_results');

// function handle_questionnaire_results() {
//     // Nonce verification
//     if (!wp_verify_nonce($_POST['nonce'], 'questionnaire_nonce')) {
//         wp_die('Security check failed');
//     }
    
//     $firstname = sanitize_text_field($_POST['firstname']);
//     $email = sanitize_email($_POST['email']);
//     $results = json_decode(stripslashes($_POST['results']), true);
//     $answers = json_decode(stripslashes($_POST['answers']), true);
    
//     // Daten in Datenbank speichern
//     global $wpdb;
    
//     $table_name = $wpdb->prefix . 'questionnaire_results';
    
//     $wpdb->insert(
//         $table_name,
//         [
//             'firstname' => $firstname,
//             'email' => $email,
//             'results' => json_encode($results),
//             'answers' => json_encode($answers),
//             'created_at' => current_time('mysql')
//         ]
//     );
    
//     // Optional: E-Mail mit Ergebnissen versenden
//     $subject = 'Ihre Fragebogen-Ergebnisse';
//     $message = "Hallo $firstname,\n\nvielen Dank für Ihre Teilnahme. Ihre Top-3-Ergebnisse:\n\n";
    
//     foreach ($results as $index => $result) {
//         $message .= ($index + 1) . ". " . $result['title'] . " (" . $result['percentage'] . "%)\n";
//         $message .= $result['description'] . "\n\n";
//     }
    
//     wp_mail($email, $subject, $message);
    
//     wp_send_json_success(['message' => 'Results saved successfully']);
// }

// Plugin Aktivierung - Datenbank-Tabelle erstellen

// register_activation_hook(__FILE__, 'create_questionnaire_table');

// function create_questionnaire_table() {
//     global $wpdb;
    
//     $table_name = $wpdb->prefix . 'questionnaire_results';
    
//     $charset_collate = $wpdb->get_charset_collate();
    
//     $sql = "CREATE TABLE $table_name (
//         id mediumint(9) NOT NULL AUTO_INCREMENT,
//         firstname varchar(100) NOT NULL,
//         email varchar(100) NOT NULL,
//         results longtext NOT NULL,
//         answers longtext NOT NULL,
//         created_at datetime DEFAULT CURRENT_TIMESTAMP,
//         PRIMARY KEY (id)
//     ) $charset_collate;";
    
//     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//     dbDelta($sql);
// }

// Scripts und Styles einbinden
add_action('wp_enqueue_scripts', 'questionnaire_widget_scripts');

function questionnaire_widget_scripts() {
    wp_enqueue_script('jquery');
    
    wp_enqueue_script(
        'questionnaire-widget',
        plugin_dir_url(__FILE__) . 'assets/questionaire-widget.js',
        ['jquery'],
        '1.0.0',
        true
    );
    
    wp_enqueue_style(
        'questionnaire-widget',
        plugin_dir_url(__FILE__) . 'assets/questionaire-widget.css',
        [],
        '1.0.0'
    );
    
    // AJAX Daten für Frontend
    wp_localize_script('questionnaire-widget', 'questionnaire_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('questionnaire_nonce')
    ]);
}
?>