<?php require "navbar.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="carrusel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>

<body>
    <!-- Carrusel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <!--button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></!--button-->

        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/img_bienvenida.png" class="d-block w-100" alt="Slide 1">
                <!--h1 class="mm">
                    Bienvenido
                </!--h1-->
                <!--p class="carousel-caption ">¡Gracias por visitar nuestro sitio web!</!--p-->
            </div>

            <div class="carousel-item">
                <img src="img/administra.png" class="d-block w-100" alt="Slide 2">
                <p class="carousel-caption ">Descubre nuestras increíbles funciones.</p>
            </div>

            <div class="carousel-item">
                <img src="img/gestiona.png" class="d-block w-100" alt="Slide 3">
                <p class="carousel-caption ">Explora nuestra amplia selección de administración.</p>
            </div>
            
            <!--div class="carousel-item">
                <img src="img/img-4.png" class="d-block w-100" alt="Slide 4">
                <p class="carousel-caption ">¡No te pierdas nuestras promociones especiales!</p>
            </!--div-->

        </div>
        <!--button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </!--button>
        <button-- class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button-->
    </div>
</body>

</html>