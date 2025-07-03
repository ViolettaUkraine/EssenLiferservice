let cart = [];

function addToCart(id, name, preis) {
    const item = cart.find(p => p.id === id);
    if (item) {
        item.menge += 1;
    } else {
        cart.push({ id, name, preis, menge: 1 });
    }
    renderCart();
}

function renderCart() {
    const container = document.getElementById('warenkorb');
    container.innerHTML = '';

    if (cart.length === 0) {
        container.innerHTML = '<p>Dein Warenkorb ist leer.</p>';
        return;
    }

    let total = 0;

    cart.forEach(item => {
        total += item.preis * item.menge;
        const div = document.createElement('div');
        div.textContent = `${item.name} × ${item.menge} = ${(item.preis * item.menge).toFixed(2)} €`;
        container.appendChild(div);
    });

    const gesamt = document.createElement('p');
    gesamt.innerHTML = `<strong>Gesamt: ${total.toFixed(2)} €</strong>`;
    container.appendChild(gesamt);
}


  const loginBtn = document.getElementById('loginBtn');
  const registerBtn = document.getElementById('registerBtn');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  loginBtn.addEventListener('click', () => {
    loginForm.classList.remove('hidden');
    registerForm.classList.add('hidden');
  });

  registerBtn.addEventListener('click', () => {
    registerForm.classList.remove('hidden');
    loginForm.classList.add('hidden');
  });
