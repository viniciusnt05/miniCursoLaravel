document.querySelector('.newItem button').addEventListener('click', async () => {
    Swal.fire({
        title: 'Criar Novo Admin',
        html: `
            <input type="text" id="nome" class="swal2-input" placeholder="Nome" required>
            <input type="text" id="cpf" class="swal2-input" placeholder="CPF" required>
            <input type="email" id="email" class="swal2-input" placeholder="Email" required>
            <input type="date" id="data_nascimento" class="swal2-input" placeholder="Data de Nascimento" required>
            <input type="password" id="senha" class="swal2-input" placeholder="Senha" required>
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
            const nome = document.getElementById('nome').value.trim();
            const cpf = document.getElementById('cpf').value.trim();
            const email = document.getElementById('email').value.trim();
            const data_nascimento = document.getElementById('data_nascimento').value;
            const senha = document.getElementById('senha').value;

            if (!nome || !cpf || !email || !data_nascimento || !senha) {
                Swal.showValidationMessage('Preencha todos os campos obrigatórios');
                return false;
            }

            return { nome, cpf, email, data_nascimento, senha };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            data.tipo_usuario = 'admin'; // Define o tipo de usuário como admin

            // Envia a requisição para criar o usuário admin
            fetch('/api/usuarios', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                    Swal.fire('Sucesso', 'Usuário administrador criado com sucesso!', 'success')
                        .then(() => {
                            carregarUsuarios(); // Atualiza a tabela de usuários
                        });
                })
                .catch((error) => {
                    console.error('Erro ao criar usuário admin:', error);
                    Swal.fire('Erro', 'Ocorreu um erro ao criar o usuário.', 'error');
                });
        }
    });
});

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
        const usuarios = data.usuarios || [];

        // Limpa a tabela antes de adicionar novos dados
        const tbody = document.querySelector('.table-data .order table tbody');
        tbody.innerHTML = '';

        // Adiciona os usuários na tabela
        usuarios.forEach(usuario => {
            if (usuario.tipo_usuario === 'admin') {
                const row = `
                    <tr>
                        <td>${usuario.nome}</td>
                        <td>${usuario.cpf}</td>
                        <td>${usuario.data_nascimento}</td>
                        <td>${usuario.email}</td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            }
        });
    } catch (error) {
        console.error('Erro ao carregar os usuários:', error);
    }
}

// Chama a função ao carregar a página
document.addEventListener('DOMContentLoaded', carregarUsuarios);

