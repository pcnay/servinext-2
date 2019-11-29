<?php
  require_once('./Modelo/UsuarioModelo.php');
	// Esta clase validara si existe el usuarios en la base de datos.
	class SesionControlador
	{		
		private $session;
		public function __construct()
		{
			// No es necesario incluir la clase de Models, el autocargador lo realiza.
			// Se tiene que definir una función "UserModel" en la clase "Models" para buscar el usuario en la base de datos.
			$this->session = new UsuarioModelo();

		}
		public function login($user,$pass)
		{
			return $this->session->validate_user($user,$pass);
		}
		public function logout()
		{
			session_start();
			session_destroy();
			header('Location: ./'); // Mostraria la pantalla de Login
		}

	}
?>