<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Product Details - {{ $product->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #2d3748;
            background: #ffffff;
            line-height: 1.4;
        }

        /* Modern Header */
        .header {
            background: #667eea;
            padding: 0;
            position: relative;
        }

        .header-content {
            padding: 20px 40px;
        }

        .header-top {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .company-info {
            display: table-cell;
            vertical-align: middle;
        }

        .company-info h1 {
            color: white;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 3px;
            letter-spacing: 0.5px;
        }

        .company-info p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 11px;
            font-weight: 300;
        }

        .header-badge {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .badge-inner {
            display: inline-block;
            background: rgba(255, 255, 255, 0.25);
            padding: 6px 14px;
            border-radius: 20px;
            color: white;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .header-title {
            background: rgba(255, 255, 255, 0.15);
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-title h2 {
            color: white;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .header-title p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 11px;
            font-weight: 300;
        }

        /* Main Container */
        .container {
            padding: 25px 40px;
            max-width: 100%;
        }

        /* Product Card */
        .product-card {
            background: #f7fafc;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            border: 2px solid #e2e8f0;
        }

        .product-id {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 14px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 20px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        /* Two Column Layout */
        .details-grid {
            display: table;
            width: 100%;
            margin-top: 12px;
        }

        .detail-row {
            display: table-row;
        }

        .detail-label {
            display: table-cell;
            font-weight: 700;
            color: #667eea;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 8px 15px 8px 0;
            width: 30%;
            vertical-align: top;
        }

        .detail-value {
            display: table-cell;
            font-size: 13px;
            color: #2d3748;
            padding: 8px 0;
            line-height: 1.4;
        }

        /* Description Box */
        .description-box {
            background: #ffffff;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            margin: 15px 0;
            border: 1px solid #e2e8f0;
        }

        .description-box .label {
            font-weight: 700;
            color: #667eea;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
            display: block;
        }

        .description-box .text {
            font-size: 12px;
            color: #4a5568;
            line-height: 1.5;
        }

        /* Price and Stock Section */
        .metrics-container {
            display: table;
            width: 100%;
            margin: 15px 0;
            border-spacing: 10px 0;
        }

        .metric-box {
            display: table-cell;
            width: 48%;
            padding: 18px;
            border-radius: 10px;
            text-align: center;
        }

        .metric-box.price {
            background: #10b981;
            color: white;
        }

        .metric-box.stock {
            background: #3b82f6;
            color: white;
        }

        .metric-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            opacity: 0.9;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .metric-value {
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
        }

        .metric-subtext {
            font-size: 11px;
            margin-top: 5px;
            opacity: 0.85;
        }

        /* Report Info Section */
        .report-info {
            background: #fef3c7;
            border-radius: 10px;
            padding: 18px;
            margin: 15px 0 20px 0;
            border: 2px solid #fbbf24;
        }

        .report-info h3 {
            color: #92400e;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-item {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            color: #78350f;
            font-weight: 600;
            font-size: 11px;
            padding: 5px 15px 5px 0;
            width: 35%;
        }

        .info-value {
            display: table-cell;
            color: #451a03;
            font-size: 11px;
            padding: 5px 0;
        }

        /* Footer */
        .footer {
            background: #1f2937;
            padding: 18px 40px;
            margin-top: 20px;
            color: white;
            text-align: center;
        }

        .footer-divider {
            width: 50px;
            height: 2px;
            background: #667eea;
            margin: 0 auto 12px;
            border-radius: 2px;
        }

        .footer-content p {
            margin: 5px 0;
            font-size: 9px;
            line-height: 1.6;
            color: #9ca3af;
        }

        .footer-content .copyright {
            color: white;
            font-weight: 600;
            font-size: 10px;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-links span {
            color: #667eea;
            font-weight: 500;
            font-size: 9px;
        }

        /* Page Break Prevention */
        @page {
            margin: 0;
            size: A4;
        }

        .container, .product-card, .description-box, .metrics-container, .report-info {
            page-break-inside: avoid;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 11px;
        }

        .status-badge.in-stock {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.out-of-stock {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <!-- Modern Header -->
    <div class="header">
        <div class="header-content">
            <div class="header-top">
                <div class="company-info">
                    <h1>{{ config('app.name', 'Laravel') }}</h1>
                    <p>Product Management System</p>
                </div>
                <div class="header-badge">
                    <span class="badge-inner">Official Document</span>
                </div>
            </div>
            <div class="header-title">
                <h2>Product Details Report</h2>
                <p>Comprehensive product information and specifications</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Product Card -->
        <div class="product-card">
            <div class="product-id">Product ID: #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</div>
            <h1 class="product-name">{{ $product->name }}</h1>
            
            <div class="details-grid">
                <div class="detail-row">
                    <div class="detail-label">Category</div>
                    <div class="detail-value">General Product</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value">
                        @if($product->stock > 0)
                            <span class="status-badge in-stock">In Stock</span>
                        @else
                            <span class="status-badge out-of-stock">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="description-box">
            <span class="label">Product Description</span>
            <div class="text">
                {{ $product->description ?? 'No description available for this product.' }}
            </div>
        </div>

        <!-- Price and Stock Metrics -->
        <div class="metrics-container">
            <div class="metric-box price">
                <div class="metric-label">Product Price</div>
                <div class="metric-value">${{ number_format($product->price, 2) }}</div>
                <div class="metric-subtext">USD</div>
            </div>
            <div class="metric-box stock">
                <div class="metric-label">Stock Available</div>
                <div class="metric-value">{{ number_format($product->stock) }}</div>
                <div class="metric-subtext">Units</div>
            </div>
        </div>

        <!-- Report Information -->
        <div class="report-info">
            <h3>📋 Report Generation Details</h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Generated On:</div>
                    <div class="info-value">{{ now()->format('F d, Y at h:i A') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Generated By:</div>
                    <div class="info-value">{{ auth()->user()->name }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">User Email:</div>
                    <div class="info-value">{{ auth()->user()->email }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">User Role:</div>
                    <div class="info-value">{{ auth()->user()->roles->pluck('name')->first() ?? 'No Role Assigned' }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Document Type:</div>
                    <div class="info-value">Product Details Report (PDF)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="footer-divider"></div>
        <div class="footer-content">
            <p class="copyright">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.</p>
            <p>This is a computer-generated document and does not require a physical signature.</p>
            <p>Confidential and proprietary information. Unauthorized distribution is prohibited.</p>
            <div class="footer-links">
                <span>For support and inquiries, please contact our team</span>
            </div>
        </div>
    </div>
</body>

</html>