document.getElementById('newUser').addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('/api/usuarios', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });


        if (response.ok) {
            const result = await response.json();

            Swal.fire({
                title: 'Sucesso',
                text: 'Usuário criado com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn-success'
                }
            }).then(() => {
                window.location.href = '/login/entrar';
            });
        } else {
            const errorResult = await response.json();
            const errorMessage = errorResult.message || 'Ocorreu um erro ao criar o usuário.';
            Swal.fire('Erro', errorMessage, 'error');
        }
    } catch (error) {
        Swal.fire('Erro', 'Ocorreu um erro ao criar o usuário.', 'error');
        console.error('Erro:', error);
    }
});
