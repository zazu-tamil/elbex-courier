<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .toolbar {
        max-width: 900px;
        margin: 0 auto 20px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    
    .btn {
        padding: 10px 20px;
        font-size: 14px;
        font-weight: bold;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-print {
        background-color: #4CAF50;
        color: white;
    }
    
    .btn-print:hover {
        background-color: #45a049;
    }
    
    .btn-download {
        background-color: #2196F3;
        color: white;
    }
    
    .btn-download:hover {
        background-color: #0b7dda;
    }
    
    .receipt-container {
        max-width: 900px;
        margin: 0 auto 40px;
        background-color: white;
        border: 5px solid #666;
        padding: 40px 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 40px;
        padding-bottom: 20px;
    }
    
    .logo-section {
        display: flex;
       justify-content: center;
       align-items: center;
        gap: 20px;
    }
    
    .logo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .logo img {
       
        object-fit: contain;
    }
    
    .company-info {
        flex: 1;
      align-items: center;
        justify-content: center;
    }
    
    .company-info h1 {
        font-size: 16px;
        font-weight: bold;
        color: #000;
        margin-bottom: 3px;
    }
    
    .company-info p {
        font-size: 11px;
        color: #000;
        line-height: 1.3;
        margin: 1px 0;
    }
    
    .receipt-header {
        text-align: center;
    }
    
    .receipt-label {
        font-size: 16px;
        font-weight: bold;
        color: #000;
    }
    
    .receipt-copy {
        font-size: 10px;
        color: #000;
        margin-top: 3px;
    }
    
    .receipt-no-row {
        margin-top: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }
    
    .receipt-no-label {
        font-size: 11px;
        color: #000;
    }
    
    .receipt-no {
        font-size: 24px;
        font-weight: bold;
        border-bottom: 2px solid #000;
        padding: 2px 12px;
        min-width: 80px;
        text-align: center;
        font-family: Arial, sans-serif;
    }
    
    .branch-row {
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        align-items: center;
    }
    
    .branch-label {
        font-size: 12px;
        color: #000;
        white-space: nowrap;
    }
    
    .branch-value {
        flex: 1;
        border-bottom: 1px solid #000;
        padding: 3px 5px;
        font-size: 12px;
        font-family: Arial, sans-serif;
    }
    
    .company-row {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .company-label {
        font-size: 12px;
        color: #000;
        white-space: nowrap;
    }
    
    .company-value {
        flex: 1;
        border-bottom: 1px solid #000;
        padding: 3px 5px;
        font-size: 12px;
        font-family: Arial, sans-serif;
    }
    
    .payment-row {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
        font-size: 12px;
        flex-wrap: wrap;
    }
    
    .payment-part {
        display: flex;
        gap: 5px;
        align-items: center;
    }
    
    .payment-label {
        font-size: 12px;
        color: #000;
        white-space: nowrap;
    }
    
    .payment-value {
        border-bottom: 1px solid #000;
        padding: 3px 5px;
        font-size: 12px;
        font-family: Arial, sans-serif;
    }
    
    .payment-value.short {
        min-width: 120px;
    }
    
    .payment-value.medium {
        min-width: 100px;
    }
    
    .payment-value.long {
     
        min-width: 150px;
    }
    
    .separator-line {
        width: 100%;
        border: none;
        border-bottom: 1px solid #000;
        margin: 20px 0;
    }
    
    .rupees-row {
        margin-bottom: 20px;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .rupees-label {
        font-size: 12px;
        color: #000;
        white-space: nowrap;
    }
    
    .rupees-value {
        flex: 1;
        border-bottom: 1px solid #000;
        padding: 3px 5px;
        font-size: 12px;
        font-family: Arial, sans-serif;
    }
    
    .purpose-row {
        margin-bottom: 40px;
        display: flex;
        gap: 10px;
        align-items: center;
        font-size: 12px;
    }
    
    .purpose-text {
        color: #000;
    }
    
    .footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 80px;
        margin-bottom: 70px;
        padding-top: 15px;
    }
    
    .amount-section {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .amount-label {
        font-size: 12px;
        color: #000;
    }
    
    .amount-value {
        min-width: 180px;
        border-bottom: 1px solid #000;
        padding: 3px 5px;
        font-size: 12px;
        text-align: center;
        font-family: Arial, sans-serif;
    }
    
    .signature-section {
        text-align: right;
    }
    
    .signature-text {
        font-size: 11px;
        color: #000;
    }
    
    .signature-line {
        width: 140px;
        margin-left: auto;
    }
    
    .bottom-note {
        font-size: 11px;
        color: #000;
        margin-top: 20px;
        padding-top: 8px;
    }
    
    @media print {
        body {
            background-color: white;
            padding: 0;
        }
        
        .toolbar {
            display: none;
        }
        
        .receipt-container {
            box-shadow: none;
            margin: 0;
            border: 1px solid #333;
            page-break-after: always;
        }
    }
</style>
<script>
function downloadPDF() {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js';
    script.onload = function() {
        const receipts = document.querySelectorAll('.receipt-container');
        receipts.forEach((element, index) => {
            const opt = {
                margin: 5,
                filename: 'ELBEX_Receipt_' + (index + 1) + '_' + new Date().getTime() + '.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        });
    };
    document.head.appendChild(script);
}
</script>