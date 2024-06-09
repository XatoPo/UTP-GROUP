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
                            <div class="py-2 px-3 cursor-pointer border-b-[3.5px] border-[#0661fc]">
                                <a href="groups.php">Group</a>
                            </div>
                            <div class="py-2 px-3 cursor-pointer">
                                <a href="students.php">Class</a>
                            </div>
                        </div>
                    </header>
                    <section class="flex-col">
                        <div class="flex items-center mt-5 ms-5">
                            <div class="inline-flex py-2.5 px-8 bg-white border-2 border-[#f94c61] rounded-lg">
                                <p class="font-bold text-3xl">GRUPOS</p>
                            </div>
                            <div class="flex ml-4 bg-[#000f37] p-1 rounded-lg">
                                <?php foreach ($roles as $role) : ?>
                                    <div class="flex flex-col items-center justify-center ml-4">
                                        <img src="images/roles/<?php echo $role['role_name']; ?>.png" class="w-8 h-8" alt="<?php echo $role['role_name']; ?>">
                                        <p class="text-xs text-white"><?php echo $role['role_name']; ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-------------------------------------------------------------------------------------------------------------------------------------------->
                        <div class="grid grid-cols-3 gap-3 mt-5 mx-5">
                            <?php foreach ($grupos as $grupo) : ?>
                                <div class="col-span-1 grid grid-rows-4">
                                    <div class="row-span-1 grid grid-cols-5">
                                        <div class="col-span-4 flex bg-[#000f37] justify-center items-center">
                                            <p class="font-bold text-2xl text-white p-2"><?php echo $grupo['group_name']; ?> - <?php echo $grupo['group_id']; ?></p>
                                        </div>
                                        <?php
                                        $isMember = $obj->EstaEnGrupo($student_id, $grupo['group_id']);
                                        $isFull = count($obj->ObtenerAlumnosPorGrupoId($grupo['group_id'])) >= $grupo['number_of_students'];
                                        if ($isFull) {
                                            echo '<button class="col-span-1 bg-gray-400 flex text-white justify-center items-center text-3xl hover:text-4xl transition-all" disabled>
                            <i class="fa-solid fa-lock"></i>
                        </button>';
                                        } elseif ($isMember) {
                                            echo '<button onclick="javascript: openModal(\'salir\', \'' . $grupo['group_id'] . '\');" class="col-span-1 bg-[#f94c61] flex text-white justify-center items-center text-3xl hover:text-4xl transition-all">
                            <i class="fa-solid fa-minus"></i>
                        </button>';
                                        } else {
                                            echo '<button onclick="javascript: openModal(\'unirse\', \'' . $grupo['group_id'] . '\');" class="col-span-1 bg-[#3ddcda] flex text-white justify-center items-center text-3xl hover:text-4xl transition-all">
                        <i class="fa-solid fa-plus"></i>
                    </button>';
                                        }
                                        ?>
                                    </div>
                                    <div class="row-span-3 grid grid-cols-5">
                                        <div class="col-span-4 flex flex-col bg-white py-1.5 px-5">
                                            <h5 class="font-extrabold tracking-tight">Integrantes</h5>
                                            <ol class="list-decimal-custom space-y-7 mt-1 space-y-7">
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
                                                <?php
                                                $assignedRoles = array_column($students_group, 'role_id');
                                                foreach ($students_group as $student) :
                                                    $role_name_v = $obj->ObtenerRolAlumnoDelGrupo($grupo['group_id'], $student['student_id']);
                                                ?>
                                                    <div class="relative inline-block w-full text-gray-700">
                                                        <?php if ($student['student_id'] == $student_id) : ?>
                                                            <select class="block appearance-none w-10 bg-gray-400 border-0 rounded-md py-2 pl-5 pr-8 leading-tight focus:outline-none focus:bg-gray-300 focus:border-gray-500 role-select" name="" id="">
                                                                <?php foreach ($roles as $role) : ?>
                                                                    <?php if (!in_array($role['role_id'], $assignedRoles) || $student['role_id'] == $role['role_id']) : ?>
                                                                        <option value="<?php echo $role['role_id']; ?>" data-image="images/roles/<?php echo $role['role_name']; ?>.png" <?php echo ($role_name_v['role_id'] == $role['role_id']) ? 'selected' : ''; ?>>
                                                                            <?php echo $role['role_name']; ?>
                                                                        </option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-2">
                                                                <img src="" class="role-image w-6 h-6">
                                                            </div>
                                                        <?php else : ?>
                                                            <span class="inline-block bg-gray-400 border-0 rounded-md py-2 pl-1 pr-8 leading-tight focus:outline-none focus:bg-gray-300 focus:border-gray-500">
                                                                <img src="images/roles/<?php echo $role_name_v['role_name']; ?>.png" class="w-6 h-6">
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Modal -->
                        <div id="myModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded shadow-lg">
                                <h2 class="text-xl font-bold mb-4" id="modal-title">Confirmación de entrada al grupo</h2>
                                <p class="mb-4" id="modal-content">¿Deseas entrar al grupo?</p>
                                <div>
                                    <button id="confirmBtn" class="bg-red-500 text-white px-4 py-2 rounded">Confirmar</button>
                                    <button id="closeModalBtn" class="bg-gray-200 text-black px-4 py-2 rounded">Cancelar</button>
                                </div>
                            </div>
                        </div>
                        <script src="js/dropdown.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const roleSelects = document.querySelectorAll('.role-select');
                                roleSelects.forEach(select => {
                                    select.addEventListener('change', function() {
                                        const selectedOption = this.options[this.selectedIndex];
                                        const imageUrl = selectedOption.getAttribute('data-image');
                                        const roleImage = this.parentElement.querySelector('.role-image');
                                        roleImage.src = imageUrl;
                                    });

                                    const initialOption = select.options[select.selectedIndex];
                                    const initialImageUrl = initialOption.getAttribute('data-image');
                                    const initialRoleImage = select.parentElement.querySelector('.role-image');
                                    initialRoleImage.src = initialImageUrl;
                                });
                            });

                            function openModal(action, groupId) {
                                const modal = document.getElementById('myModal');
                                const modalTitle = document.getElementById('modal-title');
                                const modalContent = document.getElementById('modal-content');
                                const confirmBtn = document.getElementById('confirmBtn');

                                if (action === 'unirse') {
                                    modalTitle.textContent = 'Confirmación de entrada al grupo';
                                    modalContent.textContent = '¿Deseas entrar al grupo?';
                                    confirmBtn.onclick = function() {
                                        realizarAccion('unirse', groupId);
                                    };
                                } else if (action === 'salir') {
                                    modalTitle.textContent = 'Confirmación de salida del grupo';
                                    modalContent.textContent = '¿Deseas salir del grupo?';
                                    confirmBtn.onclick = function() {
                                        realizarAccion('salir', groupId);
                                    };
                                }

                                modal.classList.remove('hidden');
                            }

                            document.getElementById('closeModalBtn').addEventListener('click', function() {
                                document.getElementById('myModal').classList.add('hidden');
                            });

                            function realizarAccion(action, groupId) {
                                const xhr = new XMLHttpRequest();
                                xhr.open('POST', 'grupo_acciones.php', true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                const studentId = '<?php echo $student_id; ?>';

                                xhr.onload = function() {
                                    if (xhr.status === 200) {
                                        location.reload();
                                    } else {
                                        alert('Error en la solicitud');
                                    }
                                };

                                xhr.send(`action=${action}&group_id=${groupId}&student_id=${studentId}`);
                            }
                        </script>

</body>

</html>