<?php

include "util/connection.php";

class utp_group_dao {

    // LOGIN DE USUARIO
    function validarLogin($student_id_v, $password_v)
    {
        $cn = new connection();
        $sql = "SELECT validarLogin('$student_id_v', '$password_v') AS resultado";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $row = mysqli_fetch_assoc($res);
        $resultado = $row['resultado'];
        return $resultado === '1';
    }

     // OBTENER DATOS DE USUARIO POR CORREO
     function obtenerEstudiantePor($usuario_correo)
     {
         $cn = new connection();
         $sql = "CALL ObtenerUsuarioPorCorreo('$usuario_correo')";
         $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
         $row = mysqli_fetch_assoc($res);
         $codigo_usuario = $row['COD_USER'];
         return $codigo_usuario;
     }

}

?>