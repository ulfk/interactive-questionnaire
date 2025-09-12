<?php
/**
 * @package Interactive Questionaire
 */
/*
Plugin Name: Interactive Questionaire
Plugin URI: https://ulf-kuehnle.de
Description: Interactive questionaire as Elementor widget.
Version: 1.1.0
Author: Ulf Kuehnle
Author URI: https://ulf-kuehnle.de/
License: GPLv2
*/


add_action('elementor/widgets/widgets_registered', function() {
    include_once "widgets/questionaire-widget.php";
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Questionnaire_Widget());
});

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
}
?>