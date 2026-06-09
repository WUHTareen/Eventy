<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background: #1e1b4b; padding: 30px; text-align: center; }
        .logo { font-size: 24px; font-weight: bold; color: #ffffff; letter-spacing: 1px; }
        .content { padding: 40px; color: #374151; }
        .h1 { font-size: 24px; font-weight: 700; color: #111827; margin-bottom: 10px; }
        .p { font-size: 16px; line-height: 24px; color: #6b7280; margin-bottom: 24px; }
        
        /* The Ticket */
        .ticket {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            border-radius: 16px;
            padding: 24px;
            color: white;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .ticket-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; border-bottom: 1px dashed rgba(255,255,255,0.3); padding-bottom: 15px; }
        .ticket-title { font-size: 14px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.9; }
        .ticket-id { font-size: 18px; font-weight: bold; font-family: monospace; }
        
        .ticket-body { display: flex; gap: 20px; }
        .info-col { flex: 1; }
        .label { font-size: 12px; text-transform: uppercase; color: rgba(255,255,255,0.7); margin-bottom: 4px; display: block; }
        .value { font-size: 16px; font-weight: 600; margin-bottom: 16px; display: block; }
        
        .qr-col { width: 100px; display: flex; align-items: center; justify-content: center; background: white; border-radius: 8px; padding: 5px; }
        .qr-img { width: 90px; height: 90px; }
        
        .footer { text-align: center; padding: 20px; background: #f9fafb; font-size: 12px; color: #9ca3af; }
        .btn { display: inline-block; background: #1e1b4b; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 10px; }
        
        /* Mobile */
        @media only screen and (max-width: 600px) {
            .container { margin: 0; border-radius: 0; }
            .content { padding: 20px; }
            .ticket-body { flex-direction: column; }
            .qr-col { margin: 0 auto; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">EVENTY</div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="h1">Booking Confirmed! 🎉</div>
            <p class="p">Hi {{ $booking->customer_name }},</p>
            <p class="p">Your reservation is locked in. Here is your official service ticket. Please show this to the vendor upon arrival.</p>
            
            <!-- The Ticket -->
            <div class="ticket">
                <div class="ticket-header">
                    <div>
                        <div class="ticket-title">Admission Ticket</div>
                        <div style="font-size: 20px; font-weight: bold; margin-top: 5px;">{{ $booking->service->name }}</div>
                    </div>
                    <div class="ticket-id">#{{ $booking->id }}</div>
                </div>
                
                <div class="ticket-body">
                    <div class="info-col">
                        <span class="label">Date</span>
                        <span class="value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('D, M d, Y') }}</span>
                        
                        <span class="label">Location</span>
                        <span class="value">{{ $booking->event_location }}</span>
                        
                        <span class="label">Total Amount</span>
                        <span class="value">Rs. {{ number_format($booking->total_price) }}</span>
                    </div>
                    <div class="qr-col">
                        <!-- Dynamic QR Code -->
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $booking->id }}-{{ $booking->status }}" class="qr-img" alt="QR">
                    </div>
                </div>
            </div>
            
            <p class="p" style="text-align: center;">
                <a href="{{ route('bookings.index') }}" class="btn">View My Bookings</a>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Eventy. All rights reserved.<br>
            Sent from info@eventy.pk
        </div>
    </div>
</body>
</html>

