<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}" />
    <title>AdminHub</title>
</head>
<body>
<section id="sidebar">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <a href="#" class="brand">
        <img src="{{ asset('assets/images/logo_brand.svg') }}" alt="Logo">
    </a>
    <h1>Olá user</h1>
    <ul class="side-menu top">
        <li>
            <a href="/admin">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="/reservas">
                <i class='bx bxs-shopping-bag-alt' ></i>
                <span class="text">Reservas</span>
            </a>
        </li>
        <li>
            <a href="/veiculos">
                <i class='bx bxs-car-garage' ></i>
                <span class="text">Veículos</span>
            </a>
        </li>
        <li>
            <a href="/categorias">
                <i class='bx bxs-category' ></i>
                <span class="text">Categorias</span>
            </a>
        </li>
        <li class="active">
            <a href="/equipe">
                <i class='bx bxs-group' ></i>
                <span class="text">Equipe</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="/home" class="logout">
                <i class='bx bxs-log-out-circle' ></i>
                <span class="text">Sair</span>
            </a>
        </li>
    </ul>
</section>
<section id="content">
    <main>
        <div class="head-title">
            <h1>Categorias</h1>
            <div class="filter">
                <div class="filter-title">
                    <h3>Buscar</h3>
                    <label>
                        <input type="text" placeholder="Nome da categoria">
                        <button class="cleanBtn">Limpar</button>
                    </label>
                </div>
                <div class="newItem">
                    <button class="filterBtn">Novo Admin</button>
                </div>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Recent Orders</h3>
                </div>
                <table>
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </main>
</section>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/admins.js') }}"></script>

</html>
