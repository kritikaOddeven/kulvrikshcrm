<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .invoice-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="email-content">
        <div class="invoice-info">
            <h3>Invoice #<?php echo e($bill->invoice_number); ?></h3>
            <p><strong>Client:</strong> <?php echo e($bill->client->lead->first_name ?? ''); ?> <?php echo e($bill->client->lead->middle_name ?? ''); ?> <?php echo e($bill->client->lead->last_name ?? ''); ?></p>
            <p><strong>Date:</strong> <?php echo e($bill->created_at->format('d M Y')); ?></p>
            <p><strong>Amount:</strong> ₹<?php echo e(number_format((float) $bill->amount, 2, '.', ',')); ?></p>
        </div>
        
        <?php echo $customBody ?? 'Please find the attached invoice for your reference.'; ?>

        
        <div class="footer">
            <p>This is an automated email from Kulvriksh. Please do not reply to this email.</p>
            <p>For any queries, please contact us at kulvriksh@gmail.com</p>
        </div>
    </div>
</body>
</html> <?php /**PATH /var/www/fastuser/data/www/crm.kulvriksh.in/resources/views/emails/bill/bill-mail.blade.php ENDPATH**/ ?>