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
                    <td><button class="btn-success" onclick="editVeiculo(${veiculo.id})">Editar</button></td>
                    <td><button class="btn-danger" onclick="deleteVeiculo(${veiculo.id})">Excluir</button></td>
                </tr>
            `;
            tabelaVeiculos.insertAdjacentHTML('beforeend', row);
        });
    } catch (error) {
        Swal.fire('Erro', error.message, 'error');
        console.error('Erro:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearBtn');

    // Carrega todos os veículos ao carregar a página
    carregarVeiculos();

    // Verifica se os elementos foram encontrados antes de adicionar os event listeners
    if (searchInput && clearBtn) {
        searchInput.addEventListener('input', async (event) => {
            const query = event.target.value.trim();

            // Recarrega todos os veículos se o input estiver vazio
            if (query.length === 0) {
                carregarVeiculos();
                return;
            }

            try {
                // Faz uma requisição para o endpoint de busca de veículos
                const response = await fetch(`/api/veiculos/search/${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Erro ao buscar veículos');
                }

                const veiculos = await response.json();

                // Renderiza os veículos encontrados
                renderVeiculos(veiculos);
            } catch (error) {
                console.error('Erro ao buscar veículos:', error);
                Swal.fire('Erro', 'Ocorreu um erro ao buscar os veículos.', 'error');
            }
        });

        clearBtn.addEventListener('click', () => {
            searchInput.value = ''; // Limpa o campo de busca
            carregarVeiculos(); // Recarrega todos os veículos
        });
    } else {
        console.error('Elementos de busca não encontrados na página.');
    }
});

// Função para renderizar os veículos na tabela
function renderVeiculos(veiculos) {
    const tbody = document.getElementById('veiculos-list');
    tbody.innerHTML = ''; // Limpa a tabela antes de adicionar os dados

    if (veiculos.length > 0) {
        veiculos.forEach(veiculo => {
            const row = document.createElement('tr');

            const categoriaCell = document.createElement('td');
            categoriaCell.textContent = veiculo.categoria ? veiculo.categoria.nome : 'Sem categoria';

            const marcaCell = document.createElement('td');
            marcaCell.textContent = veiculo.marca;

            const modeloCell = document.createElement('td');
            modeloCell.textContent = veiculo.modelo;

            const anoCell = document.createElement('td');
            anoCell.textContent = veiculo.ano_fabricacao;

            const placaCell = document.createElement('td');
            placaCell.textContent = veiculo.placa;

            const valorCell = document.createElement('td');
            valorCell.textContent = `R$ ${parseFloat(veiculo.valor).toFixed(2)}`;

            const imgCell = document.createElement('td');
            const img = document.createElement('img');
            img.src = veiculo.img;
            img.alt = veiculo.modelo;
            img.style.width = '50px';
            img.style.height = '50px';
            imgCell.appendChild(img);

            const statusCell = document.createElement('td');
            statusCell.textContent = veiculo.status;

            const editCell = document.createElement('td');
            const editButton = document.createElement('button');
            editButton.textContent = 'Editar';
            editButton.className = 'btn-success';
            editButton.onclick = () => {
                editVeiculo(veiculo); // Passando o objeto veículo
            };
            editCell.appendChild(editButton);

            const deleteCell = document.createElement('td');
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Excluir';
            deleteButton.className = 'btn-danger';
            deleteButton.onclick = () => {
                deleteVeiculo(veiculo.id);
            };
            deleteCell.appendChild(deleteButton);

            row.appendChild(categoriaCell);
            row.appendChild(marcaCell);
            row.appendChild(modeloCell);
            row.appendChild(anoCell);
            row.appendChild(placaCell);
            row.appendChild(valorCell);
            row.appendChild(imgCell);
            row.appendChild(statusCell);
            row.appendChild(editCell);
            row.appendChild(deleteCell);

            tbody.appendChild(row);
        });
    } else {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 10;
        cell.textContent = 'Não há veículos cadastrados';
        cell.style.textAlign = 'center';
        row.appendChild(cell);
        tbody.appendChild(row);
    }
}

