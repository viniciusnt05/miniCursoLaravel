document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('authToken');
    const user = JSON.parse(localStorage.getItem('user'));

    console.log(token);
    if (!token) {
        Swal.fire({
            icon: 'warning',
            title: 'Acesso Negado',
            text: 'Você precisa fazer login para acessar esta página.',
            confirmButtonText: 'Ir para Login',
            customClass: {
                confirmButton: 'btn-cancel'
            }
        }).then(() => {
            window.location.href = '/login';
        });
        return;
    }

    fetch('/api/verify-token', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
        },
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Token inválido ou expirado');
            }

            document.getElementById('userName').textContent = user.nome;
            console.log('Token válido. Acesso permitido.');
        })
        .catch(error => {
            console.error('Erro na verificação do token:', error);

            Swal.fire({
                icon: 'error',
                title: 'Sessão Inválida',
                text: 'Seu token é inválido ou expirou. Faça login novamente.',
                confirmButtonText: 'Ir para Login'
            }).then(() => {
                window.location.href = '/login';
            });
        });
});

document.getElementById('logout').addEventListener('click', function () {
    localStorage.setItem('authToken', null);
    localStorage.setItem('user', JSON.stringify(null));

    if (logoutButton) {
        logoutButton.onclick = () => {
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Você será desconectado do sistema.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, sair',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const token = localStorage.getItem('authToken');

                    if (token) {
                        fetch('/api/logout', {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${token}`,
                                'Content-Type': 'application/json',
                            },
                        })
                            .then(response => {
                                if (response.ok) {
                                    localStorage.removeItem('authToken');
                                    Swal.fire(
                                        'Desconectado!',
                                        'Você foi desconectado com sucesso.',
                                        'success'
                                    ).then(() => {
                                        window.location.href = '/login';
                                    });
                                } else {
                                    throw new Error('Falha ao desconectar');
                                }
                            })
                            .catch(error => {
                                console.error('Erro no logout:', error);
                                Swal.fire(
                                    'Erro!',
                                    'Não foi possível desconectar. Tente novamente.',
                                    'error'
                                );
                            });
                    } else {
                        Swal.fire(
                            'Erro!',
                            'Nenhum token encontrado. Redirecionando para login.',
                            'error'
                        ).then(() => {
                            window.location.href = '/login';
                        });
                    }
                }
            });
        };
    }
});
