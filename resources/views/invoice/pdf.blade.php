<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header, .footer {
            color: #333;
            text-align: center;
        }

        .header {
            position: fixed;
            top: 0;
            width: 100%;
            height: 180px;
            padding: 20px 10px;
            box-sizing: border-box;
            background-color: #fff;
        }

        .header img {
            max-height: 120px;
            display: block;
            margin: 0 auto 10px auto;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 14px;
            background-color: #f1f1f1;
            padding: 10px 0;
        }

        .content-wrapper {
            margin-top: 200px; /* increased margin to compensate for fixed header */
            margin-bottom: 80px;
        }

        .invoice-details, .product-details {
            font-size: 16px;
            line-height: 1.6;
            margin-top: 20px;
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="https://advikagreencrestresort.in/static/media/logo.94b127f44b2a1115b21c.jpeg" alt="Company Logo">
        <div class="header-content">
            <h2>Woodsee Pvt. Ltd.</h2>
            <p>123 Business Road, Mumbai, India | support@woodsee.in</p>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="content">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>

           <div class="invoice-details">
    <p><strong>User ID:</strong> {{ $invoice->user_id }}</p>
    <p><strong>Total Amount:</strong> ₹{{ $invoice->total_amount }}</p>
    <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
</div>

            <div class="product-details">
                <h2>Product Details</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price (₹)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <tr>
                            <td>product->name </td>
                            <td>product->quantity </td>
                            <td>₹product->price </td>
                            <td>₹product->quantity * $product->price </td>
                        </tr>
                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>&copy; {{ date('Y') }} Woodsee Pvt. Ltd. All rights reserved.</p>
    </div>

</body>
</html>
