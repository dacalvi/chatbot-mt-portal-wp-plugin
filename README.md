# WP N8N Chatbot

Plugin de WordPress que agrega un chatbot basado en **n8n** usando la librería [`@n8n/chat`](https://www.npmjs.com/package/@n8n/chat).

El chatbot se muestra en la parte superior de la página principal del sitio.

---

## 🚀 Instalación

1. Clonar este repositorio dentro de la carpeta `wp-content/plugins` de tu instalación de WordPress:

   ```bash
   cd wp-content/plugins
   git clone https://github.com/TUUSUARIO/wp-n8n-chatbot.git
   
2. Activar el plugin en el admin de WordPress:

Plugins → Activar “N8N Chatbot”.


## Configuracion

Editá el archivo wp-n8n-chatbot.php y reemplazá la URL del webhook de n8n en esta línea:

webhookUrl: 'https://TUSERVIDOR.COM/webhook/chat'


Asegurate de tener un workflow de n8n publicado con un Chat Trigger activo.