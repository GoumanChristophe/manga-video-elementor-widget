<?php
class Manga_Video_Widget extends \Elementor\Widget_Base {

    // Add the constructor right after the class opening
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        $this->init_shortcodes();
    }

    // Now, add the init_shortcodes method
    public function init_shortcodes() {
        add_shortcode('manga_video_embed', [self::class, 'manga_video_embed_shortcode']);
        add_shortcode('manga_video_buttons', [self::class, 'manga_video_shortcode']);
    }

    // Only one get_name method
    public function get_name() {
        return 'manga_video';
    }

    public function get_title() {
        return __( 'Manga Vidéo', 'plugin-name' );
    }

    public function get_icon() {
        return 'fa fa-video';
    }

    public function get_categories() {
        return [ 'general' ];
    }
    
    protected function _register_controls() {
        // Start a section for the content
        $this->start_controls_section(
            'button_container_style_section',
            [
                'label' => __( 'Button Container Style', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


// Contrôle pour la marge intérieure du conteneur de boutons
$this->add_responsive_control(
    'button_container_padding',
    [
        'label' => __( 'Padding', 'plugin-name' ),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => [ 'px', 'em', '%' ],
        'selectors' => [
            '{{WRAPPER}} .video-button-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();
        
        // Commencez une section pour le style
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'plugin-name' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        // Ajoutez vos contrôles de style ici
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Typography', 'plugin-name' ),
                'selector' => '{{WRAPPER}} button',
            ]
        );
        
        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} button' => 'color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_control(
            'button_background_color',
            [
                'label' => __( 'Button Background Color', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} button' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => __( 'Button Border', 'plugin-name' ),
                'selector' => '{{WRAPPER}} button',
            ]
        );
        
        $this->add_control(
            'button_border_radius',
            [
                'label' => __( 'Border Radius', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => __( 'Button Shadow', 'plugin-name' ),
                'selector' => '{{WRAPPER}} button',
            ]
        );
        
        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __( 'Button Padding', 'plugin-name' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        
        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} button',
            ]
        );
        // Fin de la section pour le style
        $this->end_controls_section();
    }
    
    protected function render() {
        // Récupérez l'ID du post actuel
        $post_id = get_the_ID();
    
        // Récupérer la catégorie principale du post
        //$category = get_the_category($post_id);
		
        //$primary_category_id = ($category) ? $category[0]->cat_ID : null;
    
        // Récupérer la catégorie parent
        //$parent_category = ($primary_category_id) ? get_category($category[0]->category_parent) : null;
        //$parent_category_link = (!is_wp_error($parent_category) && $parent_category->term_id) ? get_category_link($parent_category->term_id) : "#";
    
        // Obtenez le post précédent et suivant dans la catégorie principale
        //$prev_post = get_adjacent_post(true, '', true, $primary_category_id);
        //$next_post = get_adjacent_post(true, '', false, $primary_category_id);
        
		//@Tom
		//Code permettant de récupérer la vidéo précédente et suivante
    	$prev_post = get_previous_post(true, '', 'category');
    	$next_post = get_next_post(true, '', 'category');
		
        $prev_post_url = $prev_post ? get_permalink($prev_post->ID) : "#";
        $next_post_url = $next_post ? get_permalink($next_post->ID) : "#";
		
		//@Tom
		//Récupération de l'anime ID, puis de l'url de la fiche de l'anime
		$anime_page_id = get_post_meta($post_id, 'manga_video_anime_main_page', true);
		$fiche_post_url = get_permalink($anime_page_id);
    
        // Début du conteneur pour les boutons
        echo '<div class="video-button-container">';
    
        // Affichage des boutons
        for ($i = 1; $i <= 5; $i++) {
			$video_iframe = get_post_meta($post_id, 'manga_video_url_' . $i, true);
			if (!empty($video_iframe)) {
            	echo '<button id="bouton_' . $i . '">Lecteur ' . $i . '</button>';
			}
        }
    
        // Fin du conteneur pour les boutons
        echo '</div>';
    
        // Début du conteneur pour les vidéos
        echo '<div class="video-container">';
    
        // Boucle pour afficher toutes les vidéos (mais toutes cachées sauf la première)
        for ($i = 1; $i <= 5; $i++) {
            $video_iframe = get_post_meta($post_id, 'manga_video_url_' . $i, true);
            $display_style = ($i == 1) ? '' : 'style="display:none;"';
			$data_play = ($i == 1) ? 'ok' : 'nok';
            if (!empty($video_iframe)) {
                echo '<div data-play="'.$data_play.'" id="lecteur_' . $i . '" ' . $display_style . '>' . $video_iframe . '</div>';
            }
        }
    
        // Fin du conteneur pour les vidéos
        echo '</div>';

        // Boutons de navigation
        echo '<div class="navigation-buttons" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">';
        echo '<button data-url="' . $prev_post_url . '">Précédent</button>';
        echo '<button data-url="' . $fiche_post_url . '">Fiche</button>';
        echo '<button data-url="' . $next_post_url . '">Suivant</button>';
    
        // Script JavaScript pour la gestion des boutons et du changement de vidéos
        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const buttons = document.querySelectorAll("[id^=\'bouton_\']");
                const iframes = document.querySelectorAll("[id^=\'lecteur_\']");
    
                buttons.forEach(button => {
                    button.addEventListener("click", function() {
                        const btnNumber = this.id.split("_")[1];
    
                        iframes.forEach(iframe => {
                            iframe.style.display = "none"; // cache tous les iframes
							const internal_iframe = iframe.getElementsByTagName("iframe")[0];
							if(iframe.getAttribute("data-play") === "ok"){
								internal_iframe.src = internal_iframe.src;
								iframe.setAttribute("data-play", "nok");
							}
                        });
						
    
                        const targetIframe = document.getElementById("lecteur_" + btnNumber);
                        targetIframe.style.display = "block"; // affiche l\'iframe correspondant au bouton cliqué
						targetIframe.setAttribute("data-play", "ok");
                    });
                });
            });
        </script>
        ';
    
        echo '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const navButtons = document.querySelectorAll(".navigation-buttons button");
    
                navButtons.forEach(button => {
                    button.addEventListener("click", function() {
                        const url = this.getAttribute("data-url");
                        if(url !== "#") {
                            window.location.href = url;
                        }
                    });
                });
            });
        </script>
        ';
    }
    // Shortcode pour afficher l'embed de la vidéo principale