async function editVeiculo(id) {
    try {
        // Faz uma requisição para buscar os dados do veículo pelo ID
        const response = await fetch(`/api/veiculos/${id}`, {
            method: 'GET',
        });

        if (!response.ok) {
            throw new Error('Erro ao buscar veículo');
        }

        const veiculo = await response.json();

        Swal.fire({
            title: 'Editar Veículo',
            html: `
                <select id="id_categoria" class="swal2-input">
                    <option value="${veiculo.id_categoria}">${veiculo.categoria.nome}</option>
                </select>
                <input type="text" id="marca" class="swal2-input" placeholder="Marca" value="${veiculo.marca}">
                <input type="text" id="modelo" class="swal2-input" placeholder="Modelo" value="${veiculo.modelo}">
                <input type="number" id="ano_fabricacao" class="swal2-input" placeholder="Ano de Fabricação" value="${veiculo.ano_fabricacao}">
                <input type="text" id="placa" class="swal2-input" placeholder="Placa" value="${veiculo.placa}">
                <input type="number" id="valor" class="swal2-input" placeholder="Valor" value="${veiculo.valor}">
                <select id="status" class="swal2-input">
                    <option value="disponivel" ${veiculo.status === 'disponivel' ? 'selected' : ''}>Disponível</option>
                    <option value="alugado" ${veiculo.status === 'alugado' ? 'selected' : ''}>Alugado</option>
                    <option value="manutencao" ${veiculo.status === 'manutencao' ? 'selected' : ''}>Em Manutenção</option>
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
                const marca = document.getElementById('marca').value;
                const modelo = document.getElementById('modelo').value;
                const ano_fabricacao = document.getElementById('ano_fabricacao').value;
                const placa = document.getElementById('placa').value;
                const valor = document.getElementById('valor').value;
                const status = document.getElementById('status').value;

                if (!id_categoria || !marca || !modelo || !ano_fabricacao || !placa || !valor || !status) {
                    Swal.showValidationMessage('Preencha todos os campos obrigatórios');
                    return false;
                }

                return { id_categoria, marca, modelo, ano_fabricacao, placa, valor, status };
            }
        }).then(async (result) => {
            if (result.isConfirmed) {
                const data = result.value;

                // Faz a requisição para atualizar o veículo
                try {
                    const response = await fetch(`/api/veiculos/${id}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data),
                    });

                    if (!response.ok) {
                        throw new Error('Erro ao atualizar veículo');
                    }

                    Swal.fire('Sucesso', 'Veículo atualizado com sucesso!', 'success');
                    window.location.reload(); // Recarrega a página após a atualização
                } catch (error) {
                    Swal.fire('Erro', 'Ocorreu um erro ao atualizar o veículo.', 'error');
                    console.error('Erro:', error);
                }
            }
        });
    } catch (error) {
        Swal.fire('Erro', 'Ocorreu um erro ao buscar o veículo.', 'error');
        console.error('Erro:', error);
    }
}

async function deleteVeiculo(id) {
    const result = await Swal.fire({
        title: 'Excluir Veículo',
        text: 'Você tem certeza que deseja excluir este veículo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Excluir',
        cancelButtonText: 'Cancelar',
        focusConfirm: false,
        customClass: {
            confirmButton: 'btn-danger',
            cancelButton: 'btn-cancel'
        },
    });

    if (result.isConfirmed) {
        try {
            const response = await fetch(`/api/veiculos/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('Erro ao excluir veículo');
            }

            Swal.fire('Sucesso', 'Veículo excluído com sucesso!', 'success');
            window.location.reload(); // Recarrega a página após a exclusão
        } catch (error) {
            Swal.fire('Erro', 'Ocorreu um erro ao excluir o veículo.', 'error');
            console.error('Erro:', error);
        }
    }
}

// Chama a função para carregar os veículos ao carregar a página
document.addEventListener('DOMContentLoaded', () => {
    carregarVeiculos();
});

