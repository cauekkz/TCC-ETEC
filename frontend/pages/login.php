<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col d-flex justify-content-between align-items-center">
            <img src="frontend/static/img/logo.png" alt="logo eteconnect" class="img-logo img-fluid">
            
            <div class="light-dark px-3">
                <div class="moon p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                        <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286" />
                    </svg>
                </div>
                <div class="sun p-1 d-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708" />
                    </svg>
                </div>
            </div>
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
            
            setTimeout(() => {
                window.location.href = "/";
            }, 800);
            
        } catch (error) {
            showBackendError(error, 'Erro ao conectar com o servidor');
        }
    })
</script>