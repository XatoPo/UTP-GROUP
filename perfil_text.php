<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

session_start();

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];
    $obj = new utp_group_dao();
    $skills = $obj->ObtenerSkillsPorEstudiante($student_id);
    $hobbies = $obj->ObtenerHobbiesPorEstudiante($student_id);
    $student = $obj->ObtenerEstudiantePorId($student_id);

    // Separar las habilidades blandas y técnicas
    $skills_blandas = array_filter($skills, fn ($skill) => $skill['skill_topic'] == 'Skills Blandas');
    $skills_tecnicas = array_filter($skills, fn ($skill) => $skill['skill_topic'] == 'Skills Técnicas');

    // Asegurar que siempre haya 6 campos para cada tipo de habilidad
    while (count($skills_blandas) < 6) {
        $skills_blandas[] = ['skill_id' => 'new_blanda_' . count($skills_blandas), 'skill_name' => '', 'skill_topic' => 'Skills Blandas'];
    }
    while (count($skills_tecnicas) < 6) {
        $skills_tecnicas[] = ['skill_id' => 'new_tecnica_' . count($skills_tecnicas), 'skill_name' => '', 'skill_topic' => 'Skills Técnicas'];
    }
} else {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Actualizar'])) {
    $skills_blandas = array_filter($_POST['skills_blandas'], function ($skill) {
        return !empty(trim($skill));
    });
    $skills_tecnicas = array_filter($_POST['skills_tecnicas'], function ($skill) {
        return !empty(trim($skill));
    });
    $hobbies = $_POST['hobbies'];
    $student_description = $_POST['student_description'];

    // Procesar y actualizar skills
    $skills_data = [];
    foreach ($skills as $skill) {
        if ($skill['skill_topic'] == 'Skills Blandas' && isset($skills_blandas[$skill['skill_id']])) {
            $skills_data[] = [
                'skill_id' => $skill['skill_id'],
                'skill_name' => $skills_blandas[$skill['skill_id']],
                'skill_topic' => 'Skills Blandas'
            ];
        } elseif ($skill['skill_topic'] == 'Skills Técnicas' && isset($skills_tecnicas[$skill['skill_id']])) {
            $skills_data[] = [
                'skill_id' => $skill['skill_id'],
                'skill_name' => $skills_tecnicas[$skill['skill_id']],
                'skill_topic' => 'Skills Técnicas'
            ];
        }
    }

    // Insertar nuevas habilidades si no existen
    foreach ($skills_blandas as $skill_id => $skill_name) {
        if (!in_array($skill_name, array_column($skills_data, 'skill_name')) && !empty(trim($skill_name))) {
            $skills_data[] = [
                'skill_name' => $skill_name,
                'skill_topic' => 'Skills Blandas'
            ];
        }
    }
    foreach ($skills_tecnicas as $skill_id => $skill_name) {
        if (!in_array($skill_name, array_column($skills_data, 'skill_name')) && !empty(trim($skill_name))) {
            $skills_data[] = [
                'skill_name' => $skill_name,
                'skill_topic' => 'Skills Técnicas'
            ];
        }
    }

    // Eliminar skills si el campo está vacío
    foreach ($skills as $skill) {
        if ($skill['skill_topic'] == 'Skills Blandas') {
            if (empty(trim($skills_blandas[$skill['skill_id']]))) {
                // Eliminar la skill
                $obj->EliminarSkill($skill['skill_id']);
            }
        } elseif ($skill['skill_topic'] == 'Skills Técnicas') {
            if (empty(trim($skills_tecnicas[$skill['skill_id']]))) {
                // Eliminar la skill
                $obj->EliminarSkill($skill['skill_id']);
            }
        }
    }

    $obj->GuardarSkills($skills_data, $student_id);

    // Procesar y actualizar hobbies
    $hobbies_data = explode(',', $hobbies); // Utiliza los datos enviados por Tagify
    $obj->GuardarHobbies($hobbies_data, $student_id);

    // Procesar la imagen de perfil
    if (isset($_FILES['profile_picture_input']) && $_FILES['profile_picture_input']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture_input']['tmp_name'];
        $fileName = $_FILES['profile_picture_input']['name'];
        $fileSize = $_FILES['profile_picture_input']['size'];
        $fileType = $_FILES['profile_picture_input']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = $_SESSION['student_id'] . '-photo.' . $fileExtension;

        // Check if file has one of the following extensions
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directory in which the uploaded file will be moved
            $uploadFileDir = './images/perfil/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $message = 'Archivo subido exitosamente.';
                // Actualizar la sesión con el nuevo nombre del archivo
                $obj->ActualizarFotoPerfil($student_id, $newFileName);
            } else {
                $message = 'Hubo un error al mover el archivo subido al directorio de destino.';
            }
        } else {
            $message = 'Subida de archivo fallida. Solo se permiten archivos con las siguientes extensiones: ' . implode(',', $allowedfileExtensions);
        }
    }

    // Actualizar la descripción del estudiante
    $obj->ActualizarDescripcionEstudiante($student_id, $student_description);

    // Redireccionar para evitar reenvío de formulario
    header("Location: index.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta de Perfil - Test | UTP + class</title>
    <link rel="shortcut icon" href="images/icon/favicon-utp-class.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="css/font.css">
</head>

<body class="bg-[#f6f9ff] min-h-screen flex">
    <aside class="bg-[#000f37] flex flex-col gap-y-1 w-[65px] h-full fixed">
        <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
            <i class="fa-solid fa-bars text-2xl text-white"></i>
        </div>
        <a href="courses.php">
            <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
                <i class="fa-solid fa-book text-2xl text-white"></i>
                <p class="text-white text-xs">Cursos</p>
            </div>
        </a>
        <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
            <i class="fa-regular fa-comment text-2xl text-white"></i>
            <p class="text-white text-xs">Chat</p>
        </div>
        <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
            <i class="fa-regular fa-calendar text-2xl text-white"></i>
            <p class="text-white text-xs">Calendario</p>
        </div>
        <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
            <i class="fa-regular fa-circle-question text-2xl text-white"></i>
            <p class="text-white text-xs">Ayuda</p>
        </div>
    </aside>
    <div class="flex-1 ml-16 flex flex-col">
        <header class="bg-white flex items-center justify-between px-5 h-[65px] w-full">
            <img src="images/logo/logo-pao-class.png" class="w-40" alt="">
            <div class="flex items-center justify-center gap-x-3">
                <button class="flex items-center justify-center rounded-full p-2 w-[40px] h-[40px] hover:bg-blue-950 hover:text-white transition-all">
                    <i class="fa-regular fa-bell text-xl"></i>
                </button>
                <div class="flex flex-col items-end">
                    <p class="text-sm">Hola, <strong><?php echo htmlspecialchars($_SESSION['student_data']['name']); ?></strong></p>
                    <p class="text-xs">Estudiante</p>
                </div>
                <div class="flex items-center justify-center">
                    <img id="profileImage" src="images/perfil/<?php echo htmlspecialchars($_SESSION['student_data']['profile_picture']); ?>" class=" w-[40px] h-[40px] rounded-full block" alt="Foto de perfil">
                </div>
                <div class="relative">
                    <button id="dropdownButton" class="flex items-center justify-center">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div id="dropdownMenu" class="absolute right-0 mt-5 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                        <a href="perfil_text.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ver Perfil</a>
                        <a href="controller/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </header>
        <main class="flex justify-center items-center flex-1">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="bg-white rounded-2xl shadow-lg w-[500px] py-5 px-12 box-border relative">
                    <div class="flex justify-between items-center">
                        <div class="my-0 mx-auto relative inline-block">
                            <!-- IMAGEN DE PERFIL -->
                            <img id="profileImage" src="images/perfil/<?php echo htmlspecialchars($_SESSION['student_data']['profile_picture']); ?>" class="w-20 h-20 rounded-[50%] border-[3px] border-[#ff4081] object-cover block" alt="Foto de perfil">
                            <label for="profile_picture_input" class="absolute bottom-0 right-0 rounded-full w-[24px] h-[24px] flex justify-center items-center bg-gray-950 cursor-pointer">
                                <i class="fa-solid fa-pencil text-white text-xs"></i>
                            </label>
                            <input type="file" class="hidden" id="profile_picture_input" name="profile_picture_input" accept="image/*" onchange="previewImage(event)">

                        </div>
                    </div>

                    <div class="text-center mt-5 my-[5px] mx-0 text-black">
                        <!-- LLAMAR A TITULO DE PERFIL -->
                        <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($_SESSION['student_data']['name']); ?></h2>
                        <h3 class="text-sm font-normal"><?php echo htmlspecialchars($_SESSION['student_data']['career']); ?></h3>
                    </div>
                    <div class="mt-5">
                        <h4 class="mb-2 font-bold">Descripción del Estudiante</h4>
                        <textarea name="student_description" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: 100%;"><?php echo htmlspecialchars($student['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="mt-5">
                        <div>
                            <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold" onclick="toggleSection('skillsBlandas', 'skillsTecnicas');">Skills Blandas</h4>
                            <div id="skillsBlandas" class="max-h-0 overflow-hidden transition-all close">
                                <div class="flex flex-wrap gap-[10px] mt-[10px]">
                                    <?php
                                    foreach ($skills_blandas as $index => $skill) {
                                        echo '<input name="skills_blandas[' . $skill['skill_id'] . ']" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" value="' . htmlspecialchars($skill['skill_name']) . '" placeholder="Skill ' . ($index + 1) . '">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold" onclick="toggleSection('skillsTecnicas', 'skillsBlandas');">Skills Técnicas</h4>
                            <div id="skillsTecnicas" class="max-h-0 overflow-hidden transition-all close">
                                <div class="flex flex-wrap gap-[10px] mt-[10px]">
                                    <?php
                                    foreach ($skills_tecnicas as $index => $skill) {
                                        echo '<input name="skills_tecnicas[' . $skill['skill_id'] . ']" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" value="' . htmlspecialchars($skill['skill_name']) . '" placeholder="Skill ' . ($index + 1) . '">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="mb-2 font-bold">Pasatiempos</h4>
                        <div class="flex flex-wrap gap-[10px]">
                            <input name="hobbies" id="hobbies" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" value="<?php echo htmlspecialchars(implode(',', array_column($hobbies, 'hobby_name'))); ?>">
                        </div>
                    </div>

                    <div class="mt-5">
                        <input type="submit" value="ACTUALIZAR" name="Actualizar" class="w-full p-[10px] bg-[#f94c61] text-white border border-[#f94c61] rounded-[5px] text-base cursor-pointer transition-all hover:text-[#f94c61] hover:bg-white">
                    </div>
                </div>
            </form>
        </main>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="js/perfil.js"></script>
    <script src="js/dropdown.js"></script>
    <style>
        .close {
            max-height: 0;
        }

        .open {
            max-height: 1000px;
        }

        .transition-all {
            transition: max-height 0.3s ease-in-out;
        }
    </style>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profileImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>