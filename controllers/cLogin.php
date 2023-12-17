<?php

require_once __DIR__ . '/../models/mLogin.php';

class cLogin {
    public $nombrePagina;

    public $view;

    public $objModelo;

    public $mensajeError;

    function __construct() {
        $this->objModelo = new MLogin();
    }

    public function mostrarFormularioLogin() {
        $this->view = 'vLogin';
        $this->nombrePagina ='';
    }

    public function mostrarVistaAdmin(){
        session_start();
        if (isset($_SESSION['usuario_id']) && isset($_SESSION['tipo_usuario_id']) && $_SESSION['tipo_usuario_id'] == 1) {
            $this->view = 'vAdmin';
            $this->nombrePagina ='';
        } else {
            header("Location: index.php?c=cLogin&m=mostrarVistaError");
            exit();
        }
    }

    public function mostrarVistaNormal(){
        session_start();
        if (isset($_SESSION['usuario_id']) && isset($_SESSION['tipo_usuario_id']) && $_SESSION['tipo_usuario_id'] == 2) {
            $this->view = 'vNormal';
            $this->nombrePagina ='';
        } else {
            header("Location: index.php?c=cLogin&m=mostrarVistaError");
            exit();
        }
    }

    public function mostrarVistaError(){
        $this->view = 'vError';
        $this->nombrePagina ='';
    }


    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $usuario = $this->objModelo->verificarCredenciales($username, $password);

            if ($usuario) {
                // Iniciar sesión
                session_start();

                // Almacenar información del usuario en la sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['tipo_usuario_id'] = $usuario['tipo_usuario_id'];

                // Redireccionar según el tipo de usuario
                if ($_SESSION['tipo_usuario_id'] == 1) {
                    header("Location: index.php?c=cLogin&m=mostrarVistaAdmin");
                    exit();
                } else {
                    // Usuario normal
                    header("Location: index.php?c=cLogin&m=mostrarVistaNormal");
                    exit();
                }
            } else {
                $this->mensajeError = "Credenciales incorrectas. Por favor, inténtelo de nuevo.";
                $this->mostrarFormularioLogin();
            }
        } else {
            // Mostrar formulario de login por defecto
            $this->mostrarFormularioLogin();
        }
    }

    public function cerrarSesion() {

        session_start();
        session_destroy();

        header("Location: index.php");
        exit();
    }
}
?>