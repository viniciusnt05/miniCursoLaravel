<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}" />
    <title>Web Design Mastery | RENTAL</title>
</head>
<body>
<div class="container font-pattern ">
    <div class="content first-content ">
        <div class="first-column">
            <img src="{{ asset('assets/images/logo_brand.svg') }}" alt="Logo">
            <h2 class="title title-primary">Bem vindo de volta!</h2>
            <button id="signin" class="btn btn-primary" onclick="window.location.href='/login/entrar'">Entrar!</button>
        </div>
        <div class="second-column">
            <h2 class="title title-second">Ainda não é cliente?</h2>
            <p class="description description-second">Descubra a liberdade de dirigir o carro ideal – fácil, rápido e do seu jeito!</p>

            <form class="form" action="/api/usuarios" method="post">
                <label class="label-input" for="">
                    <i class="far fa-user icon-modify"></i>
                    <input name="nome" type="text" placeholder="Nome" required>
                </label>

                <label class="label-input" for="">
                    <i class="far fa-user icon-modify"></i>
                    <input name="cpf" type="text" placeholder="CPF" required oninput="mascaraCpf(this)">
                </label>

                <label name="email" class="label-input" for="">
                    <i class="far fa-envelope icon-modify"></i>
                    <input name="email" type="email" placeholder="Email" required>
                </label>

                <label name="data_nascimento" class="label-input" for="">
                    <i class="far fa-envelope icon-modify"></i>
                    <input name="data_nascimento" type="date" placeholder="data_nascimento" required>
                </label>

                <label name="senha" class="label-input" for="">
                    <i class="fas fa-lock icon-modify"></i>
                    <input name="senha" type="password" placeholder="Senha" required>
                </label>

                <button class="btn btn-second">Pronto</button>
            </form>
        </div><!-- second column -->
    </div><!-- first content -->
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function mascaraCpf(cpfInput) {
        // Remove caracteres que não são dígitos
        let valor = cpfInput.value.replace(/\D/g, '');

        // Limita a 11 dígitos
        if (valor.length > 11) valor = valor.slice(0, 11);

        // Formata o CPF
        cpfInput.value = valor
            .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona o primeiro ponto
            .replace(/(\d{3})(\d)/, '$1.$2') // Adiciona o segundo ponto
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o traço

        // Valida CPF quando chegar aos 11 dígitos
        if (valor.length === 11) {
            if (!validarCPF(valor)) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'CPF não é válido, por favor digite um correto.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                cpfInput.value = '';
            }
        }
    }

    function validarCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');

        // CPF deve ter 11 dígitos e não pode ser uma sequência repetida
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        let soma = 0;
        let resto;

        // Validação do primeiro dígito verificador
        for (let i = 1; i <= 9; i++) {
            soma += parseInt(cpf.charAt(i - 1)) * (11 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) {
            resto = 0;
        }
        if (resto !== parseInt(cpf.charAt(9))) {
            return false;
        }

        soma = 0;

        // Validação do segundo dígito verificador
        for (let i = 1; i <= 10; i++) {
            soma += parseInt(cpf.charAt(i - 1)) * (12 - i);
        }
        resto = (soma * 10) % 11;
        if (resto === 10 || resto === 11) {
            resto = 0;
        }
        if (resto !== parseInt(cpf.charAt(10))) {
            return false;
        }

        return true;
    }

    const params = new URLSearchParams(window.location.search);
    const message = params.get('message');

    if (message) {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: message,
        }).then(() => {
            // Remove the message from the URL
            params.delete('message');
            const newUrl = window.location.pathname + '?' + params.toString();
            history.replaceState(null, '', newUrl);
        });
    }

</script>
</body>
</html>
