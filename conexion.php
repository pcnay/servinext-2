<?php
  class Conexion
  {
    private static $host = 'localhost'; 
    private static $user = 'root';
    private static $password = 'pcnay2003';
    private static $db_name = 'ordenservicios';
    private static $db_charset = 'uft8';
    public $conexion;
    public $query;
    public $rows = array();
  
  
    public function db_open()
    {
      $this->conexion = new mysqli(self::$host,
      self::$user,
      self::$password,
      self::$db_name);   
      
      $this->conexion->set_charset(self::$db_charset);
    }

    public function db_close()
    {
      $this->conexion->close();
    }
    // Establecer un query que afecte datos (INSERT, DELETE, UPDATE ) afectan a los datos.

    public function set_query()
    {
      $this->db_open();
      //$this->conn->query() = Es un método de la clase "mysqli" 
      $this->conexion->query($this->query);
      $this->db_close();
    }

      // Obtener resultados de un Query.
    public function get_query()
    {
      $this->db_open();
      //$this->conn->query() = Es un método de la clase "mysqli" 
      $result = $this->conexion->query($this->query);
      //var_dump($this->query);
      
      // No tiene cuerpo
      // fetch_assoc = Convierte los obtenido de la consulta en arreglo asociativo (Clave , Valor)
      // Obtiene el valor de un registro de la tabla por nombre de campo, es decir cuando se escribe "nombre" nos muestra el contenido.
      //http://php.net/manual/es/mysqli-result.fetch-assoc.php
      // Cada una de las posiciones de "rows" va guardando cada registro de la consulta 
      while ($this->rows[] = $result->fetch_assoc() );

      $result->close(); // Cierra la consulta y limpiarnos la memoria
      $this->db_close();    

      // array_pop =  se utiliza para suprimir el último valor del arreglo, ya que siempre es NULL.
      // http://php.net/manual/es/function.array-pop.php
      //var_dump ($this->rows);
      return array_pop($this->rows);
    }


  } // Class Conexion

  //$conection = @mysqli_connect($host,$user,$password,$db);

  /*
  if (!$conection)
  {
    echo "Error en la conexion";
  } 
  */

?>