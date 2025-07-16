<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            width: 100%;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-header img {
            width: 180px;
        }
        .invoice-header .details {
            text-align: right;
            font-size: 12px;
            color: #555;
        }
        .invoice-header .details p {
            margin: 2px 0;
        }
        h1 {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
            font-weight: normal;
            margin: 20px 0;
            font-size: 36px;
            letter-spacing: 2px;
        }
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .address-section .from-address, .address-section .to-address {
            width: 45%;
        }
        .from-address p, .to-address p {
            margin: 2px 0;
            font-size: 14px;
            color: #555;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th, .invoice-table td {
            padding: 8px;
            text-align: left;
            font-size: 14px;
            border: 1px solid #ddd;
        }
        .invoice-table th {
            background-color: #f5eadc;
            font-weight: bold;
        }
        .invoice-summary {
            margin-top: 20px;
            float: right;
            width: 300px;
            text-align: right;
        }
        .invoice-summary p {
            margin: 5px 0;
            font-size: 14px;
        }
        .invoice-summary .total, .invoice-summary .grand-total {
            font-weight: bold;
        }
        .total-in-words {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
            width: 100%;
            float: center;
            font-weight: bold;
        }
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .signature .sig-block {
            text-align: center;
            font-size: 14px;
        }
        .signature .sig-block .line {
            width: 200px;
            border-top: 1px solid #333;
            margin: 10px 0;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #555;
        }
        .footer p {
            margin: 5px 0;
        }
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
                background-color: #fff;
            }
            .invoice-box, .invoice-box * {
                visibility: visible;
            }
            .invoice-box {
                position: absolute;
                left: 0;
                top: 0;
                width: 95%;
                margin: 0;
                box-shadow: none;
                background-color: #fff;
            }
            /* Hide the print button on print */
            #printInvoice {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="invoice-header">
        <img src="https://fashionistaahaven.com/front/assets/images/fashionistha.png" alt="Fashionistaa Logo">
        <div class="details">
            <p>Date: 18/08/2024</p>
            <p>Invoice# 003</p>
            <p>Payment Status: Paid</p>
        </div>
    </div>

    <h1>INVOICE</h1>

    <div class="address-section">
        <div class="from-address">
            <p><strong>From:</strong></p>
            <p><strong>Fashionistaa Clothing Store</strong></p>
            <p>Rupayan Z.R Plaza 9th floor</p>
            <p>Contact Number: +8801709925778</p>
            <p>Email: fashionistaahaven@gmail.com</p>
        </div>
        <div class="to-address" style="text-align: right;">
            <p><strong>To:</strong> Abu Arif</p>
            <p><strong>Address:</strong> Rupayan Z.R Plaza 9th floor</p>
            <p><strong>Contact Number:</strong> +8801709925700</p>
            <p><strong>Email:</strong> mediqmedi@gmail.com</p>
            <p><strong>Payment Method:</strong> Cash on delivery</p>
        </div>
    </div>

    <table class="invoice-table">
        <tr>
            <th>DESCRIPTION</th>
            <th>PRICE</th>
            <th>SIZE</th>
            <th>QTY.</th>
            <th>AMOUNT</th>
        </tr>
        <tr>
            <td>1. Round Neck Premium Quality T Shirt</td>
            <td>&#2547; 350</td>
            <td>XL</td>
            <td>1</td>
            <td>&#2547; 350</td>
        </tr>
        <tr>
            <td>2. Round Neck Premium Quality T Shirt</td>
            <td>&#2547; 350</td>
            <td>M</td>
            <td>1</td>
            <td>&#2547; 350</td>
        </tr>
        <tr>
            <td>3. Round Neck Premium Quality T Shirt</td>
            <td>&#2547; 350</td>
            <td>S</td>
            <td>1</td>
            <td>&#2547; 350</td>
        </tr>
        <tr>
            <td>4. Round Neck Premium Quality T Shirt</td>
            <td>&#2547; 350</td>
            <td>L</td>
            <td>1</td>
            <td>&#2547; 350</td>
        </tr>
        <tr>
            <td>5. Round Neck Premium Quality T Shirt</td>
            <td>&#2547; 200</td>
            <td>M</td>
            <td>1</td>
            <td>&#2547; 200</td>
        </tr>
    </table>

    <div class="invoice-summary">
        <p><strong>Total:</strong> &#2547; 1,600</p>
        <p>Discount: &#2547; 0</p>
        <p>Shipping cost: &#2547; 0</p>
        <p class="grand-total"><strong>Grand Total:</strong> &#2547; 1,600</p>
    </div>


    <div class="signature">
        <div class="sig-block">
            <p>SIGNATURE OF CEO</p>
            <div class="line"></div>
            <p>Ayman Rahman</p>
        </div>
        <div class="sig-block"></div>
    </div>

    <div class="total-in-words" id="totalInWords"></div>

    <!-- Footer Section -->
    <div class="footer">
        <p><strong>Terms and Conditions:</strong> Payment is due within 15 days. Please make checks payable to Fashionistaa Clothing Store.</p>
        <p><strong>Return & Refund Policy:</strong> Returns are accepted within 30 days of purchase. Items must be in original condition with tags attached. Refunds will be issued to the original payment method within 7-10 business days of receiving the returned item.</p>
        <p>If you have any questions, feel free to contact us at <strong>+8801709925778</strong> or <strong>fashionistaahaven@gmail.com</strong>.</p>
    </div>
</div>
<button id="printInvoice" onclick="window.print()">Print Invoice</button>

<!-- Script to convert number to words and update total-in-words div -->
<script>
    function numberToWords(num) {
        const a = [
            "", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven",
            "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen" ];
        const b = [ "", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety" ];

        const convert = (n) => {
            if (n < 20) return a[n];
            const digit = n % 10;
            if (n < 100) return b[Math.floor(n / 10)] + (digit ? " " + a[digit] : "");
            if (n < 1000) return a[Math.floor(n / 100)] + " Hundred" + (n % 100 == 0 ? "" : " " + convert(n % 100));
            return convert(Math.floor(n / 1000)) + " Thousand" + (n % 1000 !== 0 ? " " + convert(n % 1000) : "");
        };

        return convert(num);
    }

    // Fetch the grand total value from the DOM
    const grandTotalText = document.querySelector('.grand-total').textContent;
    const grandTotalAmount = parseInt(grandTotalText.replace(/[^0-9]/g, ''), 10); // Extract the number part
    const grandTotalInWords = numberToWords(grandTotalAmount) + " Taka Only";

    document.getElementById("totalInWords").textContent = "Total (in words): " + grandTotalInWords;
</script>
</body>
</html>
