<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

session_start();

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $obj = new utp_group_dao();

    $skills = $obj->ObtenerSkillsPorEstudiante($student_id);
    $hobbies = $obj->ObtenerHobbiesPorEstudiante($student_id);
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

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
                <h4 class="mb-2 font-bold">Descripción</h4>
                <textarea name="description" class="w-full h-[100px] p-[10px] box-border border border-[#ccc] rounded-md resize-none text-sm tracking-tight" placeholder="Soy una persona..."><?php echo htmlspecialchars($_SESSION['student_data']['description']); ?></textarea>
            </div>
            <div class="mt-5">
                <div>
                    <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold" onclick="javascript: toggle(this);">Skills Blandas</h4>
                    <div class="max-h-0 overflow-hidden transition-all close">
                        <div class="flex flex-wrap gap-[10px] mt-[10px]">
                            <input name="skills_blandas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="1">
                            <input name="skills_blandas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="4">
                            <input name="skills_blandas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="2">
                            <input name="skills_blandas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="5">
                            <input name="skills_blandas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="3">
                            <input name="skills_blandas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="6">
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold"  onclick="javascript: toggle(this);">Skills Técnicas</h4>
                    <div class="max-h-0 overflow-hidden transition-all close">
                        <div class="flex flex-wrap gap-[10px] mt-[10px]">
                            <input name="skills_tecnicas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="1">
                            <input name="skills_tecnicas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="4">
                            <input name="skills_tecnicas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="2">
                            <input name="skills_tecnicas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="5">
                            <input name="skills_tecnicas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="3">
                            <input name="skills_tecnicas" class="text-sm p-[10px] box-border border border-[#ccc] rounded-[5px]" style="width: calc(50% - 10px);" type="text" placeholder="6">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <h4 class="mb-2 font-bold">Pasatiempos</h4>
                <input class="text-sm border border-[#ccc] rounded-[5px]" name="tags-pasatiempos" placeholder="" value="">
            </div>
            <div class="mt-5">
                <input type="submit" value="ACTUALIZAR" name="Actualizar" class="w-full p-[10px] bg-[#f94c61] text-white border border-[#f94c61] rounded-[5px] text-base cursor-pointer transition-all hover:text-[#f94c61] hover:bg-white">
            </div>
        </div>
    </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="js/perfil.js"></script>
</body>

</html>