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
    
     $('#srch_franchise_id').select2();
     $('#to_franchise_id').select2();
    
     $(".edit_record").click(function() {   
                  
         $.ajax({
                   // url: "send-enquiry.php",
                    url: "<?php echo site_url('get-data');?>",
                    type: "post",
                    data: { tbl : 'franchises_ts_rate_info', id: $(this).val() },
                    success: function(d) {                                 
                        // alert(d.c_type);
                        $('#edit_modal #franchises_ts_rate_id').val(d.franchises_ts_rate_id) ;  
                        $('#edit_modal #franchise_id').val(d.franchise_id) ;  
                        $('#edit_modal #service_id').val(d.service_id) ;  
                        $('#edit_modal #c_type').val('Transhipment Weight') ;  
                        $('#edit_modal #from_weight').val(d.from_weight) ;  
                        $('#edit_modal #to_weight').val(d.to_weight) ;  
                        //$('#edit_modal input:radio[value="'+ d.c_type +'"]').prop('checked', true);
                        if(d.flg_region == '1')
                            $('#edit_modal #flg_region').prop('checked', true);
                        if(d.flg_state == '1')
                            $('#edit_modal #flg_state').prop('checked', true);
                        if(d.flg_city == '1')
                            $('#edit_modal #flg_city').prop('checked', true);
                        if(d.flg_metro == '1')
                            $('#edit_modal #flg_metro').prop('checked', true);
                        
                        $('#edit_modal #from_weight').val(d.from_weight) ; 
                        $('#edit_modal #to_weight').val(d.to_weight) ;  
                        $('#edit_modal #min_charges').val(d.min_charges) ;  
                        $('#edit_modal #delivery_charges').val(d.delivery_charges) ;  
                       
                        $('#edit_modal input:radio[value='+ d.status +']').prop('checked', true);  
                    }
          }); 
                    
        });
    
    
    
     
    
    
} );
</script> 