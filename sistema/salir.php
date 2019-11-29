<?php
  //require_once "./Modelo/UsuarioModelo.php";
  //require_once "SesionControlador.php";
  
  
  //$usuario_session = new SesionControlador();
  // Esta funcion de la clase SessionController, valida si el usuario existe.
  //$usuario_session->logout();
  
  session_start();
  session_destroy();
  // Regresa un nivel, para ejecutar de forma automatica el archivo "index.php"
  header('location: ../');
  
?> 