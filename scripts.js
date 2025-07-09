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
  if (!container) return;

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

function increaseQuantity(id) {
  const item = cart.find(p => p.id === id);
  if (item) {
    item.menge += 1;
    renderCart();
  }
}

function decreaseQuantity(id) {
  const item = cart.find(p => p.id === id);
  if (item) {
    item.menge -= 1;
    if (item.menge <= 0) {
      cart = cart.filter(p => p.id !== id);
    }
    renderCart();
  }
}

function removeFromCart(id) {
  cart = cart.filter(p => p.id !== id);
  renderCart();
}

// 📤 Formular vorbereiten
const checkoutForm = document.getElementById('checkoutForm');
if (checkoutForm) {
  checkoutForm.addEventListener('submit', function (e) {
    if (cart.length === 0) {
      e.preventDefault();
      alert('🛒 Der Warenkorb ist leer!');
      return;
    }

    const cartInput = document.getElementById('cartInput');
    cartInput.value = JSON.stringify(cart); // Verstecktes Feld füllen
  });
}
