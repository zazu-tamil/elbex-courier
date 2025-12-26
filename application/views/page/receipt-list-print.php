<?php include_once(VIEWPATH . '/inc/header.php'); ?>



<div class="toolbar">
    <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
    <button class="btn btn-download" onclick="downloadPDF()">⬇️ Download PDF</button>
        &nbsp;&nbsp;
        &nbsp;&nbsp;
    <a href="<?php echo site_url('receipt-list'); ?>" class="btn btn-back">🔙 Back to Receipt List</a>
</div>

<?php 
if(isset($receipt_list) && !empty($receipt_list)) {
    foreach($receipt_list as $receipt) {
        // Convert amount to words
        $amount = floatval($receipt['payment_amt']);
        $amount_words = convertNumberToWords($amount);
        
        // Check if payment type is "Received" or "Paid"
        $isReceived = (strtolower(trim($receipt['payment_type'])) == 'received');
?>



    <?php if($isReceived): ?>

        <div class="receipt-container" id="receiptContent_<?php echo $receipt['receipt_id']; ?>">
    <div class="header">
        <div class="logo-section">
            <div class="logo">
                <img src="<?php echo base_url('asset/images/logo1.png'); ?>" alt="ELBEX Logo">
            </div>
            <div class="company-info">
                <h1>ELBEX Couriers Pvt. Ltd.</h1>
                <p>258, Avarampalayam Road, New Siddapudur,</p>
                <p>Coimbatore - 641 044, Tamil Nadu, INDIA.</p>
                <p>MOB : 95 666 0 99 11, Tel : 0422 - 4388573.</p>
                <p>Web : www.elbex.in</p>
            </div>
        </div>
        <div class="receipt-header">
            <div class="receipt-label">RECEIPT</div>
            <div class="receipt-copy">CLIENT COPY</div>
            <div class="receipt-no-row">
                <div class="receipt-no-label">Receipt No. :</div>
                <div class="receipt-no"><?php echo str_pad($receipt['receipt_no'], 4, '0', STR_PAD_LEFT); ?></div>
            </div>
        </div>
    </div>
    
    <div class="branch-row">
        <div class="branch-label">Branch :</div>
        <div class="branch-value"><?php echo htmlspecialchars($receipt['branch']); ?></div>
        <div class="branch-label" style="margin-left: 20px;">Date :</div>
        <div class="branch-value" style="max-width: 150px;"><?php echo $receipt['receipt_date'] ? date('d-m-Y', strtotime($receipt['receipt_date'])) : ''; ?></div>
    </div>
        
        <!-- RECEIVED FORMAT -->
        <div class="company-row">
            <div class="company-label">RECEIVED with thanks from M/s.</div>
            <div class="company-value"><?php echo htmlspecialchars($receipt['receipt_from']); ?></div>
        </div>
        <?php if($receipt['payment_mode'] == 'Cheque' or $receipt['payment_mode'] == 'DD'): ?>
        <div class="payment-row">
            <div class="payment-part">
                <span class="payment-label">by <?php echo htmlspecialchars($receipt['payment_mode']); ?> No. :</span>
                <span class="payment-value short"><?php echo htmlspecialchars($receipt['cheq_dd_no']); ?></span>
            </div>
            <div class="payment-part">
                <span class="payment-label">Dated :</span>
                <span class="payment-value medium"><?php echo $receipt['cheq_dd_date'] ? date('d-m-Y', strtotime($receipt['cheq_dd_date'])) : ''; ?></span>
            </div>
            <div class="payment-part">
                <span class="payment-label">Drawn on</span>
                <span class="payment-value long"><?php echo htmlspecialchars($receipt['receipt_to']); ?></span>
                
            </div>
        </div>
        <div class="rupees-row">
            <div class="rupees-label">the sum of Rupees</div>
            <div class="rupees-value"><?php echo $amount_words; ?></div>
        </div>
        <div class="separator-line">towards <?php echo htmlspecialchars($receipt['payment_desc']); ?></div> 
        <?php else: ?>
            
        <div class="company-row">
            <div class="company-label">by <?php echo htmlspecialchars($receipt['payment_mode']); ?>,</div>
            <div class="company-label">the sum of Rupees</div>
            <div class="company-value"><?php echo $amount_words; ?></div>
        </div>
        <div class="company-row">
             <div class="company-label">towards </div>
              <div class="company-value"><?php echo htmlspecialchars($receipt['payment_desc']); ?></div> 
              <div class="company-label">for </div>
              <div class="company-value"><?php echo htmlspecialchars($receipt['receipt_to']); ?></div> 
        </div> 
         
         
        <?php endif; ?>
        
        
        <div class="purpose-row">
            <div class="purpose-text">as in full / part payment of appointment towards Unit Franchisee.</div>
        </div>
        
        <div class="footer">
            <div class="amount-section">
                <span class="amount-label">Rs.</span>
                <span class="amount-value"><?php echo number_format($receipt['payment_amt'], 2); ?>/-</span> 
            </div>
            <div class="signature-section">
                <div class="signature-text">For ELBEX Couriers Pvt. Ltd.</div>
                <div class="signature-line"></div>
            </div>
        </div>
        
        <div class="bottom-note">
            *Subject to Realisation of Cheques
        </div>
        
    <?php else: ?>

        <div class="receipt-container" id="receiptContent_<?php echo $receipt['receipt_id']; ?>">
    <div class="header">
        <div class="logo-section">
            <div class="logo">
                <img src="<?php echo base_url('asset/images/logo1.png'); ?>" alt="ELBEX Logo">
            </div>
            <div class="company-info">
                <h1>ELBEX Couriers Pvt. Ltd.</h1>
                <p>258, Avarampalayam Road, New Siddapudur,</p>
                <p>Coimbatore - 641 044, Tamil Nadu, INDIA.</p>
                <p>MOB : 95 666 0 99 11, Tel : 0422 - 4388573.</p>
                <p>Web : www.elbex.in</p>
            </div>
        </div>
        <div class="receipt-header">
            <div class="receipt-label">Voucher</div>
            <div class="receipt-copy">CLIENT COPY</div>
            <div class="receipt-no-row">
                <div class="receipt-no-label">Voucher No. :</div>
                <div class="receipt-no"><?php echo str_pad($receipt['receipt_no'], 4, '0', STR_PAD_LEFT); ?></div>
            </div>
        </div>
    </div>
    
    <div class="branch-row">
        <div class="branch-label">Branch :</div>
        <div class="branch-value"><?php echo htmlspecialchars($receipt['branch']); ?></div>
        <div class="branch-label" style="margin-left: 20px;">Date :</div>
        <div class="branch-value" style="max-width: 150px;"><?php echo $receipt['receipt_date'] ? date('d-m-Y', strtotime($receipt['receipt_date'])) : ''; ?></div>
    </div>
        <!-- PAID FORMAT -->
        <div class="company-row">
            <div class="company-label">Paid to</div>
            <div class="company-value"><?php echo htmlspecialchars($receipt['receipt_from']); ?></div>
        </div>
        
        <div class="rupees-row">
            <div class="rupees-label">the sum of Rupees</div>
            <div class="rupees-value"><?php echo $amount_words; ?></div>
        </div>

        <div class="payment-row">
            <div class="payment-part">
                <span class="payment-label">towards</span>
                <span class="payment-value long"><?php echo htmlspecialchars($receipt['payment_desc']); ?></span>
            </div>
        </div>

        <div class="company-row">
            <div class="company-label">Method Of Payment</div>
            <div class="company-value"><?php echo htmlspecialchars($receipt['payment_mode']); ?></div>
        </div>

        <?php if(!empty($receipt['cheq_dd_no'])): ?>
        <div class="payment-row">
            <div class="payment-part">
                <span class="payment-label"><?php echo htmlspecialchars($receipt['payment_mode']); ?> No. :</span>
                <span class="payment-value short"><?php echo htmlspecialchars($receipt['cheq_dd_no']); ?></span>
            </div>
            <div class="payment-part">
                <span class="payment-label">Dated :</span>
                <span class="payment-value medium"><?php echo $receipt['cheq_dd_date'] ? date('d-m-Y', strtotime($receipt['cheq_dd_date'])) : ''; ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="amount-section" style="margin: 20px 0;">
            <span class="amount-label">Rs.</span>
            <span class="amount-value"><?php echo number_format($receipt['payment_amt'], 2); ?></span>
            <span class="amount-label">/-</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 60px;">
            <div class="bottom-note" style="text-align: center; flex: 1;">
                Prepared by<br>
                <div style=" margin-top: 40px; padding-top: 5px;"></div>
            </div>
            <div class="bottom-note" style="text-align: center; flex: 1;">
                Authorized By<br>
                <div style=" margin-top: 40px; padding-top: 5px;"></div>
            </div>
            <div class="bottom-note" style="text-align: center; flex: 1;">
                Received By<br>
                <div style=" margin-top: 40px; padding-top: 5px;"></div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php 
    }
} else {
    echo "<h3 style='color:red;'>No receipts found.</h3>";
}
?>



