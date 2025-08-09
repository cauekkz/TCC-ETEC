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
<script src="frontend/static/js/login.js">
</script>
<script>
    const form = document.getElementById('signupForm')
    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const body = {
            name: form.name.value,
            email: form.email.value,
            password: form.password.value,
            conf_password: form.conf_password.value,
            birthday: form.birthday.value,
            registration: form.registration.value
        }
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const response = await fetch("/api/signup", {
            method: 'POST',
            body: JSON.stringify(body)
        })
        if (!response.ok) {
            //500
        }
        const data = await response.json()
        console.log(data)
        if (data.status !== "success") {
            //error message
            return;
        }
        
        const dataLogin = await login(form.email.value, form.password.value)
        if (data.status !== "success") {
            return;
        }
        localStorage.setItem('jwt_token', dataLogin.data);
        console.log(dataLogin.data)
        setCookie("logged", "1", 1440 * 7);
        window.location.href = "/"



    });
</script>