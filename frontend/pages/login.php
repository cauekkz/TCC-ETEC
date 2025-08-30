<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col">
            <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">
        </div>
    </div>

    <div class="row">
        <div class="col">
            <p class="text-center text-entrar">Entrar na Eteconnect</p>
            <hr id="hr-style">
        </div>
    </div>

    <div class="row form-style">
        <form id="loginForm">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="seu@etec.sp.gov.br" required>

            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Sua senha" required>

            <button class="btn btn-danger mt-2">Entrar</button>
        </form>
    </div>

    <div class="row text-center text-style">
        <p id="forgetPassword" class="text-danger pt-2">Esqueceu a senha?</p><!-- nd de link por enquanto -->
        <p id="signup">Não tem conta? <a href="/signup" class="text-danger" id="linkSignup">Cadastre-se</a></p>
    </div>
</div>
<link rel="stylesheet" href="/frontend/static/css/alerts.css">

<script src="frontend/static/js/alerts.js"></script>
<script src="frontend/static/js/alerts.js"></script>
<script src="frontend/static/js/login.js"></script>
<script>
    const form = document.getElementById('loginForm')
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        
        try {
            const data = await login(form.email.value, form.password.value)
            
            if (data.status !== "success") {
                // Mostrar erro do backend
                showBackendError(data, 'Erro ao fazer login');
                return;
            }
            
            // Mostrar sucesso
            showSuccess('Login realizado com sucesso!');
            
            localStorage.setItem('jwt_token', data.data);
            setCookie("logged", "1", 1440 * 7);
            
            // Redirecionar após um pequeno delay para mostrar o sucesso
            setTimeout(() => {
                window.location.href = "/";
            }, 1000);
            
        } catch (error) {
            showBackendError(error, 'Erro ao conectar com o servidor');
        }
    })
</script>