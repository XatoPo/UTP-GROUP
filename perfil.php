<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta de Perfil</title>
    <link rel="stylesheet" href="css/styles_index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
</head>
<body>
    <div class="tarjeta">
        <div class="encabezado">
            <div class="imagen-perfil-contenedor">
                <img src="img/panda.jpg" alt="Imagen de Perfil" class="imagen-perfil">
            </div>
            <div class="boton-cerrar">&times;</div>
        </div>
        <div class="info">
            <h2>Flavio Sebastian Villanueva Medina - U21201392</h2>
            <h3>Ingeniería de Software</h3>
        </div>
        <div class="seccion">
            <h4>Descripción</h4>
            <textarea placeholder="Soy una persona..."></textarea>
        </div>
        <div class="acordeon">
            <div class="seccion-acordeon">
                <h4 class="acordeon-titulo">Habilidades blandas</h4>
                <div class="acordeon-contenido">
                    <div class="habilidades">
                        <input type="text" placeholder="1">
                        <input type="text" placeholder="4">
                        <input type="text" placeholder="2">
                        <input type="text" placeholder="5">
                        <input type="text" placeholder="3">
                        <input type="text" placeholder="6">
                    </div>
                </div>
            </div>
            <div class="seccion-acordeon">
                <h4 class="acordeon-titulo">Conocimientos</h4>
                <div class="acordeon-contenido">
                    <div class="habilidades">
                        <input type="text" placeholder="1">
                        <input type="text" placeholder="4">
                        <input type="text" placeholder="2">
                        <input type="text" placeholder="5">
                        <input type="text" placeholder="3">
                        <input type="text" placeholder="6">
                    </div>
                </div>
            </div>
        </div>
        <div class="seccion">
            <h4>Pasatiempos</h4>
            <input name="tags-pasatiempos" placeholder=""" value="">
        </div>
        <div class="seccion">
            <button class="boton-guardar">Guardar</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="js/main.js"></script>
</body>
</html>