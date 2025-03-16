# BM Correduría de Seguros

Bienvenido a la aplicación web "BM Correduría de Seguros", una plataforma para gestionar seguros y ofrecer un área privada para clientes donde pueden ver sus pólizas.

## ¿Qué hace esta aplicación?

- Permite a los usuarios registrarse e iniciar sesión.
- Los clientes pueden ver sus pólizas en el área privada (`/cliente`).
- Los administradores tienen un panel de control (`/admin`) para gestionar usuarios y pólizas.
- La página principal (`/`) muestra información sobre los servicios de la correduría con un carrusel de imágenes.

## Requisitos para usar la aplicación

- PHP 8.2.27 (o superior)
- Composer
- Docker y Docker Compose
- Un navegador web (como Chrome o Firefox)

## Cómo instalar y usar la aplicación

1. **Clona el proyecto (si usas Git):**
   ```bash
   git clone <URL_DEL_REPOSITORIO> ~/bm_correduria
   cd ~/bm_correduria
2. Instala las dependencias de PHP:
   ```bash
   composer install
3. Inicia los contenedores de Docker:

    Asegúrate de tener un archivo docker-compose.yml en la raíz del proyecto.
    
    ´´´bash
    docker-compose up -d

4. Configura la base de datos:
   ´´´bash
   docker exec -it php-fpm php bin/console doctrine:database:create
   docker exec -it php-fpm php bin/console doctrine:schema:update --force

5. Inicia el servidor de desarrollo:
    
    docker exec -it php-fpm symfony server:start -d

6. Accede a la aplicación:

    Abre tu navegador y ve a http://localhost:8000.

## Estructura del Proyecto

- templates/: Contiene las plantillas Twig para las vistas.
- base.html.twig: Plantilla base con diseño responsive y footer fijo.
- index.html.twig: Página de inicio con carrusel y área de clientes.
- src/Controller/: Contiene los controladores Symfony.
- PublicController.php: Maneja las rutas públicas como la página de inicio y contacto.
- docker/: Configuración para el entorno Docker.

## Contribuciones

Si quieres ayudar a mejorar el proyecto:

- Crea un fork del repositorio.
- Haz tus cambios en una nueva rama.
- Envía un pull request con una descripción de los cambios.

## Contacto

Para preguntas o soporte, contacta a franveper@example.com o visita la página de "Contacto" en la aplicación (/contact).
Licencia

Este proyecto está bajo la licencia MIT License (puedes cambiarla si usas otra).