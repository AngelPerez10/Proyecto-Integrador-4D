<?php
class Database {
	private $conexion;

	public function __construct() {
		$this->conexion = new mysqli('localhost', 'root', '', 'fadama');
		if ($this->conexion->connect_error) {
			die('Error de conexión (' . $this->conexion->connect_errno . ') ' . $this->conexion->connect_error);
		}
	}

	public function obtenerConexion() {
		return $this->conexion;
	}

	public function cerrarConexion() {
		$this->conexion->close();
	}
}
?>
