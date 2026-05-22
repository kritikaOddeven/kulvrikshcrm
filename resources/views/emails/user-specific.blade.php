<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $data['subject'] ?? 'User Specific Email' }}</title>
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
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $data['subject'] ?? 'User Specific Email' }}</h2>
        <p>Sent by: {{ $user->name }} ({{ $user->email }})</p>
    </div>

    <div class="content">
        @if(isset($data['message']))
            {!! $data['message'] !!}
        @else
            <p>This is a user-specific email sent using your configured SMTP settings.</p>
        @endif

        @if(isset($data['additional_content']))
            <div style="margin-top: 20px; padding: 15px; background-color: #e9ecef; border-radius: 5px;">
                {!! $data['additional_content'] !!}
            </div>
        @endif
    </div>

    <div class="footer">
        <p>This email was sent using your personal SMTP configuration.</p>
        <p>Sent on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
    </div>
</body>
</html> 