<div class="container">

    <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">
    <div class="form-title text-center text-style">
        <p id="TitleForm" class="h4">Crie sua conta</p>
        <p id="SubTitleForm">Junte-se a rede social das ETECs</p>
        <hr id="hr-style">
    </div>

    <div class="form-style">
        <form id="signupForm">
            <label for="name" class="form-label">Nome completo</label>
            <input type="text" id="name" name="name" placeholder="Nome completo" class="form-control" required>

            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" placeholder="seu@etec.sp.gov.br" class="form-control" required>
            <label for="registration" class="form-label">MatrÍcula</label>
            <input type="text" id="registration" name="registration" placeholder="matrícula" class="form-control" required>

            <label for="birthday" class="form-label">Data de nascimento</label>

            <input type="date" id="birthday" name="birthday" class="form-control" required>

            <label for="password" class="form-label">Senha</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Sua senha" required>

            <label for="confirmPassword" class="form-label">Confirmar Senha</label>
            <input type="password" id="confirmPassword" name="conf_password" class="form-control" placeholder="Confirme a senha" required>

            <button type="submit" class="btn btn-danger mt-2">Cadastrar-se</button>
        </form>
    </div>

    <div class="login mt-2 text-style mt-2">
        <p id="text-login">Já tem conta? <a href="/login" id="link-login" class="text-danger">Entrar</a></p>
    </div>
</div>
<link rel="stylesheet" href="/frontend/static/css/alerts.css">
<script src="frontend/static/js/alerts.js"></script>
<script src="frontend/static/js/login.js"></script>
<script>
    const form = document.getElementById('signupForm')
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        // Validação das senhas
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        
        if (password !== confirmPassword) {
            showError('As senhas não coincidem');
            return;
        }
        
        if (password.length < 6) {
            showWarning('A senha deve ter pelo menos 6 caracteres');
            return;
        }
        
        const body = {
            name: form.name.value,
            email: form.email.value,
            password: form.password.value,
            conf_password: form.conf_password.value,
            birthday: form.birthday.value,
            registration: form.registration.value
        }
        
        try {
            const response = await fetch("/api/signup", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(body)
            })
            
            if (!response.ok) {
                const errorData = await response.json();
                showBackendError(errorData, 'Erro ao criar conta');
                return;
            }
            
            const data = await response.json()
            if (data.status !== "success") {
                showBackendError(data, 'Erro ao criar conta');
                return;
            }
            
            showSuccess('Conta criada com sucesso! Fazendo login...');
            
            // Fazer login automaticamente
            const dataLogin = await login(form.email.value, form.password.value)
            if (dataLogin.status !== "success") {
                showBackendError(dataLogin, 'Conta criada, mas erro ao fazer login');
                return;
            }
            
            localStorage.setItem('jwt_token', dataLogin.data);
            setCookie("logged", "1", 1440 * 7);
            
            setTimeout(() => {
                window.location.href = "/";
            }, 1500);
            
        } catch (error) {
            showBackendError(error, 'Erro ao conectar com o servidor');
        }
    });
</script>