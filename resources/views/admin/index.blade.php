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
        <a href="#" class="brand">
            <img src="{{ asset('assets/images/logo_brand.svg') }}" alt="Logo">
        </a>
        <h1>Olá <span id="userName">user</span>!</h1>
        <ul class="side-menu top">
            <li class="active">
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
            <li>
                <a href="/equipe">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Equipe</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="/home" class="logout" id="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Sair</span>
                </a>
            </li>
        </ul>
    </section>
    <section id="content">
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                </div>
            </div>
            <ul class="box-info">
                <li>
                    <i class='bx bxs-calendar-check' ></i>
                    <span class="text">
                        <h3 id="total-reservas">0</h3>
                        <p>Reservas</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3 id="total-visitors">0</h3>
                        <p>Clientes</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-dollar-circle' ></i>
                    <span class="text">
                        <h3 id="total-sales">$0</h3>
                        <p>Total Sales</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Orders</h3>
                    </div>
                    <table>
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Date Order</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="todo">
                    <div class="head">
                        <h3>Todos</h3>
                        <i class='bx bx-plus' ></i>
                        <i class='bx bx-filter' ></i>
                    </div>
                    <ul class="todo-list">

                    </ul>
                </div>
            </div>
        </main>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/admin.js') }}"></script>

</html>
