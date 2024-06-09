<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

session_start();

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $obj = new utp_group_dao();

    $student = $obj->ObtenerEstudiantePorId($student_id);
    $estudiantes = $obj->ObtenerEstudiantesPorCurso(1001);

    if ($student) {
        $_SESSION['student_data'] = $student;
    } else {
        echo "No se pudieron obtener los datos del estudiante.";
    }
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
        <aside class="bg-[#000f37] flex flex-col gap-y-1 w-[65px] h-full">
            <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
                <i class="fa-solid fa-bars text-2xl text-white"></i>
            </div>
            <div class="p-1 flex flex-col items-center justify-center w-[65px] h-[65px]">
                <i class="fa-solid fa-book text-2xl text-white"></i>
                <p class="text-white text-xs">Cursos</p>
            </div>
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
        <div class="flex-1">
            <header class="bg-white flex items-center justify-between px-5 h-[65px] w-full">
                <img src="images/logo/logo-pao-class.png" class="w-40" alt="">
                <div class="flex items-center justify-center gap-x-3">
                    <button class="flex items-center justify-center rounded-full p-2 w-[40px] h-[40px] hover:bg-blue-950 hover:text-white transition-all">
                        <i class="fa-regular fa-bell text-xl"></i>
                    </button>
                    <div class="flex flex-col items-end">
                        <?php if (isset($_SESSION['student_data']['name'])) : ?>
                            <p class="text-sm">Hola, <strong><?php echo $_SESSION['student_data']['name']; ?></strong></p>
                        <?php else : ?>
                            <p class="text-sm">Hola, Usuario</p>
                        <?php endif; ?> <p class="text-xs">Estudiante</p>
                    </div>
                    <div class="flex items-center justify-center rounded-full bg-lime-200 p-2 w-[40px] h-[40px]">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="relative">
                        <button id="dropdownButton" class="flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="divide-y-2 divide-[#4f6168] px-5 py-2.5">
                <header>
                    <div class="flex py-2.5 px-5 divide-x-2 divide-black gap-x-2">
                        <a href="#" class="flex items-center text-[#0661fc] gap-x-1">
                            <i class="fa-solid fa-arrow-left"></i>
                            <p class="text-xs font-extrabold">Volver a cursos</p>
                        </a>
                        <div class="flex gap-x-1 font-bold items-center ps-2">
                            <p class="text-[#4A4F55] text-sm">Análisis y Diseño de Sistemas de Información - Sección 13758</p>
                            <div class="bg-[#B21F5F] text-[#FCDAE2] text-xs py-0.5 px-3 rounded-full">
                                Virtual 24/7
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
                        ?>

                        <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                            <div class="col-span-1 flex justify-center items-center">
                                <img src="<?php echo htmlspecialchars($estudiante['profile_picture']);?>" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                            </div>
                            <div class="col-span-2 flex flex-col justify-between py-5">
                                <div class="flex flex-col">
                                    <p class="text-xl font-bold text-pretty"><?php echo htmlspecialchars($estudiante['name']);?></p>
                                    <p class="text-xs text-[#4f6168]"><?php echo htmlspecialchars($estudiante['career']);?> - <?php echo $edad;?> años - <?php echo htmlspecialchars($estudiante['academic_cycle']);?> Ciclo</p>
                                </div>
                                <div class="flex gap-x-2 me-10">
                                    <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all" onclick="javascript: openProfile('<?php echo htmlspecialchars($estudiante['student_id']);?>');">Ver perfil</button>
                                    <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/U21201391-photo.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <p class="text-xl font-bold text-pretty">Morelia Paola Gonzales Valdivia</p>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <div class="flex gap-x-2 me-10">
                                <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all" onclick="javascript: openProfile('U21208430');">Ver perfil</button>
                                <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/U21201391-photo.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <p class="text-xl font-bold text-pretty">Morelia Paola Gonzales Valdivia</p>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <div class="flex gap-x-2 me-10">
                                <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all" onclick="javascript: openProfile('U21208430');">Ver perfil</button>
                                <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/U21201391-photo.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <p class="text-xl font-bold text-pretty">Morelia Paola Gonzales Valdivia</p>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <div class="flex gap-x-2 me-10">
                                <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all" onclick="javascript: openProfile('U21208430');">Ver perfil</button>
                                <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/U21201391-photo.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <p class="text-xl font-bold text-pretty">Morelia Paola Gonzales Valdivia</p>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <div class="flex gap-x-2 me-10">
                                <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all" onclick="javascript: openProfile('U21208430');">Ver perfil</button>
                                <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/U21201391-photo.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <p class="text-xl font-bold text-pretty">Morelia Paola Gonzales Valdivia</p>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <div class="flex gap-x-2 me-10">
                                <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all" onclick="javascript: openProfile('U21208430');">Ver perfil</button>
                                <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-2xl shadow-lg w-[500px] py-5 px-12 box-border relative">
                <div class="flex justify-between items-center">
                    <div class="my-0 mx-auto">
                        <img src="images/perfil/panda_full.jpg" class="w-20 h-20 rounded-[50%] border-[3px] border-[#ff4081] object-cover" alt="Foto de perfil">
                    </div>
                    <div id="closeModalBtn" class="text-3xl cursor-pointer text-[#f94c61]">&times;</div>
                </div>
                <div class="text-center mt-5 my-[5px] mx-0 text-black">
                    <h2 class="text-xl font-semibold">Francesco Riva Reyes - U21208430</h2>
                    <h3 class="text-sm font-normal">Ingeniería de Software</h3>
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
                            <p>🧘‍♂️</p>
                        </div>
                        <p class="text-xs">Mediador</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center relative">
                        <div class="flex justify-center bg-[#D2A5E7] w-12 rounded-md">
                            <p>🕵️‍♂️</p>
                        </div>
                        <p class="text-xs">Investigador</p>
                        <div class="rounded-full w-5 h-5 flex justify-center items-center bg-green-400 absolute -top-2 -right-2">
                            <p class="text-white text-xs">45</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="mb-2 font-bold">Descripción</h4>
                    <p class="text-sm text-pretty">Soy una persona alegre y positiva. Sé que al grupo le daré muy buena vibra. Asimismo, tengo ideas muy buenas para dar las mejores vibras.</p>
                </div>
                <div class="mt-5 inline-flex items-center gap-x-2 cursor-pointer" onclick="javascript: toggle(this);">
                    <i class="fa-solid fa-caret-down bg-[#203672] rounded-sm px-1 text-white"></i>
                    <h4 class="font-bold">Skills blandas</h4>
                </div>
                <div class="max-h-0 overflow-hidden grid grid-cols-2 gap-x-5 close">
                    <div class="col-span-1 flex flex-col">
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">1</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Comunicación</p>
                        </div>
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">2</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Trabajo en equipo</p>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">3</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Creatividad</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col">
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">4</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Diseño de PPTs</p>
                        </div>
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">5</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">UX/UI en Figma</p>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">6</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">HTML, CSS, PHP, Python</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 inline-flex items-center gap-x-2 cursor-pointer" onclick="javascript: toggle(this);">
                    <i class="fa-solid fa-caret-down bg-[#203672] rounded-sm px-1 text-white"></i>
                    <h4 class="font-bold">Skills duras</h4>
                </div>
                <div class="max-h-0 overflow-hidden grid grid-cols-2 gap-x-5 close">
                    <div class="col-span-1 flex flex-col">
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">1</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Comunicación</p>
                        </div>
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">2</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Trabajo en equipo</p>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">3</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Creatividad</p>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col">
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">4</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">Diseño de PPTs</p>
                        </div>
                        <div class="mb-2 flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">5</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">UX/UI en Figma</p>
                        </div>
                        <div class="flex items-center gap-x-1">
                            <p class="font-extrabold text-gray-600">6</p>
                            <p class="py-1 px-2 text-sm border border-[#ccc] rounded-[5px] w-full">HTML, CSS, PHP, Python</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <h4 class="mb-2 font-bold">Pasatiempos</h4>
                    <input class="text-sm border-0" readonly value="Música, TKD, More Academy">
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="js/dropdown.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/student_profile.js"></script>
</body>

</html>