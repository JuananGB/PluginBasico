# My Custom Plugin for WordPress

### Este es un plugin personalizado para WordPress que agrega un saludo y un mensaje de bienvenida en el pie de página de tu sitio. Además, guarda la información del saludo en una base de datos MySQL.
### 1.Instalación

    Descarga el archivo zip del plugin desde el repositorio.
    Descomprime el archivo y coloca la carpeta resultante en el directorio wp-content/plugins/ de tu instalación de WordPress.
    Activa el plugin desde el panel de administración de WordPress.

### 2.Uso

Puedes mostrar el saludo y el mensaje de bienvenida en cualquier parte de tu sitio utilizando el siguiente shortcode:

bash

[my_custom_plugin_shortcode]

Este shortcode activará el plugin y mostrará el saludo y el mensaje de bienvenida en el pie de página.
Configuración

No se requiere ninguna configuración adicional. El plugin utiliza una clase MyPlugin para mostrar el contenido y una clase Database para gestionar la conexión y almacenamiento de datos en la base de datos.
Base de Datos

El plugin crea una tabla llamada tu_tabla en la base de datos de WordPress con las siguientes columnas:

    id: Identificador único autoincremental.
    title: Título del saludo.
    content: Contenido del mensaje de bienvenida.
    created_at: Fecha y hora de creación del registro.