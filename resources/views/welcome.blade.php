@extends('layouts.master')

@push('styles')
<style>

/* ══════════════════════════════════════════
   HERO
══════════════════════════════════════════ */
.hero {
    min-height: 90vh;
    background: var(--espresso);
    display: grid;
    grid-template-columns: 1fr 1fr;
    position: relative;
    overflow: hidden;
}

.hero-dot-bg {
    position: absolute; inset: 0; opacity: 0.25;
    background-image: radial-gradient(circle, rgba(201,168,76,0.18) 1px, transparent 1px);
    background-size: 26px 26px;
}

.hero-img {
    position: absolute; right: 0; top: 0;
    height: 100%; width: 52%;
    object-fit: cover; object-position: top;
}
.hero-img-fade {
    position: absolute; inset: 0;
    background: linear-gradient(90deg, var(--espresso) 35%, rgba(59,34,9,0.5) 65%, transparent 100%);
}
.hero-img-fade-mob {
    position: absolute; inset: 0;
    background: rgba(59,34,9,0.88);
    display: none;
}

.hero-content {
    position: relative; z-index: 10;
    padding: 100px 3rem 80px 5rem;
    display: flex; flex-direction: column; justify-content: center;
    max-width: 680px;
}

.hero-eyebrow {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 20px;
}
.hero-eyebrow-line { width: 28px; height: 1px; background: var(--gold); }
.hero-eyebrow-text { font-size: 10px; letter-spacing: 0.22em; text-transform: uppercase; color: var(--gold); font-weight: 500; }

.hero-h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(46px, 5.5vw, 78px);
    font-weight: 400; line-height: 1.05;
    color: #fff; margin-bottom: 24px;
    letter-spacing: -1px;
}
.hero-h1 strong { font-weight: 700; color: var(--gold); display: block; }

.hero-sub {
    font-size: 15px; color: rgba(255,255,255,0.58);
    line-height: 1.8; margin-bottom: 40px; max-width: 420px;
}

.hero-cta { display: flex; gap: 14px; flex-wrap: wrap; margin-bottom: 56px; }

.btn-primary {
    display: inline-block;
    background: var(--crimson); color: #fff;
    padding: 15px 36px; font-size: 11px;
    font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase;
    text-decoration: none; transition: all 0.3s; border: none; cursor: pointer;
}
.btn-primary:hover { background: var(--crimson-dark); transform: translateY(-2px); }

.btn-outline-gold {
    display: inline-block;
    border: 1px solid rgba(201,168,76,0.4); color: rgba(255,255,255,0.8);
    padding: 15px 36px; font-size: 11px;
    font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase;
    text-decoration: none; transition: all 0.3s;
}
.btn-outline-gold:hover { border-color: var(--gold); color: var(--gold); }

.hero-stats { display: flex; gap: 0; }
.hero-stat { padding-right: 32px; margin-right: 32px; border-right: 1px solid rgba(201,168,76,0.2); }
.hero-stat:last-child { border-right: none; margin-right: 0; padding-right: 0; }
.hero-stat-num { font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: var(--gold); line-height: 1; }
.hero-stat-lbl { font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-top: 4px; }

/* ══════════════════════════════════════════
   TRUST STRIP
══════════════════════════════════════════ */
.trust-strip {
    background: #fff; border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    display: grid; grid-template-columns: repeat(4,1fr);
    divide: solid;
}
.trust-item {
    display: flex; flex-direction: column; align-items: center;
    text-align: center; padding: 28px 16px; gap: 10px;
    border-right: 1px solid var(--border);
    transition: background 0.2s;
}
.trust-item:last-child { border-right: none; }
.trust-item:hover { background: var(--cream-soft); }
.trust-icon { width: 44px; height: 44px; object-fit: contain; }
.trust-title { font-size: 13px; font-weight: 600; color: var(--espresso); }
.trust-desc { font-size: 11px; color: #9A8C7E; line-height: 1.5; }

/* ══════════════════════════════════════════
   SECTION COMMON
══════════════════════════════════════════ */
.section-wrap { padding: 88px 5rem; }
.section-wrap-alt { background: var(--cream-soft); }
.section-header { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 52px; }
.section-bar { width: 3px; height: 52px; background: var(--crimson); border-radius: 99px; flex-shrink: 0; margin-top: 4px; }
.section-eyebrow { font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--crimson); font-weight: 600; margin-bottom: 6px; }
.section-title { font-family: 'Playfair Display', serif; font-size: 34px; font-weight: 600; color: var(--espresso); line-height: 1.15; }

