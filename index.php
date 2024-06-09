<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

// Inicia la sesión
session_start();

if (isset($_SESSION['student_id'])) {
    header("Location: courses.php");
    exit();
}

$obj = new utp_group_dao();
$mensaje_error = '';
// Verifica si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentId = filter_input(INPUT_POST, 'student_id', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (!preg_match('/^U/i', $studentId)) {
        $mensaje_error = "El ID del estudiante debe comenzar con la letra 'U' o 'u'.";
    } else {
        if ($obj->validarLogin($studentId, $password)) {
            $_SESSION['user_id'] = $studentId;  // Cambiado a 'user_id' para ser más apropiado si no es un email
            header("Location: inicio.php");
            exit();
        } else {
            $mensaje_error = "Credenciales incorrectas. Intente de nuevo.";
        }
    }
    
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión | UTP + class</title>
    <link rel="shortcut icon" href="images/icon/favicon-utp-class.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f6f9ff] h-screen flex items-center justify-center">
    <main>
        <div class="grid grid-cols-2 w-[1200px] bg-white rounded-xl overflow-hidden">
            <div class="bg-[#f6f9ff] flex items-center justify-center">
                <img src="images/login/web-login-pao.png" alt="Illustration" class="h-full object-cover">
            </div>
            <div class="flex flex-col items-center justify-center p-10 gap-y-5">
                <div class="flex flex-col items-center gap-y-1 mb-5">
                    <img src="images/logo/logo-pao-class.png" class="w-56" alt="UTP + class">
                </div>
                <h3 class="font-bold text-3xl mb-5 text-gray-700">La nueva experiencia digital de aprendizaje</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="w-full max-w-xs">
                    <div class="flex flex-col relative mb-5">
                        <input class="peer bg-[#f6f9ff] rounded-md border-2 p-2 focus:outline-none placeholder-transparent focus:border-black border-gray-400" type="text" name="student_id" id="student_id" placeholder="Correo electrónico" required>
                        <label class="absolute bg-[#f6f9ff] inline-flex px-2 left-2 -top-3 text-sm text-black transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-black peer-focus:text-sm peer-focus:px-2" for="student_id">Código UTP</label>
                    </div>
                    <div class="flex flex-col relative mb-5">
                        <input class="peer bg-[#f6f9ff] rounded-md border-2 p-2 focus:outline-none placeholder-transparent focus:border-black border-gray-400" type="password" name="password" id="password" placeholder="Contraseña" required>
                        <label class="absolute bg-[#f6f9ff] inline-flex px-2 left-2 -top-3 text-sm text-black transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-black peer-focus:text-sm peer-focus:px-2" for="password">Contraseña</label>
                    </div>
                    <a class="text-blue-600 hover:underline mb-5 block text-right" href="#">Restablecer contraseña</a>
                    <input type="submit" value="Iniciar sesión" name="iniciar_sesion" class="bg-blue-600 w-full py-2 rounded-lg text-white border border-blue-600 hover:bg-white hover:text-blue-600 transition">
                </form>
                <?php if (!empty($mensaje_error)) { ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?php echo $mensaje_error; ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
</body>

</html>