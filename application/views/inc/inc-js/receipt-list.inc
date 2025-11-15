<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/select2/dist/css/select2.min.css">
<script src="<?php echo base_url() ?>asset/bower_components/select2/dist/js/select2.full.min.js"></script>
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #0080FF;
    border: 1px solid #000;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: #000;
    cursor: pointer;
    display: inline-block;
    font-weight: bold;
    margin-right: 2px;
}
</style>

<script>
jQuery(function($) { 
    
    // Show/Hide Cheque DD fields based on payment mode
    function toggleChequeFields(modal) {
        var paymentMode = $(modal + ' #payment_mode').val();
        if(paymentMode === 'Cheque' || paymentMode === 'DD') {
            $(modal + ' #cheque_dd_row').show();
            $(modal + ' #cheq_dd_no').attr('required', true);
            $(modal + ' #cheq_dd_date').attr('required', true);
        } else {
            $(modal + ' #cheque_dd_row').hide();
            $(modal + ' #cheq_dd_no').removeAttr('required');
            $(modal + ' #cheq_dd_date').removeAttr('required');
        }
    }

    // Add Modal - Payment Mode Change
    $('#add_modal #payment_mode').change(function() {
        toggleChequeFields('#add_modal');
    });

    // Edit Modal - Payment Mode Change
    $('#edit_modal #payment_mode').change(function() {
        toggleChequeFields('#edit_modal');
    });

    // Set today's date as default for receipt date
    var today = new Date().toISOString().split('T')[0];
    $('#add_modal #receipt_date').val(today);

    // Edit Receipt
    $(".edit_record").click(function() {
        var receipt_id = $(this).val();
        $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl: 'get-receipt', id: receipt_id },
            success: function(d) {
                
                $('#edit_modal #receipt_id').val(d.receipt_id);
                $('#edit_modal #receipt_date').val(d.receipt_date);
                $('#edit_modal #receipt_no').val(d.receipt_no);
                $('#edit_modal #receipt_from').val(d.receipt_from);
                $('#edit_modal #receipt_to').val(d.receipt_to);
                $('#edit_modal #branch').val(d.branch);
                $('#edit_modal #payment_amt').val(d.payment_amt);
                $('#edit_modal #cheq_dd_no').val(d.cheq_dd_no);
                $('#edit_modal #cheq_dd_date').val(d.cheq_dd_date);
                $('#edit_modal #payment_desc').val(d.payment_desc);
                
                // Set payment type radio
                $('#edit_modal input:radio[name="payment_type"][value="' + d.payment_type + '"]').prop('checked', true);
                
                // Set payment mode dropdown
                $('#edit_modal #payment_mode').val(d.payment_mode).trigger('change');
                
                // Show/hide cheque fields
                toggleChequeFields('#edit_modal');
            }
        });
    });




      $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'receipt_info', id: $(this).val()},
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  





});
</script>