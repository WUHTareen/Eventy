<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6; color: #374151; margin: 0; padding: 0; background-color: #f3f4f6; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background: #0A192F; padding: 28px; text-align: center; }
        .logo { color: #ffffff; font-size: 24px; font-weight: bold; letter-spacing: 1px; }
        .logo .dot { color: #ED1C24; }
        .content { padding: 36px; }
        .h2 { font-size: 22px; font-weight: 700; color: #111827; margin: 0 0 12px; }
        .p { font-size: 15px; color: #6b7280; margin: 0 0 18px; }
        .status-badge { display: inline-block; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: bold; text-transform: uppercase; }
        .status-pending { background-color: #fef3c7; color: #b45309; }
        .status-confirmed { background-color: #e0e7ff; color: #4338ca; }
        .status-completed { background-color: #dcfce7; color: #15803d; }
        .status-cancelled { background-color: #fee2e2; color: #b91c1c; }
        .details { background-color: #f9fafb; padding: 18px 20px; border-radius: 10px; margin: 20px 0; }
        .details p { margin: 6px 0; font-size: 14px; }
        .btn { display: inline-block; background: #ED1C24; color: #ffffff; padding: 12px 26px; border-radius: 8px; text-decoration: none; font-weight: 600; }
        .footer { text-align: center; padding: 20px; background: #f9fafb; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">EVENTY<span class="dot">.</span>PK</div>
        </div>
        <div class="content">
            <div class="h2">{{ $title }}</div>
            <p class="p">Dear {{ $booking->customer_name }},</p>
            <p class="p">{{ $messageBody }}</p>

            <div class="details">
                <p><strong>Booking Ref:</strong> #{{ $booking->id }}</p>
                <p><strong>Service:</strong> {{ $booking->service->name }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('D, M d, Y') }}</p>
                <p><strong>Location:</strong> {{ $booking->event_location }}</p>
                <p><strong>Total:</strong> Rs. {{ number_format($booking->total_price) }}</p>
                <p><strong>Status:</strong>
                    <span class="status-badge status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                </p>
            </div>

            <p class="p" style="text-align:center;">
                <a href="{{ url('/') }}" class="btn">Visit Eventy.pk</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Eventy.pk. All rights reserved.<br>
            Sent from info@eventy.pk
        </div>
    </div>
</body>
</html>
