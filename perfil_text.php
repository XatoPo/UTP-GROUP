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
} else {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Actualizar'])) {
    $skills_blandas = $_POST['skills_blandas'];
    $skills_tecnicas = $_POST['skills_tecnicas'];
    $hobbies = $_POST['hobbies'];
    $student_description = $_POST['student_description'];

    // Procesar y actualizar skills
    $skills_data = [];
    foreach ($skills as $skill) {
        if ($skill['skill_topic'] == 'Skills Blandas') {
            $skills_data[] = [
                'skill_id' => $skill['skill_id'],
                'skill_name' => $skills_blandas[$skill['skill_id']],
                'skill_topic' => 'Skills Blandas'
            ];
        } else {
            $skills_data[] = [
                'skill_id' => $skill['skill_id'],
                'skill_name' => $skills_tecnicas[$skill['skill_id']],
                'skill_topic' => 'Skills Técnicas'
            ];
        }
    }

    // Insertar nuevas habilidades si no existen
    foreach ($skills_blandas as $skill_name) {
        if (!in_array($skill_name, array_column($skills_data, 'skill_name'))) {
            $skills_data[] = [
                'skill_name' => $skill_name,
                'skill_topic' => 'Skills Blandas'
            ];
        }
    }
    foreach ($skills_tecnicas as $skill_name) {
        if (!in_array($skill_name, array_column($skills_data, 'skill_name'))) {
            $skills_data[] = [
                'skill_name' => $skill_name,
                'skill_topic' => 'Skills Técnicas'
            ];
        }
    }

    $obj->GuardarSkills($skills_data, $student_id);

    // Procesar y actualizar hobbies
    $hobbies_data = explode(',', $hobbies); // Utiliza los datos enviados por Tagify
    $obj->GuardarHobbies($hobbies_data, $student_id);

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="css/font.css">
</head>

<body>
    <main>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="bg-white rounded-2xl shadow-lg w-[500px] py-5 px-12 box-border relative">
                <div class="flex justify-between items-center">
                    <div class="my-0 mx-auto">
                        <!-- IMAGEN DE PERFIL -->
                        <img src="images/perfil/<?php echo htmlspecialchars($_SESSION['student_data']['profile_picture']); ?>" class="w-20 h-20 rounded-[50%] border-[3px] border-[#ff4081] object-cover" alt="Foto de perfil">
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
                                <?php foreach ($skills as $index => $skill): ?>
                                    <?php if ($skill['skill_topic'] == 'Skills Blandas'): ?>
                                        <input name="skills_blandas[<?php echo $skill['skill_id']; ?>]" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" value="<?php echo htmlspecialchars($skill['skill_name']); ?>" placeholder="Skill <?php echo $index + 1; ?>">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold" onclick="toggleSection('skillsTecnicas', 'skillsBlandas');">Skills Técnicas</h4>
                        <div id="skillsTecnicas" class="max-h-0 overflow-hidden transition-all close">
                            <div class="flex flex-wrap gap-[10px] mt-[10px]">
                                <?php foreach ($skills as $index => $skill): ?>
                                    <?php if ($skill['skill_topic'] == 'Skills Técnicas'): ?>
                                        <input name="skills_tecnicas[<?php echo $skill['skill_id']; ?>]" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" value="<?php echo htmlspecialchars($skill['skill_name']); ?>" placeholder="Skill <?php echo $index + 1; ?>">
                                    <?php endif; ?>
                                <?php endforeach; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="js/perfil.js"></script>
    <style>
        .close { max-height: 0; }
        .open { max-height: 1000px; }
        .transition-all { transition: max-height 0.3s ease-in-out; }
    </style>
</body>
</html>