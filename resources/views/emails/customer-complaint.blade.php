<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Customer Complaint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            padding: 25px 20px;
            border-radius: 8px 8px 0 0;
            text-align: center;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
        }
        .info-row {
            margin-bottom: 15px;
            padding: 12px 15px;
            background: white;
            border-left: 4px solid #e53e3e;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .label {
            font-weight: bold;
            color: #e53e3e;
            display: inline-block;
            min-width: 160px;
        }
        .value {
            color: #333;
        }
        .complaint-box {
            background: #fff8f8;
            border: 1px solid #fed7d7;
            border-left: 4px solid #e53e3e;
            border-radius: 4px;
            padding: 15px;
            margin-top: 5px;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
        .badge {
            display: inline-block;
            background: #e53e3e;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">📢 New Customer Complaint Received</h2>
        <span class="badge">Action Required</span>
    </div>

    <div class="content">
        <p>A new customer complaint has been submitted. Please review the details below:</p>

        <div class="info-row">
            <span class="label">👤 Name:</span>
            <span class="value">{{ $complaint->name }}</span>
        </div>

        <div class="info-row">
            <span class="label">📧 Email:</span>
            <span class="value">{{ $complaint->email }}</span>
        </div>

        <div class="info-row">
            <span class="label">📞 Phone:</span>
            <span class="value">{{ $complaint->phone }}</span>
        </div>

        <div class="info-row">
            <span class="label">🛒 Order Number:</span>
            <span class="value">{{ $complaint->order_number ?? 'N/A' }}</span>
        </div>

        <div class="info-row">
            <span class="label">📌 Subject:</span>
            <span class="value">{{ $complaint->subject }}</span>
        </div>

        <div class="info-row">
            <span class="label">🗓️ Submitted At:</span>
            <span class="value">{{ \Carbon\Carbon::parse($complaint->created_at)->format('d M, Y - h:i A') }}</span>
        </div>

        <div class="info-row">
            <span class="label">💬 Complaint Details:</span>
            <div class="complaint-box">{{ $complaint->complaint }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>