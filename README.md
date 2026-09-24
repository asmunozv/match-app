# Match App 💘

Aplicación web de compatibilidad con PHP + MySQL + Apache + Docker.

## Ejecutar localmente
1. Instala Docker Desktop.
2. Abre esta carpeta en una terminal.
3. Ejecuta:
   docker compose up --build
4. Abre http://localhost:8080

## Funciones
- Registro y login seguro con password_hash/password_verify.
- 30 preguntas.
- Respuestas almacenadas en MySQL.
- Cálculo de compatibilidad entre usuarios.
- Descubrir perfiles.
- Likes.
- Match cuando el like es mutuo.
- Base preparada para agregar chat, fotos y filtros.

Para ponerla en Internet hace falta desplegar los dos servicios y configurar dominio/HTTPS, correo y almacenamiento de imágenes.
