<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('assets/css/entrar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}"/>
    <title>Web Design Mastery | RENTAL</title>
</head>
<body>
<div class="container font-pattern">
    <img src="{{ asset('assets/images/logo_brand.svg') }}" alt="Logo" class="logo">

    <h2 class="title title-second">Bem-vindo de volta!</h2>

    <p class="description description-second">
        Pronto para acelerar? Faça seu login e alugue o carro perfeito em poucos cliques!
    </p>

    <form id="loginForm" class="form">
        <label class="label-input">
            <input id="email" name="email" type="email" placeholder="Email" required>
        </label>

        <label class="label-input">
            <input id="senha" name="senha" type="password" placeholder="Senha" required>
        </label>

        <a href="/" class="description forgot-password">
            Esqueci minha senha
        </a>

        <div class="buttons">
            <button type="button" class="btn btn-second btn-back" onclick="window.location.href='/login'">Voltar</button>
            <button type="submit" class="btn btn-second btn-enter">Entrar</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('assets/js/entrar.js')}}"></script>
</body>
</html>
