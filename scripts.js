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

function increaseQuantity(produktId) { // Erhöht die Menge eines Produkts im Warenkorb
  const item = cart.find(p => p.id === produktId);
  if (item) {
    item.menge += 1;
    renderCart();
  }
}

function decreaseQuantity(produktId) {// Verringert die Menge eines Produkts im Warenkorb
  const item = cart.find(p => p.id === produktId);
  if (item) {
    item.menge -= 1;
    if (item.menge <= 0) {
      cart = cart.filter(p => p.id !== produktId);
    }
    renderCart();
  }
}

function removeFromCart(produktId) {
  cart = cart.filter(p => p.id !== produktId);
  renderCart();
}

// 🧾 Checkout-Formular sicher behandeln
const checkoutForm = document.getElementById('checkoutForm');

if (checkoutForm) {
  checkoutForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const adresse = this.adresse?.value;
    const zahlungsart = this.zahlungsart?.value;

    if (!adresse || !zahlungsart) {
      alert('Bitte Adresse und Zahlungsart eingeben!');
      return;
    }

    if (cart.length === 0) {
      alert('Dein Warenkorb ist leer!');
      return;
    }

    try {
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
    } catch (err) {
      console.error('Bestellfehler:', err);
      alert('❌ Ein technischer Fehler ist aufgetreten.');
    }
  });
}