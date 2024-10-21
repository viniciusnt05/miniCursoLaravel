<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/carro.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}"/>
    <title>Car Details | RENTAL</title>
</head>
<body>
    <header>
        <nav>
            <div class="nav__header">
                <div class="nav__logo">
                    <img src="{{ asset('assets/images/logo_brand.svg') }}" alt="Logo">
                    <a>Rental</a>
                </div>
                <ul class="nav__links" id="nav-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#rent">Alugue</a></li>
                    <li><a href="#contact">Contate-nos</a></li>
                </ul>
                <div class="nav__btn">
                    <button class="btn" onclick="window.location.href = '/login'">Alugue agora</button>
                </div>
            </div>
        </nav>
    </header>

    <div class="car-details">
        <img src="car_image.jpg" alt="Car Image"/>
        <div class="details">
            <h1>Nome do Carro</h1>
            <p><strong>Marca:</strong> Marca do Carro</p>
            <p><strong>Ano:</strong> 2023</p>
            <p><strong>Descrição:</strong> Descrição detalhada do carro, incluindo suas características e benefícios.</p>
        </div>
        <button class="btn-rent">Alugar</button>
    </div>

</body>
</html>
