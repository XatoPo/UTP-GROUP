<?php
session_start();
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
                        <p class="text-sm">Hola, <strong><?php echo $_SESSION['nombre'] ?></strong></p>
                        <p class="text-xs">Estudiante</p>
                    </div>
                    <div class="flex items-center justify-center rounded-full bg-lime-200 p-2 w-[40px] h-[40px]">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <button>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
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
                        <div class="py-2 px-3">
                            <p>Sílabo</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Contenido</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Evaluaciones</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Tareas</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Foros</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Notas</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Anuncios</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Zoom</p>
                        </div>
                        <div class="py-2 px-3">
                            <p>Group</p>
                        </div>
                        <div class="py-2 px-3 border-b-[3.5px] border-[#0661fc]">
                            <p>Class</p>
                        </div>
                    </div>
                </header>
                <section class="grid grid-cols-3 gap-2 pt-2">
                    <!-- Diseño tarjeta 1 -->
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg relative h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/panda_full.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex justify-between items-center">
                            <div class="flex flex-col justify-center h-full py-2 pe-8">
                                <a href="#" class="text-xl font-bold text-pretty hover:underline">Morelia Paola Gonzales Valdivia</a>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                        </div>
                        <div class="absolute top-0 right-0">
                            <div class="flex flex-col">
                                <button class="bg-[#f94c61] border border-[#f94c61] text-white w-8 h-8 rounded-sm flex justify-center items-center hover:bg-white hover:text-[#f94c61] transition-all">
                                    <i class="fa-regular fa-eye"></i>
                                </button>
                                <button class="border border-black text-black w-8 h-8 rounded-sm flex justify-center items-center hover:bg-gray-200 transition-all">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Diseño tarjeta 2 -->
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/panda_full.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <a href="#" class="text-xl font-bold text-pretty hover:underline">Morelia Paola Gonzales Valdivia</a>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <button class="bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm me-20 hover:bg-white hover:text-[#f94c61] transition-all">Hacer grupo</button>
                        </div>
                    </div>
                    <!-- Diseño tarjeta 3 -->
                    <div class="col-span-1 bg-white grid grid-cols-3 rounded-lg h-[130px]">
                        <div class="col-span-1 flex justify-center items-center">
                            <img src="images/perfil/panda_full.jpg" class="rounded-full border-[3px] border-[#f94c61] w-24 h-24 object-cover" alt="">
                        </div>
                        <div class="col-span-2 flex flex-col justify-between py-5">
                            <div class="flex flex-col">
                                <a href="#" class="text-xl font-bold text-pretty hover:underline">Morelia Paola Gonzales Valdivia</a>
                                <p class="text-xs text-[#4f6168]">Ingeniería de Software - 20 años - 6to ciclo</p>
                            </div>
                            <div class="flex gap-x-2 me-10">
                                <button class="flex-1 bg-[#f94c61] border border-[#f94c61] py-1 text-white rounded-md text-sm hover:bg-white hover:text-[#f94c61] transition-all">Ver perfil</button>
                                <button class="flex-1 border border-black py-1 text-black rounded-md text-sm hover:bg-gray-200 transition-all">Hacer grupo</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>