<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Invoice #{{ $bill->invoice_number }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Outfit", sans-serif;
            margin: 0;
            padding: 0;
            align-items: normal;
        }

        table {
            vertical-align: top;
        }

        .header {
            position: relative;
            background-color: #E0EFFF;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .logo {
            position: relative;
            max-width: 160px;
        }

        .invoice-number {
            position: relative;
            font-size: 16px;
            line-height: normal;
            color: #000;
            font-weight: 500;
            text-align: right;

        }

        .address-section {
            position: relative;
            margin-bottom: 15px;
            align-items: normal;
        }

        .address-title {
            position: relative;
            font-size: 16px;
            line-height: normal;
            color: #000;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .address-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .address-table th {
            font-size: 14px;
            line-height: normal;
            color: #000;
            font-weight: 500;
            padding-bottom: 8px;
            white-space: nowrap;
            text-align: left;
        }

        .address-table td {
            font-size: 14px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 400;
            padding-bottom: 8px;
        }

        .info-section {
            position: relative;
            margin-bottom: 15px;
        }

        .info-label {
            position: relative;
            font-size: 16px;
            line-height: normal;
            color: #000;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .info-value {
            position: relative;
            font-size: 14px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 400;
        }

        .status-badge {
            position: relative;
            background-color: #CBF5E5;
            border-radius: 100px;
            padding: 5px 15px;
            color: #267055;
            font-size: 14px;
            line-height: normal;
            font-weight: 400;
            display: inline-block;
        }

        .status-paid {
            background-color: #CBF5E5;
            color: #267055;
        }

        .status-unpaid {
            background-color: #FFDAE1;
            color: #E25F5F;
        }

        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .services-table th {
            background-color: #E0EFFF;
            font-size: 14px;
            line-height: normal;
            color: #000;
            font-weight: 500;
            padding: 13px 20px;
            border-bottom: 0;
            text-align: left;
        }

        .services-table td {
            font-size: 14px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 500;
            padding: 10px 20px;
            border-bottom: 1px solid #E6EAED;
        }

        .services-table tbody tr:last-child td {
            border-bottom: none;
        }

        .amount-value {
            text-align: right;
        }

        .totals-section {
            margin-bottom: 15px;
            align-items: normal;
        }

        .notes-section {
            padding: 15px;
            background-color: #f0f4f7;
            border-radius: 10px;
        }

        .form-label {
            position: relative;
            font-size: 18px;
            line-height: normal;
            color: #000;
            font-weight: 400;
            margin: 0;
            padding: 0;
        }

        .bill-note-ul {
            padding-left: 20px;
        }

        .bill-note-ul li {
            position: relative;
            font-size: 16px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 400;
            margin-bottom: 10px;
        }

        .bank-details-box p {
            position: relative;
            font-size: 16px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 400;
            margin-bottom: 5px;
        }

        .bank-details-box p span {
            color: #000;
            font-weight: 500;
        }


        .total-row {
            margin-bottom: 8px;
            padding: 5px 0;
        }

        .subtotal-box .title {
            font-size: 16px;
            line-height: normal;
            color: #000;
            font-weight: 500;
        }

        .subtotal-box .total-number {
            font-size: 16px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 500;
            text-align: right;
        }

        .subtotal-box .total-title {
            font-size: 16px;
            line-height: normal;
            color: #000;
            font-weight: 500;
        }

        .pe-3 {
            padding-right: 1.2rem !important;
        }

        .subtotal-box {
            position: relative;
            padding: 15px;
            background-color: #F0F0FF;
            border-radius: 10px;
        }

        .terms-section h4 {
            position: relative;
            font-size: 16px;
            line-height: normal;
            color: #000;
            font-weight: 500;
            margin-bottom: 0;
        }

        .terms-section p {
            position: relative;
            font-size: 14px;
            line-height: normal;
            color: #6f6f6f;
            font-weight: 400;
        }

        @media print {
            body {
                margin: 0;
            }

            .amount-value {
                text-align: right !important;
            }

            .services-table th,
            .services-table td {
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <div class="logo">
                        <img src="{{ asset('assets/admin/images/logo.png') }}" alt="Kulvriksh Logo" style="max-width: 150px; max-height: 60px;">
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="invoice-number">
                        Invoice #{{ $bill->invoice_number }}
                    </div>
                </td>
            </tr>
        </table>


    </div>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <div class="from-address">
                    <div class="address-title">From</div>
                    <table class="address-table">
                        <tr>
                            <th class="pe-3">Name:</th>
                            <td>Kulvriksh Pvt Ltd </td>
                        </tr>
                        <tr>
                            <th class="pe-3">Address:</th>
                            <td>D 204, EARTH ACROPOLIS, TOWER 2, BHAYLI, VADODARA, GUJARAT - 390002</td>
                        </tr>
                        <tr>
                            <th class="pe-3">Email:</th>
                            <td>kulvriksh@gmail.com</td>
                        </tr>
                        <tr>
                            <th class="pe-3">CIN Number:</th>
                            <td>U74110GJ2017PTC098902 </td>
                        </tr>
                        <tr>
                            <th class="pe-3">GST Number:</th>
                            <td>24AAZCS1599N1Z8 </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 50%;">
                <div class="to-address">
                    <div class="address-title">To</div>
                    <table class="address-table">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $bill->client->lead->first_name ?? '-' }}
                                {{ $bill->client->lead->middle_name ?? '-' }}
                                {{ $bill->client->lead->last_name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Country:</th>
                            <td>{{ $bill->client->lead->countries->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td style="width: 300px; text-wrap: break-word;">
                                {{ $bill->client->lead->notes ?? '-' }},
                                {{ implode(', ', array_filter([$bill->client->lead->villages->name ?? null, $bill->client->lead->talukas->name ?? null, $bill->client->lead->districts->name ?? null, $bill->client->lead->states->name ?? null])) }}
                            </td>
                        </tr>

                        <tr>
                            <th>Email:</th>
                            <td>{{ $bill->client->lead->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Phone No.:</th>
                            <td>{{ $bill->client->lead->phone ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="info-section">
        <table style="width: 100%;">
            <tr>
                <td style="width: 25%;">
                    <div class="info-item">
                        <div class="info-label">Kulvriksh ID</div>
                        <div class="info-value">{{ $bill->client->kulvrisk_id ?? '-' }}</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="info-item">
                        <div class="info-label">Created On</div>
                        <div class="info-value">{{ $bill->created_at->format('d M Y') }}</div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $bill->status }}">
                                {{ ucfirst($bill->status) }}
                            </span>
                        </div>
                    </div>
                </td>
                <td style="width: 25%;">
                    <div class="info-item">
                        <div class="info-label">Total Amount</div>
                        <div class="info-value">₹{{ number_format((float) $totalAmount, 2, '.', ',') }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="services-table">
        <thead>
            <tr>
                <th>Service Name</th>
                <th>HSN/SAC</th>
                <th style="text-align: right;">Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $bill->sac_number }}</td>
                    <td class="amount-value">₹{{ number_format((float) $project->amount, 2, '.', ',') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 60%;">
                <div class="notes-section">
                    <h5 class="form-label">Important Notes:</h5>
                    <ul class="bill-note-ul">
                        <li>Payment is due within <strong>30 days</strong> of invoice date.</li>
                        <li>Make payment to the below account details:</li>
                    </ul>
                    <div class="bank-details bank-details-box">
                        <p><span>Bank:</span> {{ $bill->bankAccount->bank_name ?? 'N/A' }}</p>
                        <p><span>Account Holder:</span> {{ $bill->bankAccount->account_holder_name ?? 'N/A' }}</p>
                        <p><span>IFSC Code:</span> {{ $bill->bankAccount->ifsc_code ?? 'N/A' }}</p>
                        <p><span>Account No:</span> {{ $bill->bankAccount->account_number ?? 'N/A' }}</p>
                        <p><span>Branch:</span> {{ $bill->bankAccount->branch_name ?? 'N/A' }}</p>
                        <p><span>UPI ID Kulvriksh:</span> {{ $bill->bankAccount->upi_number ?? 'N/A' }}</p>
                        <p><span>SWIFT Code:</span> {{ $bill->bankAccount->swift_code ?? 'N/A' }}</p>
                    </div>
                </div>
            </td>
            <td style="width: 40%;">
                <div class="subtotal-box">
                    <div class="total-row">
                        <span class="title pe-3">Sub-total:</span>
                        <span class="total-number">₹ {{ number_format((float) ($isIndia ? $subTotal : $subTotal + $cgst + $sgst), 2, '.', ',') }}</span>
                    </div>
                    @if ($isIndia)
                        @if ($isGujarat)
                            <div class="total-row">
                                <span class="title pe-3">CGST <small class="text-danger">(9%)</small>:</span>
                                <span class="total-number">₹ {{ number_format((float) $cgst, 2, '.', ',') }}</span>
                            </div>
                            <div class="total-row">
                                <span class="title pe-3">SGST <small class="text-danger">(9%)</small>:</span>
                                <span class="total-number">₹ {{ number_format((float) $sgst, 2, '.', ',') }}</span>
                            </div>
                        @else
                            <div class="total-row">
                                <span class="title pe-3">IGST <small class="text-danger">(18%)</small>:</span>
                                <span class="total-number">₹ {{ number_format((float) $igst, 2, '.', ',') }}</span>
                            </div>
                        @endif
                    @endif
                    <div class="total-row">
                        <span class="title pe-3">Actual Amount:</span>
                        <span class="total-number">₹ {{ number_format((float) $grossAmount, 2, '.', ',') }}</span>
                    </div>
                    @if ($roundOffDiscount > 0)
                        <div class="total-row">
                            <span class="title pe-3">Round-off Discount:</span>
                            <span class="total-number">₹ {{ number_format((float) $roundOffDiscount, 2, '.', ',') }}</span>
                        </div>
                    @endif
                    <div class="total-row">
                        <span class="total-title pe-3">Total Amount:</span>
                        <span class="total-title">₹ {{ number_format((float) $totalAmount, 2, '.', ',') }}</span>
                    </div>
                </div>

            </td>
        </tr>
    </table>

    <div class="terms-section">
        <h4>Terms & Condition</h4>
        <p>
            The payment is immediate. Genealogy research will take 7 to 251 working days. For more terms and conditions,
            visit www.kulvriksh.in. The genealogy research fee is non-refundable.
        </p>

        <h4>Declaration</h4>
        <p>
            We declare that this invoice shows the actual price of the goods described and that all particulars are true and
            correct in all respects.
        </p>
    </div>
</body>

</html>
