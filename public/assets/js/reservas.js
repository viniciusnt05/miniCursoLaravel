document.getElementById('newItem').addEventListener('click', async () => {
    // Carrega os veículos disponíveis para a reserva
    let veiculos = await fetch('/api/veiculos', { method: 'GET' })
        .then(response => response.json())
        .catch(error => {
            Swal.fire('Erro', 'Não foi possível carregar os veículos.', 'error');
            console.error('Erro:', error);
        });

    // Carrega os usuários para a reserva
    let usuarios = await fetch('/api/usuarios', { method: 'GET' })
        .then(response => response.json())
        .catch(error => {
            Swal.fire('Erro', 'Não foi possível carregar os usuários.', 'error');
            console.error('Erro:', error);
        });

    // Monta as opções dos veículos
    const optionsVeiculos = veiculos.map(
        (veiculo) => `<option value="${veiculo.id}">${veiculo.modelo} - ${veiculo.placa}</option>`
    ).join('');

    // Monta as opções dos usuários
    const optionsUsuarios = usuarios.map(
        (usuario) => `<option value="${usuario.id}">${usuario.nome}</option>`
    ).join('');

    // Exibe o modal de criação de reserva
    Swal.fire({
        title: 'Criar Nova Reserva',
        html: `
            <select id="id_veiculo" class="swal2-input">
                <option value="">Selecione um veículo</option>
                ${optionsVeiculos}
            </select>
            <select id="id_cliente" class="swal2-input">
                <option value="">Selecione um cliente</option>
                ${optionsUsuarios}
            </select>
            <label>Data de Retirada</label>
            <input type="date" id="data_retirada" class="swal2-input">
            <label>Data de Devolução Prevista</label>
            <input type="date" id="data_devolucao_prevista" class="swal2-input">
            <label>Valor Total</label>
            <input type="number" id="valor_total" class="swal2-input" placeholder="Valor Total">
            <select id="status" class="swal2-input">
                <option value="" disabled selected>Status da Reserva</option>
                <option value="confirmada">Confirmada</option>
                <option value="concluida">Concluída</option>
                <option value="cancelada">Cancelada</option>
            </select>
        `,
        confirmButtonText: 'Salvar',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        customClass: {
            confirmButton: 'btn-success',
            cancelButton: 'btn-cancel'
        },
        preConfirm: () => {
            const id_veiculo = document.getElementById('id_veiculo').value;
            const id_cliente = document.getElementById('id_cliente').value;
            const data_retirada = document.getElementById('data_retirada').value;
            const data_devolucao_prevista = document.getElementById('data_devolucao_prevista').value;
            const valor_total = document.getElementById('valor_total').value;
            const status = document.getElementById('status').value;

            if (!id_veiculo || !id_cliente || !data_retirada || !data_devolucao_prevista || !valor_total || !status) {
                Swal.showValidationMessage('Preencha todos os campos obrigatórios');
                return false;
            }

            return { id_veiculo, id_cliente, data_retirada, data_devolucao_prevista, valor_total, status };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;

            // Envia a requisição para criar a reserva
            fetch('/api/reservas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(() => {
                    Swal.fire('Sucesso', 'Reserva criada com sucesso!', 'success');
                    carregarReservas(); // Recarrega a tabela de reservas
                })
                .catch((error) => {
                    Swal.fire('Erro', error.message || 'Ocorreu um erro ao criar a reserva.', 'error');
                    console.error('Erro:', error);
                });
        }
    });
});


// Função para carregar as reservas da API e preencher a tabela
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

        const reservas = await response.json();

        // Preenche a tabela com as reservas
        const tabelaReservas = document.querySelector('.table-data .order table tbody');
        tabelaReservas.innerHTML = ''; // Limpa a tabela antes de adicionar os dados

        reservas.forEach((reserva) => {
            const row = `
                <tr>
                    <td>${reserva.usuario.nome}</td>
                    <td>${reserva.veiculo.modelo}</td>
                    <td>${new Date(reserva.data_reserva).toLocaleDateString()}</td>
                    <td>${new Date(reserva.data_devolucao).toLocaleDateString()}</td>
                    <td>${reserva.status}</td>
                </tr>
            `;
            tabelaReservas.insertAdjacentHTML('beforeend', row);
        });
    } catch (error) {
        Swal.fire('Erro', error.message, 'error');
        console.error('Erro:', error);
    }
}

// Chama a função para carregar as reservas ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    carregarReservas();
});
