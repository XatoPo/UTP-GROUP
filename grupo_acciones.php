<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

session_start();

if (isset($_POST['action']) && isset($_POST['group_id']) && isset($_POST['student_id'])) {
    $action = $_POST['action'];
    $group_id = $_POST['group_id'];
    $student_id = $_POST['student_id'];

    $obj = new utp_group_dao();

    if ($action === 'unirse') {
        try {
            $obj->AgregarAlumnoEnGrupo($group_id, $student_id);
            echo 'success';
        } catch (Exception $e) {
            echo 'error: ' . $e->getMessage();
        }
    } elseif ($action === 'salir') {
        $obj->EliminarAlumnoDelGrupo($group_id, $student_id);
        echo 'success';
    }
} else {
    echo 'error';
}
?>
