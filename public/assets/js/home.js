document.addEventListener('DOMContentLoaded', () => {
    const user = JSON.parse(localStorage.getItem('user'));
    const token = localStorage.getItem('authToken');

    const rentButtonContainer = document.querySelector('.nav__btn');
    const rentButton = rentButtonContainer.querySelector('.btn');

    const userType = user.is_admin;
    console.log(userType)

    if (userType === true) {
        rentButton.textContent = 'Painel de controle';
        rentButton.onclick = () => {
            if (token) {
                fetch('/api/verify-token', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                    },
                })
                    .then(response => {
                        if (response.ok) {
                            console.log('Token válido. Redirecionando para /admin.');
                            window.location.href = '/admin';
                        } else {
                            throw new Error('Token inválido');
                        }
                    })
                    .catch(error => {
                        console.error('Erro na verificação do token:', error);

                        Swal.fire({
                            icon: 'error',
                            title: 'Acesso Negado',
                            text: 'Token inválido ou expirado. Faça login novamente.',
                            confirmButtonText: 'Ir para Login'
                        }).then(() => {
                            window.location.href = '/login';
                        });
                    });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Token Ausente',
                    text: 'Por favor, faça login para acessar esta página.',
                    confirmButtonText: 'Ir para Login'
                }).then(() => {
                    window.location.href = '/login';
                });
            }
        };
    } else if (userType === false) {
        rentButtonContainer.removeChild(rentButton);
    }
});
