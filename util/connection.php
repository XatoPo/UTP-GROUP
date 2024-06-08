<?php

class connection
{
    private $cn = null;

    function conecta()
    {
        if ($this->cn == null) {
            $this->cn = mysqli_connect("localhost", "root", "", "utp_group");
            if (!$this->cn) {
                die("Error de conexión: " . mysqli_connect_error());
            }
            else {
                echo "";
            }   
        }
        return $this->cn;
    }

    function desconecta()
    {
        if ($this->cn != null) {
            mysqli_close($this->cn);
        }
    }
}