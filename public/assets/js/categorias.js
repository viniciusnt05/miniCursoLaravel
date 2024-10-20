window.onload = fetchCategorias;

document.getElementById('newItem').addEventListener('click', async () => {
    Swal.fire({
        title: 'Criar Nova Categoria',
        html: `
            <input type="text" id="nome" class="swal2-input" placeholder="Nome" required>
            <input type="text" id="descricao" class="swal2-input" placeholder="Descrição">
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
            const nome = document.getElementById('nome').value;
            const descricao = document.getElementById('descricao').value.trim();

            return { nome, descricao };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            fetch('/api/categorias', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Categoria criada com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn-success'
                    }
                }).then(() => {
                    window.location.reload();
                })
            .catch((error) => {
                Swal.fire('Erro', 'Ocorreu um erro ao criar a categoria.', 'error');
                console.error('Erro:', error);
            });
        }
    });
});

document.getElementById('searchInput').addEventListener('input', async (event) => {
    const query = event.target.value.trim();

    if (query.length === 0) {
        fetchCategorias();
        return;
    }

    try {
        const response = await fetch(`/api/categorias/search/${encodeURIComponent(query)}`); // Use o endpoint apropriado

        const categorias = await response.json();
        renderCategorias(categorias);
    } catch (error) {
        console.error('Erro:', error);
        Swal.fire('Erro', 'Ocorreu um erro ao buscar as categorias.', 'error');
    }
});

document.getElementById('clearBtn').addEventListener('click', () => {
    document.getElementById('searchInput').value = '';
    fetchCategorias();
});

function renderCategorias(categorias) {
    const tbody = document.createElement('tbody');

    if (categorias.length > 0) {
        categorias.forEach(categoria => {
            const row = document.createElement('tr');

            const nomeCell = document.createElement('td');
            nomeCell.textContent = categoria.nome;

            const descricaoCell = document.createElement('td');
            descricaoCell.textContent = categoria.descricao;

            const editCell = document.createElement('td');
            const editButton = document.createElement('button');
            editButton.textContent = 'Editar';
            editButton.className = 'btn-success';
            editButton.onclick = () => {
                editCategoria(categoria); // Passando o objeto categoria
            };
            editCell.appendChild(editButton);

            const deleteCell = document.createElement('td');
            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Excluir';
            deleteButton.className = 'btn-danger';
            deleteButton.onclick = () => {
                deleteCategoria(categoria.id);
            };
            deleteCell.appendChild(deleteButton);

            row.appendChild(nomeCell);
            row.appendChild(descricaoCell);
            row.appendChild(editCell);
            row.appendChild(deleteCell);

            tbody.appendChild(row);
        });
    } else {
        const row = document.createElement('tr');
        const cell = document.createElement('td');
        cell.colSpan = 4;
        cell.textContent = 'Não há categorias cadastradas';
        cell.style.textAlign = 'center';
        row.appendChild(cell);
        tbody.appendChild(row);
    }

    const table = document.querySelector('.order table');
    table.querySelector('tbody')?.remove();
    table.appendChild(tbody);
}

async function fetchCategorias() {
    try {
        const response = await fetch('/api/categorias');
        const categorias = await response.json();
        renderCategorias(categorias);
    } catch (error) {
        console.error('Erro ao carregar categorias:', error);
    }
}

async function editCategoria(id) {
    let categoria = await fetch(`/api/categorias/${id}`, {
        method: 'GET',
    }).then(response => response.json())
        .catch(error => {
            Swal.fire('Erro', 'Não foi possível encontrar a categoria.', 'error');
            console.error('Erro:', error);
        });

    Swal.fire({
        title: 'Editar Categoria',
        html: `
            <input type="text" id="nome" class="swal2-input" placeholder="Nome" value="${categoria.nome}" required>
            <input type="text" id="descricao" class="swal2-input" placeholder="Descrição" value="${categoria.descricao}">
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
            const nome = document.getElementById('nome').value;
            const descricao = document.getElementById('descricao').value.trim();

            if (!nome) {
                Swal.showValidationMessage('Por favor, insira um nome');
                return false;
            }

            return { nome, descricao };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            fetch(`/api/categorias/${categoria.id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao atualizar a categoria');
                    }
                    return response.json();
                })
                .then(() => {
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Categoria editada com sucesso!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn-success'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                })
                .catch((error) => {
                    Swal.fire('Erro', 'Ocorreu um erro ao editar a categoria.', 'error');
                    console.error('Erro:', error);
                });
        }
    });
}

async function deleteCategoria(id) {
    const result = await Swal.fire({
        title: 'Excluir Categoria',
        text: 'Você tem certeza que deseja excluir esta categoria?',
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
            const response = await fetch(`/api/categorias/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            });

            if (!response.ok) {
                Swal.fire('Erro', 'Ocorreu um erro ao excluir a categoria.', 'error');
            }

            Swal.fire({
                title: 'Sucesso',
                text: 'Categoria excluída com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn-success'
                }
            }).then(() => {
                window.location.reload();
            });
        } catch (error) {
            Swal.fire('Erro', 'Ocorreu um erro ao excluir a categoria.', 'error');
            console.error('Erro:', error);
        }
    }
}

