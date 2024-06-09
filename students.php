<?php
require_once 'dao/utp_group_dao.php';
// include_once 'util/connection.php';

session_start();

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $obj = new utp_group_dao();
    if (isset($_GET['course_id'])) {
        $curso_id = $_GET['course_id'];
        $_SESSION['course_id'] = $curso_id;
        $_SESSION['course_data'] = $obj->ObtenerCursoPorId($_SESSION['course_id']);
    }
    $estudiantes = $obj->ObtenerEstudiantesPorCurso($_SESSION['course_id']);
} else {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes | UTP + class</title>
    <link rel="shortcut icon" href="images/icon/favicon-utp-class.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
    <link rel="stylesheet" href="css/font.css">
</head>

<body class="bg-[#f6f9ff] h-screen">
    <main class="flex h-full">
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
        <div class="flex-1 ml-16">
            <div class="flex-1">
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
                            <img src="images/perfil/<?php echo htmlspecialchars($_SESSION['student_data']['profile_picture']); ?>" class=" w-[40px] h-[40px] rounded-full block" alt="Foto de perfil">
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
                <div class="divide-y-2 divide-[#4f6168] px-5 py-2.5">
                    <header>
                        <div class="flex py-2.5 px-5 divide-x-2 divide-black gap-x-2">
                            <a href="courses.php" class="flex items-center text-[#0661fc] gap-x-1">
                                <i class="fa-solid fa-arrow-left"></i>
                                <p class="text-xs font-extrabold">Volver a cursos</p>
                            </a>
                            <div class="flex gap-x-1 font-bold items-center ps-2">
                                <p class="text-[#4A4F55] text-sm"><?php echo $_SESSION['course_data']['course_name']; ?> - Sección <?php echo $_SESSION['course_id']; ?></p>
                                <div class="bg-[#B21F5F] text-[#FCDAE2] text-xs py-0.5 px-3 rounded-full">
                                    <?php echo $_SESSION['course_data']['modality']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="flex font-extrabold text-sm text-[#4f6168] px-4">
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Sílabo</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Contenido</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Evaluaciones</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Tareas</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Foros</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Notas</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Anuncios</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <p>Zoom</p>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <a href="groups.php">Group</a>
                            </div>
                            <div class="py-2 px-3 cursor-pointer border-b-[3.5px] border-[#0661fc]">
                                <a href="students.php">Class</a>
                            </div>
                        </div>
                    </header>
                    <section class="grid grid-cols-3 gap-2 pt-2">
                        <?php
                        foreach ($estudiantes as $estudiante) {
                        ?>
                            <?php
                            $fechaNacimiento = $estudiante['birth_date']; // dd/mm/yy
                            $edad = DateTime::createFromFormat('Y-m-d', $fechaNacimiento)->diff(new DateTime())->y;

                            $cellphone_sin_espacios = str_replace(' ', '', $estudiante['cellphone']);
                            ?>

                        <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                            <div class="col-span-1 flex justify-center items-center">
                                <img src="images/perfil/<?php echo htmlspecialchars($estudiante['profile_picture']); ?>" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                            </div>
                            <div class="col-span-2 flex flex-col justify-between py-5">
                                <div class="flex flex-col">
                                    <p class="text-xl font-bold text-pretty"><?php echo htmlspecialchars($estudiante['name']); ?></p>
                                    <p class="text-xs text-[#4f6168]"><?php echo htmlspecialchars($estudiante['career']); ?> - <?php echo $edad; ?> años - <?php echo htmlspecialchars($estudiante['academic_cycle']); ?> Ciclo</p>
                                </div>
                                <div class="flex gap-x-2 me-10">
                                    <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all"
                                        onclick="javascript:openProfile('<?php echo htmlspecialchars($estudiante['student_id']); ?>');"> <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <a class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all flex items-center justify-center" href="https://wa.me/<?php echo $cellphone_sin_espacios; ?>" target="_blank"> <i class="fa-solid fa-comment"></i> </a>                                
                                </div>
                            </div>
                        </div>

                        <?php
                        }
                        ?>

                </section>
            </div>
        </div>
        <!-- Modal -->

        <div id="myModalEstudiante" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="student_id"></div>
            <div class="bg-white rounded-2xl shadow-lg w-[500px] py-5 px-12 box-border relative">
                <div class="flex justify-between items-center">
                    <div class="my-0 mx-auto">
                        <img id="imagePerfil" src="" class="image w-20 h-20 rounded-[50%] border-[3px] border-[#ff4081] object-cover" alt="Foto de perfil">
                    </div>
                    <div id="closeModalBtn" class="text-3xl cursor-pointer text-[#f94c61]">&times;</div>
                </div>
                <div class="text-center mt-5 my-[5px] mx-0 text-black">
                    <h2 id="NombreCodigoEstudiante" class="text-xl font-semibold"></h2>
                    <h3 id="CarreraEstudiante" class="text-sm font-normal"></h3>
                </div>
                
                <div class="mt-5 flex justify-center gap-x-4">
                    <div class="flex flex-col items-center relative">
                        <div class="flex justify-center bg-[#FFBDBD] w-12 rounded-md">
                            <p>👑</p>
                        </div>
                        <p class="text-xs">Líder</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="flex justify-center bg-[#A4E2D3] w-12 rounded-md">
                            <p>😁</p>
                        </div>
                        <p class="text-xs">Motivador</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="flex justify-center bg-[#F1E2BE] w-12 rounded-md">
                            <p>🎨</p>
                        </div>
                        <p class="text-xs">Creativo</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="flex justify-center bg-[#BDDFFF] w-12 rounded-md">
                            <p>🧘‍♂</p>
                        </div>
                        <p class="text-xs">Mediador</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="flex justify-center bg-[#D2A5E7] w-12 rounded-md">
                            <p>🕵‍♂</p>
                        </div>
                        <p class="text-xs">Investigador</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <h4 class="mb-2 font-bold">Descripción</h4>
                    <p class="descripcion p-[7.5px] border border-[#ccc] rounded-[5px] text-sm text-pretty h-[75px] overflow-auto" id="descripcion_estudiante"></p>
                </div>

                <div class="mt-5">
                    <div>
                        <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold" onclick="toggleSection('skillsBlandas', 'skillsTecnicas');">Skills Blandas</h4>
                        <div id="skillsBlandas" class="max-h-0 overflow-hidden transition-all close">
                            <div class="flex flex-wrap gap-[10px] mt-[10px]" id="skillsBlandasInfo">
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="cursor-pointer m-0 p-[10px] bg-[#f1f1f1] rounded-[5px] font-bold" onclick="toggleSection('skillsTecnicas', 'skillsBlandas');">Skills Técnicas</h4>
                        <div id="skillsTecnicas" class="max-h-0 overflow-hidden transition-all close">
                            <div class="flex flex-wrap gap-[10px] mt-[10px]" id ="skillsTecnicasInfo">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <h4 class="mb-2 font-bold">Pasatiempos</h4>
                    <p id="hobbies_text"></p>
                </div>

            </div>
        </div>
    </main>
    <script>
        var getUrl = window.location;
        var base_url = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/student_profile.js"></script>
    <script src="js/perfil.js"></script>
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
</body>

</html>