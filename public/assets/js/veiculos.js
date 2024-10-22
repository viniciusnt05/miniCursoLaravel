document.getElementById('newItem').addEventListener('click', async () => {
    let categorias = await fetch('/api/categorias', {
        method: 'GET',
    }).then(response => response.json())
        .catch(error => {
            console.error('Erro ao carregar categorias:', error);
            Swal.fire('Erro', 'Não foi possível carregar as categorias.', 'error');
        });

    if (!categorias) {
        console.error('Nenhuma categoria encontrada ou falha na requisição.');
        return;
    }

    const options = categorias.map(
        (cat) => `<option value="${cat.id}">${cat.nome}</option>`
    ).join('');

    Swal.fire({
        title: 'Criar Novo Item',
        html: `
            <select id="id_categoria" class="swal2-input">
                <option value="">Selecione uma categoria</option>
                ${options}
            </select>
            <input type="text" id="marca" class="swal2-input" placeholder="Marca">
            <input type="text" id="modelo" class="swal2-input" placeholder="Modelo">
            <input type="number" id="ano_fabricacao" class="swal2-input" placeholder="Ano de Fabricação">
            <input type="text" id="placa" class="swal2-input" placeholder="Placa">
            <input type="number" id="valor" class="swal2-input" placeholder="R$ Valor">
            <input type="file" id="img" class="swal2-input" accept="image/*" style="width: 50%">
            <select id="status" class="swal2-input">
                <option value="" disabled selected>Status do veículo</option>
                <option value="disponivel">Disponível</option>
                <option value="alugado">Alugado</option>
                <option value="manutencao">Em Manutenção</option>
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
            const id_categoria = document.getElementById('id_categoria').value;
            const marca = document.getElementById('marca').value.trim();
            const modelo = document.getElementById('modelo').value.trim();
            const ano_fabricacao = document.getElementById('ano_fabricacao').value;
            const valor = document.getElementById('valor').value;
            const placa = document.getElementById('placa').value.trim();
            const img = document.getElementById('img').files[0];
            const status = document.getElementById('status').value;

            if (!id_categoria || !marca || !modelo || !ano_fabricacao || !placa || !status || !valor) {
                Swal.showValidationMessage('Preencha todos os campos');
                return false;
            }

            return { id_categoria, marca, modelo, ano_fabricacao, placa, img, status, valor };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;

            // Cria um objeto FormData para envio multipart
            const formData = new FormData();
            formData.append('id_categoria', data.id_categoria);
            formData.append('marca', data.marca);
            formData.append('modelo', data.modelo);
            formData.append('ano_fabricacao', data.ano_fabricacao);
            formData.append('valor', data.valor);
            formData.append('placa', data.placa);
            formData.append('img', data.img); // Adiciona o arquivo de imagem
            formData.append('status', data.status);

            console.log('Dados a serem enviados:', formData);

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/api/veiculos', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                body: formData, // Envia o FormData
            })
                .then(async response => {
                    console.log('Resposta bruta:', response);
                    if (!response.ok) {
                        const errorData = await response.json().catch(() => {
                            console.error('Erro ao analisar a resposta JSON:', response);
                            throw new Error('Resposta inesperada do servidor.');
                        });
                        console.error('Erro na resposta da API:', errorData);
                        throw new Error(errorData.message || 'Erro desconhecido ao criar o veículo.');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Resposta bem-sucedida:', data);
                    Swal.fire('Sucesso', 'Veículo criado com sucesso!', 'success');
                })
                .catch((error) => {
                    console.error('Erro ao criar veículo:', error);
                    Swal.fire('Erro', error.message || 'Ocorreu um erro ao criar o veículo.', 'error');
                });
        }
    });
});

// Função para carregar os veículos da API e preencher a tabela
async function carregarVeiculos() {
    try {
        const response = await fetch('/api/veiculos', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Erro ao buscar veículos');
        }

        const veiculos = await response.json();

        // Preenche a tabela com os veículos
        const tabelaVeiculos = document.querySelector('.table-data .order table tbody');
        tabelaVeiculos.innerHTML = ''; // Limpa a tabela antes de adicionar os dados

        veiculos.forEach((veiculo) => {
            // Constroi o caminho correto para a imagem
            const imgPath = veiculo.img;
            console.log('Caminho da imagem:', imgPath); // Adicione isso para verificar o caminho da imagem

            const row = `
                <tr>
                    <td>${veiculo.categoria ? veiculo.categoria.nome : 'Sem categoria'}</td>
                    <td>${veiculo.marca}</td>
                    <td>${veiculo.modelo}</td>
                    <td>${veiculo.ano_fabricacao}</td>
                    <td>${veiculo.placa}</td>
                    <td>R$ ${parseFloat(veiculo.valor).toFixed(2)}</td>
                    <td><img src="${imgPath}" alt="${veiculo.modelo}" style="width: 50px; height: 50px;"></td>
                    <td>${veiculo.status}</td>
                </tr>
            `;
            tabelaVeiculos.insertAdjacentHTML('beforeend', row);
        });
    } catch (error) {
        Swal.fire('Erro', error.message, 'error');
        console.error('Erro:', error);
    }
}

// Chama a função para carregar os veículos ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    carregarVeiculos();
});