/* ══════════════════════════════════════════
   FACE SHAPE FINDER
══════════════════════════════════════════ */
.finder-section {
    padding: 80px 5rem;
    background: var(--espresso);
    position: relative; overflow: hidden;
}
.finder-section::before {
    content: '';
    position: absolute; inset: 0; opacity: 0.15;
    background-image: radial-gradient(circle, rgba(201,168,76,0.15) 1px, transparent 1px);
    background-size: 26px 26px;
}
.finder-inner { position: relative; z-index: 2; display: grid; grid-template-columns: 1fr 1.6fr; gap: 60px; align-items: center; }
.finder-left .section-eyebrow { color: var(--gold); }
.finder-left .section-title { color: #fff; }
.finder-left p { font-size: 14px; color: rgba(255,255,255,0.55); line-height: 1.8; margin: 16px 0 28px; }

.face-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 10px; margin-bottom: 24px; }
.face-card {
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 12px; padding: 18px 8px;
    text-align: center; cursor: pointer;
    transition: all 0.2s;
}
.face-card:hover { background: rgba(201,168,76,0.1); border-color: rgba(201,168,76,0.5); }
.face-card.active { background: rgba(201,168,76,0.15); border-color: var(--gold); }
.face-card svg { margin: 0 auto 8px; display: block; }
.face-card-name { font-size: 11px; font-weight: 600; color: #fff; margin-bottom: 2px; }
.face-card-hint { font-size: 10px; color: rgba(201,168,76,0.6); }

.rec-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; }
.rec-card {
    background: rgba(255,255,255,0.06); border: 1px solid rgba(201,168,76,0.15);
    border-radius: 10px; padding: 14px 12px;
    display: flex; align-items: center; gap: 12px;
}
.rec-thumb {
    width: 56px; height: 36px; flex-shrink: 0;
    background: rgba(255,255,255,0.08); border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
}
.rec-name { font-size: 12px; font-weight: 500; color: #fff; margin-bottom: 3px; }
.rec-match { font-size: 10px; color: var(--gold); background: rgba(201,168,76,0.15); padding: 2px 8px; border-radius: 99px; display: inline-block; }

/* ══════════════════════════════════════════
   SERVICES
══════════════════════════════════════════ */
.services-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
.service-card {
    background: #fff; border: 1px solid var(--border);
    padding: 36px 28px; display: flex; flex-direction: column;
    align-items: flex-start; text-align: left;
    transition: all 0.3s; position: relative; overflow: hidden;
}
.service-card::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 0; height: 3px; background: var(--crimson);
    transition: width 0.3s;
}
.service-card:hover { transform: translateY(-4px); box-shadow: 0 20px 60px rgba(59,34,9,0.1); }
.service-card:hover::after { width: 100%; }
.service-icon-wrap {
    width: 56px; height: 56px; border-radius: 14px;
    background: var(--gold-light); display: flex; align-items: center; justify-content: center;
    margin-bottom: 20px;
}
.service-icon { width: 28px; height: 28px; object-fit: contain; }
.service-title { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: var(--espresso); margin-bottom: 10px; }
.service-desc { font-size: 13px; color: #6B6259; line-height: 1.7; flex: 1; margin-bottom: 20px; }
.service-link { font-size: 11px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; color: var(--crimson); text-decoration: none; border-bottom: 1px solid transparent; padding-bottom: 2px; transition: border-color 0.2s; }
.service-link:hover { border-bottom-color: var(--crimson); }

/* ══════════════════════════════════════════
   APPOINTMENT BANNER
══════════════════════════════════════════ */
.appt-banner {
    background: var(--crimson);
    padding: 72px 5rem;
    position: relative; overflow: hidden;
    text-align: center;
}
.appt-banner::before {
    content: ''; position: absolute; inset: 0; opacity: 0.12;
    background-image: radial-gradient(circle, rgba(212,175,55,0.2) 1px, transparent 1px);
    background-size: 22px 22px;
}
.appt-banner-content { position: relative; z-index: 2; }
.appt-banner h2 { font-family: 'Playfair Display', serif; font-size: 42px; font-weight: 400; color: #fff; margin-bottom: 14px; }
.appt-banner h2 em { color: var(--gold); font-style: italic; }
.appt-banner p { font-size: 14px; color: rgba(255,255,255,0.6); max-width: 520px; margin: 0 auto 36px; line-height: 1.8; }
.btn-gold {
    display: inline-block;
    background: var(--gold); color: var(--espresso);
    padding: 15px 40px; font-size: 11px; font-weight: 700;
    letter-spacing: 0.16em; text-transform: uppercase;
    text-decoration: none; transition: all 0.3s;
}
.btn-gold:hover { background: #e8d08a; transform: translateY(-2px); }
.appt-hours { margin-top: 16px; font-size: 11px; color: rgba(255,255,255,0.3); letter-spacing: 0.12em; }

/* ══════════════════════════════════════════
   PRODUCTS
══════════════════════════════════════════ */
.products-section { padding: 88px 5rem; background: #fff; }
.products-topbar { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px; }
.filter-chips { display: flex; gap: 8px; }
.fchip {
    padding: 7px 18px; border-radius: 99px; font-size: 11px; font-weight: 600;
    letter-spacing: 0.08em; text-transform: uppercase; cursor: pointer;
    border: 1.5px solid var(--border); color: var(--espresso-mid);
    background: transparent; transition: all 0.15s;
}
.fchip:hover, .fchip.on { background: var(--crimson); color: #fff; border-color: var(--crimson); }

/* ── Product Card ── */
.product-grid { display: grid; grid-template-columns: repeat(4,minmax(0,1fr)); gap: 20px; }
.product-card {
    border: 1px solid var(--border); border-radius: 0;
    overflow: hidden; cursor: pointer;
    transition: box-shadow 0.3s, transform 0.3s;
}
.product-card:hover { box-shadow: 0 16px 48px rgba(59,34,9,0.12); transform: translateY(-4px); }
.product-card-img {
    position: relative; height: 200px;
    background: var(--cream-soft); overflow: hidden;
    display: flex; align-items: center; justify-content: center;
}
.product-card-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
.product-card:hover .product-card-img img { transform: scale(1.06); }
.product-badge {
    position: absolute; top: 12px; left: 12px;
    font-size: 9px; font-weight: 700; padding: 4px 10px;
    text-transform: uppercase; letter-spacing: 0.1em;
}
.badge-new { background: #E1F5EE; color: #085041; }
.badge-hot { background: #FAECE7; color: #712B13; }
.badge-sale { background: #FAEEDA; color: #633806; }
.product-card-body { padding: 18px; }
.product-card-name { font-size: 14px; font-weight: 500; color: var(--espresso); margin-bottom: 4px; font-family: 'Playfair Display', serif; }
.product-card-sub { font-size: 11px; color: #9A8C7E; margin-bottom: 12px; }
.product-card-foot { display: flex; justify-content: space-between; align-items: center; }
.product-card-price { font-size: 15px; font-weight: 600; color: var(--crimson); }
.product-card-price s { font-size: 11px; color: #bbb; font-weight: 400; margin-left: 4px; }
.product-card-add {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--espresso); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s; color: #fff; font-size: 16px; text-decoration: none;
}
.product-card-add:hover { background: var(--crimson); }

.load-more-wrap { text-align: center; margin-top: 48px; }
.btn-load-more {
    border: 1.5px solid var(--crimson); color: var(--crimson);
    background: transparent; padding: 13px 40px;
    font-size: 11px; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase;
    cursor: pointer; transition: all 0.3s;
}
.btn-load-more:hover { background: var(--crimson); color: #fff; }
.btn-load-more:disabled { opacity: 0.4; cursor: not-allowed; }

/* ══════════════════════════════════════════
   VIRTUAL TRY-ON FEATURE
══════════════════════════════════════════ */
.tryon-section { padding: 88px 5rem; background: var(--cream-soft); }
.tryon-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; border: 1px solid var(--border); background: #fff; overflow: hidden; }
.tryon-left { padding: 52px 48px; display: flex; flex-direction: column; justify-content: center; border-right: 1px solid var(--border); }
.tryon-right { background: var(--cream-soft); display: flex; align-items: center; justify-content: center; min-height: 360px; position: relative; }

.ai-pill {
    display: inline-flex; align-items: center; gap: 8px;
    background: #EAF3DE; border: 1px solid #C0DD97;
    border-radius: 99px; padding: 5px 14px;
    font-size: 11px; font-weight: 600; color: #27500A;
    letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 20px;
}
.ai-pill::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #639922; flex-shrink: 0; }
.tryon-title { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 600; color: var(--espresso); margin-bottom: 14px; line-height: 1.2; }
.tryon-sub { font-size: 14px; color: #6B6259; line-height: 1.8; margin-bottom: 28px; }
.tryon-features { display: flex; flex-direction: column; gap: 14px; margin-bottom: 32px; }
.tryon-feat { display: flex; align-items: flex-start; gap: 14px; }
.tryon-feat-icon {
    width: 30px; height: 30px; border-radius: 8px; background: var(--gold-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    color: var(--espresso-mid); font-size: 14px;
}
.tryon-feat-title { font-size: 13px; font-weight: 600; color: var(--espresso); margin-bottom: 2px; }
.tryon-feat-desc { font-size: 12px; color: #9A8C7E; line-height: 1.5; }

.camera-frame {
    width: 220px; height: 280px; border-radius: 16px;
    border: 1px solid var(--border); background: var(--cream);
    position: relative; display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.cam-corner {
    position: absolute; width: 22px; height: 22px;
    border-color: var(--crimson); border-style: solid;
}
.cc-tl { top: 14px; left: 14px; border-width: 2px 0 0 2px; border-radius: 4px 0 0 0; }
.cc-tr { top: 14px; right: 14px; border-width: 2px 2px 0 0; border-radius: 0 4px 0 0; }
.cc-bl { bottom: 14px; left: 14px; border-width: 0 0 2px 2px; border-radius: 0 0 0 4px; }
.cc-br { bottom: 14px; right: 14px; border-width: 0 2px 2px 0; border-radius: 0 0 4px 0; }
.cam-scanline { position: absolute; width: 75%; height: 1px; background: var(--gold); opacity: 0.7; animation: scan 2.5s ease-in-out infinite; }
@keyframes scan { 0%,100% { top: 30%; } 50% { top: 70%; } }
.cam-label { position: absolute; bottom: 18px; left: 0; right: 0; text-align: center; font-size: 9px; color: #bbb; letter-spacing: 0.12em; text-transform: uppercase; }

/* ══════════════════════════════════════════
   STORE SECTION
══════════════════════════════════════════ */
.store-section { padding: 88px 5rem; background: #fff; }
.store-grid { display: grid; grid-template-columns: 1fr 1fr; border: 1px solid var(--border); overflow: hidden; }
.store-info { padding: 56px; border-right: 1px solid var(--border); }
.store-tag { font-size: 10px; letter-spacing: 0.2em; text-transform: uppercase; color: var(--crimson); font-weight: 600; margin-bottom: 16px; display: block; }
.store-title { font-family: 'Playfair Display', serif; font-size: 30px; font-weight: 600; color: var(--espresso); margin-bottom: 16px; line-height: 1.2; }
.store-desc { font-size: 13px; color: #5A4E44; line-height: 1.8; margin-bottom: 28px; }
.store-details { display: flex; flex-direction: column; gap: 14px; margin-bottom: 32px; }
.store-detail { display: flex; align-items: flex-start; gap: 12px; font-size: 13px; color: var(--espresso); }
.store-detail i { color: var(--crimson); margin-top: 2px; font-size: 15px; width: 16px; flex-shrink: 0; }
.store-map { display: flex; flex-direction: column; }
.store-map iframe { flex: 1; min-height: 260px; border: none; display: block; }
.store-photos { display: grid; grid-template-columns: 1fr 1fr; }
.store-photo { height: 160px; overflow: hidden; }
.store-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
.store-photo:hover img { transform: scale(1.06); }

/* ══════════════════════════════════════════
   LENS BUILDER
══════════════════════════════════════════ */
.builder-section { padding: 88px 5rem; background: var(--cream-soft); }
.builder-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; border: 1px solid var(--border); overflow: hidden; }
.builder-left { padding: 48px; border-right: 1px solid var(--border); background: #fff; }
.builder-right { padding: 48px; background: var(--espresso); }
.builder-step { margin-bottom: 28px; padding-bottom: 28px; border-bottom: 1px solid var(--border); }
.builder-step:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.builder-step-label { font-size: 10px; letter-spacing: 0.18em; text-transform: uppercase; color: #9A8C7E; font-weight: 600; margin-bottom: 12px; }
.step-opts { display: flex; gap: 8px; flex-wrap: wrap; }
.step-opt {
    padding: 7px 16px; border-radius: 99px; font-size: 12px; font-weight: 500;
    border: 1.5px solid var(--border); color: var(--espresso-mid);
    cursor: pointer; background: #fff; transition: all 0.15s;
}
.step-opt:hover { border-color: var(--crimson); color: var(--crimson); }
.step-opt.active { background: var(--crimson); color: #fff; border-color: var(--crimson); }

.price-summary { background: rgba(255,255,255,0.06); border: 1px solid rgba(201,168,76,0.2); border-radius: 0; padding: 28px; }
.builder-right .section-eyebrow { color: var(--gold); }
.builder-right .section-title { color: #fff; font-size: 26px; margin-bottom: 28px; }
.ps-row { display: flex; justify-content: space-between; font-size: 13px; padding: 10px 0; border-bottom: 1px solid rgba(201,168,76,0.12); color: rgba(201,168,76,0.7); }
.ps-row:last-of-type { border-bottom: none; }
.ps-row span:last-child { color: #fff; font-weight: 500; }
.ps-total { display: flex; justify-content: space-between; font-size: 17px; font-weight: 600; padding-top: 16px; margin-top: 8px; border-top: 1px solid rgba(201,168,76,0.25); color: var(--gold); }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 1024px) {
    .hero { grid-template-columns: 1fr; }
    .hero-img { width: 100%; }
    .hero-img-fade-mob { display: block; }
    .hero-img-fade { display: none; }
    .hero-content { padding: 80px 2rem; }
    .section-wrap, .finder-section, .tryon-section, .store-section, .products-section, .builder-section, .appt-banner { padding: 56px 2rem; }
    .finder-inner, .tryon-grid, .store-grid, .builder-grid { grid-template-columns: 1fr; }
    .tryon-left, .store-info, .builder-left, .builder-right { border-right: none; border-bottom: 1px solid var(--border); }
    .builder-right { border-bottom: none; }
    .services-grid { grid-template-columns: 1fr 1fr; }
    .product-grid { grid-template-columns: repeat(2,1fr); }
    .face-grid { grid-template-columns: repeat(5,1fr); }
    .trust-strip { grid-template-columns: repeat(2,1fr); }
}
@media (max-width: 640px) {
    .hero-h1 { font-size: 40px; }
    .hero-stats { gap: 0; flex-wrap: wrap; }
    .services-grid { grid-template-columns: 1fr; }
    .product-grid { grid-template-columns: 1fr; }
    .face-grid { grid-template-columns: repeat(3,1fr); }
    .rec-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<section class="hero">
    <div class="hero-dot-bg"></div>
    <img src="{{ asset('images/banner.png') }}" alt="Sairam Collection" class="hero-img">
    <div class="hero-img-fade"></div>
    <div class="hero-img-fade-mob"></div>

    <div class="hero-content">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-line"></span>
            <span class="hero-eyebrow-text">Est. Malangawa · Premium Eyewear</span>
        </div>

        <h1 class="hero-h1">
            See the world<br>
            <strong>in your style.</strong>
        </h1>

        <p class="hero-sub">
            Original frames from world-renowned designers — crafted for those who value clarity, elegance, and lasting eye health.
        </p>

        <div class="hero-cta">
            <a href="#products" class="btn-primary">Shop Collection</a>
            <a href="{{ route('virtual.index') }}" class="btn-outline-gold">Virtual Try-On</a>
        </div>

        <div class="hero-stats">
            <div class="hero-stat">
                <div class="hero-stat-num">20+</div>
                <div class="hero-stat-lbl">Years trusted</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">500+</div>
                <div class="hero-stat-lbl">Frame styles</div>
            </div>
            <div class="hero-stat">
                <div class="hero-stat-num">4.9★</div>
                <div class="hero-stat-lbl">Avg rating</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     TRUST STRIP
══════════════════════════════════════ --}}
<div class="trust-strip">
    @foreach([
        ['transport.png',      'Free Shipping',   'On all orders above Rs. 2000'],
        ['easy-return.png',    '30-day Returns',  'Hassle-free returns & exchanges'],
        ['secure-payment.png', 'Secure Checkout', '100% safe & encrypted payments'],
        ['customer-care.png',  '24/7 Support',    'Dedicated customer assistance'],
    ] as $t)
    <div class="trust-item">
        <img src="{{ asset('images/'.$t[0]) }}" alt="{{ $t[1] }}" class="trust-icon">
        <div class="trust-title">{{ $t[1] }}</div>
        <div class="trust-desc">{{ $t[2] }}</div>
    </div>
    @endforeach
</div>

{{-- ══════════════════════════════════════
     FACE SHAPE FINDER
══════════════════════════════════════ --}}
<section class="finder-section">
    <div class="finder-inner">
        <div class="finder-left">
            <div class="section-eyebrow">Smart Feature</div>
            <h2 class="section-title" style="color:#fff;">Find your<br>perfect frame.</h2>
            <p>Tell us your face shape and we'll instantly surface the frames that flatter you most — no guesswork, no wasted trips.</p>
            <a href="{{ route('virtual.index') }}" class="btn-gold" style="align-self:flex-start;">Try it virtually</a>
        </div>
        <div>
            <div class="face-grid" id="faceGrid">
                @foreach([
                    ['oval',   'Oval',   'Versatile'],
                    ['round',  'Round',  'Soft angles'],
                    ['square', 'Square', 'Strong jaw'],
                    ['heart',  'Heart',  'Wide forehead'],
                    ['oblong', 'Oblong', 'Longer face'],
                ] as [$shape, $name, $hint])
                <div class="face-card {{ $shape === 'oval' ? 'active' : '' }}"
                     onclick="selectFace(this,'{{ $shape }}')">
                    @if($shape === 'oval')
                        <svg width="36" height="46" viewBox="0 0 36 46"><ellipse cx="18" cy="23" rx="14" ry="19" fill="none" stroke="rgba(201,168,76,0.8)" stroke-width="1.5"/></svg>
                    @elseif($shape === 'round')
                        <svg width="36" height="46" viewBox="0 0 36 46"><circle cx="18" cy="23" r="14" fill="none" stroke="rgba(201,168,76,0.8)" stroke-width="1.5"/></svg>
                    @elseif($shape === 'square')
                        <svg width="36" height="46" viewBox="0 0 36 46"><rect x="4" y="8" width="28" height="30" rx="3" fill="none" stroke="rgba(201,168,76,0.8)" stroke-width="1.5"/></svg>
                    @elseif($shape === 'heart')
                        <svg width="36" height="46" viewBox="0 0 36 46"><path d="M18 38 C18 38 4 24 4 14 Q4 4 18 9 Q32 4 32 14 C32 24 18 38 18 38Z" fill="none" stroke="rgba(201,168,76,0.8)" stroke-width="1.5"/></svg>
                    @else
                        <svg width="36" height="46" viewBox="0 0 36 46"><rect x="8" y="3" width="20" height="40" rx="10" fill="none" stroke="rgba(201,168,76,0.8)" stroke-width="1.5"/></svg>
                    @endif
                    <div class="face-card-name">{{ $name }}</div>
                    <div class="face-card-hint">{{ $hint }}</div>
                </div>
                @endforeach
            </div>
            <div class="rec-grid" id="recGrid">
                @foreach([['Aviator Classic','98%'],['Round Retro','94%'],['Wayfarer Bold','91%']] as [$n,$m])
                <div class="rec-card">
                    <div class="rec-thumb">
                        <svg width="44" height="24" viewBox="0 0 44 24"><rect x="2" y="3" width="16" height="16" rx="7" fill="none" stroke="rgba(201,168,76,0.7)" stroke-width="1.5"/><rect x="26" y="3" width="16" height="16" rx="7" fill="none" stroke="rgba(201,168,76,0.7)" stroke-width="1.5"/><line x1="18" y1="11" x2="26" y2="11" stroke="rgba(201,168,76,0.7)" stroke-width="1.5"/><line x1="2" y1="9" x2="0" y2="4" stroke="rgba(201,168,76,0.7)" stroke-width="1.2"/><line x1="42" y1="9" x2="44" y2="4" stroke="rgba(201,168,76,0.7)" stroke-width="1.2"/></svg>
                    </div>
                    <div><div class="rec-name">{{ $n }}</div><span class="rec-match">{{ $m }} match</span></div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     SERVICES
══════════════════════════════════════ --}}
<section class="section-wrap section-wrap-alt">
    <div class="section-header">
        <div class="section-bar"></div>
        <div>
            <div class="section-eyebrow">What we offer</div>
            <h2 class="section-title">Eye Care Services</h2>
        </div>
    </div>
    <div class="services-grid">
        @foreach([
            ['eye exam.jpg',     'Comprehensive Eye Exams',  'Professional check-ups by certified optometrists for clear vision and lasting eye health.',      '#book-appointment', 'Book an Exam'],
            ['fitt.jpg',         'Personalized Fittings',    'Get the perfect fit for ultimate comfort and vision clarity at our in-store location in Chitwan.', '#our-store',        'Visit Store'],
            ['virtualtryon.jpg', 'Virtual Try-On',           'Explore different styles from home before visiting. Our AI maps your face for an exact preview.',  route('virtual.index'), 'Try It Now'],
        ] as $s)
        <div class="service-card">
            <div class="service-icon-wrap">
                <img src="{{ asset('images/'.$s[0]) }}" alt="{{ $s[1] }}" class="service-icon">
            </div>
            <div class="service-title">{{ $s[1] }}</div>
            <p class="service-desc">{{ $s[2] }}</p>
            <a href="{{ $s[3] }}" class="service-link">{{ $s[4] }} &rarr;</a>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════
     APPOINTMENT BANNER
══════════════════════════════════════ --}}
<section id="book-appointment" class="appt-banner">
    <div class="appt-banner-content">
        <h2>Ready for an <em>Eye Check-up?</em></h2>
        <p>Book a comprehensive eye exam or a personalized fitting at our Geetanagar store. Expert care, just a click away.</p>
        {{-- was href="#" --}}
        <a href="{{ route('booking.create') }}" class="btn-gold">Book Your Appointment</a>
        <p class="appt-hours">Sunday – Friday &nbsp;·&nbsp; 10:00 AM – 7:00 PM</p>
    </div>
</section>

{{-- ══════════════════════════════════════
     PRODUCTS
══════════════════════════════════════ --}}
<section id="products" class="products-section">
    <div class="products-topbar">
        <div class="section-header" style="margin-bottom:0;">
            <div class="section-bar"></div>
            <div>
                <div class="section-eyebrow">Newest styles</div>
                <h2 class="section-title">Latest Collection</h2>
            </div>
        </div>
        <div class="filter-chips">
            <button class="fchip on">All</button>
            <button class="fchip">Men</button>
            <button class="fchip">Women</button>
            <button class="fchip">Sport</button>
            <button class="fchip">Kids</button>
        </div>
    </div>

    <div id="product-list" class="product-grid">
        @include('partials.product_cards')
    </div>

    <div class="load-more-wrap">
        <button id="loadMoreBtn" class="btn-load-more">Load More</button>
    </div>
</section>

{{-- ══════════════════════════════════════
     VIRTUAL TRY-ON
══════════════════════════════════════ --}}
<section class="tryon-section">
    <div class="section-header" style="margin-bottom:40px;">
        <div class="section-bar"></div>
        <div>
            <div class="section-eyebrow">AI-Powered</div>
            <h2 class="section-title">Virtual Try-On</h2>
        </div>
    </div>
    <div class="tryon-grid">
        <div class="tryon-left">
            <div class="ai-pill">Live face mapping</div>
            <h3 class="tryon-title">Try before you buy.<br>Zero guesswork.</h3>
            <p class="tryon-sub">Point your camera, pick a frame, and see the result instantly. Our face-mapping engine overlays frames with millimetre precision — before you spend a rupee.</p>
            <div class="tryon-features">
                <div class="tryon-feat">
                    <div class="tryon-feat-icon"><i class="ri-focus-2-line"></i></div>
                    <div><div class="tryon-feat-title">Real-time face mapping</div><div class="tryon-feat-desc">68 facial landmarks tracked live</div></div>
                </div>
                <div class="tryon-feat">
                    <div class="tryon-feat-icon"><i class="ri-glasses-line"></i></div>
                    <div><div class="tryon-feat-title">Hundreds of frames to try</div><div class="tryon-feat-desc">Switch styles in one tap</div></div>
                </div>
                <div class="tryon-feat">
                    <div class="tryon-feat-icon"><i class="ri-share-line"></i></div>
                    <div><div class="tryon-feat-title">Share your look</div><div class="tryon-feat-desc">Screenshot and share with friends</div></div>
                </div>
            </div>
            <a href="{{ route('virtual.index') }}" class="btn-primary" style="align-self:flex-start;">Launch Virtual Try-On</a>
        </div>
        <div class="tryon-right">
            <div class="camera-frame">
                <div class="cam-corner cc-tl"></div>
                <div class="cam-corner cc-tr"></div>
                <div class="cam-corner cc-bl"></div>
                <div class="cam-corner cc-br"></div>
                <div class="cam-scanline"></div>
                <svg width="130" height="90" viewBox="0 0 130 90">
                    <ellipse cx="65" cy="32" rx="28" ry="28" fill="none" stroke="#ddd" stroke-width="1" stroke-dasharray="4,3"/>
                    <rect x="14" y="42" width="36" height="22" rx="8" fill="none" stroke="#3B2209" stroke-width="2"/>
                    <rect x="80" y="42" width="36" height="22" rx="8" fill="none" stroke="#3B2209" stroke-width="2"/>
                    <line x1="50" y1="53" x2="80" y2="53" stroke="#3B2209" stroke-width="2"/>
                    <line x1="14" y1="50" x2="8" y2="40" stroke="#3B2209" stroke-width="1.5"/>
                    <line x1="116" y1="50" x2="122" y2="40" stroke="#3B2209" stroke-width="1.5"/>
                </svg>
                <div class="cam-label">Align face to frame</div>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     LENS BUILDER
══════════════════════════════════════ --}}
<section class="builder-section">
    <div class="section-header" style="margin-bottom:40px;">
        <div class="section-bar"></div>
        <div>
            <div class="section-eyebrow">Customize your pair</div>
            <h2 class="section-title">Custom Lens Builder</h2>
        </div>
    </div>
    <div class="builder-grid">
        <div class="builder-left">
            <div class="builder-step">
                <div class="builder-step-label">Frame style</div>
                <div class="step-opts">
                    <span class="step-opt active" onclick="pickOpt(this)">Aviator</span>
                    <span class="step-opt" onclick="pickOpt(this)">Round</span>
                    <span class="step-opt" onclick="pickOpt(this)">Wayfarer</span>
                    <span class="step-opt" onclick="pickOpt(this)">Cat-eye</span>
                </div>
            </div>
            <div class="builder-step">
                <div class="builder-step-label">Lens type</div>
                <div class="step-opts">
                    <span class="step-opt active" onclick="pickOpt(this)">Single vision</span>
                    <span class="step-opt" onclick="pickOpt(this)">Progressive</span>
                    <span class="step-opt" onclick="pickOpt(this)">Bifocal</span>
                </div>
            </div>
            <div class="builder-step">
                <div class="builder-step-label">Coating</div>
                <div class="step-opts">
                    <span class="step-opt active" onclick="pickOpt(this)">Anti-glare</span>
                    <span class="step-opt" onclick="pickOpt(this)">Blue light</span>
                    <span class="step-opt" onclick="pickOpt(this)">Photochromic</span>
                </div>
            </div>
            <div class="builder-step">
                <div class="builder-step-label">Material</div>
                <div class="step-opts">
                    <span class="step-opt active" onclick="pickOpt(this)">Polycarbonate</span>
                    <span class="step-opt" onclick="pickOpt(this)">1.67 thin</span>
                    <span class="step-opt" onclick="pickOpt(this)">1.74 ultra-thin</span>
                </div>
            </div>
        </div>
        <div class="builder-right">
            <div class="section-eyebrow">Your build</div>
            <div class="section-title">Order Summary</div>
            <div class="price-summary">
                <div class="ps-row"><span>Frame (Aviator)</span><span>Rs. 2,499</span></div>
                <div class="ps-row"><span>Lens (Single vision)</span><span>Rs. 800</span></div>
                <div class="ps-row"><span>Coating (Anti-glare)</span><span>Rs. 300</span></div>
                <div class="ps-row"><span>Shipping</span><span style="color:#9FE1CB;">Free</span></div>
                <div class="ps-total"><span>Total</span><span>Rs. 3,599</span></div>
            </div>
            <a href="#products" class="btn-gold" style="display:block;text-align:center;margin-top:20px;">Shop Now &rarr;</a>
            <p style="text-align:center;font-size:11px;color:rgba(201,168,76,0.4);margin-top:12px;">30-day returns · 1-year warranty</p>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     OUR STORE
══════════════════════════════════════ --}}
<section id="our-store" class="store-section">
    <div class="section-header" style="margin-bottom:40px;">
        <div class="section-bar"></div>
        <div>
            <div class="section-eyebrow">Come visit us</div>
            <h2 class="section-title">Our Store</h2>
        </div>
    </div>
    <div class="store-grid">
        <div class="store-info">
            <span class="store-tag">Geetanagar, Bharatpur · Chitwan, Nepal</span>
            <h3 class="store-title">Personal service,<br>expert care.</h3>
            <p class="store-desc">Come experience personalized service at our physical store. Our optical specialists are here to help you find the perfect pair with expert fittings and professional recommendations.</p>
            <div class="store-details">
                <div class="store-detail"><i class="ri-map-pin-2-fill"></i><span>Sairam Chasma Pasal, Bharatpur-11, Chitwan, Nepal</span></div>
                <div class="store-detail"><i class="ri-phone-fill"></i><a href="tel:+9779815444184" style="color:inherit;">+977 9815444184</a></div>
                <div class="store-detail"><i class="ri-time-fill"></i><span>Sunday – Friday, 10:00 AM – 7:00 PM (NST)</span></div>
                <div class="store-detail"><i class="ri-mail-fill"></i><a href="mailto:sairamlegacy1@gmail.com" style="color:inherit;">sairamlegacy1@gmail.com</a></div>
            </div>
            <a href="https://www.google.com/maps/search/?api=1&query=Geetanagar+Chasma+Pasal,+Bharatpur,+Nepal" target="_blank" class="btn-primary">Get Directions</a>
        </div>
        <div class="store-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3535.2525411255083!2d84.38704787550634!3d27.616694176234663!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3994f18364658f13%3A0x67271c075b6e3d5a!2sGeetanagar%20Chasma%20Pasal!5e0!3m2!1sen!2snp!4v1751724078918!5m2!1sen!2snp"
                class="w-full" style="border:0;flex:1;min-height:260px;" allowfullscreen loading="lazy">
            </iframe>
            <div class="store-photos">
                <div class="store-photo">
                    <img src="{{ asset('images/interior.jpg') }}" alt="Store Interior" loading="lazy">
                </div>
                <div class="store-photo">
                    <img src="{{ asset('images/exterior.avif') }}" alt="Store Exterior" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Load More
    let nextPage = 2;
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const lastPage = {{ $products->lastPage() }};
    if (loadMoreBtn) {
        if (lastPage <= 1) { loadMoreBtn.style.display = 'none'; }
        else {
            loadMoreBtn.addEventListener('click', function () {
                loadMoreBtn.textContent = 'Loading…';
                loadMoreBtn.disabled = true;
                fetch(window.location.pathname + `?page=${nextPage}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(r => r.text())
                .then(html => {
                    if (!html.trim()) {
                        loadMoreBtn.textContent = 'All products loaded';
                    } else {
                        document.getElementById('product-list').insertAdjacentHTML('beforeend', html);
                        nextPage++;
                        if (nextPage > lastPage) { loadMoreBtn.textContent = 'All products loaded'; }
                        else { loadMoreBtn.textContent = 'Load More'; loadMoreBtn.disabled = false; }
                    }
                })
                .catch(() => { loadMoreBtn.textContent = 'Error — try again'; loadMoreBtn.disabled = false; });
            });
        }
    }

    // Filter chips (UI only)
    document.querySelectorAll('.fchip').forEach(chip => {
        chip.addEventListener('click', function() {
            document.querySelectorAll('.fchip').forEach(c => c.classList.remove('on'));
            this.classList.add('on');
        });
    });

    // Face Shape Finder
    const faceRecs = {
        oval:   [['Aviator Classic','98%'],['Round Retro','94%'],['Wayfarer Bold','91%']],
        round:  [['Wayfarer Bold','97%'],['Square Geo','93%'],['Cat-eye Edge','89%']],
        square: [['Round Retro','96%'],['Aviator Classic','92%'],['Oval Slim','88%']],
        heart:  [['Aviator Light','95%'],['Round Slim','91%'],['Bottom-heavy','87%']],
        oblong: [['Oversized Round','97%'],['Bold Square','93%'],['Wraparound','89%']],
    };
    const thumbSvg = `<svg width="44" height="24" viewBox="0 0 44 24"><rect x="2" y="3" width="16" height="16" rx="7" fill="none" stroke="rgba(201,168,76,0.7)" stroke-width="1.5"/><rect x="26" y="3" width="16" height="16" rx="7" fill="none" stroke="rgba(201,168,76,0.7)" stroke-width="1.5"/><line x1="18" y1="11" x2="26" y2="11" stroke="rgba(201,168,76,0.7)" stroke-width="1.5"/><line x1="2" y1="9" x2="0" y2="4" stroke="rgba(201,168,76,0.7)" stroke-width="1.2"/><line x1="42" y1="9" x2="44" y2="4" stroke="rgba(201,168,76,0.7)" stroke-width="1.2"/></svg>`;
    function selectFace(el, shape) {
        document.querySelectorAll('.face-card').forEach(c => c.classList.remove('active'));
        el.classList.add('active');
        const recs = faceRecs[shape] || faceRecs.oval;
        document.getElementById('recGrid').innerHTML = recs.map(([n,m]) =>
            `<div class="rec-card"><div class="rec-thumb">${thumbSvg}</div><div><div class="rec-name">${n}</div><span class="rec-match">${m} match</span></div></div>`
        ).join('');
    }

    // Lens Builder
    function pickOpt(el) {
        const group = el.closest('.step-opts');
        group.querySelectorAll('.step-opt').forEach(o => o.classList.remove('active'));
        el.classList.add('active');
    }
</script>
@endpush
