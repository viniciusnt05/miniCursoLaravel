document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Faz a requisição para buscar o total de reservas
        const response = await fetch('/api/reservas', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Erro ao buscar reservas');
        }

        const data = await response.json();
        console.log(data.numero_total);
        // Verifica se 'numero_total' está presente na resposta
        if (data && data.numero_total !== undefined) {
            // Atualiza o valor no banner "New Order"
            document.getElementById('total-reservas').textContent = data.numero_total;
        } else {
            console.error('A resposta não contém "numero_total".');
        }

        // Outros valores de exemplo para os banners
        document.getElementById('total-visitors').textContent = 2834; // Atualize conforme a lógica
        document.getElementById('total-sales').textContent = '$2543'; // Atualize conforme a lógica
    } catch (error) {
        console.error('Erro ao carregar o dashboard:', error);
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    try {
        // Faz a requisição para buscar o total de reservas
        console.log('Iniciando a requisição para /api/reservas');
        const responseReservas = await fetch('/api/reservas', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!responseReservas.ok) {
            throw new Error('Erro ao buscar reservas');
        }

        const dataReservas = await responseReservas.json();
        console.log('Dados de reservas recebidos:', dataReservas);

        // Verifica se 'numero_total' está presente na resposta de reservas
        if (dataReservas && dataReservas.numero_total !== undefined) {
            console.log('Número total de reservas:', dataReservas.numero_total);
            document.getElementById('total-reservas').textContent = dataReservas.numero_total;
        } else {
            console.error('A resposta de reservas não contém "numero_total".');
        }

        // Faz a requisição para buscar o total de usuários
        console.log('Iniciando a requisição para /api/usuarios');
        const responseUsuarios = await fetch('/api/usuarios', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!responseUsuarios.ok) {
            throw new Error('Erro ao buscar usuários');
        }

        const dataUsuarios = await responseUsuarios.json();
        console.log('Dados de usuários recebidos:', dataUsuarios);

        // Verifica se 'numero_total' está presente na resposta de usuários
        if (dataUsuarios && dataUsuarios.numero_total !== undefined) {
            console.log('Número total de usuários:', dataUsuarios.numero_total);
            document.getElementById('total-visitors').textContent = dataUsuarios.numero_total;
        } else {
            console.error('A resposta de usuários não contém "numero_total".');
        }

        // Valor de exemplo para o banner "Total Sales"
        document.getElementById('total-sales').textContent = '$2543'; // Atualize conforme a lógica
    } catch (error) {
        console.error('Erro ao carregar o dashboard:', error);
    }
});

