// Shopping Cart JavaScript

// Cart data structure
let cart = [];

// Load cart from localStorage if available
function loadCart() {
    const savedCart = localStorage.getItem('shoppingCart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartCounter();
    }
}

// Save cart to localStorage
function saveCart() {
    localStorage.setItem('shoppingCart', JSON.stringify(cart));
}

// Add product to cart
function addToCart(id, name, price, image) {
    // Check if product already exists in cart
    const existingItem = cart.find(item => item.id === id);
    
    if (existingItem) {
        // Increment quantity if product already in cart
        existingItem.quantity += 1;
    } else {
        // Add new product to cart
        cart.push({
            id: id,
            name: name,
            price: price,
            image: image,
            quantity: 1
        });
    }
    
    // Update cart display
    updateCartCounter();
    updateCartPopup();
    saveCart();
    
    // Show notification
    showNotification(`${name} added to cart!`);
}

// Update cart counter in navbar
function updateCartCounter() {
    const counter = document.getElementById('cart-counter');
    const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
    
    counter.textContent = itemCount;
    
    // Show/hide counter based on cart contents
    if (itemCount > 0) {
        counter.style.display = 'inline-block';
    } else {
        counter.style.display = 'none';
    }
}

// Update cart popup content
function updateCartPopup() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    
    // Clear current items
    cartItems.innerHTML = '';
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-center my-3">Your cart is empty</p>';
        cartTotal.textContent = '0.00';
        return;
    }
    
    // Calculate total
    let total = 0;
    
    // Add each item to the popup
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item d-flex align-items-center border-bottom py-2';
        itemElement.innerHTML = `
            <div class="cart-item-img me-2">
                <img src="${item.image}" alt="${item.name}" width="50" height="50" class="rounded">
            </div>
            <div class="cart-item-details flex-grow-1">
                <h6 class="mb-0">${item.name}</h6>
                <div class="d-flex justify-content-between">
                    <small>${item.quantity} × $${item.price.toFixed(2)}</small>
                    <span>$${itemTotal.toFixed(2)}</span>
                </div>
            </div>
            <button class="btn btn-sm text-danger remove-item" onclick="removeFromCart('${item.id}')">
                <i class="bi bi-x-circle"></i>
            </button>
        `;
        
        cartItems.appendChild(itemElement);
    });
    
    cartTotal.textContent = total.toFixed(2);
}

// Remove item from cart
function removeFromCart(id) {
    const index = cart.findIndex(item => item.id === id);
    
    if (index !== -1) {
        const item = cart[index];
        
        if (item.quantity > 1) {
            // Decrease quantity
            item.quantity -= 1;
        } else {
            // Remove item completely
            cart.splice(index, 1);
        }
        
        updateCartCounter();
        updateCartPopup();
        saveCart();
    }
}

// Clear entire cart
function clearCart() {
    cart = [];
    updateCartCounter();
    updateCartPopup();
    saveCart();
}

// Show notification when product is added
function showNotification(message) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.classList.add('show');
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
    }, 3000);
}

// Toggle cart popup visibility
function toggleCartPopup() {
    const cartPopup = document.getElementById('cart-popup');
    cartPopup.classList.toggle('show');
    
    // Update cart contents when opened
    if (cartPopup.classList.contains('show')) {
        updateCartPopup();
    }
}

// Close cart popup when clicking outside
document.addEventListener('click', function(event) {
    const cartPopup = document.getElementById('cart-popup');
    const cartIcon = document.getElementById('cart-icon');
    
    if (cartPopup.classList.contains('show') && 
        !cartPopup.contains(event.target) && 
        !cartIcon.contains(event.target)) {
        cartPopup.classList.remove('show');
    }
});

// Initialize cart on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});