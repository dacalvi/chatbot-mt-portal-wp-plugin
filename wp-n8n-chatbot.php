<?php
/**
 * Plugin Name: N8N Chatbot
 * Description: Agrega un chatbot de n8n en la parte superior de la página principal.
 * Version: 1.0.0
 * Author: Daniel Calvi
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acceso directo
}

// Registrar el script del chatbot
add_action('wp_enqueue_scripts', function() {
    // Cargar CSS propio
    wp_enqueue_style(
        'n8n-chatbot-style',
        plugin_dir_url(__FILE__) . 'assets/style.css',
        array(),
        '1.0.0'
    );
    
    // Cargar la librería de @n8n/chat desde un CDN o bundle propio
    wp_enqueue_script(
        'n8n-chat',
        'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js',
        array(),
        null,
        true
    );

    // Inicializar el chat en frontend
    wp_add_inline_script('n8n-chat', "
        document.addEventListener('DOMContentLoaded', function() {
            const widget = new window.N8nChat({
                webhookUrl: 'https://TUSERVIDOR.COM/webhook/chat', // tu endpoint en n8n
                target: '#n8n-chatbot-container',
                mode: 'fullscreen', // puede ser 'fullscreen', 'embedded'
            });
        });
    ");
});

// Mostrar el contenedor del chat en la parte superior de la home
add_action('wp_body_open', function() {
    if (is_front_page()) {
        echo '<div id="n8n-chatbot-container" style="width:100%;height:500px;background:#fff;"></div>';
    }
});
