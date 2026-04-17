{{-- resources/views/booking/create.blade.php --}}
@extends('layouts.master')

@push('styles')
<style>
.booking-wrap {
    max-width: 720px;
    margin: 60px auto;
    padding: 0 20px 80px;
}
.booking-card {
    border: 1px solid var(--border);
    background: #fff;
    padding: 48px;
}
.booking-title {
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    font-weight: 600;
    color: var(--espresso);
    margin-bottom: 6px;
}
.booking-sub {
    font-size: 13px;
    color: #9A8C7E;
    margin-bottom: 36px;
}
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 18px;
}
.form-grid-3 {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 18px;
    margin-bottom: 18px;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.form-group.full {
    margin-bottom: 18px;
}
.form-label {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #9A8C7E;
}
.form-label span { color: var(--crimson); }
.form-control {
    padding: 10px 14px;
    border: 1px solid var(--border);
    font-size: 14px;
    color: var(--espresso);
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
    box-sizing: border-box;
    font-family: inherit;
}
.form-control:focus { border-color: var(--espresso); }
textarea.form-control { resize: vertical; }
.alert {
    padding: 14px 18px;
    margin-bottom: 24px;
    font-size: 13px;
    border-radius: 0;
}
.alert-success { background: #E1F5EE; border: 1px solid #5DCAA5; color: #085041; }
.alert-error   { background: #FAECE7; border: 1px solid #F0997B; color: #712B13; }
.prefill-note {
    font-size: 12px;
    color: #9A8C7E;
    background: var(--cream-soft);
    border: 1px solid var(--border);
    padding: 10px 14px;
    margin-bottom: 28px;
}
.section-divider {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--crimson);
    border-bottom: 1px solid var(--border);
    padding-bottom: 8px;
    margin-bottom: 20px;
    margin-top: 8px;
}
.btn-submit {
    width: 100%;
    background: var(--crimson);
    color: #fff;
    border: none;
    padding: 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 10px;
}
.btn-submit:hover { background: var(--crimson-dark); }

@media (max-width: 640px) {
    .booking-card { padding: 28px 20px; }
    .form-grid-2, .form-grid-3 { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="booking-wrap">
    <div class="booking-card">

        <div class="booking-title">Book an Appointment</div>
        <p class="booking-sub">Sunday – Friday &nbsp;·&nbsp; 10:00 AM – 7:00 PM &nbsp;·&nbsp; Geetanagar, Bharatpur</p>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- Pre-fill note --}}
        @auth
            <div class="prefill-note">
                Logged in as <strong>{{ Auth::user()->name }}</strong> — your details have been filled in automatically.
            </div>
        @endauth

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            {{-- Personal info --}}
            <div class="section-divider">Personal information</div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Full name <span>*</span></label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $user?->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone <span>*</span></label>
                    <input type="text" name="phone" class="form-control"
                        value="{{ old('phone', $user?->phone) }}" required>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $user?->email) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $user?->address) }}">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Age</label>
                    <input type="number" name="age" class="form-control"
                        min="1" max="120" value="{{ old('age') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control">
                        <option value="">Select</option>
                        <option value="male"   {{ old('gender') === 'male'   ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other"  {{ old('gender') === 'other'  ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            {{-- Eye problems --}}
            <div class="section-divider" style="margin-top:28px;">Eye problems</div>

            <div class="form-group full">
                <label class="form-label">Describe your eye problems / reason for visit <span>*</span></label>
                <textarea name="problems" class="form-control" rows="3" required>{{ old('problems') }}</textarea>
            </div>

            {{-- Appointment details --}}
            <div class="section-divider" style="margin-top:28px;">Appointment details</div>

            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Date <span>*</span></label>
                    <input type="date" name="booking_date" class="form-control"
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('booking_date') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Time slot <span>*</span></label>
                    <select name="booking_time" class="form-control" required>
                        <option value="">Pick a slot</option>
                        @foreach(['10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30'] as $slot)
                            <option value="{{ $slot }}" {{ old('booking_time') === $slot ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromFormat('H:i', $slot)->format('h:i A') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Service <span>*</span></label>
                    <select name="service_type" class="form-control" required>
                        <option value="eye_exam"     {{ old('service_type') === 'eye_exam'     ? 'selected' : '' }}>Eye Exam</option>
                        <option value="fitting"      {{ old('service_type') === 'fitting'      ? 'selected' : '' }}>Frame Fitting</option>
                        <option value="consultation" {{ old('service_type') === 'consultation' ? 'selected' : '' }}>Consultation</option>
                    </select>
                </div>
            </div>

            <div class="form-group full">
                <label class="form-label">Additional notes</label>
                <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Submit Booking Request</button>

        </form>
    </div>
</div>
@endsection
