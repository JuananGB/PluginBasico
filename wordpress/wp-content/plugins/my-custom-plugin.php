<?php
/*
Plugin Name: My Custom Plugin
Description: Un plugin personalizado para WordPress.
Version: 1.0
Author: Tu Nombre
*/

class MyPlugin {
	private $title;
	private $content;

	public function __construct($title, $content) {
		$this->title = $title;
		$this->content = $content;

		// Registra el método display para ejecutarse en el gancho 'wp_footer'
		add_action('wp_footer', array($this, 'display'));
	}

	public function display() {
		echo "<h2>{$this->title}</h2>";
		echo "<p>{$this->content}</p>";
	}
}

class Database {
	private $conexion;

	public function __construct() {
		// Obtén la dirección IP del contenedor MySQL desde la configuración de WordPress
		$db_host = defined('DB_HOST') ? DB_HOST : 'localhost';

		// Las variables de entorno ahora están definidas en el archivo docker-compose.yml
		$this->conexion = new mysqli($db_host, 'wordpress', 'fimosis', 'wordpress');

		if ($this->conexion->connect_error) {
			die("Error de conexión: " . $this->conexion->connect_error);
		}

		// Crear la tabla si no existe
		$this->createTable();
	}

	private function createTable() {
		$sql = "
            CREATE TABLE IF NOT EXISTS tu_tabla (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

		$result = $this->conexion->query($sql);

		if (!$result) {
			die("Error al crear la tabla: " . $this->conexion->error);
		}
	}

	public function insertData($title, $content) {
		$title = $this->conexion->real_escape_string($title);
		$content = $this->conexion->real_escape_string($content);

		$sql = "INSERT INTO tu_tabla (title, content) VALUES ('$title', '$content')";
		$result = $this->conexion->query($sql);

		if (!$result) {
			die("Error al insertar datos: " . $this->conexion->error);
		}
	}

	public function selectData() {
		$sql = "SELECT * FROM tu_tabla";
		$result = $this->conexion->query($sql);

		if (!$result) {
			die("Error al seleccionar datos: " . $this->conexion->error);
		}

		$data = [];
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;
	}
}

// Activar el plugin solo cuando es necesario (por ejemplo, mediante un shortcode)
add_shortcode('my_custom_plugin_shortcode', 'my_custom_plugin_shortcode');

function my_custom_plugin_shortcode() {
	$title = "Saludo";
	$content = "¡¡Bienvenido a mi página!!";

	$plugin = new MyPlugin($title, $content);

	ob_start(); // Inicia el búfer de salida
	$plugin->display();
	$database = new Database();
	$database->insertData($title, $content);

	$data = $database->selectData();
	//print_r($data);

	return ob_get_clean(); // Devuelve el contenido del búfer de salida
}
