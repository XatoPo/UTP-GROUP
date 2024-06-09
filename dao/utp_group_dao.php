<?php

include "util/connection.php";

class utp_group_dao
{

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
    function ObtenerEstudiantePorId($student_id_v)
    {
        $cn = new connection();
        $sql = "CALL ObtenerEstudiantePorId('$student_id_v')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $student = mysqli_fetch_assoc($res);
        mysqli_close($cn->conecta());
        return $student;
    }

    function ObtenerCursosEstudiantePorId($student_id_c)
    {
        $cn = new connection();
        $sql = "CALL ObtenerCursosEstudiantePorId('$student_id_c')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));

        // Obtener todas las filas de resultado
        $cursos = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $cursos[] = $fila;
        }

        mysqli_close($cn->conecta());
        return $cursos;
    }
        
    // OBTENER SKILLS DE USUARIO POR ESTUDIANTE
    function ObtenerSkillsPorEstudiante($student_id_v)
    {
        $cn = new connection();
        $sql = "CALL ObtenerSkillsPorEstudiante('$student_id_v')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $skills = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $skills[] = $fila;
        }
        mysqli_close($cn->conecta());
        return $skills;
    }

        // OBTENER HOBBIES DE USUARIO POR ESTUDIANTE
    function ObtenerHobbiesPorEstudiante($student_id_v)
    {
        $cn = new connection();
        $sql = "CALL ObtenerHobbiesPorEstudiante('$student_id_v')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $hobbies = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $hobbies[] = $fila;
        }
        mysqli_close($cn->conecta());
        return $hobbies;
    }

    function ObtenerEstudiantesPorCurso($curso_id_s)
    {
        $cn = new connection();
        $sql = "CALL ObtenerEstudiantesPorCursoId('$curso_id_s')";
        
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $estudiantes = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $estudiantes[] = $fila;
        }
        mysqli_close($cn->conecta());
        return $estudiantes;
    }
}

?>