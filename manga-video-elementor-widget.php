<?php
/**
 * Plugin Name: Manga Vidéo Elementor Widget
 * Description: Widget personnalisé pour afficher des vidéos manga dans Elementor.
 */

// Vérifiez si Elementor est installé et activé
if ( ! defined( 'ELEMENTOR_PATH' ) ) {
    return;
}

// Ajoutez une action pour enregistrer votre widget
add_action( 'elementor/widgets/widgets_registered', 'register_manga_video_widget' );

function register_manga_video_widget() {
    require_once( __DIR__ . '/class-manga-video-widget.php' );
    
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Manga_Video_Widget() );
}
