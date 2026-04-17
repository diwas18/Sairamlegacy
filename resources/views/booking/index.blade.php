@extends('layouts.app')

@section('content')
<div style="padding: 40px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
        <div>
            <h2 style="font-family:'Playfair Display',serif; font-size:26px; font-weight:600; color:var(--espresso); margin-bottom:4px;">Booking Requests</h2>
            <p style="font-size:13px; color:#9A8C7E;">Manage and respond to appointment requests</p>
        </div>
        <div style="display:flex; gap:10px;">
            <span style="background:#FAEEDA; color:#633806; padding:6px 14px; font-size:12px; font-weight:600; border-radius:99px;">
                Pending: {{ $bookings->where('status','pending')->count() }}
            </span>
            <span style="background:#E1F5EE; color:#085041; padding:6px 14px; font-size:12px; font-weight:600; border-radius:99px;">
                Accepted: {{ $bookings->where('status','accepted')->count() }}
            </span>
            <span style="background:#FAECE7; color:#712B13; padding:6px 14px; font-size:12px; font-weight:600; border-radius:99px;">
                Rejected: {{ $bookings->where('status','rejected')->count() }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#E1F5EE; border:1px solid #5DCAA5; color:#085041; padding:13px 18px; margin-bottom:20px; font-size:13px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background:#fff; border:1px solid var(--border); overflow:hidden;">
        <table style="width:100%; border-collapse:collapse; font-size:13px;">
            <thead>
                <tr style="background:var(--cream-soft); border-bottom:2px solid var(--border);">
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">#</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Patient</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Contact</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Appointment</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Service</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Problems</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Status</th>
                    <th style="padding:13px 16px; text-align:left; font-size:10px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#9A8C7E;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr style="border-bottom:1px solid var(--border); transition:background 0.15s;"
                    onmouseover="this.style.background='var(--cream-soft)'"
                    onmouseout="this.style.background='#fff'">

                    {{-- # --}}
                    <td style="padding:14px 16px; color:#9A8C7E;">{{ $booking->id }}</td>

                    {{-- Patient --}}
                    <td style="padding:14px 16px;">
                        <div style="font-weight:600; color:var(--espresso); margin-bottom:2px;">{{ $booking->name }}</div>
                        <div style="font-size:11px; color:#9A8C7E;">
                            {{ $booking->age ? 'Age '.$booking->age : '' }}
                            {{ $booking->age && $booking->gender ? ' · ' : '' }}
                            {{ $booking->gender ? ucfirst($booking->gender) : '' }}
                        </div>
                        @if($booking->address)
                            <div style="font-size:11px; color:#9A8C7E;">{{ $booking->address }}</div>
                        @endif
                    </td>

                    {{-- Contact --}}
                    <td style="padding:14px 16px;">
                        <div style="font-size:13px; color:var(--espresso);">{{ $booking->phone }}</div>
                        @if($booking->email)
                            <div style="font-size:11px; color:#9A8C7E;">{{ $booking->email }}</div>
                        @endif
                    </td>

                    {{-- Appointment --}}
                    <td style="padding:14px 16px;">
                        <div style="font-weight:600; color:var(--espresso);">{{ $booking->formatted_date }}</div>
                        <div style="font-size:12px; color:#9A8C7E; margin-top:2px;">{{ $booking->formatted_time }}</div>
                    </td>

                    {{-- Service --}}
                    <td style="padding:14px 16px;">
                        <span style="background:var(--cream-soft); color:var(--espresso); padding:4px 10px; font-size:11px; font-weight:600; border:1px solid var(--border);">
                            {{ $booking->service_label }}
                        </span>
                    </td>

                    {{-- Problems --}}
                    <td style="padding:14px 16px; max-width:200px;">
                        <div style="font-size:12px; color:#5A4E44; line-height:1.5;">
                            {{ Str::limit($booking->problems, 70) }}
                        </div>
                        @if($booking->notes)
                            <div style="font-size:11px; color:#9A8C7E; margin-top:3px; font-style:italic;">
                                Note: {{ Str::limit($booking->notes, 40) }}
                            </div>
                        @endif
                    </td>

                    {{-- Status badge --}}
                    <td style="padding:14px 16px;">
                        @if($booking->isPending())
                            <span style="background:#FAEEDA; color:#633806; padding:4px 12px; font-size:11px; font-weight:600; border-radius:99px;">Pending</span>
                        @elseif($booking->isAccepted())
                            <span style="background:#E1F5EE; color:#085041; padding:4px 12px; font-size:11px; font-weight:600; border-radius:99px;">Accepted</span>
                        @else
                            <span style="background:#FAECE7; color:#712B13; padding:4px 12px; font-size:11px; font-weight:600; border-radius:99px;">Rejected</span>
                        @endif
                        <div style="font-size:10px; color:#9A8C7E; margin-top:4px;">
                            {{ $booking->created_at->diffForHumans() }}
                        </div>
                    </td>

                    {{-- Action --}}
                    <td style="padding:14px 16px;">
                        @if($booking->isPending())
                            <div style="display:flex; flex-direction:column; gap:6px;">
                                <form action="{{ route('admin.booking.status', $booking) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="accepted">
    <button type="submit"
        style="width:100%; background:#1D9E75; color:#fff; border:none; padding:7px 16px; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; cursor:pointer;">
        Accept
    </button>
</form>
                                <form action="{{ route('admin.booking.status', $booking) }}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="rejected">
    <button type="submit"
        style="width:100%; background:#D85A30; color:#fff; border:none; padding:7px 16px; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; cursor:pointer;">
        Reject
    </button>
</form>
                            </div>
                        @else
                            <span style="font-size:12px; color:#9A8C7E;">Done</span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding:48px; text-align:center; color:#9A8C7E; font-size:14px;">
                        No booking requests yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($bookings->hasPages())
        <div style="margin-top:20px;">
            {{ $bookings->links() }}
        </div>
    @endif

</div>
@endsection
