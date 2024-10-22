document.getElementById('loginForm').addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const result = await response.json();

            localStorage.setItem('user', JSON.stringify(result['usuario']));
            localStorage.setItem('authToken', result['token']);

            window.location.href = '/home';
        } else {
            const errorResult = await response.json();
            const errorMessage = errorResult.message || 'Verifique suas credenciais e tente novamente';
            Swal.fire('Erro', errorMessage, 'error');
        }
    } catch (error) {
        Swal.fire('Erro', 'Ocorreu um erro ao identificar usuário.', 'error');
        console.error('Erro:', error);
    }
});
