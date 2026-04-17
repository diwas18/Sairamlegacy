@extends('layouts.master')

@section('content')

{{-- ===== FONTS ===== --}}
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

<style>
    /* ── CSS Variables ── */
    :root {
        --burgundy:    #800020;
        --burgundy-lt: #a0203a;
        --gold:        #c9a84c;
        --cream:       #faf8f4;
        --charcoal:    #1a1a1a;
        --mid:         #555;
        --border:      #e0d9ce;
        --glass-bg:    rgba(255,255,255,0.72);
        --shadow:      0 8px 40px rgba(0,0,0,0.10);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--cream);
        font-family: 'DM Sans', sans-serif;
        color: var(--charcoal);
        min-height: 100vh;
    }

    /* ── Page Header ── */
    .vto-header {
        text-align: center;
        padding: 48px 24px 24px;
        border-bottom: 1px solid var(--border);
        background: white;
    }
    .vto-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(2rem, 5vw, 3.2rem);
        font-weight: 700;
        letter-spacing: 0.02em;
        color: var(--charcoal);
    }
    .vto-header h1 span { color: var(--burgundy); }
    .vto-header p {
        margin-top: 8px;
        color: var(--mid);
        font-size: 0.95rem;
        font-weight: 300;
    }

    /* ── Main Layout ── */
    .vto-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 32px;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 24px 60px;
    }
    @media (max-width: 900px) {
        .vto-layout { grid-template-columns: 1fr; }
    }

    /* ── Card ── */
    .card {
        background: white;
        border-radius: 20px;
        box-shadow: var(--shadow);
        border: 1px solid var(--border);
        overflow: hidden;
    }
    .card-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-header .dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: var(--burgundy);
        flex-shrink: 0;
    }
    .card-header h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 600;
        letter-spacing: 0.03em;
    }
    .card-body { padding: 24px; }

    /* ── Tabs ── */
    .tabs {
        display: flex;
        gap: 0;
        border-bottom: 1px solid var(--border);
        background: white;
    }
    .tab-btn {
        flex: 1;
        padding: 14px 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        color: var(--mid);
        transition: all 0.2s;
    }
    .tab-btn.active {
        color: var(--burgundy);
        border-bottom-color: var(--burgundy);
    }
    .tab-btn:hover:not(.active) { color: var(--charcoal); }

    /* ── Try-On View ── */
    .tryon-view {
        position: relative;
        width: 100%;
        background: #f0ede8;
        border-radius: 12px;
        overflow: hidden;
        min-height: 340px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .tryon-view video,
    .tryon-view img#userPhoto {
        width: 100%;
        max-height: 420px;
        object-fit: cover;
        display: block;
        border-radius: 12px;
    }
    .tryon-view canvas {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border-radius: 12px;
        pointer-events: none;
    }
    .tryon-placeholder {
        text-align: center;
        padding: 40px 20px;
        color: var(--mid);
    }
    .tryon-placeholder svg {
        width: 56px; height: 56px;
        margin: 0 auto 12px;
        opacity: 0.3;
    }
    .tryon-placeholder p { font-size: 0.9rem; }

    /* Tab panels */
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── Upload Area ── */
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 28px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        margin-bottom: 20px;
    }
    .upload-area:hover { border-color: var(--burgundy); background: #fff5f7; }
    .upload-area input { display: none; }
    .upload-area svg { width: 36px; height: 36px; opacity: 0.35; margin-bottom: 8px; }
    .upload-area p { font-size: 0.88rem; color: var(--mid); }
    .upload-area strong { color: var(--burgundy); font-weight: 500; }

    /* ── Face Shape Badge ── */
    .face-badge {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 12px 16px;
        margin-top: 16px;
    }
    .face-badge label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--mid);
        font-weight: 500;
    }
    .face-badge #faceShape {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--burgundy);
    }

    /* ── Status Bar ── */
    .status-bar {
        margin-top: 12px;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 0.83rem;
        font-weight: 400;
        display: none;
    }
    .status-bar.info  { background: #eef4ff; color: #3a6fd8; display: block; }
    .status-bar.warn  { background: #fff7e6; color: #c07b00; display: block; }
    .status-bar.error { background: #fff0f0; color: #c0392b; display: block; }
    .status-bar.ok    { background: #f0fff4; color: #27a060; display: block; }

    /* ── Glasses Sidebar ── */
    .glasses-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-height: 520px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .glasses-grid::-webkit-scrollbar { width: 4px; }
    .glasses-grid::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .glass-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border: 1.5px solid var(--border);
        border-radius: 12px;
        cursor: pointer;
        background: white;
        transition: all 0.2s;
        text-align: left;
    }
    .glass-card:hover {
        border-color: var(--burgundy);
        background: #fff5f7;
        transform: translateX(3px);
    }
    .glass-card.selected {
        border-color: var(--burgundy);
        background: #fff0f2;
        box-shadow: 0 0 0 3px rgba(128,0,32,0.10);
    }
    .glass-card img {
        width: 72px; height: 40px;
        object-fit: contain;
        border-radius: 6px;
        background: var(--cream);
        flex-shrink: 0;
        padding: 4px;
    }
    .glass-card-info { flex: 1; }
    .glass-card-info .glass-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--charcoal);
        line-height: 1.2;
    }
    .glass-card-info .glass-sub {
        font-size: 0.78rem;
        color: var(--mid);
        margin-top: 2px;
    }
    .glass-card .check {
        width: 20px; height: 20px;
        border-radius: 50%;
        background: var(--burgundy);
        color: white;
        font-size: 11px;
        display: none;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .glass-card.selected .check { display: flex; }

    /* ── Face Shape Filter ── */
    .shape-filter {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .shape-chip {
        padding: 5px 12px;
        border-radius: 20px;
        border: 1px solid var(--border);
        background: white;
        font-size: 0.78rem;
        cursor: pointer;
        transition: all 0.18s;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        color: var(--mid);
    }
    .shape-chip.active {
        background: var(--burgundy);
        border-color: var(--burgundy);
        color: white;
    }

    /* ── Tip Box ── */
    .tip-box {
        margin-top: 20px;
        padding: 14px 16px;
        border-left: 3px solid var(--gold);
        background: #fffbf0;
        border-radius: 0 10px 10px 0;
        font-size: 0.83rem;
        color: #7a6000;
        line-height: 1.5;
    }
    .tip-box strong { display: block; margin-bottom: 4px; font-weight: 600; }
</style>

{{-- ===== HTML ===== --}}

<div class="vto-header">
    <h1>Virtual <span>Try‑On</span></h1>
    <p>See how glasses look on your face — live via webcam or with a photo upload.</p>
</div>

<div class="vto-layout">

    {{-- ── LEFT: Camera / Photo Panel ── --}}
    <div class="card">
        {{-- Tabs --}}
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('webcam')">📷 Webcam</button>
            <button class="tab-btn"        onclick="switchTab('photo')">🖼 Upload Photo</button>
        </div>

        {{-- WEBCAM TAB --}}
        <div id="tab-webcam" class="tab-panel active card-body">
            <div class="tryon-view" id="webcamView">
                <video id="webcamVideo" autoplay playsinline muted></video>
                <canvas id="webcamCanvas"></canvas>
            </div>
            <div id="webcamStatus" class="status-bar info">Starting camera…</div>
            <div class="face-badge">
                <label>Face Shape</label>
                <span id="faceShape">Detecting…</span>
            </div>
        </div>

        {{-- PHOTO TAB --}}
        <div id="tab-photo" class="tab-panel card-body">
            <label class="upload-area" for="photoInput">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <p><strong>Click to upload</strong> or drag and drop</p>
                <p style="margin-top:4px; font-size:0.78rem;">JPG, PNG — front-facing portrait works best</p>
                <input type="file" id="photoInput" accept="image/*">
            </label>

            <div class="tryon-view" id="photoView" style="display:none;">
                <img id="userPhoto" src="" alt="Your photo">
                <canvas id="photoCanvas"></canvas>
            </div>
            <div id="photoPlaceholder" class="tryon-placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                    <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <p>Upload a photo to try on glasses</p>
            </div>
            <div id="photoStatus" class="status-bar" style="display:none;"></div>
            <div class="face-badge" style="margin-top:16px;">
                <label>Face Shape</label>
                <span id="faceShapePhoto">—</span>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Glasses Sidebar ── --}}
    <div>
        <div class="card">
            <div class="card-header">
                <div class="dot"></div>
                <h2>Choose Glasses</h2>
            </div>
            <div class="card-body">

                {{-- Face shape filter chips --}}
                <div class="shape-filter">
                    <button class="shape-chip active" onclick="filterByShape('all', this)">All</button>
                    <button class="shape-chip" onclick="filterByShape('oval', this)">Oval</button>
                    <button class="shape-chip" onclick="filterByShape('round', this)">Round</button>
                    <button class="shape-chip" onclick="filterByShape('long', this)">Long</button>
                    <button class="shape-chip" onclick="filterByShape('square', this)">Square</button>
                </div>

                {{-- Glasses list --}}
                <div class="glasses-grid" id="glassesList">
    @foreach($glasses as $glass)
    <div
        class="glass-card"
        data-shape="{{ strtolower($glass->face_shape ?? 'all') }}"
        {{-- Updated JS parameter to use products folder and photopath --}}
        onclick="selectGlass(this, '{{ asset('images/products/' . $glass->photopath) }}', '{{ $glass->name }}')"
    >
        <img
            {{-- Updated image source path --}}
            src="{{ asset('images/products/' . $glass->photopath) }}"
            alt="{{ $glass->name ?? 'Product Image' }}"
            {{-- Added path visibility to the error handler for easier debugging --}}
            onerror="this.style.opacity=0.3; this.title='Image not found: {{ $glass->photopath }}'"
        >
        <div class="glass-card-info">
            <div class="glass-name">{{ $glass->name }}</div>
            <div class="glass-sub">{{ $glass->face_shape ?? 'All face shapes' }}</div>
        </div>
        <div class="check">✓</div>
    </div>
    @endforeach
</div>

                {{-- Style tip --}}
                <div class="tip-box" id="styleTip">
                    <strong>💡 Style Tip</strong>
                    Select a frame to see it on your face. For the best result, face the camera directly with good lighting.
                </div>

            </div>
        </div>
    </div>

</div>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>

<script>
// ================================================================
//  STATE
// ================================================================
let currentGlassUrl  = null;
let glassImage       = new Image();
let activeTab        = 'webcam';
let faceMesh         = null;
let mpCamera         = null;
let photoFaceMesh    = null;

// ================================================================
//  TAB SWITCHING
// ================================================================
function switchTab(tab) {
    activeTab = tab;

    // Update tab buttons
    document.querySelectorAll('.tab-btn').forEach((btn, i) => {
        btn.classList.toggle('active', (i === 0 && tab === 'webcam') || (i === 1 && tab === 'photo'));
    });

    // Show/hide panels
    document.getElementById('tab-webcam').classList.toggle('active', tab === 'webcam');
    document.getElementById('tab-photo').classList.toggle('active',  tab === 'photo');
}

// ================================================================
//  GLASSES SELECTION
// ================================================================
function selectGlass(cardEl, url, name) {
    // Deselect all
    document.querySelectorAll('.glass-card').forEach(c => c.classList.remove('selected'));
    cardEl.classList.add('selected');

    currentGlassUrl = url;
    glassImage      = new Image();
    glassImage.crossOrigin = 'anonymous';
    glassImage.src  = url;

    // Update style tip
    document.getElementById('styleTip').innerHTML =
        `<strong>👓 Selected: ${name}</strong>Switch between Webcam and Upload to try it on.`;
}

// ================================================================
//  FACE SHAPE FILTER
// ================================================================
function filterByShape(shape, chipEl) {
    document.querySelectorAll('.shape-chip').forEach(c => c.classList.remove('active'));
    chipEl.classList.add('active');

    document.querySelectorAll('.glass-card').forEach(card => {
        const cardShape = card.dataset.shape;
        card.style.display = (shape === 'all' || cardShape === 'all' || cardShape === shape)
            ? 'flex' : 'none';
    });
}

// ================================================================
//  STATUS HELPER
// ================================================================
function setStatus(elId, type, msg) {
    const el = document.getElementById(elId);
    el.className = 'status-bar ' + type;
    el.textContent = msg;
}

// ================================================================
//  FACE SHAPE FROM LANDMARKS
// ================================================================
function detectFaceShape(landmarks) {
    const jawWidth   = Math.abs(landmarks[234].x - landmarks[454].x);
    const faceHeight = Math.abs(landmarks[10].y  - landmarks[152].y);
    const ratio = faceHeight / jawWidth;

    if (ratio < 1.3) return 'Round';
    if (ratio > 1.8) return 'Long';
    if (ratio > 1.55) return 'Oval';
    return 'Square';
}

// ================================================================
//  DRAW GLASSES ON CANVAS  (shared by webcam + photo)
// ================================================================
function drawGlasses(ctx, landmarks, W, H) {
    if (!currentGlassUrl || !glassImage.complete || !glassImage.naturalWidth) return;

    // Landmark 33  = left eye outer corner
    // Landmark 263 = right eye outer corner
    const x1 = landmarks[33].x  * W;
    const y1 = landmarks[33].y  * H;
    const x2 = landmarks[263].x * W;
    const y2 = landmarks[263].y * H;

    const cx    = (x1 + x2) / 2;           // center between eyes
    const cy    = (y1 + y2) / 2;
    const gw    = (x2 - x1) * 2.4;         // glasses width — tweak multiplier if needed
    const gh    = gw * 0.45;               // height ratio
    const angle = Math.atan2(y2 - y1, x2 - x1); // head tilt

    ctx.save();
    ctx.translate(cx, cy);
    ctx.rotate(angle);
    ctx.drawImage(glassImage, -gw / 2, -gh / 2 - gh * 0.05, gw, gh);
    ctx.restore();
}

// ================================================================
//  WEBCAM SETUP
// ================================================================
const webcamVideo  = document.getElementById('webcamVideo');
const webcamCanvas = document.getElementById('webcamCanvas');
const ctxWebcam    = webcamCanvas.getContext('2d');

// Start webcam stream
navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: 640, height: 480 } })
    .then(stream => {
        webcamVideo.srcObject = stream;
        setStatus('webcamStatus', 'ok', '✅ Camera ready — select a pair of glasses!');
    })
    .catch(err => {
        setStatus('webcamStatus', 'error', '❌ Camera not available: ' + err.message);
    });

