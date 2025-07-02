<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sairam Chasma Pasal - Eyewear</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/Sairam.png') }}" type="image/x-icon" />

    <!-- Remixicon Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" href="/css/slick.css" />

    <!-- Your app CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Load jQuery first, required by Slick -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

    <!-- Slick Carousel JS -->
    <script src="/js/slick.min.js" defer></script>
</head>

<body class="font-sans leading-relaxed" style="background-color: #FFFFF0; color: #4B2E0A;">

    @include('layouts.alert')

    <!-- Top Bar -->
  <div
  class="flex justify-between items-center px-16 py-2 font-semibold text-sm"
  style="background-color: #800020; color: #D4AF37;"
>
  <p>Where Vision Meets Elegance</p>
  <p>Call us: 9815444184</p>
</div>




<!-- Main Navbar -->
<nav class="border-b border-gray-300 bg-[#FFFFF0] shadow-sm">
  <div class="flex justify-between items-center px-6 md:px-16 py-2">

    <!-- Left: Logo -->
    <div class="flex-shrink-0 mr-6">
      <a href="{{ route('home') }}">
        <img src="{{ asset('images/Sairam.png') }}" alt="Sairam Logo" class="h-16 md:h-20 select-none" />
      </a>
    </div>

    <!-- Center: Search Bar -->
    <div class="flex-grow max-w-xl mx-10">
      <form action="{{ route('search') }}" method="GET" class="relative w-full">
        <input
          type="search"
          name="search"
          value="{{ request()->query('search') }}"
          placeholder="Search"
          class="w-full border border-[#800020] rounded-full px-4 pr-12 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#D4AF37] transition"
          style="color: #4B2E0A;"
        />
        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-[#800020] hover:text-[#D4AF37] transition">
          <i class="ri-search-line text-lg"></i>
        </button>
      </form>
    </div>

    <!-- Right: User, Orders, Cart -->
    <div class="flex items-center gap-x-10 font-medium text-sm md:text-base text-[#4B2E0A]">

      @auth
        <!-- Orders -->
        <a href="{{ route('order.index') }}" class="flex flex-col items-center group" title="My Orders">
          <img src="{{ asset('images/order.png') }}" alt="Orders" class="w-6 h-6 mb-1 group-hover:brightness-110 transition" />
          <span class="text-xs text-[#800020]">Orders</span>
        </a>

        <!-- Cart -->
        <a href="{{ route('mycart') }}" class="relative flex flex-col items-center group" title="My Cart">
          <img src="{{ asset('images/shopping-cart.png') }}" alt="Shopping Cart" class="w-6 h-6 mb-1 group-hover:brightness-110 transition" />
          <span class="text-xs text-[#800020]">Cart</span>

          @php
              $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
          @endphp
          @if($cartCount > 0)
              <span class="absolute -top-2 -right-2 bg-[#f9ecef] text-[#800020] border border-[#800020] text-[10px] w-5 h-5 flex items-center justify-center font-bold rounded-full">
                  {{ $cartCount }}
              </span>
          @endif
        </a>

        <!-- Notifications -->
<div class="relative">
  <button onclick="toggleNotificationDropdown()" class="relative text-[#4B2E0A] flex flex-col items-center focus:outline-none">
    <div class="relative w-7 h-7">
      <img src="{{ asset('images/notification.png') }}" alt="Notifications" class="w-7 h-7" />

      @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
      @if($unreadCount > 0)
        <span id="notif-count"
              class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full border border-white">
          {{ $unreadCount }}
        </span>
      @endif
    </div>
    <span class="text-xs text-[#800020] select-none mt-1">Notifications</span>
  </button>

  <!-- Dropdown -->
  <div id="notificationDropdown"
       class="hidden absolute right-0 mt-2 w-72 max-h-96 overflow-y-auto bg-white border border-gray-200 rounded shadow-lg z-50">
    <div class="p-3 border-b text-[#800020] font-semibold">Notifications</div>

    @forelse(auth()->user()->notifications->take(5) as $notification)
      <div class="px-4 py-2 text-sm text-gray-700 border-b hover:bg-gray-50">
        {{ $notification->data['message'] }}
        <div class="text-xs text-gray-400 mt-1">
          {{ $notification->created_at->diffForHumans() }}
        </div>
      </div>
    @empty
      <div class="px-4 py-2 text-sm text-gray-500">No notifications</div>
    @endforelse

    <div class="text-center p-2">
      <a href="{{ route('notifications.all') }}" class="text-sm text-[#800020] hover:underline">View All</a>
    </div>
  </div>
</div>







        <!-- Account Dropdown -->
        <div class="relative group flex flex-col items-center cursor-pointer select-none">
          <img src="{{ asset('images/user.png') }}" alt="User" class="w-8 h-8 mb-1" />
          <span class="text-xs text-[#800020]">Account</span>

          <!-- Dropdown -->
          <div class="hidden group-hover:block absolute top-12 right-0 bg-[#FFFFF0] border border-[#800020] rounded-lg shadow-lg w-40 z-20 text-sm mt-1">

            <a href="#" class="block px-4 py-2 hover:bg-[#D4AF37] hover:text-[#800020] transition flex items-center gap-2 rounded">
              <i class="ri-profile-line"></i> My Profile
            </a>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="w-full text-left px-4 py-2 hover:bg-[#D4AF37] hover:text-[#800020] transition flex items-center gap-2 rounded">
                <i class="ri-logout-box-r-line"></i> Logout
              </button>
            </form>
          </div>
        </div>
      @else
        <!-- Guest -->
        <a href="{{ route('login') }}" class="transition hover:text-[#D4AF37]">Login</a>
        <a href="{{ route('register') }}" class="transition hover:text-[#D4AF37]">Register</a>
      @endauth

    </div>
  </div>

  <!-- Second row: Categories -->
   <div class="bg-transparent">
    <div class="max-w-full md:max-w-7xl mx-auto px-6 md:px-16">
      <nav class="flex space-x-4 overflow-x-auto scrollbar-hide py-2 text-sm font-semibold text-[#4B2E0A]">

        @foreach($categories as $category)
  <a href="{{ route('categoryproduct', $category->id) }}"
             class="hover:text-[#D4AF37] transition">
             {{ $category->name }}
          </a>
        @endforeach
      </nav>
    </div>
  </div>
</nav>












    @yield('content')

    <!-- Footer -->
   <footer class="grid grid-cols-1 md:grid-cols-3 gap-8 px-8 md:px-16 py-10" style="background-color: #800020; color: #D4AF37;">

    <!-- Branding & Description -->
    <div>
        <h1 class="text-2xl font-bold mb-3 tracking-wider">Sairam Chasma Pasal</h1>
        <p class="text-sm leading-relaxed">
            Trusted for 20+ years, we offer premium eyewear, expert eye care, and timeless style tailored just for you.
        </p>
        <div class="flex space-x-4 mt-4">
            <a href="#" class="hover:text-white transition"><i class="ri-facebook-circle-fill text-2xl"></i></a>
            <a href="#" class="hover:text-white transition"><i class="ri-instagram-fill text-2xl"></i></a>
            <a href="#" class="hover:text-white transition"><i class="ri-twitter-fill text-2xl"></i></a>
            <a href="#" class="hover:text-white transition"><i class="ri-tiktok-fill text-2xl"></i></a>
        </div>
    </div>

    <!-- Quick Links -->
    <div>
        <h1 class="text-2xl font-bold mb-3 tracking-wider">Shop</h1>
        <ul class="space-y-2 text-sm">
            <li class="cursor-pointer hover:text-white transition">Men's Sunglasses</li>
            <li class="cursor-pointer hover:text-white transition">Women's Sunglasses</li>
            <li class="cursor-pointer hover:text-white transition">Prescription Glasses</li>
            <li class="cursor-pointer hover:text-white transition">New Arrivals</li>
        </ul>
    </div>

    <!-- Contact Info -->
    <div>
        <h1 class="text-2xl font-bold mb-3 tracking-wider">Get in Touch</h1>
        <p class="text-sm mb-2">Phone: 9815444184</p>
        <p class="text-sm mb-2">Email: sairamlegacy1@gmail.com</p>
        <p class="text-sm">Location: Geetanagar, Nepal</p>
    </div>

</footer>
<script>
function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notificationDropdown');
    dropdown.classList.toggle('hidden');

    // Mark as read
    fetch("{{ route('notifications.markAsRead') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    }).then(response => {
        if (response.ok) {
            const countBadge = document.getElementById('notif-count');
            if (countBadge) countBadge.remove();
        }
    });
}

// Close dropdown if clicked outside
window.addEventListener('click', function(e) {
    const dropdown = document.getElementById('notificationDropdown');
    const button = document.querySelector('button[onclick="toggleNotificationDropdown()"]');
    if (dropdown && !dropdown.contains(e.target) && !button.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

// 🔔 Optional: Play sound on new notification (replace path with your sound)
function playNotificationSound() {
    const audio = new Audio("{{ asset('sounds/notification.mp3') }}"); // Add your .mp3 file in public/sounds
    audio.play();
}

// Optional: Simulate notification sound trigger (only if using Echo/Pusher)
window.Echo && Echo.private(`App.Models.User.{{ auth()->id() }}`)
    .notification((notification) => {
        playNotificationSound();
        // You can also increase count manually if needed
    });
</script>




</body>
</html>
