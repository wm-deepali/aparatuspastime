// Aparatus Pastime - Central State & LocalStorage Manager

import { products } from './data/products.js';

const STORAGE_KEYS = {
  CART: 'aparatus_cart',
  WISHLIST: 'aparatus_wishlist',
  USER: 'aparatus_user',
  ADDRESSES: 'aparatus_addresses',
  ORDERS: 'aparatus_orders',
  REVIEWS: 'aparatus_reviews',
  RECENTLY_VIEWED: 'aparatus_recently_viewed',
  NOTIFICATIONS: 'aparatus_notifications',
  COUPON: 'aparatus_active_coupon'
};

// Default Initial Data
const DEFAULT_USER = {
  isLoggedIn: true,
  firstName: "Aarav",
  lastName: "Sharma",
  email: "aarav.sharma@example.com",
  phone: "+91 98765 43210",
  memberSince: "January 2026"
};

const DEFAULT_ADDRESSES = [
  {
    id: 1,
    name: "Aarav Sharma",
    type: "Home",
    isDefault: true,
    address: "Flat 402, Lotus Greens, Sector 45",
    city: "Noida",
    state: "Uttar Pradesh",
    postalCode: "201303",
    country: "India",
    phone: "+91 98765 43210"
  },
  {
    id: 2,
    name: "Aarav Sharma (Office)",
    type: "Work",
    isDefault: false,
    address: "Tower B, Cyber Hub, DLF Phase 2",
    city: "Gurugram",
    state: "Haryana",
    postalCode: "122002",
    country: "India",
    phone: "+91 98765 43210"
  }
];

const DEFAULT_ORDERS = [
  {
    id: "AP-2026-89421",
    date: "2026-03-24",
    status: "Delivered", // Statuses: Pending, Processing, Shipped, Out for Delivery, Delivered, Cancelled
    estimatedDelivery: "2026-03-28",
    items: [
      {
        id: 1,
        name: "Match Pro Classic Football - Size 5",
        slug: "classic-football",
        price: 999,
        quantity: 1,
        image: "https://images.unsplash.com/photo-1511886929837-354d827aae26?auto=format&fit=crop&w=400&q=80"
      },
      {
        id: 5,
        name: "Magnetic 3D Architect Master Tiles (100 Pcs)",
        slug: "magnetic-learning-set",
        price: 2199,
        quantity: 1,
        image: "https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=400&q=80"
      }
    ],
    subtotal: 3198,
    discount: 319,
    shipping: 0,
    total: 2879,
    paymentMethod: "UPI (Google Pay)",
    shippingAddress: {
      name: "Aarav Sharma",
      address: "Flat 402, Lotus Greens, Sector 45, Noida, UP - 201303",
      phone: "+91 98765 43210"
    },
    timeline: [
      { status: "Order Placed", date: "March 24, 2026 10:15 AM", done: true },
      { status: "Processing & Quality Check", date: "March 24, 2026 03:30 PM", done: true },
      { status: "Shipped via BlueDart (AWB #889210)", date: "March 25, 2026 09:00 AM", done: true },
      { status: "Out for Delivery", date: "March 28, 2026 08:30 AM", done: true },
      { status: "Delivered", date: "March 28, 2026 01:45 PM", done: true }
    ]
  },
  {
    id: "AP-2026-91204",
    date: "2026-03-27",
    status: "Shipped",
    estimatedDelivery: "2026-03-31",
    items: [
      {
        id: 2,
        name: "Kingdoms & Conquests Strategy Board Game",
        slug: "strategy-board-game",
        price: 1899,
        quantity: 1,
        image: "https://images.unsplash.com/photo-1610890716171-6b1bb98ffd09?auto=format&fit=crop&w=400&q=80"
      }
    ],
    subtotal: 1899,
    discount: 0,
    shipping: 0,
    total: 1899,
    paymentMethod: "Credit Card",
    shippingAddress: {
      name: "Aarav Sharma",
      address: "Flat 402, Lotus Greens, Sector 45, Noida, UP - 201303",
      phone: "+91 98765 43210"
    },
    timeline: [
      { status: "Order Placed", date: "March 27, 2026 02:45 PM", done: true },
      { status: "Processing & Packaging", date: "March 27, 2026 06:10 PM", done: true },
      { status: "Shipped via Delhivery (AWB #445901)", date: "March 28, 2026 11:00 AM", done: true },
      { status: "Out for Delivery", date: "Pending", done: false },
      { status: "Delivered", date: "Estimated March 31, 2026", done: false }
    ]
  }
];