// MediaPipe FaceMesh for webcam
faceMesh = new FaceMesh({
    locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
});
faceMesh.setOptions({
    maxNumFaces: 1,
    refineLandmarks: true,
    minDetectionConfidence: 0.5,
    minTrackingConfidence: 0.5
});
faceMesh.onResults(resultsWebcam);

// Camera utils loop
mpCamera = new Camera(webcamVideo, {
    onFrame: async () => {
        if (activeTab === 'webcam') {
            await faceMesh.send({ image: webcamVideo });
        }
    },
    width: 640,
    height: 480
});
mpCamera.start();

function resultsWebcam(results) {
    const W = webcamVideo.videoWidth  || 640;
    const H = webcamVideo.videoHeight || 480;

    webcamCanvas.width  = W;
    webcamCanvas.height = H;
    ctxWebcam.clearRect(0, 0, W, H);
    ctxWebcam.drawImage(webcamVideo, 0, 0, W, H);

    if (!results.multiFaceLandmarks || results.multiFaceLandmarks.length === 0) {
        document.getElementById('faceShape').textContent = 'No face detected';
        return;
    }

    const landmarks = results.multiFaceLandmarks[0];

    // Update face shape
    const shape = detectFaceShape(landmarks);
    document.getElementById('faceShape').textContent = shape;

    // Draw glasses
    drawGlasses(ctxWebcam, landmarks, W, H);
}

