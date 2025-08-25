<?php
/**
 * Plugin Name: N8N Chatbot (CDN Module)
 * Description: Inserta un chatbot (n8n) arriba de la home usando @n8n/chat vía CDN con type="module".
 * Version: 1.0.1
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1) Contenedor arriba de la home
add_action('wp_body_open', function () {
    if (!is_front_page()) return;
    echo '<div id="n8n-chatbot-container" class="n8n-chat-hero"></div>';
});

// 2) CSS (estilos del widget + tamaño tipo hero)
add_action('wp_head', function () {
    if (!is_front_page()) return;

    // CSS oficial del widget
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@n8n/chat@latest/dist/style.css" />';

    // Tus estilos (ajustá altura a gusto; 100vh = pantalla completa)
    echo '<style>
      .n8n-chat-hero {
        width: 100%;
        height: 100vh;      /* Cambiá a 70vh/600px si querés */
        max-height: 1000px;
        background: #fff;
      }
      @media (max-width: 768px) {
        .n8n-chat-hero { height: 80vh; }
      }
    </style>';
}, 20);

// 3) Script ESM en el footer (importando desde CDN)
add_action('wp_footer', function () {
    if (!is_front_page()) return;

    $webhook_url = '';

    // imprimimos un <script type="module"> con el import + createChat()
    echo "<script type='module'>
      import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat@latest/dist/chat.bundle.es.js';

      createChat({
        webhookUrl: '$webhook_url',
        target: '#n8n-chatbot-container',
        mode: 'fullscreen',   // también: 'embedded'
        // opciones útiles:
        // initialMessage: '¡Hola! ¿En qué te ayudo?',
        // showHeader: true,
        // theme: { primary: '#111827' }
      });
    </script>";
}, 999);
