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
        <li class="active">
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
        <li>
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
            <h1>Veículos</h1>
            <div class="filter">
                <div class="filter-title">
                    <h3>Buscar</h3>
                    <label>
                        <input type="text" id="searchInput" placeholder="Nome do veículo">
                        <button class="cleanBtn" id="clearBtn">Limpar</button>
                    </label>
                </div>
                <div class="newItem">
                    <button id="newItem" class="filterBtn">Novo veículo</button>
                </div>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <table>
                    <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                        <th>Placa</th>
                        <th>Valor</th>
                        <th>Img</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="veiculos-list">
                    <!-- As linhas da tabela serão geradas dinamicamente -->
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/veiculos.js') }}"></script>
</body>
</html>