function manga_video_embed_shortcode($atts) {
    global $post;
    
    if($post->post_type !== 'manga_video') return;

    $embed_code = get_post_meta($post->ID, 'manga_video_url_1', true);

    return $embed_code;
}


// Shortcode modifié avec des boutons de navigation
function manga_video_shortcode($atts) {
    global $post;
    
    if($post->post_type !== 'manga_video') return;

    $output = '<div class="manga-video-embeds">';

    for ($i = 1; $i <= 5; $i++) {
        $embed_code = get_post_meta($post->ID, 'manga_video_url_' . $i, true);
        $lecteur_name = get_post_meta($post->ID, 'manga_video_lecteur_name_' . $i, true);

        if (!empty($embed_code) && !empty($lecteur_name)) {
            $output .= '<div class="manga-video-embed">' . $embed_code . '</div>';
        }
    }

    // Ajout des boutons
    $prev_post = get_previous_post(true, '', 'category');
    $next_post = get_next_post(true, '', 'category');
    $anime_page_id = get_post_meta($post->ID, 'manga_video_anime_main_page', true);
    
    $output .= '<div class="manga-navigation-buttons">';
    if ($prev_post) {
        $output .= '<a href="' . get_permalink($prev_post->ID) . '" class="manga-prev-button">Précédent</a>';
    }
    if ($next_post) {
        $output .= '<a href="' . get_permalink($next_post->ID) . '" class="manga-next-button">Suivant</a>';
    }
    if ($anime_page_id) {
        $output .= '<a href="' . get_permalink($anime_page_id) . '" class="manga-anime-page-button">Fiche</a>';
    }
    $output .= '</div>';

    $output .= '</div>';
    return $output;
}


}    