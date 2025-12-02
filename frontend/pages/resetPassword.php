<?php

$token = $_GET['token'] ?? '';

if (
  empty($token) ||
  !isset($_SESSION['password_reset']) ||
  $_SESSION['password_reset']['token'] !== $token ||
  $_SESSION['password_reset']['expires'] < time()
){
  header("Location: /login");
}
?>
<style>
  .text-entrar {
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-primary);
  }

  #hr-style {
    border-color: var(--border-primary);
    opacity: 0.5;
  }

  .form-style {
    display: flex;
    justify-content: center;
  }
  header, footer {
    display: none;
  }
  .light-dark{
    display: none;
  }
</style>

<div class="container mt-5 pt-5">

  <!-- LOGO + TEMA -->


  <!-- TÍTULO -->
  <div class="row">
    <div class="col">
      <p class="text-center text-entrar">Criar nova senha</p>
      <hr id="hr-style">
    </div>
  </div>

  <!-- FORM -->
  <div class="row form-style">

    <form id="resetForm" class="bg-card p-4 shadow-medium rounded mx-auto" style="max-width:400px;">
      <input type="hidden" name="token" value="<?= $token ?>">

      <label class="form-label">Nova senha</label>
      <input type="password" name="password" class="form-control bg-input text-primary border-primary" required>

      <label class="form-label mt-2">Confirmar senha</label>
      <input type="password" id="confirmPassword" class="form-control bg-input text-primary border-primary" required>

      <button class="btn btn-danger w-100 mt-3">Salvar nova senha</button>

      <div id="msg" class="text-center mt-3"></div>
    </form>


  </div>
</div>
<script>
  const form = document.getElementById("resetForm");
  const msg = document.getElementById("msg");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const pass = form.password.value;
    const confirm = document.getElementById("confirmPassword").value;

    if (pass.length < 6) {
      msg.innerText = "A senha deve ter no mínimo 6 caracteres.";
      return;
    }

    if (pass !== confirm) {
      msg.innerText = "As senhas não coincidem.";
      return;
    }

    const data = {
      token: form.token.value,
      password: pass
    };

    const res = await fetch("/api/updatepassword", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify(data)
    });

    const j = await res.json();

    msg.innerText = j.msg;

    if (j.status === "success") {
      msg.style.color = "var(--accent-secondary)";
      setTimeout(() => location.href = "/login", 2000);
    } else {
      msg.style.color = "var(--accent-primary)";
    }
  });
</script>