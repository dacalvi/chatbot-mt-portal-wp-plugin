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
    echo '<div id="particles-js"></div>';
    
    // Contenido de ejemplo para permitir scroll
    echo '<div style="margin-top: 100vh; padding: 20px;">
        <h2>Contenido de ejemplo</h2>
        <p>Este es un contenido de ejemplo para permitir el scroll.</p>
        <div style="height: 100vh; background: #f5f5f5; padding: 20px; margin: 20px 0;">
            Sección 1
        </div>
        <div style="height: 100vh; background: #e5e5e5; padding: 20px; margin: 20px 0;">
            Sección 2
        </div>
        <div style="height: 100vh; background: #d5d5d5; padding: 20px; margin: 20px 0;">
            Sección 3
        </div>
    </div>';
    //echo '<div class="count-particles"><span class="js-count-particles">--</span> particles</div>';
});

// 2) CSS (estilos del widget + tamaño tipo hero)
add_action('wp_head', function () {
    if (!is_front_page()) return;

    // CSS oficial del widget
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@n8n/chat@latest/dist/style.css" />';
    
    // Particles.js library
    echo '<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>';
    


    // Tus estilos (ajustá altura a gusto; 100vh = pantalla completa)
    echo '<style>


      .chat-layout .chat-header {
        display: none !important;
      }

      

      .n8n-chat-hero {
        width: 600px;
        height: 30vh;      /* Cambiá a 70vh/600px si querés */
        max-height: 1000px;
        background: #fff;
        position: fixed;
        z-index: 10;
        top: 100px;
        left: 100px;
        border-radius: 10px!important;
        overflow: auto !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        opacity: 0.7;
        transition: all 0.3s ease;
      }

      @media (max-width: 768px) {
        .n8n-chat-hero { height: 80vh; }
      }
      
      /* Particles.js styles */
      #particles-js {
        position: absolute;
        width: 100%;
        height: 60vh;
        background-color: #1822b6;
        background-image: url("");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 50% 50%;
        z-index: 1;
        top: 0;
      }
      

    </style>';
}, 20);

// 3) Script ESM en el footer (importando desde CDN)
add_action('wp_footer', function () {
    if (!is_front_page()) return;

    $webhook_url = 'https://n8n-dacalvi.zapto.org/webhook/d7af5f2e-5fc3-4c96-9acd-822e1831eb58/chat';

    // imprimimos un <script type="module"> con el import + createChat()
    echo "<script type='module'>
      import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat@latest/dist/chat.bundle.es.js';

      let chatInstance = null;
      let isEmbedded = false;

      // Función para cambiar el modo del chat
      const toggleChatMode = () => {
        const chatContainer = document.querySelector('#n8n-chatbot-container');
        const particlesArea = document.querySelector('#particles-js');
        
        if (!chatContainer || !particlesArea) return;

        // Crear el observer para el área de partículas
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (!isEmbedded && !entry.isIntersecting) {
              // Cambiar a modo embedded cuando las partículas desaparecen
              isEmbedded = true;
              chatContainer.style.position = 'fixed';
              chatContainer.style.top = '20px';
              chatContainer.style.right = '20px';
              chatContainer.style.left = 'auto';
              chatContainer.style.width = '350px';
              chatContainer.style.height = '500px';
              chatContainer.style.transition = 'all 0.3s ease';
              document.body.style.overflow = 'auto';
            } else if (isEmbedded && entry.isIntersecting) {
              // Volver a modo hero cuando las partículas son visibles
              isEmbedded = false;
              chatContainer.style.position = 'fixed';
              chatContainer.style.top = '100px';
              chatContainer.style.left = '100px';
              chatContainer.style.right = 'auto';
              chatContainer.style.width = '600px';
              chatContainer.style.height = '30vh';
              chatContainer.style.transition = 'all 0.3s ease';
              document.body.style.overflow = 'hidden';
            }
          });
        }, {
          threshold: 0.1 // Trigger cuando 10% del elemento es visible
        });

        // Observar el área de partículas
        observer.observe(particlesArea);
      };

      // Aplicar el observer después de que el chat se cree
      window.addEventListener('load', toggleChatMode);
      
      createChat({
        webhookUrl: '$webhook_url',
        target: '#n8n-chatbot-container',
        mode: 'fullscreen',   // también: 'embedded'
        loadPreviousSession: false,
        // opciones útiles:
        initialMessages: [
		'¡Hola! 👋',
		'¿En qué te puedo ayudar?'
	],
        showHeader: false,
        // theme: { primary: '#111827' }
      });
      

    </script>";

    // Particles.js configuration and initialization
    echo "<script>
      // Initialize particles.js
      particlesJS('particles-js', {
        'particles': {
          'number': {
            'value': 255,
            'density': {
              'enable': true,
              'value_area': 800
            }
          },
          'color': {
            'value': '#6150de'
          },
          'shape': {
            'type': 'circle',
            'stroke': {
              'width': 0,
              'color': '#000000'
            },
            'polygon': {
              'nb_sides': 5
            },
            'image': {
              'src': 'img/github.svg',
              'width': 100,
              'height': 100
            }
          },
          'opacity': {
            'value': 0.4182482500651045,
            'random': true,
            'anim': {
              'enable': false,
              'speed': 1,
              'opacity_min': 0.1,
              'sync': false
            }
          },
          'size': {
            'value': 11.83721462448409,
            'random': false,
            'anim': {
              'enable': false,
              'speed': 40,
              'size_min': 0.1,
              'sync': false
            }
          },
          'line_linked': {
            'enable': true,
            'distance': 150,
            'color': '#ededed',
            'opacity': 0.4,
            'width': 0
          },
          'move': {
            'enable': true,
            'speed': 6,
            'direction': 'right',
            'random': true,
            'straight': true,
            'out_mode': 'out',
            'bounce': false,
            'attract': {
              'enable': false,
              'rotateX': 962.0472365193136,
              'rotateY': 1200
            }
          }
        },
        'interactivity': {
          'detect_on': 'window',
          'events': {
            'onhover': {
              'enable': false,
              'mode': 'bubble'
            },
            'onclick': {
              'enable': true,
              'mode': 'bubble'
            },
            'resize': true
          },
          'modes': {
            'grab': {
              'distance': 400,
              'line_linked': {
                'opacity': 1
              }
            },
            'bubble': {
              'distance': 207.079689136843,
              'size': 20.301930307533627,
              'duration': 3.0046856855149766,
              'opacity': 1,
              'speed': 3
            },
            'repulse': {
              'distance': 200,
              'duration': 0.4
            },
            'push': {
              'particles_nb': 4
            },
            'remove': {
              'particles_nb': 2
            }
          }
        },
        'retina_detect': true
      });


    </script>";
}, 999);