// ================================================================
//  PHOTO UPLOAD + FACE DETECTION
// ================================================================
const photoInput   = document.getElementById('photoInput');
const userPhoto    = document.getElementById('userPhoto');
const photoCanvas  = document.getElementById('photoCanvas');
const ctxPhoto     = photoCanvas.getContext('2d');
const photoView    = document.getElementById('photoView');
const photoHolder  = document.getElementById('photoPlaceholder');

// Separate FaceMesh instance for photos
photoFaceMesh = new FaceMesh({
    locateFile: file => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`
});
photoFaceMesh.setOptions({
    maxNumFaces: 1,
    refineLandmarks: true,
    minDetectionConfidence: 0.5,
    minTrackingConfidence: 0.5
});
photoFaceMesh.onResults(resultsPhoto);

photoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    setStatus('photoStatus', 'info', '⏳ Loading photo…');
    document.getElementById('photoStatus').style.display = 'block';

    const reader = new FileReader();
    reader.onload = evt => {
        userPhoto.onload = async () => {
            photoView.style.display  = 'flex';
            photoHolder.style.display = 'none';

            photoCanvas.width  = userPhoto.naturalWidth;
            photoCanvas.height = userPhoto.naturalHeight;
            ctxPhoto.drawImage(userPhoto, 0, 0);

            setStatus('photoStatus', 'info', '🔍 Detecting face…');
            await photoFaceMesh.send({ image: userPhoto });
        };
        userPhoto.src = evt.target.result;
    };
    reader.readAsDataURL(file);
});

function resultsPhoto(results) {
    const W = userPhoto.naturalWidth;
    const H = userPhoto.naturalHeight;

    ctxPhoto.clearRect(0, 0, W, H);
    ctxPhoto.drawImage(userPhoto, 0, 0, W, H);

    if (!results.multiFaceLandmarks || results.multiFaceLandmarks.length === 0) {
        setStatus('photoStatus', 'warn', '⚠️ No face detected — try a clearer front-facing photo.');
        document.getElementById('faceShapePhoto').textContent = '—';
        return;
    }

    const landmarks = results.multiFaceLandmarks[0];
    const shape = detectFaceShape(landmarks);
    document.getElementById('faceShapePhoto').textContent = shape;
    setStatus('photoStatus', 'ok', `✅ Face detected — shape: ${shape}`);

    drawGlasses(ctxPhoto, landmarks, W, H);
}

// Re-draw photo when a new glass is selected
glassImage.onload = () => {
    if (activeTab === 'photo' && userPhoto.src && userPhoto.naturalWidth) {
        photoFaceMesh.send({ image: userPhoto });
    }
};

// ================================================================
//  GLASSES SELECTION OVERRIDE (For Photo Re-render)
// ================================================================

// 1. Define the re-draw function separately for clarity
function reProcessPhoto() {
    if (activeTab === 'photo' && userPhoto.src && userPhoto.complete) {
        photoFaceMesh.send({ image: userPhoto });
    }
}

// 2. Override the selectGlass function to trigger the re-draw
const _originalSelectGlass = window.selectGlass;

window.selectGlass = function(cardEl, url, name) {
    // Call the original selection logic (updates UI and URL)
    _originalSelectGlass(cardEl, url, name);

    // When the new glass image finishes loading,
    // immediately re-run the FaceMesh on the uploaded photo
    glassImage.onload = reProcessPhoto;

    // If the image was already cached/loaded, trigger it manually
    if (glassImage.complete) {
        reProcessPhoto();
    }
};
</script>

@endsection
