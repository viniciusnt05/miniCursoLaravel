document.getElementById('newItem').addEventListener('click', async () => {
    let categorias = await fetch('/api/categorias', {
        method: 'GET',
    }).then(response => response.json())
        .catch(error => {
            Swal.fire('Erro', 'Não foi possível carregar as categorias.', 'error');
            console.error('Erro:', error);
        });

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
            <select id="status" class="swal2-input">
                <option value="" disabled selected>Status do veículo</option>
                <option value="disponível">Disponível</option>
                <option value="alugado">Alugado</option>
                <option value="em manutenção">Em Manutenção</option>
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
            const placa = document.getElementById('placa').value.trim();
            const status = document.getElementById('status').value;

            if (!id_categoria || !marca || !modelo || !ano_fabricacao || !placa) {
                Swal.showValidationMessage('Preencha todos os campos');
                return false;
            }

            return { id_categoria, marca, modelo, ano_fabricacao, placa, status };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const data = result.value;
            fetch('/api/veiculos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
                .then(response => response.json())
                .then(() => {
                    Swal.fire('Sucesso', 'Veículo criado com sucesso!', 'success');
                })
                .catch((error) => {
                    Swal.fire('Erro', 'Ocorreu um erro ao criar o veículo.', 'error');
                    console.error('Erro:', error);
                });
        }
    });
});
