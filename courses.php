<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

$obj = new utp_group_dao();
$student = $obj->obtenerEstudiantePor($_SESSION['student_id']);
if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $student = $obj->obtenerEstudiantePor($student_id);

    $_SESSION['$student_data'] = $student;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos | UTP + class</title>
    <link rel="shortcut icon" href="images/icon/favicon-utp-class.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
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
                    <button
                        class="flex items-center justify-center rounded-full p-2 w-[40px] h-[40px] hover:bg-blue-950 hover:text-white transition-all">
                        <i class="fa-regular fa-bell text-xl"></i>
                    </button>
                    <div class="flex flex-col items-end">
                        <p class="text-sm">Hola, <strong><?php echo isset($_SESSION['user_data']['name']) ?></strong></p>
                        <p class="text-xs">Estudiante</p>
                    </div>
                    <div class="flex items-center justify-center rounded-full bg-lime-200 p-2 w-[40px] h-[40px]">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="relative">
                        <button id="dropdownButton" class="flex items-center justify-center">
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div id="dropdownMenu" class="absolute right-0 mt-5 w-48 bg-white border border-gray-200 rounded-lg shadow-lg hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ver Perfil</a>
                            <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </header>
            <div>
                <div></div>
                <div class="grid grid-cols-4 p-5 gap-x-5">
                    <div class="col-span-3 flex flex-col divide-y-2 divide-black">
                        <div class="flex items-center justify-between px-5 py-2.5">
                            <h3 class="font-bold text-xl">MIS CURSOS</h3>
                            <div class="flex justify-center items-center gap-x-2">
                                <h5 class="text-sm tracking-wide font-semibold">Filtrar por</h5>
                                <select class="p-1 rounded-md border-gray-300" name="" id="">
                                    <option value="1">Ciclo Marzo 2024</option>
                                </select>
                            </div>
                        </div>
                        <div class="px-5 py-2.5 grid grid-cols-2 gap-2.5">
                            <div class="col-span-1 grid grid-cols-3 h-[130px]">
                                <div class="col-span-1 bg-pink-200 rounded-l-md">
                                </div>
                                <div class="col-span-2 bg-white flex flex-col justify-between p-2 rounded-r-md">
                                    <div class="flex flex-col">
                                        <h5 class="font-bold text-lg">Análisis y Diseño de Sistemas de Información</h5>
                                        <p>13758 - Virtual 24/7</p>
                                    </div>
                                    <p class="text-sm">Christian Eduardo Espinoza Paredes</p>
                                </div>
                            </div>
                            <div class="col-span-1 grid grid-cols-3 h-[130px]">
                                <div class="col-span-1 bg-pink-200 rounded-l-md">
                                </div>
                                <div class="col-span-2 bg-white flex flex-col justify-between p-2 rounded-r-md">
                                    <div class="flex flex-col">
                                        <h5 class="font-bold text-lg">Ciudadanía y Reflexión Ética</h5>
                                        <p>47971 - Virtual 24/7</p>
                                    </div>
                                    <p class="text-sm">Juana Andrea Ballena Aguilar</p>
                                </div>
                            </div>
                            <div class="col-span-1 grid grid-cols-3 h-[130px]">
                                <div class="col-span-1 bg-pink-200 rounded-l-md">
                                </div>
                                <div class="col-span-2 bg-white flex flex-col justify-between p-2 rounded-r-md">
                                    <div class="flex flex-col">
                                        <h5 class="font-bold text-lg">Herramientas para la Comunicación Efectiva</h5>
                                        <p>13148 - Virtual 24/7</p>
                                    </div>
                                    <p class="text-sm">Martin Remberto Horna Romero</p>
                                </div>
                            </div>
                            <div class="col-span-1 grid grid-cols-3 h-[130px]">
                                <div class="col-span-1 bg-pink-200 rounded-l-md">
                                </div>
                                <div class="col-span-2 bg-white flex flex-col justify-between p-2 rounded-r-md">
                                    <div class="flex flex-col">
                                        <h5 class="font-bold text-lg">Programación Lógica y Funcional</h5>
                                        <p>24795 - Presencial</p>
                                    </div>
                                    <p class="text-sm">Jhonatan Derlin Jordan Pereda</p>
                                </div>
                            </div>
                            <div class="col-span-1 grid grid-cols-3 h-[130px]">
                                <div class="col-span-1 bg-pink-200 rounded-l-md">
                                </div>
                                <div class="col-span-2 bg-white flex flex-col justify-between p-2 rounded-r-md">
                                    <div class="flex flex-col">
                                        <h5 class="font-bold text-lg">Programación de Videojuegos con C++</h5>
                                        <p>30405 - Presencial</p>
                                    </div>
                                    <p class="text-sm">David William Cota Sencara</p>
                                </div>
                            </div>
                            <div class="col-span-1 grid grid-cols-3 h-[130px]">
                                <div class="col-span-1 bg-pink-200 rounded-l-md">
                                </div>
                                <div class="col-span-2 bg-white flex flex-col justify-between p-2 rounded-r-md">
                                    <div class="flex flex-col">
                                        <h5 class="font-bold text-lg">Seguridad Informática</h5>
                                        <p>13413 - Virtual 24/7</p>
                                    </div>
                                    <p class="text-sm">Juana Andrea Ballena Aguilar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1 flex flex-col">
                        <div class="rounded-t-md px-4 py-2 bg-blue-950">
                            <h3 class="text-white">Actividades semanales</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="js/dropdown.js"></script>
</body>

</html>