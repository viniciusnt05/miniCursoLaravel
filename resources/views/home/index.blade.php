<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}" />
    <title>Web Design Mastery | RENTAL</title>
</head>
<body>
<header>
    <nav>
        <div class="nav__header">
            <div class="nav__logo">
                <img src="{{ asset('assets/images/logo_brand.svg') }}" alt="Logo">
                <a>Rental</a>
            </div>
            <div class="nav__menu__btn" id="menu-btn">
                <i class="ri-menu-line"></i>
            </div>
        </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#rent">Alugue</a></li>
            <li><a href="#contact">Contate-nos</a></li>
        </ul>
        <div class="nav__btn">
            <button id="rentBtn" class="btn" onclick="window.location.href = '/login'">Alugue agora</button>
        </div>
    </nav>
    <div class="header__container" id="home">
        <h1>Aluguel Premium</h1>
        <img src="{{ asset('assets/images/header.png') }}" alt="header" />
    </div>
</header>


<section class="section__container location__container" id="rent">
    <div class="location__image">
        <img src="{{ asset('assets/images/location.png') }}" alt="location" />
    </div>
    <div class="location__content">
        <h2 class="section__header">Encontre o carro perfeito perto de você</h2>
        <p>
            Descubra o veículo perfeito e adaptado às suas necessidades, onde quer que esteja.
            Nosso recurso 'Encontrar carro em seus locais' permite que você encontre facilmente
            pesquise e selecione entre nossa frota premium disponível perto de você. Se
            você está procurando um sedã de luxo, um SUV espaçoso ou um esportivo
            conversível, nossa ferramenta fácil de usar garante que você encontre o carro ideal para
            sua jornada. Basta inserir sua localização e deixe-nos conectá-lo com
            veículos de primeira linha prontos para locação.
        </p>
    </div>
</section>

<section class="select__container" id="ride">
    <h2 class="section__header">Escolha o carro do seus sonhos</h2>
    <!-- Slider main container -->
    <div class="swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
                <div class="select__card">
                    <img src="{{ asset('assets/images/select-1.png') }}" alt="select" />
                </div>
            </div>
            <div class="swiper-slide">
                <div class="select__card">
                    <img src="{{ asset('assets/images/select-2.png') }}" alt="select" />
                </div>
            </div>
            <div class="swiper-slide">
                <div class="select__card">
                    <img src="{{ asset('assets/images/select-3.png') }}" alt="select" />
                </div>
            </div>
            <div class="swiper-slide">
                <div class="select__card">
                    <img src="{{ asset('assets/images/select-4.png') }}" alt="select" />
                </div>
            </div>
            <div class="swiper-slide">
                <div class="select__card">
                    <img src="{{ asset('assets/images/select-5.png') }}" alt="select" />
                </div>
            </div>
        </div>
    </div>
    <form action="/" class="select__form">
        <div class="select__price">
            <span><i class="ri-price-tag-3-line"></i></span>
            <div><span id="select-price">225</span> /day</div>
        </div>
        <div class="select__btns">
            <button class="btn">View Details</button>
            <button class="btn">Rent Now</button>
        </div>
    </form>
</section>

<section class="banner__container">
    <div class="banner__wrapper">
        <img src="{{ asset('assets/images/banner-1.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-2.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-3.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-4.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-5.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-6.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-7.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-8.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-9.png') }}" alt="banner" />
        <img src="{{ asset('assets/images/banner-10.png') }}" alt="banner" />
    </div>
</section>

<section class="download">
    <div class="section__container download__container">
        <div class="download__content">
            <h2 class="section__header">Aluguel Premium</h2>
            <div class="download__links">
                <a href="#">
                    <img src="{{ asset('assets/images/apple.png') }}" alt="apple" />
                </a>
                <a href="#">
                    <img src="{{ asset('assets/images/google.png') }}" alt="google" />
                </a>
            </div>
        </div>
        <div class="download__image">
            <img src="{{ asset('assets/images/download.png') }}" alt="download" />
        </div>
    </div>
</section>

<section class="news" id="contact">
    <div class="section__container news__container">
        <h2 class="section__header">Stay up to date on all the latest news.</h2>
    </div>
</section>

<footer>
    <div class="section__container footer__container">
        <div class="footer__col">
            <h4>Resources</h4>
            <ul class="footer__links">
                <li><a href="#">Installation Manual</a></li>
                <li><a href="#">Release Note</a></li>
                <li><a href="#">Community Help</a></li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Company</h4>
            <ul class="footer__links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Career</a></li>
                <li><a href="#">Press</a></li>
                <li><a href="#">Support</a></li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Product</h4>
            <ul class="footer__links">
                <li><a href="#">Demo</a></li>
                <li><a href="#">Security</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Features</a></li>
            </ul>
        </div>
        <div class="footer__col">
            <h4>Follow Us</h4>
            <ul class="footer__socials">
                <li>
                    <a href="#"><i class="ri-facebook-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-twitter-fill"></i></a>
                </li>
                <li>
                    <a href="#"><i class="ri-linkedin-fill"></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="footer__bar">
        Copyright © 2024 Web Design Mastery. All rights reserved.
    </div>
</footer>

<script src="https://unpkg.com/scrollreveal"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/home.js') }}"></script>

</body>
</html>
