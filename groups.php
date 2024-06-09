<?php
include_once 'dao/utp_group_dao.php';
include_once 'util/connection.php';

session_start();

if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    $obj = new utp_group_dao();

    $studentMe = $_SESSION['student_data'];
    $grupos = $obj->ObtenerGruposPorCursoId($_SESSION['course_id']);

    $roles = $obj->ListarRoles();

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
    <title>Grupos | UTP + class</title>
    <link rel="shortcut icon" href="images/icon/favicon-utp-class.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/group.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    <div class="flex items-center justify-center rounded-full bg-lime-200 p-2 w-[40px] h-[40px]">
                        <i class="fa-solid fa-user"></i>
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
                        <div class="py-2 px-3 cursor-pointer border-b-[3.5px] border-[#0661fc]">
                            <a href="groups.php">Group</a>
                        </div>
                        <div class="py-2 px-3 cursor-pointer">
                            <a href="students.php">Class</a>
                        </div>
                    </div>
                </header>
                <section class="flex-col">
                    <div class="inline-flex py-2.5 px-8 bg-white border-2 border-[#f94c61] rounded-lg mt-5 ms-5">
                        <p class="font-bold text-3xl">GRUPOS</p>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mt-5 mx-5">
                        <!-------------------------------------------------------------------------------------------------------------------------------------------->
                        <?php foreach ($grupos as $grupo) : ?>
                            <div class="col-span-1 grid grid-rows-4">
                                <div class="row-span-1 grid grid-cols-5">
                                    <div class="col-span-4 flex bg-[#000f37] justify-center">
                                        <p class="font-bold text-2xl text-white p-2"><?php echo $grupo['group_name']; ?></p>
                                    </div>
                                    <button onclick="javascript: openModal(2);" class="col-span-1 bg-[#3ddcda] flex text-white justify-center items-center text-3xl hover:text-4xl transition-all">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                                <div class="row-span-3 grid grid-cols-5">
                                    <div class="col-span-4 flex flex-col bg-white py-1.5 px-5">
                                        <h5 class="font-extrabold tracking-tight">Integrantes</h5>
                                        <ol class="list-decimal-custom space-y-2 mt-1">
                                            <?php
                                            $students_group = $obj->ObtenerAlumnosPorGrupoId($grupo['group_id']);
                                            foreach ($students_group as $student) : ?>
                                                <li class="text-sm font-bold"><?php echo $student['name']; ?></li>
                                            <?php endforeach; ?>
                                        </ol>
                                    </div>
                                    <div class="col-span-1 flex flex-col items-center bg-gray-200 py-1.5">
                                        <h5 class="font-extrabold tracking-tight">Rol</h5>
                                        <div class="flex flex-col space-y-1">
                                            <?php foreach ($students_group as $student) : ?>
                                                <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="">
                                                    <?php foreach ($roles as $role) : ?>
                                                        <!-- hacer cambio para qeu se vea la imagen y no el nombre del rol -->
                                                        <option value="<?php echo $role['role_id']; ?>">
                                                            <img src="images/roles/<?php echo $role['role_name'];?>.png" class="w-6 h-6"> <?php echo $role['role_name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <!-------------------------------------------------------------------------------------------------------------------------------------------->
                        <!-- Diseño de grupo 1 -->
                        <div class="col-span-1 grid grid-rows-4">
                            <div class="row-span-1 grid grid-cols-5">
                                <div class="col-span-4 flex bg-[#000f37] justify-center">
                                    <p class="font-bold text-2xl text-white p-2">GRUPO 1</p>
                                </div>
                                <button class="col-span-1 bg-gray-400 flex text-white justify-center items-center text-3xl hover:text-4xl transition-all" disabled>
                                    <i class="fa-solid fa-lock"></i>
                                </button>
                            </div>
                            <div class="row-span-3 grid grid-cols-5">
                                <div class="col-span-4 flex flex-col bg-white py-1.5 px-5">
                                    <h5 class="font-extrabold tracking-tight">Integrantes</h5>
                                    <ol class="list-decimal-custom space-y-2 mt-1">
                                        <li class="text-sm font-bold">Morelia Gonzales Valdivia</li>
                                        <li class="text-sm font-bold">Flavio Villanueva Medina</li>
                                        <li class="text-sm font-bold">Eduardo Brito Escobar</li>
                                        <li class="text-sm font-bold">Sebastián Quenta Tunque</li>
                                        <li class="text-sm font-bold">Francesco Riva Reyes</li>
                                    </ol>
                                </div>
                                <div class="col-span-1 flex flex-col items-center bg-gray-200 py-1.5">
                                    <h5 class="font-extrabold tracking-tight">Rol</h5>
                                    <div class="flex flex-col space-y-1">
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-------------------------------------------------------------------------------------------------------------------------------------------->
                        <!-- Diseño de grupo 2 -->
                        <div class="col-span-1 grid grid-rows-4">
                            <div class="row-span-1 grid grid-cols-5">
                                <div class="col-span-4 flex bg-[#000f37] justify-center">
                                    <p class="font-bold text-2xl text-white p-2">GRUPO 2</p>
                                </div>
                                <button onclick="javascript: openModal(2);" class="col-span-1 bg-[#3ddcda] flex text-white justify-center items-center text-3xl hover:text-4xl transition-all">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <div class="row-span-3 grid grid-cols-5">
                                <div class="col-span-4 flex flex-col bg-white py-1.5 px-5">
                                    <h5 class="font-extrabold tracking-tight">Integrantes</h5>
                                    <ol class="list-decimal-custom space-y-2 mt-1">
                                        <li class="text-sm font-bold">Morelia Gonzales Valdivia</li>
                                        <li class="text-sm font-bold">Flavio Villanueva Medina</li>
                                        <li class="text-sm font-bold">Eduardo Brito Escobar</li>
                                        <li class="text-sm font-bold">Sebastián Quenta Tunque</li>
                                        <li class="text-sm font-bold">&nbsp;</li>
                                    </ol>
                                </div>
                                <div class="col-span-1 flex flex-col items-center bg-gray-200 py-1.5">
                                    <h5 class="font-extrabold tracking-tight">Rol</h5>
                                    <div class="flex flex-col space-y-1">
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="" disabled>
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Diseño de grupo 3 -->
                        <div class="col-span-1 grid grid-rows-4">
                            <div class="row-span-1 grid grid-cols-5">
                                <div class="col-span-4 flex bg-[#000f37] justify-center">
                                    <p class="font-bold text-2xl text-white p-2">GRUPO 3</p>
                                </div>
                                <button class="col-span-1 bg-[#f94c61] flex text-white justify-center items-center text-3xl hover:text-4xl transition-all">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </div>
                            <div class="row-span-3 grid grid-cols-5">
                                <div class="col-span-4 flex flex-col bg-white py-1.5 px-5">
                                    <h5 class="font-extrabold tracking-tight">Integrantes</h5>
                                    <ol class="list-decimal-custom space-y-2 mt-1">
                                        <li class="text-sm font-bold">Morelia Gonzales Valdivia</li>
                                        <li class="text-sm font-bold">Flavio Villanueva Medina</li>
                                        <li class="text-sm font-bold">Eduardo Brito Escobar</li>
                                        <li class="text-sm font-bold">Sebastián Quenta Tunque</li>
                                        <li class="text-sm font-bold">&nbsp;</li>
                                    </ol>
                                </div>
                                <div class="col-span-1 flex flex-col items-center bg-gray-200 py-1.5">
                                    <h5 class="font-extrabold tracking-tight">Rol</h5>
                                    <div class="flex flex-col space-y-1">
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="">
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="">
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="">
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                        <select class="py-0 px-0 bg-gray-400 border-0 rounded-md" name="" id="">
                                            <option value="">😂</option>
                                            <option value="">😎</option>
                                            <option value="">🤗</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg">
                <h2 class="text-xl font-bold mb-4" id="modal-title">Confirmación de entrada al grupo</h2>
                <p class="mb-4" id="modal-content">¿Deseas entrar al grupo?</p>
                <div>
                    <button id="closeModalBtn" class="bg-red-500 text-white px-4 py-2 rounded">Confirmar</button>
                    <button id="closeModalBtn" class="bg-gray-200 text-black px-4 py-2 rounded">Cancelar</button>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <script src="js/modal.js"></script>
    <script src="js/dropdown.js"></script>
</body>

</html>