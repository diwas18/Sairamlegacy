<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sairam Chasma Pasal</title>

    <link rel="shortcut icon" href="{{ asset('images/Sairam.png') }}" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/slick.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script src="/js/slick.min.js" defer></script>

    @stack('styles')

    <style>
        :root {
            --crimson: #800020;
            --crimson-dark: #5c0017;
            --crimson-deep: #3d000e;
            --gold: #C9A84C;
            --gold-light: #F5ECD7;
            --gold-pale: #fdf8ef;
            --espresso: #3B2209;
            --espresso-mid: #5A3E28;
            --cream: #FDFAF4;
            --cream-soft: #FAF7F2;
            --border: #EDE8DF;
        }

        * { box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background: var(--cream); color: var(--espresso); }
        h1, h2, h3, h4 { font-family: 'Playfair Display', serif; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: var(--cream-soft); }
        ::-webkit-scrollbar-thumb { background: var(--crimson); border-radius: 99px; }

        /* ── Topbar ── */
        .topbar {
            background: var(--crimson);
            color: var(--gold);
            padding: 8px 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }
        .topbar a { color: var(--gold); transition: color 0.2s; }
        .topbar a:hover { color: #fff; }
        .topbar-marquee { flex: 1; overflow: hidden; margin: 0 40px; }
        .topbar-marquee-inner {
            display: flex; gap: 60px; white-space: nowrap;
            animation: marquee 22s linear infinite;
        }
        @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .topbar-sep { color: var(--gold); opacity: 0.4; }

        /* ── Nav ── */
        .main-nav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(253, 250, 244, 0.97);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .nav-inner {
            max-width: 1400px; margin: 0 auto;
            padding: 0 3rem;
            display: flex; align-items: center;
            gap: 24px; height: 72px;
        }
        .nav-logo { display: flex; align-items: center; gap: 12px; text-decoration: none; flex-shrink: 0; }
        .nav-logo img { height: 42px; transition: transform 0.3s; }
        .nav-logo:hover img { transform: scale(1.05); }
        .nav-logo-text { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 700; color: var(--crimson); line-height: 1.1; }
        .nav-logo-sub { font-size: 10px; font-family: 'Outfit', sans-serif; color: var(--espresso-mid); letter-spacing: 0.15em; text-transform: uppercase; font-weight: 400; }

        /* ── Search ── */
        .nav-search { flex: 1; max-width: 440px; position: relative; }
        .nav-search input {
            width: 100%;
            background: var(--cream-soft);
            border: 1.5px solid transparent;
            border-radius: 99px;
            padding: 10px 44px 10px 18px;
            font-size: 13px;
            font-family: 'Outfit', sans-serif;
            color: var(--espresso);
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }
        .nav-search input:focus { border-color: var(--crimson); background: #fff; }
        .nav-search input::placeholder { color: #aaa; }
        .nav-search button {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--crimson); font-size: 18px; line-height: 1;
        }
        #search-suggestions {
            position: absolute; top: calc(100% + 8px); left: 0; right: 0;
            background: #fff; border: 1px solid var(--border);
            border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            z-index: 200; overflow: hidden;
        }

        /* ── Nav Actions ── */
        .nav-actions { display: flex; align-items: center; gap: 6px; margin-left: auto; }
        .nav-action-btn {
            display: flex; flex-direction: column; align-items: center;
            gap: 3px; padding: 8px 10px; border-radius: 10px; cursor: pointer;
            text-decoration: none; color: var(--crimson); border: none; background: none;
            transition: background 0.15s; position: relative;
        }
        .nav-action-btn:hover { background: var(--gold-light); }
        .nav-action-btn i { font-size: 22px; line-height: 1; }
        .nav-action-btn span.lbl { font-size: 9px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; }

        .cart-badge {
            position: absolute; top: 4px; right: 4px;
            background: var(--crimson); color: var(--gold);
            font-size: 9px; font-weight: 700;
            width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--cream);
        }
        .notif-badge {
            position: absolute; top: 4px; right: 4px;
            background: #dc2626; color: #fff;
            font-size: 9px; font-weight: 700;
            width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid var(--cream);
        }

        /* ── Profile avatar ── */
        .nav-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--crimson); color: var(--gold);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; border: 2px solid transparent;
            transition: border-color 0.2s;
        }
        .profile-wrap:hover .nav-avatar { border-color: var(--crimson); }

        /* ── Profile Dropdown ── */
        .profile-dropdown {
            display: none; position: absolute; top: calc(100% + 8px); right: 0;
            background: #fff; border: 1px solid var(--border);
            border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            width: 200px; z-index: 200; overflow: hidden;
        }
        .profile-wrap:hover .profile-dropdown { display: block; }
        .profile-dropdown a, .profile-dropdown button {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 16px; font-size: 13px; width: 100%;
            text-align: left; border: none; background: none; cursor: pointer;
            color: #444; text-decoration: none; transition: background 0.15s;
        }
        .profile-dropdown a:hover { background: var(--cream-soft); }
        .profile-dropdown button:hover { background: #fef0f0; color: #dc2626; }
        .profile-dropdown .drop-divider { border-top: 1px solid var(--border); }

        /* ── Notif Panel ── */
        .notif-panel {
            display: none; position: absolute; top: calc(100% + 8px); right: 0;
            background: #fff; border: 1px solid var(--border);
            border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.12);
            width: 320px; max-height: 400px; overflow-y: auto; z-index: 200;
        }
        .notif-panel.open { display: block; }
        .notif-head {
            padding: 14px 18px; font-weight: 700; font-size: 13px;
            border-bottom: 1px solid var(--border); background: var(--cream-soft);
            color: var(--crimson); font-family: 'Playfair Display', serif;
        }
        .notif-item {
            padding: 12px 18px; border-bottom: 1px solid #f9f6f2;
            font-size: 12px; color: #555;
        }
        .notif-item.unread { background: #fffbf3; font-weight: 500; }
        .notif-item p { color: #333; margin-bottom: 3px; }
        .notif-item time { font-size: 10px; color: #aaa; text-transform: uppercase; letter-spacing: 0.08em; }
        .notif-footer {
            display: block; text-align: center; padding: 12px;
            font-size: 11px; font-weight: 700; color: var(--crimson);
            text-transform: uppercase; letter-spacing: 0.1em;
            text-decoration: none;
        }
        .notif-footer:hover { background: var(--cream-soft); }

        /* ── Category Bar ── */
        .cat-bar {
            background: #fff;
            border-bottom: 1px solid var(--border);
        }
        .cat-bar-inner {
            max-width: 1400px; margin: 0 auto; padding: 0 3rem;
            display: flex; gap: 0; overflow-x: auto;
        }
        .cat-bar-inner::-webkit-scrollbar { display: none; }
        .cat-link {
            padding: 13px 20px; font-size: 11px; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.12em;
            color: var(--espresso-mid); white-space: nowrap;
            text-decoration: none; border-bottom: 2px solid transparent;
            transition: color 0.2s, border-color 0.2s;
        }
        .cat-link:hover { color: var(--crimson); border-bottom-color: var(--crimson); }

        /* ── Auth buttons ── */
        .btn-login {
            font-size: 12px; font-weight: 600; color: var(--crimson);
            text-decoration: none; padding: 8px 16px; border-radius: 99px;
            border: 1.5px solid var(--crimson); transition: all 0.2s;
            text-transform: uppercase; letter-spacing: 0.08em;
        }
        .btn-login:hover { background: var(--crimson); color: #fff; }
        .btn-register {
            font-size: 12px; font-weight: 600; color: var(--gold);
            text-decoration: none; padding: 8px 20px; border-radius: 99px;
            background: var(--crimson); border: 1.5px solid var(--crimson);
            transition: all 0.2s; text-transform: uppercase; letter-spacing: 0.08em;
        }
        .btn-register:hover { background: var(--crimson-dark); }

        /* ── Footer ── */
        .site-footer { background: var(--espresso); color: var(--gold); }
        .footer-grid {
            max-width: 1400px; margin: 0 auto;
            display: grid; grid-template-columns: 1.4fr 1fr 1fr 1fr;
            gap: 48px; padding: 72px 3rem 48px;
        }
        .footer-brand-name { font-family: 'Playfair Display', serif; font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 12px; }
        .footer-tagline { font-size: 12px; color: rgba(201,168,76,0.7); line-height: 1.7; font-style: italic; }
        .footer-socials { display: flex; gap: 10px; margin-top: 24px; }
        .footer-social {
            width: 38px; height: 38px; border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.25);
            display: flex; align-items: center; justify-content: center;
            color: var(--gold); font-size: 16px; text-decoration: none;
            transition: all 0.2s;
        }
        .footer-social:hover { background: var(--gold); color: var(--espresso); border-color: var(--gold); }
        .footer-col-title {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.2em; color: #fff; margin-bottom: 20px;
        }
        .footer-links { display: flex; flex-direction: column; gap: 12px; }
        .footer-link { font-size: 13px; color: rgba(201,168,76,0.75); text-decoration: none; transition: color 0.2s; }
        .footer-link:hover { color: #fff; }
        .footer-contact-item { display: flex; align-items: flex-start; gap: 10px; font-size: 12px; color: rgba(201,168,76,0.75); margin-bottom: 12px; }
        .footer-contact-item i { color: var(--gold); margin-top: 2px; font-size: 14px; }
        .footer-bottom {
            border-top: 1px solid rgba(201,168,76,0.1);
            padding: 20px 3rem; text-align: center;
            font-size: 10px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.25em; color: rgba(201,168,76,0.4);
            max-width: 100%;
        }

        @media (max-width: 1024px) {
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; padding: 48px 2rem 32px; }
        }
        @media (max-width: 768px) {
            .topbar { padding: 8px 1.5rem; }
            .topbar-marquee { display: none; }
            .nav-inner { padding: 0 1.5rem; height: 64px; }
            .nav-logo-text { font-size: 15px; }
            .nav-search { display: none; }
            .footer-grid { grid-template-columns: 1fr; gap: 24px; padding: 40px 1.5rem 24px; }
            .footer-bottom { padding: 16px 1.5rem; }
        }
    </style>
</head>

<body>

    @include('layouts.alert')

    {{-- ── Topbar ── --}}
    <div class="topbar">
        <span class="hidden md:block" style="letter-spacing:0.2em; font-size:10px;">Where Vision Meets Elegance</span>

        <div class="topbar-marquee hidden md:block">
            <div class="topbar-marquee-inner">
                <span>Free shipping over Rs. 2000</span>
                <span class="topbar-sep">·</span>
                <span>30-day easy returns</span>
                <span class="topbar-sep">·</span>
                <span>1-year warranty on all frames</span>
                <span class="topbar-sep">·</span>
                <span>Expert eye-care since 2004</span>
                <span class="topbar-sep">·</span>
                <span>Free shipping over Rs. 2000</span>
                <span class="topbar-sep">·</span>
                <span>30-day easy returns</span>
                <span class="topbar-sep">·</span>
                <span>1-year warranty on all frames</span>
                <span class="topbar-sep">·</span>
                <span>Expert eye-care since 2004</span>
                <span class="topbar-sep">·</span>
            </div>
        </div>

        <a href="tel:+9779815444184" class="flex items-center gap-2" style="font-size:11px;">
            <i class="ri-phone-fill"></i> 9815444184
        </a>
    </div>

    {{-- ── Main Nav ── --}}
    <nav class="main-nav">
        <div class="nav-inner">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="nav-logo">
                <img src="{{ asset('images/Sairam.png') }}" alt="Sairam Logo" />
                <div>
                    <div class="nav-logo-text">Sairam</div>
                    <div class="nav-logo-sub">Chasma Pasal</div>
                </div>
            </a>

            {{-- Search --}}
            <div class="nav-search">
                <form action="{{ route('search') }}" method="GET">
                    <input type="search" name="search" value="{{ request()->query('search') }}"
                           placeholder="Search frames, brands, styles…" autocomplete="off" />
                    <button type="submit"><i class="ri-search-2-line"></i></button>
                    <div id="search-suggestions" class="hidden"></div>
                </form>
            </div>

            {{-- Actions --}}
            <div class="nav-actions">
                @auth

                {{-- Orders --}}
                <a href="{{ route('vieworder') }}" class="nav-action-btn" title="My Orders">
                    <i class="ri-history-line"></i>
                    <span class="lbl">Orders</span>
                </a>

                {{-- Cart --}}
                <a href="{{ route('mycart') }}" class="nav-action-btn" title="My Cart">
                    <i class="ri-shopping-bag-3-line"></i>
                    <span class="lbl">Cart</span>
                    @php $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                {{-- Notifications --}}
                <div style="position:relative;">
                    <button class="nav-action-btn" onclick="toggleNotif()" id="notifToggle">
                        <i class="ri-notification-3-line"></i>
                        <span class="lbl">Alerts</span>
                        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="notif-badge" id="notif-count">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <div class="notif-panel" id="notifPanel">
                        <div class="notif-head">Notifications</div>
                        @forelse(auth()->user()->notifications->take(5) as $notification)
                            <div class="notif-item {{ $notification->unread() ? 'unread' : '' }}">
                                <p>{{ $notification->data['message'] }}</p>
                                <time>{{ $notification->created_at->diffForHumans() }}</time>
                            </div>
                        @empty
                            <div style="padding:32px 18px;text-align:center;color:#bbb;font-size:13px;">No new notifications</div>
                        @endforelse
                        <a href="{{ route('notifications.all') }}" class="notif-footer">View all</a>
                    </div>
                </div>

                {{-- Profile --}}
                <div class="profile-wrap" style="position:relative;">
                    <div class="nav-action-btn" style="cursor:default;">
                        @php $avatar = auth()->user()->photo ?? auth()->user()->profile_image; @endphp
                        @if($avatar)
                            <img src="{{ asset($avatar) }}" class="nav-avatar" style="object-fit:cover;" />
                        @else
                            <div class="nav-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                        @endif
                        <span class="lbl">{{ explode(' ', auth()->user()->name)[0] }}</span>
                    </div>
                    <div class="profile-dropdown">
                        <a href="{{ route('profile.edit') }}"><i class="ri-user-settings-line" style="color:var(--crimson)"></i> My Profile</a>
                        <div class="drop-divider">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"><i class="ri-logout-circle-r-line"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                @else
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-register">Register</a>
                @endauth
            </div>
        </div>

        {{-- Category Bar --}}
        <div class="cat-bar">
            <div class="cat-bar-inner">
                @foreach($categories as $category)
                    <a href="{{ route('categoryproduct', $category->id) }}" class="cat-link">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    {{-- ── Content ── --}}
    <main class="min-h-[60vh]">
        @yield('content')
    </main>

    {{-- ── Footer ── --}}
    <footer class="site-footer">
        <div class="footer-grid">

            <div>
                <div class="footer-brand-name">Sairam Chasma Pasal</div>
                <p class="footer-tagline">"Trusted for over 20 years, we provide premium frames and expert eye care with precision and elegance."</p>
                <div class="footer-socials">
                    <a href="#" class="footer-social"><i class="ri-facebook-fill"></i></a>
                    <a href="https://www.instagram.com/sairamlegacy7" class="footer-social" target="_blank"><i class="ri-instagram-line"></i></a>
                    <a href="#" class="footer-social"><i class="ri-tiktok-fill"></i></a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Shop</div>
                <div class="footer-links">
                    <a href="#" class="footer-link">Sunglasses</a>
                    <a href="#" class="footer-link">Prescription Frames</a>
                    <a href="#" class="footer-link">Contact Lenses</a>
                    <a href="#" class="footer-link">New Arrivals</a>
                    <a href="#" class="footer-link">Kids Eyewear</a>
                    <a href="#" class="footer-link">Blue Light Glasses</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Services</div>
                <div class="footer-links">
                    <a href="{{ route('virtual.index') }}" class="footer-link">Virtual Try-On</a>
                    <a href="#" class="footer-link">Eye Exam Booking</a>
                    <a href="#" class="footer-link">Prescription Upload</a>
                    <a href="#" class="footer-link">Frame Repair</a>
                    <a href="#" class="footer-link">Lens Replacement</a>
                </div>
            </div>

            <div>
                <div class="footer-col-title">Contact</div>
                <div class="footer-contact-item"><i class="ri-map-pin-2-fill"></i><span>Geetanagar, Bharatpur, Chitwan, Nepal</span></div>
                <div class="footer-contact-item"><i class="ri-phone-fill"></i><a href="tel:+9779815444184" style="color:inherit;">9815444184</a></div>
                <div class="footer-contact-item"><i class="ri-mail-fill"></i><a href="mailto:sairamlegacy1@gmail.com" style="color:inherit;">sairamlegacy1@gmail.com</a></div>
                <div class="footer-contact-item"><i class="ri-time-fill"></i><span>Sun – Fri, 10:00 AM – 7:00 PM</span></div>
            </div>

        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Sairam Chasma Pasal · All Rights Reserved
        </div>
    </footer>

    <script>
        function toggleNotif() {
            const panel = document.getElementById('notifPanel');
            panel.classList.toggle('open');
            fetch("{{ route('notifications.markAsRead') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" }
            }).then(r => {
                if (r.ok) {
                    const b = document.getElementById('notif-count');
                    if (b) b.remove();
                }
            });
        }
        document.addEventListener('click', function(e) {
            const panel = document.getElementById('notifPanel');
            const btn = document.getElementById('notifToggle');
            if (panel && btn && !panel.contains(e.target) && !btn.contains(e.target)) {
                panel.classList.remove('open');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
