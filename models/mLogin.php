<?php

class mLogin {
    private $conexion;

    function __construct() {
        require_once __DIR__ . '/../config/configdb.php';
        $this->conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BBDD);
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        if (!$this->conexion->set_charset("utf8")) {
            printf("Error al establecer la conexión a UTF-8: %s\n", $this->conexion->error);
            exit();
        }
    }

    public function verificarCredenciales($username, $password) {
        $username = $this->conexion->real_escape_string($username);
        $password = $this->conexion->real_escape_string($password);

        $sql = "SELECT id, username, tipo_usuario_id FROM usuarios WHERE username = '$username' AND password = '$password'";
        $result = $this->conexion->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

}
?>
