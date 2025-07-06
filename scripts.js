window.cart = [];

window.addToCart = function(produkt_id, name, preis) {
    const item = window.cart.find(p => p.produkt_id === produkt_id);
    if (item) {
        item.menge += 1;
    } else {
        window.cart.push({ produkt_id, name, preis, menge: 1 });
    }
    renderCart();
};

function renderCart() {
    const container = document.getElementById('warenkorb');
    container.innerHTML = '';

    if (window.cart.length === 0) {
        container.innerHTML = '<p>Dein Warenkorb ist leer.</p>';
        return;
    }

    let total = 0;

    window.cart.forEach(item => {
        total += item.preis * item.menge;
        const div = document.createElement('div');
        div.textContent = `${item.name} × ${item.menge} = ${(item.preis * item.menge).toFixed(2)} €`;
        container.appendChild(div);
    });

    const gesamt = document.createElement('p');
    gesamt.innerHTML = `<strong>Gesamt: ${total.toFixed(2)} €</strong>`;
    container.appendChild(gesamt);
}

document.getElementById('checkoutForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const adresse = formData.get('adresse');
    const zahlungsart = formData.get('zahlungsart');

    if (window.cart.length === 0) {
        alert('Warenkorb ist leer!');
        return;
    }

    fetch('bestellung.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            adresse,
            zahlungsart,
            cart: window.cart
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Bestellung erfolgreich!');
            window.cart = [];
            renderCart();
            document.getElementById('checkoutForm').reset();
        } else {
            alert('Fehler: ' + data.message);
        }
    });
});

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
  