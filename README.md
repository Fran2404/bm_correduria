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

5. Añade datos de prueba (opcional):

   Para probar el área de clientes, inserta un usuario:
   ´´´bash
   docker exec -it php-fpm php bin/console doctrine:query:sql "INSERT INTO usuario (email, roles, password, cliente_id) VALUES ('cliente@bmcorreduria.com', '[]', 'hashed_password', 1);"
   docker exec -it php-fpm php bin/console doctrine:query:sql "INSERT INTO cliente (email, nombre, telefono, direccion) VALUES ('cliente@bmcorreduria.com', 'Cliente Prueba', '123456789', 'Calle Falsa 123');"
   Usa una contraseña hasheada (puedes generarla con php bin/console security:encode-password).

6. Accede a la aplicación:

    Abre tu navegador y ve a http://localhost:8000.

Estructura del Proyecto

    src/Controller/: Contiene los controladores (por ejemplo, SecurityController.php para la página principal, RegistrationController.php para el registro).
    src/Entity/: Define las entidades como Usuario.php, Cliente.php, y Poliza.php.
    templates/: Almacena las plantillas Twig, incluyendo:
        base.html.twig: Define la estructura general (navegación, contenido, footer).
        home/index.html.twig: Página de inicio con contenido y carrusel.
        registration/register.html.twig: Formulario de registro.
    public/: Contiene archivos estáticos como imágenes (public/images/ con seguro-auto.jpg, seguro-hogar.jpg, seguro-vida.jpg, salud2.jpg).

Detalles de la página de inicio
Diseño

    Contenido principal:
        Título: "Bienvenido a BM Correduría de Seguros".
        Subtítulo: "Tu tranquilidad es nuestra prioridad. Encuentra el seguro perfecto para ti."
        Texto adicional: "Explora nuestras opciones o contáctanos para más información."
        Botones: "Sobre Nosotros" (/about), "Contacto" (/contact), "Productos" (/products).
    Carrusel de imágenes:
        Ubicado debajo del contenido principal.
        Muestra las imágenes: seguro-auto.jpg, seguro-hogar.jpg, seguro-vida.jpg, y salud2.jpg.
        Cambia automáticamente cada 5 segundos (puedes ajustar el intervalo con data-bs-interval).
        Incluye controles de navegación ("anterior" y "siguiente").
    Footer:
        Fijo en la parte inferior con position: sticky.
        Texto: "© 2025 BM Correduría de Seguros. Todos los derechos reservados."
        Enlace: "Contacto" (/contact).

Archivos involucrados

    Plantilla: templates/home/index.html.twig.
    Imágenes: Guardadas en public/images/. Asegúrate de tener todas las imágenes listadas.

Contribuciones

Si quieres ayudar a mejorar el proyecto:

    Crea un fork del repositorio.
    Haz tus cambios en una nueva rama.
    Envía un pull request con una descripción de los cambios.

Contacto

Para preguntas o soporte, contacta a franveper@example.com o visita la página de "Contacto" en la aplicación (/contact).
Licencia

Este proyecto está bajo la licencia MIT License (puedes cambiarla si usas otra).