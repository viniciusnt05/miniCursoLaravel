document.addEventListener('DOMContentLoaded', async () => {
    await carregarReservas();
    await carregarUsuarios();
    await carregarTotalSales();
});

// Função para carregar o total de reservas
async function carregarReservas() {
    try {
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

        // Atualiza o valor no banner de reservas
        if (data && data.numero_total !== undefined) {
            document.getElementById('total-reservas').textContent = data.numero_total;
        } else {
            console.error('A resposta de reservas não contém "numero_total".');
        }
    } catch (error) {
        console.error('Erro ao carregar o total de reservas:', error);
    }
}

// Função para carregar o total de usuários
async function carregarUsuarios() {
    try {
        const response = await fetch('/api/usuarios', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Erro ao buscar usuários');
        }

        const data = await response.json();

        // Atualiza o valor no banner de usuários
        if (data && data.numero_total !== undefined) {
            document.getElementById('total-visitors').textContent = data.numero_total;
        } else {
            console.error('A resposta de usuários não contém "numero_total".');
        }
    } catch (error) {
        console.error('Erro ao carregar o total de usuários:', error);
    }
}

// Função para carregar o valor total das reservas concluídas
async function carregarTotalSales() {
    try {
        const response = await fetch('/api/reservas', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Erro ao buscar total de vendas');
        }

        const data = await response.json();

        // Atualiza o valor no banner de vendas concluídas
        if (data && data.valor_total_concluidas !== undefined) {
            document.getElementById('total-sales').textContent = `R$ ${parseFloat(data.valor_total_concluidas).toFixed(2)}`;
        } else {
            console.error('A resposta de vendas não contém "valor_total_concluidas".');
        }
    } catch (error) {
        console.error('Erro ao carregar o total de vendas:', error);
    }
}