const DEFAULT_REVIEWS = [
  {
    id: 1,
    productId: 1,
    productName: "Match Pro Classic Football - Size 5",
    productSlug: "classic-football",
    rating: 5,
    title: "Exceptional grip and durability",
    comment: "Bought this for my 10-year old son. The flight stability is superb and the outer shell hasn't scuffed despite heavy use on our turf park.",
    date: "March 12, 2026"
  }
];

const DEFAULT_NOTIFICATIONS = [
  {
    id: 1,
    title: "Order Shipped!",
    message: "Your order AP-2026-91204 has been dispatched via Delhivery.",
    time: "2 hours ago",
    read: false,
    type: "order"
  },
  {
    id: 2,
    title: "Weekend Play Sale",
    message: "Get flat 15% off on all Board Games this Saturday! Use code PLAY15.",
    time: "1 day ago",
    read: true,
    type: "promo"
  }
];

// State Helpers
export const State = {
  // CART
  getCart() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.CART);
      return data ? JSON.parse(data) : [];
    } catch {
      return [];
    }
  },

  saveCart(cart) {
    localStorage.setItem(STORAGE_KEYS.CART, JSON.stringify(cart));
    window.dispatchEvent(new CustomEvent('aparatus:cart-updated', { detail: cart }));
  },

  addToCart(productId, quantity = 1) {
    const product = products.find(p => p.id === Number(productId));
    if (!product) return null;

    let cart = this.getCart();
    const existingIndex = cart.findIndex(item => item.id === product.id);

    if (existingIndex > -1) {
      cart[existingIndex].quantity += quantity;
    } else {
      cart.push({
        id: product.id,
        name: product.name,
        slug: product.slug,
        price: product.price,
        originalPrice: product.originalPrice,
        image: product.images[0],
        category: product.category,
        quantity: quantity
      });
    }

    this.saveCart(cart);
    return product;
  },

  removeFromCart(productId) {
    let cart = this.getCart();
    cart = cart.filter(item => item.id !== Number(productId));
    this.saveCart(cart);
  },

  updateCartQty(productId, quantity) {
    let cart = this.getCart();
    const index = cart.findIndex(item => item.id === Number(productId));
    if (index > -1) {
      if (quantity <= 0) {
        cart.splice(index, 1);
      } else {
        cart[index].quantity = quantity;
      }
      this.saveCart(cart);
    }
  },

  clearCart() {
    this.saveCart([]);
    localStorage.removeItem(STORAGE_KEYS.COUPON);
  },

  getCartCount() {
    const cart = this.getCart();
    return cart.reduce((total, item) => total + item.quantity, 0);
  },

  getCartSubtotal() {
    const cart = this.getCart();
    return cart.reduce((total, item) => total + (item.price * item.quantity), 0);
  },

  getCartOriginalTotal() {
    const cart = this.getCart();
    return cart.reduce((total, item) => total + ((item.originalPrice || item.price) * item.quantity), 0);
  },

  getCoupon() {
    return localStorage.getItem(STORAGE_KEYS.COUPON) || '';
  },

  applyCoupon(code) {
    const cleanCode = code.trim().toUpperCase();
    if (cleanCode === 'PLAY10' || cleanCode === 'SPORTS20' || cleanCode === 'PASTIME15') {
      localStorage.setItem(STORAGE_KEYS.COUPON, cleanCode);
      window.dispatchEvent(new CustomEvent('aparatus:cart-updated'));
      return { success: true, message: `Coupon ${cleanCode} applied successfully!` };
    }
    return { success: false, message: 'Invalid coupon code. Try PLAY10 or SPORTS20.' };
  },

  removeCoupon() {
    localStorage.removeItem(STORAGE_KEYS.COUPON);
    window.dispatchEvent(new CustomEvent('aparatus:cart-updated'));
  },

  getCartCalculations() {
    const subtotal = this.getCartSubtotal();
    const coupon = this.getCoupon();
    let discount = 0;
    
    if (coupon === 'PLAY10') {
      discount = Math.round(subtotal * 0.10);
    } else if (coupon === 'SPORTS20') {
      discount = Math.round(subtotal * 0.20);
    } else if (coupon === 'PASTIME15') {
      discount = Math.round(subtotal * 0.15);
    }

    const freeShippingThreshold = 999;
    const shipping = subtotal >= freeShippingThreshold || subtotal === 0 ? 0 : 49;
    const total = Math.max(0, subtotal - discount + shipping);
    const amountForFreeShipping = Math.max(0, freeShippingThreshold - subtotal);
    const freeShippingPercent = Math.min(100, Math.round((subtotal / freeShippingThreshold) * 100));

    return {
      subtotal,
      discount,
      shipping,
      total,
      coupon,
      amountForFreeShipping,
      freeShippingPercent,
      freeShippingThreshold
    };
  },

  // WISHLIST
  getWishlist() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.WISHLIST);
      return data ? JSON.parse(data) : [1, 2, 4]; // default seeded items
    } catch {
      return [1, 2, 4];
    }
  },

  saveWishlist(wishlist) {
    localStorage.setItem(STORAGE_KEYS.WISHLIST, JSON.stringify(wishlist));
    window.dispatchEvent(new CustomEvent('aparatus:wishlist-updated', { detail: wishlist }));
  },

  isInWishlist(productId) {
    const wishlist = this.getWishlist();
    return wishlist.includes(Number(productId));
  },

  toggleWishlist(productId) {
    const id = Number(productId);
    let wishlist = this.getWishlist();
    const index = wishlist.indexOf(id);
    let added = false;

    if (index > -1) {
      wishlist.splice(index, 1);
    } else {
      wishlist.push(id);
      added = true;
    }

    this.saveWishlist(wishlist);
    return added;
  },

  getWishlistCount() {
    return this.getWishlist().length;
  },

  // RECENTLY VIEWED
  getRecentlyViewed() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.RECENTLY_VIEWED);
      return data ? JSON.parse(data) : [];
    } catch {
      return [];
    }
  },

  addRecentlyViewed(productId) {
    const id = Number(productId);
    let list = this.getRecentlyViewed().filter(item => item !== id);
    list.unshift(id);
    if (list.length > 4) list = list.slice(0, 4);
    localStorage.setItem(STORAGE_KEYS.RECENTLY_VIEWED, JSON.stringify(list));
  },

  // AUTH USER
  getUser() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.USER);
      return data ? JSON.parse(data) : DEFAULT_USER;
    } catch {
      return DEFAULT_USER;
    }
  },

  saveUser(user) {
    localStorage.setItem(STORAGE_KEYS.USER, JSON.stringify(user));
    window.dispatchEvent(new CustomEvent('aparatus:user-updated', { detail: user }));
  },

  login(email, password) {
    const user = {
      isLoggedIn: true,
      firstName: email.split('@')[0] || "Customer",
      lastName: "User",
      email: email,
      phone: "+91 98765 43210",
      memberSince: "March 2026"
    };
    this.saveUser(user);
    return user;
  },

  signup(formData) {
    const user = {
      isLoggedIn: true,
      firstName: formData.firstName || "Customer",
      lastName: formData.lastName || "",
      email: formData.email,
      phone: formData.phone || "+91 98765 43210",
      memberSince: "March 2026"
    };
    this.saveUser(user);
    return user;
  },

  logout() {
    const user = { isLoggedIn: false };
    this.saveUser(user);
  },

  // ADDRESSES
  getAddresses() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.ADDRESSES);
      return data ? JSON.parse(data) : DEFAULT_ADDRESSES;
    } catch {
      return DEFAULT_ADDRESSES;
    }
  },

  saveAddresses(addresses) {
    localStorage.setItem(STORAGE_KEYS.ADDRESSES, JSON.stringify(addresses));
    window.dispatchEvent(new CustomEvent('aparatus:addresses-updated', { detail: addresses }));
  },

  addAddress(address) {
    let addresses = this.getAddresses();
    const newId = Date.now();
    const newAddr = { ...address, id: newId };
    if (newAddr.isDefault) {
      addresses = addresses.map(a => ({ ...a, isDefault: false }));
    }
    addresses.push(newAddr);
    this.saveAddresses(addresses);
    return newAddr;
  },

  deleteAddress(id) {
    let addresses = this.getAddresses().filter(a => a.id !== Number(id));
    if (addresses.length > 0 && !addresses.some(a => a.isDefault)) {
      addresses[0].isDefault = true;
    }
    this.saveAddresses(addresses);
  },

  setDefaultAddress(id) {
    let addresses = this.getAddresses().map(a => ({
      ...a,
      isDefault: a.id === Number(id)
    }));
    this.saveAddresses(addresses);
  },

  // ORDERS
  getOrders() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.ORDERS);
      return data ? JSON.parse(data) : DEFAULT_ORDERS;
    } catch {
      return DEFAULT_ORDERS;
    }
  },

  getOrderById(id) {
    const orders = this.getOrders();
    return orders.find(o => o.id.toLowerCase() === id.toLowerCase());
  },

  createOrder(orderData) {
    const orders = this.getOrders();
    const orderNumber = `AP-2026-${Math.floor(10000 + Math.random() * 90000)}`;
    const today = new Date();
    const dateStr = today.toISOString().split('T')[0];
    
    // 4 days from now estimated
    const estDate = new Date(today);
    estDate.setDate(estDate.getDate() + 4);
    const estDateStr = estDate.toISOString().split('T')[0];

    const newOrder = {
      id: orderNumber,
      date: dateStr,
      status: "Processing",
      estimatedDelivery: estDateStr,
      items: orderData.items || this.getCart(),
      subtotal: orderData.subtotal || this.getCartSubtotal(),
      discount: orderData.discount || 0,
      shipping: orderData.shipping || 0,
      total: orderData.total || this.getCartCalculations().total,
      paymentMethod: orderData.paymentMethod || "UPI",
      shippingAddress: orderData.shippingAddress,
      timeline: [
        { status: "Order Placed", date: `${today.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} ${today.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`, done: true },
        { status: "Processing & Quality Check", date: "In Progress", done: true },
        { status: "Shipped", date: "Pending", done: false },
        { status: "Out for Delivery", date: "Pending", done: false },
        { status: "Delivered", date: `Estimated ${estDateStr}`, done: false }
      ]
    };

    orders.unshift(newOrder);
    localStorage.setItem(STORAGE_KEYS.ORDERS, JSON.stringify(orders));
    this.clearCart();
    return newOrder;
  },

  // REVIEWS
  getReviews() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.REVIEWS);
      return data ? JSON.parse(data) : DEFAULT_REVIEWS;
    } catch {
      return DEFAULT_REVIEWS;
    }
  },

  addReview(review) {
    let reviews = this.getReviews();
    const newReview = {
      ...review,
      id: Date.now(),
      date: new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })
    };
    reviews.unshift(newReview);
    localStorage.setItem(STORAGE_KEYS.REVIEWS, JSON.stringify(reviews));
    return newReview;
  },

  deleteReview(id) {
    let reviews = this.getReviews().filter(r => r.id !== Number(id));
    localStorage.setItem(STORAGE_KEYS.REVIEWS, JSON.stringify(reviews));
  },

  // NOTIFICATIONS
  getNotifications() {
    try {
      const data = localStorage.getItem(STORAGE_KEYS.NOTIFICATIONS);
      return data ? JSON.parse(data) : DEFAULT_NOTIFICATIONS;
    } catch {
      return DEFAULT_NOTIFICATIONS;
    }
  },

  markNotificationRead(id) {
    let notifs = this.getNotifications().map(n => n.id === Number(id) ? { ...n, read: true } : n);
    localStorage.setItem(STORAGE_KEYS.NOTIFICATIONS, JSON.stringify(notifs));
  }
};
