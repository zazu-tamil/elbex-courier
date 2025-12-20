<link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/select2/dist/css/select2.min.css">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<script src="<?php echo base_url() ?>asset/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

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
.ui-autocomplete {
    max-height: 200px;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 1051;
}
.ui-menu-item {
    padding: 5px 10px;
}
</style>

<script>
jQuery(function($) { 
    
    // Autocomplete data sources
    var receiptFromTags = [];
    var receiptToTags = [];
    var branchTags = [];
    
    // Fetch autocomplete data from server
    function fetchAutocompleteData() {
        $.ajax({
            url: "<?php echo site_url('get-autocomplete-data');?>",
            type: "post",
            dataType: "json",
            success: function(d) {
                receiptFromTags = d.receipt_from || [];
                receiptToTags = d.receipt_to || [];
                branchTags = d.branch || [];
            }
        });
    }
    
    // Initialize autocomplete on document ready
    fetchAutocompleteData();
    
    // Autocomplete for Receipt From (Add Modal)
    $("#add_modal #receipt_from").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(receiptFromTags, function(item) {
                return matcher.test(item);
            }).slice(0, 10));
        },
        minLength: 1
    });
    
    // Autocomplete for Receipt To (Add Modal)
    $("#add_modal #receipt_to").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(receiptToTags, function(item) {
                return matcher.test(item);
            }).slice(0, 10));
        },
        minLength: 1
    });
    
    // Autocomplete for Branch (Add Modal)
    $("#add_modal #branch").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(branchTags, function(item) {
                return matcher.test(item);
            }).slice(0, 10));
        },
        minLength: 1
    });
    
    // Autocomplete for Receipt From (Edit Modal)
    $("#edit_modal #receipt_from").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(receiptFromTags, function(item) {
                return matcher.test(item);
            }).slice(0, 10));
        },
        minLength: 1
    });
    
    // Autocomplete for Receipt To (Edit Modal)
    $("#edit_modal #receipt_to").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(receiptToTags, function(item) {
                return matcher.test(item);
            }).slice(0, 10));
        },
        minLength: 1
    });
    
    // Autocomplete for Branch (Edit Modal)
    $("#edit_modal #branch").autocomplete({
        source: function(request, response) {
            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(request.term), "i");
            response($.grep(branchTags, function(item) {
                return matcher.test(item);
            }).slice(0, 10));
        },
        minLength: 1
    });
    
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
    $(".edit_record").click(function(e) {
        e.preventDefault(); // Prevent default behavior to avoid conflicts
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
                
                // Open the modal after populating data
                $('#edit_modal').modal('show');
            }
        });
    });

    // Delete Record
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