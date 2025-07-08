document.addEventListener('DOMContentLoaded', () => {
  const loginBtn = document.getElementById('loginBtn');
  const registerBtn = document.getElementById('registerBtn');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const showRegisterLink = document.getElementById('showRegister');

  if (loginBtn && registerBtn && loginForm && registerForm) {
    loginBtn.addEventListener('click', () => {
      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
    });

    registerBtn.addEventListener('click', () => {
      registerForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
    });
  }

  // Falls man auf „Registrieren“ klickt im Login-Fenster
  if (showRegisterLink && registerForm && loginForm) {
    showRegisterLink.addEventListener('click', (e) => {
      e.preventDefault();
      registerForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
    });
  }
});