<?php include_once(VIEWPATH . '/inc/footer.php'); ?>

<?php
// Helper function to convert number to words
function convertNumberToWords($number) {
    $ones = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
    $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
    $tens = array('', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');
    
    $number = number_format($number, 2, '.', '');
    $parts = explode('.', $number);
    $rupees = intval($parts[0]);
    $paise = intval($parts[1]);
    
    if ($rupees == 0) {
        $words = 'Zero Rupees';
    } else {
        $words = convertToWords($rupees, $ones, $teens, $tens) . ' Rupees';
    }
    
    if ($paise > 0) {
        $words .= ' and ' . convertToWords($paise, $ones, $teens, $tens) . ' Paise';
    }
    
    return $words . ' Only';
}

function convertToWords($num, $ones, $teens, $tens) {
    if ($num == 0) return '';
    if ($num < 10) return $ones[$num];
    if ($num < 20) return $teens[$num - 10];
    if ($num < 100) return $tens[intval($num / 10)] . ($num % 10 != 0 ? ' ' . $ones[$num % 10] : '');
    if ($num < 1000) return $ones[intval($num / 100)] . ' Hundred' . ($num % 100 != 0 ? ' ' . convertToWords($num % 100, $ones, $teens, $tens) : '');
    if ($num < 100000) return convertToWords(intval($num / 1000), $ones, $teens, $tens) . ' Thousand' . ($num % 1000 != 0 ? ' ' . convertToWords($num % 1000, $ones, $teens, $tens) : '');
    if ($num < 10000000) return convertToWords(intval($num / 100000), $ones, $teens, $tens) . ' Lakh' . ($num % 100000 != 0 ? ' ' . convertToWords($num % 100000, $ones, $teens, $tens) : '');
    return convertToWords(intval($num / 10000000), $ones, $teens, $tens) . ' Crore' . ($num % 10000000 != 0 ? ' ' . convertToWords($num % 10000000, $ones, $teens, $tens) : '');
}
?>