<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 20px;
            line-height: 1.4;
        }
        /* HEADER */
        .header-left {
            float: left;
            width: 50%;
            font-size: 12px;
        }
        .header-left strong {
            font-size: 18px;
            color: #0f3c75;
            display: block;
            margin-bottom: 5px;
        }
        .header-right {
            float: right;
            width: 30%;
            text-align: right;
        }
        .logo-box {
            width: 100px;
            height: 100px;
            overflow: hidden;
            float: right;
            margin-bottom: 5px;
        }
        .logo-box img {
            width: 100%;
            height: auto;
            display: block;
        }
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        .divider {
            clear: both;
            border-bottom: 2px solid #0f3c75;
            margin: 15px 0;
        }
        /* TITLE */
        .title {
            text-align: center;
            font-size: 42px;
            font-weight: bold;
            color: #0f3c75;
            margin: 20px 0;
        }
        .meta {
            float: right;
            text-align: right;
            font-size: 12px;
            margin-bottom: 20px;
        }
        .meta-line {
            margin-bottom: 3px;
        }
        /* FROM/TO */
        .from-box {
            float: left;
            width: 48%;
            border: 1px solid #d0d0d0;
            background: #fafbfc;
            padding: 12px;
            margin-bottom: 20px;
        }
        .to-box {
            float: right;
            width: 48%;
            border: 1px solid #d0d0d0;
            background: #fafbfc;
            padding: 12px;
            margin-bottom: 20px;
        }
        .box-title {
            font-size: 11px;
            font-weight: bold;
            color: #0f3c75;
            text-transform: uppercase;
            border-bottom: 1px solid #d0d0d0;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .box-content {
            font-size: 11px;
            line-height: 1.6;
        }
        .box-content strong {
            color: #0f3c75;
        }
        /* TABLE */
        .items-header {
            clear: both;
            font-size: 12px;
            font-weight: bold;
            color: #0f3c75;
            text-transform: uppercase;
            margin: 25px 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            clear: both;
        }
        table tr th {
            background: #0f3c75;
            color: #fff;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        table tr td {
            padding: 10px;
            border-bottom: 1px solid #d0d0d0;
            font-size: 11px;
        }
        table tr:nth-child(even) td {
            background: #f9fafb;
        }
        .qty { text-align: center; }
        .price { text-align: right; }
        .amount { text-align: right; font-weight: bold; }
        /* TOTALS */
        .totals {
            clear: both;
            float: right;
            width: 45%;
            margin-bottom: 20px;
        }
        .total-line {
            display: block;
            padding: 8px 12px;
            font-size: 13px;
        }
        .label {
            float: left;
            width: 60%;
        }
        .value {
            float: right;
            width: 35%;
            text-align: right;
        }
        .total-row {
            font-weight: bold;
            font-size: 14px;
            color: #000;
            border: none;
        }
        /* TERMS */
        .terms {
            clear: both;
            background: #f9fafb;
            border: 1px solid #d0d0d0;
            padding: 12px;
            margin-bottom: 20px;
        }
        .terms h4 {
            font-size: 12px;
            font-weight: bold;
            color: #0f3c75;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .terms p {
            font-size: 11px;
            margin-bottom: 4px;
        }
        .terms ul {
            margin-left: 15px;
            font-size: 11px;
        }
        .terms li {
            margin-bottom: 2px;
        }
        /* FOOTER */
        .footer {
            clear: both;
            border-top: 2px solid #0f3c75;
            padding-top: 12px;
            font-size: 11px;
            text-align: center;
        }
        .footer-item {
            display: inline-block;
            width: 30%;
            margin: 0 2%;
        }
        .footer-label {
            font-weight: bold;
            color: #0f3c75;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="clearfix">
        <div class="header-left">
            <strong>KM AUTOMOBILE</strong>
            Kampala, Uganda<br>
            Phone: +256 790555545<br>
            Email: info@km-automobile.com
        </div>
        <div class="header-right">
            <div class="logo-box">
                <img src="{{ 'file://' . public_path('logo.png') }}" alt="KM Logo" />
            </div>
        </div>
    </div>
    <div class="divider"></div>

    <!-- TITLE -->
    <div class="title">INVOICE</div>
    
    <div class="meta">
        <div class="meta-line"><strong>Invoice #:</strong> {{ $invoice->invoice_number }}</div>
        <div class="meta-line"><strong>Date:</strong> {{ $invoice->created_at->format('m/d/Y') }}</div>
        <div class="meta-line"><strong>Status:</strong> {{ $invoice->status }}</div>
    </div>

    <!-- FROM/TO -->
    <div style="clear: both; margin: 20px 0;">
        <div class="from-box">
            <div class="box-title">From</div>
            <div class="box-content">
                <strong>Km-Automobile Garage</strong><br>
                Kampala, Uganda<br>
                Phone: +256 790555545<br>
                Email: info@km-automobile.com
            </div>
        </div>
        <div class="to-box">
            <div class="box-title">Bill To</div>
            <div class="box-content">
                <strong>{{ $invoice->job->client->name }}</strong><br>
                Phone: {{ $invoice->job->client->phone }}<br>
                Vehicle: <strong>{{ $invoice->job->vehicle->car_model }}</strong><br>
                Plate: {{ $invoice->job->vehicle->number_plate }}
            </div>
        </div>
    </div>

    <!-- ITEMS TABLE -->
    <div class="items-header">Items / Services</div>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">QTY</th>
                <th style="width: 50%;">Description</th>
                <th style="width: 20%; text-align: right;">Unit Price</th>
                <th style="width: 20%; text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td class="qty">{{ $item->quantity }}</td>
                <td>{{ $item->item_name }}</td>
                <td class="price">{{ number_format($item->unit_price, 2) }}</td>
                <td class="amount">{{ number_format($item->total_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALS -->
    @php
        $subtotal = $invoice->total_amount;
        $total = $subtotal;
    @endphp
    <div class="totals">
        <span class="total-line"><span class="label">Subtotal:</span><span class="value">{{ number_format($subtotal, 2) }}</span></span>
        <span class="total-line total-row"><span class="label">Total Due:</span><span class="value">{{ number_format($total, 2) }}</span></span>
    </div>

    <!-- TERMS -->
    <div class="terms">
        <h4>Terms and Conditions</h4>
        <p>Payment is due within 14 days of project completion.</p>
        <ul>
            <li>All checks to be made out to KM Automobile</li>
            <li>Please include invoice number in payment reference</li>
            <li>Thank you for your business!</li>
        </ul>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="footer-item">
            <div class="footer-label">Phone</div>
            +256 790555545
        </div>
        <div class="footer-item">
            <div class="footer-label">Email</div>
            info@km-automobile.com
        </div>
        <div class="footer-item">
            <div class="footer-label">Website</div>
            www.km-automobile.com
        </div>
    </div>
</body>
</html>
