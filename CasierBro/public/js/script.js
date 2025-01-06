// Set current date
const options = {
    weekday: "short",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  
  const currentDate = new Date().toLocaleDateString("id-ID", options);
  document.getElementById("current-date").textContent = currentDate;
  
  document.addEventListener("DOMContentLoaded", () => {
    const categoryButtons = document.querySelectorAll(".category-btn");
    const searchInput = document.getElementById("menu-search");
    const menuItems = document.querySelectorAll(".menu-item-card");
  
    const filterMenu = () => {
      const selectedCategory = document
        .querySelector(".category-btn.active")
        .getAttribute("data-category");
      const searchValue = searchInput.value.toLowerCase();
  
      menuItems.forEach((item) => {
        const itemCategory = item.getAttribute("data-category");
        const menuName = item
          .querySelector(".menu-name")
          .textContent.toLowerCase();
  
        // Filter berdasarkan kategori dan pencarian
        if (
          (selectedCategory === "all" || itemCategory === selectedCategory) &&
          menuName.includes(searchValue)
        ) {
          item.style.display = "block"; // Tampilkan item
        } else {
          item.style.display = "none"; // Sembunyikan item
        }
      });
    };
  
    // Event listener untuk kategori
    categoryButtons.forEach((button) => {
      button.addEventListener("click", () => {
        // Remove active class from all buttons
        categoryButtons.forEach((btn) => btn.classList.remove("active"));
  
        // Add active class to the clicked button
        button.classList.add("active");
  
        // Filter menu
        filterMenu();
      });
    });
  
    // Event listener untuk pencarian
    searchInput.addEventListener("input", filterMenu);
  });
  
  document.addEventListener("DOMContentLoaded", () => {
    const cartContainer = document.querySelector(".order-items-container");
    const addToCartButtons = document.querySelectorAll(".add-to-cart-btn");
    const summarySubtotal = document.querySelector(".subtotal-value");
    const continueButton = document.querySelector(".continue-btn");
    const paymentButtons = document.querySelectorAll(".payment-button");
    const paymentMethodInput = document.getElementById("payment-method");
  
    let cart = {};
    let orderType = ""; // Declare orderType here
  
    const updateCart = () => {
      cartContainer.innerHTML = "";
      let subtotal = 0;
  
      for (const [key, item] of Object.entries(cart)) {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
  
        const cartItem = document.createElement("div");
        cartItem.classList.add("order-item");
        cartItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <p class="order-item-name">${item.name}</p>
                <p class="order-item-note">Rp ${item.price.toLocaleString()}</p>
              </div>
              <div class="d-flex align-items-center">
                <input type="number" class="order-qty-input" value="${item.quantity}" min="1" />
                <p class="order-item-price ms-3">Rp ${itemTotal.toLocaleString()}</p>
                <button class="delete-btn ms-3">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
          `;
  
        cartItem
          .querySelector(".order-qty-input")
          .addEventListener("input", (e) => {
            const newQty = parseInt(e.target.value, 10);
            if (newQty > 0) {
              item.quantity = newQty;
              updateCart();
            }
          });
  
        cartItem.querySelector(".delete-btn").addEventListener("click", () => {
          delete cart[key];
          updateCart();
        });
  
        cartContainer.appendChild(cartItem);
      }
  
      summarySubtotal.textContent = `Rp ${subtotal.toLocaleString()}`;
  
      // Update the href of the continue button
      const orderData = Object.values(cart).map((item) => ({
        name: item.name,
        quantity: item.quantity,
        price: item.price,
      }));
  
      const discount = subtotal > 100000 ? subtotal * 0.1 : 0;
      const orderJSON = encodeURIComponent(
        JSON.stringify({
          items: orderData,
          discount,
          subtotal,
          orderType,
        })
      );
      console.log("Final URL:", continueButton.href);
      continueButton.href = `order-confirmation.php?order=${orderJSON}`;
      console.log("Cart Contents:", cart);
    };
  
    addToCartButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const menuCard = this.closest(".menu-item-card");
        const menuName = menuCard.querySelector(".menu-name").innerText;
        const menuPrice = parseFloat(
          menuCard
            .querySelector(".menu-price")
            .innerText.replace("Rp", "")
            .replace(".", "")
            .trim()
        );
  
        if (cart[menuName]) {
          cart[menuName].quantity++;
        } else {
          cart[menuName] = { name: menuName, price: menuPrice, quantity: 1 };
        }
  
        console.log("Cart Updated:", cart); // Debug cart setelah menambah item
        updateCart();
      });
    });
  
    updateCart();
  });
  
  document.addEventListener("DOMContentLoaded", () => {
    const orderTypeButtons = document.querySelectorAll(".type-order-btn");
    orderTypeButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Remove active class from all buttons
        orderTypeButtons.forEach((btn) => btn.classList.remove("active"));
        // Add active class to the clicked button
        this.classList.add("active");
        // Set the order type value
        document.getElementById("order-type").value = this.innerText;
      });
    });
  });
  
  document.addEventListener("DOMContentLoaded", () => {
    const confirmButton = document.getElementById("confirm-payment");
  
    confirmButton.addEventListener("click", () => {
      // Ambil data yang dibutuhkan
      const paymentMethod = document.getElementById("payment-method").value;
      const customerName = document.getElementById("customer-name").value;
      const phoneNumber = document.getElementById("phone-number").value;
      const orderType = document.querySelector(
        ".type-order-btn.active"
      ).innerText;
  
      // Data keranjang
      const cartData = Object.values(cart);
  
      // Validasi apakah data lengkap
      if (
        !paymentMethod ||
        !customerName ||
        !phoneNumber ||
        !orderType ||
        cartData.length === 0
      ) {
        alert("Pastikan semua data telah diisi dan keranjang tidak kosong.");
        return;
      }
  
      // Buat data untuk dikirim
      const orderData = {
        paymentMethod,
        customerName,
        phoneNumber,
        orderType,
        items: cartData,
        subtotal: cartData.reduce(
          (total, item) => total + item.price * item.quantity,
          0
        ),
        discount: 0, // Tambahkan logika diskon jika ada
      };
  
      // Debug: Tampilkan data sebelum dikirim
      console.log("Order Data:", orderData);
      console.log("Tombol Confirm Payment diklik.");
      console.log("Metode Pembayaran:", paymentMethod);
      console.log("Nama Pelanggan:", customerName);
      console.log("Nomor Telepon:", phoneNumber);
      console.log("Tipe Order:", orderType);
      console.log("Isi Keranjang:", cartData);
  
      // Kirim data ke PHP melalui URL
      const queryString = encodeURIComponent(JSON.stringify(orderData));
      window.location.href = `{{ order-confirmation?order=${queryString} }}`;
    });
  });