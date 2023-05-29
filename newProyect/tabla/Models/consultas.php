<?php
require_once('db/db.php');

class Parking {
	private $conexion;

	public function __construct() {
		$db = new Database();
		$this->conexion = $db->obtenerConexion();
	}

	public function obtenerDatos() {
		$sql="SELECT * from parking";
		$result=$this->conexion->query($sql);
		return $result;
	}
}
?>
