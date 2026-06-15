<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f7f6; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #eeeeee; }
        .logo { color: #0A3A7A; font-size: 24px; font-weight: bold; }
        .content { padding: 20px 0; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .status-confirmed { background-color: #e0e7ff; color: #4338ca; }
        .status-completed { background-color: #dcfce7; color: #15803d; }
        .status-cancelled { background-color: #fee2e2; color: #b91c1c; }
        .details { background-color: #f9fafb; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; padding-top: 20px; font-size: 12px; color: #666; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Event Marketplace</div>
        </div>
        <div class="content">
            <h2>{{ $title }}</h2>
            <p>Dear {{ $booking->customer_name }},</p>
            <p>{{ $messageBody }}</p>
            
            <div class="details">
                <p><strong>Service:</strong> {{ $booking->service->name }}</p>
                <p><strong>Date:</strong> {{ $booking->booking_date->format('M d, Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="status-badge status-{{ $booking->status }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </p>
            </div>
            
            <p>You can view more details in your dashboard.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Event Marketplace. All rights reserved.
        </div>
    </div>
</body>
</html>

