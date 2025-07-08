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
    div.innerHTML = `
      ${item.name} × ${item.menge} = ${(item.preis * item.menge).toFixed(2)} €
      <button onclick="increaseQuantity(${item.id})">➕</button>
      <button onclick="decreaseQuantity(${item.id})">➖</button>
      <button onclick="removeFromCart(${item.id})">🗑️</button>
    `;
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
// Formular-Handler für Bestellung
document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const adresse = this.adresse.value;
  const zahlungsart = this.zahlungsart.value;

  if (cart.length === 0) {
    alert('Dein Warenkorb ist leer!');
    return;
  }

  const response = await fetch('bestellung.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      adresse: adresse,
      zahlungsart: zahlungsart,
      cart: cart.map(item => ({
        produkt_id: item.id,
        menge: item.menge,
        preis: item.preis
      }))
    })
  });

  const result = await response.json();
  if (result.success) {
    alert('✅ Bestellung erfolgreich!');
    cart = [];
    renderCart();
    this.reset();
  } else {
    alert('❌ Fehler: ' + result.message);
  }
});
// Produktmenge um 1 erhöhen
function mengeErhöhen(produktId) {
  const artikel = warenkorb.find(p => p.id === produktId);
  if (artikel) {
    artikel.menge += 1;
    warenkorbAnzeigen();
  }
}


// Produktmenge um 1 verringern (löschen, wenn 0)

function decreaseQuantity(produktId) {
  const item = cart.find(p => p.id === produktId);
  if (item) {
    item.menge -= 1;
    if (item.menge <= 0) {
      cart = cart.filter(p => p.id !== produktId);
    }
    renderCart();
  }
}

// Produkt komplett aus dem Warenkorb entfernen
function removeFromCart(produktId) {
  cart = cart.filter(p => p.id !== produktId);
  renderCart();
}