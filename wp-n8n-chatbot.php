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
    echo '<div class="count-particles"><span class="js-count-particles">--</span> particles</div>';
});

// 2) CSS (estilos del widget + tamaño tipo hero)
add_action('wp_head', function () {
    if (!is_front_page()) return;

    // CSS oficial del widget
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@n8n/chat@latest/dist/style.css" />';
    
    // Particles.js library
    echo '<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>';
    
    // Stats.js library
    echo '<script src="https://threejs.org/examples/js/libs/stats.min.js"></script>';

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
      
      .count-particles {
        background: #000022;
        position: absolute;
        top: 48px;
        left: 0;
        width: 80px;
        color: #13E8E9;
        font-size: .8em;
        text-align: left;
        text-indent: 4px;
        line-height: 14px;
        padding-bottom: 2px;
        font-family: Helvetica, Arial, sans-serif;
        font-weight: bold;
        z-index: 5;
        -webkit-user-select: none;
        margin-top: 5px;
        margin-left: 5px;
        border-radius: 0 0 3px 3px;
      }
      
      .js-count-particles {
        font-size: 1.1em;
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

      // Prevenir scroll y saltos
      const preventJumps = () => {
        // Prevenir scroll del body
        document.body.style.overflow = 'hidden';
        
        // Observar cambios en el DOM para detectar cuando se agrega el formulario
        const observer = new MutationObserver((mutations) => {
          const chatContainer = document.querySelector('#n8n-chatbot-container');
          if (chatContainer) {
            // Prevenir scroll en el contenedor del chat
            chatContainer.style.overflow = 'auto';
            chatContainer.style.position = 'fixed';
            
            // Buscar y prevenir submit en formularios
            const forms = chatContainer.querySelectorAll('form');
            forms.forEach(form => {
              if (!form.dataset.prevented) {
                form.dataset.prevented = 'true';
                form.addEventListener('submit', (e) => {
                  e.preventDefault();
                  // Permitir que el evento se propague para que el chat funcione
                });
              }
            });
          }
        });
        
        // Observar cambios en todo el documento
        observer.observe(document.body, {
          childList: true,
          subtree: true
        });
      };

      // Aplicar prevención inmediatamente y después de cargar
      preventJumps();
      window.addEventListener('load', preventJumps);
      
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

      // Stats and particle counter
      var count_particles, stats, update;
      stats = new Stats;
      stats.setMode(0);
      stats.domElement.style.position = 'absolute';
      stats.domElement.style.left = '0px';
      stats.domElement.style.top = '0px';
      document.body.appendChild(stats.domElement);
      count_particles = document.querySelector('.js-count-particles');
      update = function() {
        stats.begin();
        stats.end();
        if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) {
          count_particles.innerText = window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
      };
      requestAnimationFrame(update);
    </script>";
}, 999);
