<?php

class Conexion
{
    private $serverName = "localhost:3306";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "UTP_GROUP";
    private $cn = null;

    function conecta()
    {
        // Verifica si la conexión ya está establecida
        if ($this->cn === null) {
            // Establece la conexión utilizando mysqli_connect
            // Cambia "localhost" por la dirección IP de la máquina si deseas una conexión remota
            $this->cn = mysqli_connect($this->serverName, $this->dbUsername, $this->dbPassword, $this->dbName);

            if (!$this->cn) {
                die("Error de conexión: " . mysqli_connect_error());
            } else {
                echo "Conexión establecida";
            }
        }

        // Devuelve la conexión establecida
        return $this->cn;
    }

    function desconecta()
    {
        // Verifica si la conexión existe antes de cerrarla
        if ($this->cn !== null) {
            // Cierra la conexión utilizando mysqli_close
            mysqli_close($this->cn);
            $this->cn = null;  // Asegura que la variable cn se restablezca
        }
    }
}
?>
