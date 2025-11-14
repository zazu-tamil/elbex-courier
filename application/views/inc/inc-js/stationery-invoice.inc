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
      $('#franchise_id').select2();
      
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });

    $("#add_modal .stationery_item_id").change(function() {   
         
         $('#add_modal .rate_' + $(this).find(':selected').attr('data-rindex')).val($(this).find(':selected').attr('data-rate'));
         $('#add_modal .qty_' + $(this).find(':selected').attr('data-rindex')).focus();           
    });
    
      
     $("#add_modal .qty").keyup(function(){  //alert($('#add_modal .itmtot').length)
     
        var idx = $(this).closest("tr").index() ;
            
              var tt =  $('#add_modal .rate_' + (idx)).val(); 
              var qty = $(this).val();
              var tot =  (qty * tt) ;  
              $('#add_modal .amount_' + (idx)).val(tot.toFixed(2));     
              $.fn.myFunction();         
     }); 
     
     $("#add_modal .bt_calc").keyup(function(){  
      $.fn.myFunction();         
     });  
     
      $.fn.myFunction = function() {  
        //alert($('#add_modal .itmtot').length);
        var tot = 0;
        var tot_e = (parseFloat($('#add_modal #email_chrg').val()) + parseFloat($('#add_modal #id_card_chrg').val()) + parseFloat($('#add_modal #transit_chrg').val()));
        $.each($('#add_modal .itmtot'), function (key, fld) {
        //alert($('#add_modal .amount_' + key).val());
       // alert(fld.value);
            tot += parseFloat(fld.value);
         });
       // alert($('#add_modal #email_chrg').val());
        var tot1 = tot + parseFloat(tot * 18 /100 ) + tot_e;
        
        $('.totamt').html("Total Amount : " + tot1.toFixed(2));
        $('#add_modal #tot_amt').val(tot1.toFixed(2));
        
      } 
     
     
    $(".edit_record").click(function() {  
         //   alert($(this).val());
          $.ajax({
            url: "<?php echo site_url('get-data');?>",
            type: "post",
            data: { tbl : 'fr_stationery_invoice_info', id: $(this).val() },
            success: function(d) {  
              //  alert(d.franchise_type_id);
              $('#edit_modal #fr_stationery_invoice_id').val(d.fr_stationery_invoice_id) ;     
              $('#edit_modal #franchise_id').val(d.franchise_id) ;     
              $('#edit_modal #invoice_no').val(d.invoice_no) ;     
              $('#edit_modal #invoice_date').val(d.invoice_date) ;   
              $('#edit_modal #email_chrg').val(d.email_chrg) ;   
              $('#edit_modal #id_card_chrg').val(d.id_card_chrg) ;   
              $('#edit_modal #transit_chrg').val(d.transit_chrg) ;    
              $('#edit_modal #tot_amt').val(d.tot_amt) ;    
              
              //alert(d['itm'].length);
              
              $.each(d['itm'], function(key,val) {             
                //alert(key+val.qty);         
                $('#edit_modal #fr_stationery_invoice_itm_id_'+ key).val(val.fr_stationery_invoice_itm_id) ; 
                $('#edit_modal #stationery_item_id_'+ key).val(val.stationery_item_id) ; 
                $('#edit_modal #qty_'+ key).val(val.qty) ; 
                $('#edit_modal #rate_'+ key).val(val.rate) ; 
                $('#edit_modal #amount_'+ key).val(val.amount) ; 
              });  
            }
         }); 
         
     }); 
     
     
     $("#edit_modal .stationery_item_id").change(function() {   
         
         $('#edit_modal .rate_' + $(this).find(':selected').attr('data-rindex')).val($(this).find(':selected').attr('data-rate'));
         $('#edit_modal .qty_' + $(this).find(':selected').attr('data-rindex')).focus();           
    });
    
    
     $("#edit_modal .qty").keyup(function(){  
     
        var idx = $(this).closest("tr").index() ;
            
              var tt =  $('#edit_modal .rate_' + (idx)).val(); 
              var qty = $(this).val();
              var tot =  (qty * tt) ;  
              $('#edit_modal .amount_' + (idx)).val(tot.toFixed(2));     
              
              $.fn.myFunction1();          
     }); 
     
     
      $("#edit_modal .bt_calc").keyup(function(){  
      $.fn.myFunction1();         
     });  
     
      $.fn.myFunction1 = function() {  
         
        var tot = 0;
        var tot_e = (parseFloat($('#edit_modal #email_chrg').val()) + parseFloat($('#edit_modal #id_card_chrg').val()) + parseFloat($('#edit_modal #transit_chrg').val()));
        $.each($('#edit_modal .itmtot'), function (key, fld) {
       
            tot += parseFloat(fld.value);
         }); 
        var tot1 = tot + parseFloat(tot * 18 /100 ) + tot_e;
        
        $('.totamt').html("Total Amount : " + tot1.toFixed(2));
        $('#edit_modal #tot_amt').val(tot1.toFixed(2));
        
      } 
    
    
    $('.del_record').click(function() {  
        if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : 'fr_stationery_invoice_info', id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });  
    
    

});
</script> 