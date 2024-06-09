<?php

include "util/connection.php";

class utp_group_dao
{
    // Obtener Estudiante por ID
    public function ObtenerEstudiantePorId($student_id_v)
    {
        $cn = new connection();
        $sql = "CALL ObtenerEstudiantePorId('$student_id_v')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $student = mysqli_fetch_assoc($res);
        mysqli_close($cn->conecta());
        return $student;
    }

    // Obtener Skills por Estudiante
    public function ObtenerSkillsPorEstudiante($student_id_v)
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

    // Obtener Hobbies por Estudiante
    public function ObtenerHobbiesPorEstudiante($student_id_v)
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

    // LOGIN DE USUARIO
    public function validarLogin($student_id_v, $password_v)
    {
        $cn = new connection();
        $sql = "SELECT validarLogin('$student_id_v', '$password_v') AS resultado";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $row = mysqli_fetch_assoc($res);
        $resultado = $row['resultado'];
        mysqli_close($cn->conecta());
        return $resultado === '1';
    }

    // OBTENER CURSOS POR ESTUDIANTE
    public function ObtenerCursosEstudiantePorId($student_id_c)
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

    // OBTENER ESTUDIANTES POR CURSO
    public function ObtenerEstudiantesPorCurso($curso_id_s)
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

    // ACTUALIZAR O INSERTAR SKILLS
    public function GuardarSkills($skills, $student_id) 
    {
        $cn = new connection();
        foreach ($skills as $skill) {
            if (isset($skill['skill_id'])) {
                $sql = "UPDATE skills SET skill_name = ?, skill_topic = ? WHERE skill_id = ?";
                $stmt = $cn->conecta()->prepare($sql);
                $stmt->bind_param("sss", $skill['skill_name'], $skill['skill_topic'], $skill['skill_id']);
            } else {
                $sql = "INSERT INTO skills (student_id, skill_name, skill_topic) VALUES (?, ?, ?)";
                $stmt = $cn->conecta()->prepare($sql);
                $stmt->bind_param("sss", $student_id, $skill['skill_name'], $skill['skill_topic']);
            }
            $stmt->execute();
            $stmt->close();
        }
        mysqli_close($cn->conecta());
    }

    // ACTUALIZAR O INSERTAR HOBBIES
    public function GuardarHobbies($hobbies, $student_id) 
    {
        $cn = new connection();

        // Eliminar todos los hobbies actuales del estudiante
        $sql = "DELETE FROM hobbies WHERE student_id = ?";
        $stmt = $cn->conecta()->prepare($sql);
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $stmt->close();

        // Insertar los nuevos hobbies
        foreach ($hobbies as $hobby_name) {
            $sql = "INSERT INTO hobbies (student_id, hobby_name) VALUES (?, ?)";
            $stmt = $cn->conecta()->prepare($sql);
            $stmt->bind_param("ss", $student_id, $hobby_name);
            $stmt->execute();
            $stmt->close();
        }
        mysqli_close($cn->conecta());
    }

    // ACTUALIZAR DESCRIPCIÓN DEL ESTUDIANTE
    public function ActualizarDescripcionEstudiante($student_id, $description) 
    {
        $cn = new connection();
        $sql = "UPDATE students SET description = ? WHERE student_id = ?";
        $stmt = $cn->conecta()->prepare($sql);
        $stmt->bind_param("ss", $description, $student_id);
        $stmt->execute();
        $stmt->close();
        mysqli_close($cn->conecta());
    }

    // OBTENER CURSO POR ID
    public function ObtenerCursoPorId($course_id) 
    {
        $cn = new connection();
        $sql = "CALL ObtenerCursoPorId('$course_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $curso = mysqli_fetch_assoc($res);
        mysqli_close($cn->conecta());
        return $curso;
    }

    // OBTENER GRUPOS POR CURSO
    function ObtenerGruposPorCursoId($course_id) {
        $cn = new connection();
        $sql = "CALL ObtenerGruposPorCursoId('$course_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $grupos = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $grupos[] = $fila;
        }
        mysqli_close($cn->conecta());
        return $grupos;
    }

    // OBTENER ALUMNOS POR GRUPO
    function ObtenerAlumnosPorGrupoId($group_id) {
        $cn = new connection();
        $sql = "CALL ObtenerAlumnosPorGrupoId('$group_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $alumnos = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $alumnos[] = $fila;
        }
        mysqli_close($cn->conecta());
        return $alumnos;
    }

    // PROCEDURE PARA AGREGAR ALUMNO EN GRUPO
    function AgregarAlumnoEnGrupo($group_id, $student_id) {
        $cn = new connection();
        $sql = "CALL AgregarAlumnoEnGrupo('$group_id', '$student_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        mysqli_close($cn->conecta());
    }

    // PROCEDURE PARA ELIMINAR ALUMNO DEL GRUPO
    function EliminarAlumnoDelGrupo($group_id, $student_id) {
        $cn = new connection();        
        $sql = "CALL EliminarAlumnoDelGrupo('$group_id', '$student_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        mysqli_close($cn->conecta());
    }

    // PROCEDURE PARA EDITAR ROL DEL ALUMNO DEL GRUPO
    function EditarRolAlumnoDelGrupo($group_id, $student_id, $role_id) {
        $cn = new connection();
        $sql = "CALL EditarRolAlumnoDelGrupo('$group_id', '$student_id', '$role_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        mysqli_close($cn->conecta());
    }

    // PROCEDURE PARA OBTENER ROL DEL ALUMNO DEL GRUPO
    function ObtenerRolAlumnoDelGrupo($group_id, $student_id) {
        $cn = new connection();
        $sql = "CALL ObtenerRolAlumnoDelGrupo('$group_id', '$student_id')";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $rol = mysqli_fetch_assoc($res);
        mysqli_close($cn->conecta());
        return $rol;
    }
    
    // PROCEDURE PARA LISTRAR ROLES
    function ListarRoles() {
        $cn = new connection();
        $sql = "CALL ListarRoles()";
        $res = mysqli_query($cn->conecta(), $sql) or die(mysqli_error($cn->conecta()));
        $roles = array();
        while ($fila = mysqli_fetch_assoc($res)) {
            $roles[] = $fila;
        }
        mysqli_close($cn->conecta());
        return $roles;
    }

}

// Comprueba si se ha recibido una solicitud y si la acción es válida
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['accion'])) {
    $utp_group_dao = new utp_group_dao();
    $accion = $_GET['accion'];
    $student_id = $_GET['student_id']; // Recoge el ID del estudiante

    // Dependiendo de la acción, llama a la función correspondiente
    switch ($accion) {
        case 'obtenerEstudiante':
            $resultado = $utp_group_dao->ObtenerEstudiantePorId($student_id);
            break;
        case 'obtenerSkills':
            $resultado = $utp_group_dao->ObtenerSkillsPorEstudiante($student_id);
            break;
        case 'obtenerHobbies':
            $resultado = $utp_group_dao->ObtenerHobbiesPorEstudiante($student_id);
            break;
        default:
            // Si la acción no es válida, devuelve un error
            $resultado = array('error' => 'Acción no válida');
            break;
    }

    // Devuelve los resultados como JSON
    echo json_encode($resultado);
    exit;
}

?>
