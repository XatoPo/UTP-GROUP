<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión | UTP + class</title>
    <link rel="shortcut icon" href="images/icon/favicon-utp-class.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f6f9ff] h-screen flex items-center justify-center">
    <main>
        <div class="grid grid-cols-3 w-[1200px]">
            <div class="col-span-2">
                <img src="images/login/web-login-pao.png" alt="">
            </div>
            <div class="col-span-1 flex flex-col items-center justify-center gap-y-5">
                <div class="flex flex-col items-center gap-y-1">
                    <h1 class="text-2xl font-bold text-gray-700">Bienvenido a</h1>
                    <img src="images/logo/logo-pao-class.png" class="w-56" alt="">
                </div>
<<<<<<< HEAD

                <h3 class="font-bold text-3xl">INICIO DE SESIÓN</h3>
                
                <form action="controller/control.php?opc=1" method="POST">
                    <div class="flex flex-col relative">
                        <input
                            class="peer bg-[#f6f9ff] rounded-md border-2 p-2 focus:outline-none placeholder-transparent focus:border-black border-gray-400 w-[300px]"
                            type="text" name="id" id="id" placeholder="Correo electrónico" required>
                        <label
                            class="absolute bg-[#f6f9ff] inline-flex px-2 ms-2 -top-3 text-sm text-black transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-black peer-focus:text-sm peer-focus:px-2"
                            for="id">Código de estudiante</label>

                    </div>
                    <div class="flex flex-col relative">
                        <input
                            class="peer bg-[#f6f9ff] rounded-md border-2 p-2 focus:outline-none placeholder-transparent focus:border-black border-gray-400 w-[300px]"
                            type="password" name="password" id="password" placeholder="Contraseña" required>
                        <label
                            class="absolute bg-[#f6f9ff] inline-flex px-2 ms-2 -top-3 text-sm text-black  transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3 peer-focus:text-black  peer-focus:text-sm peer-focus:px-2"
                            for="password">Contraseña</label>
                    </div>
                    <a class="text-blue-600 hover:underline" href="#">¿Olvidaste tu contraseña?</a>
                    <input type="submit" value="Iniciar Sesión" name="iniciar_sesion"
                        class="bg-black w-[300px] py-2 rounded-lg text-white border border-black hover:bg-white hover:text-black transition">
                </form>
                
            </div>
        </div>
    </main>
</body>

</html>