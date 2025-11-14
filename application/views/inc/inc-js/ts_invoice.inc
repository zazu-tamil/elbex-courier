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
      
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd' 
    });
    
    
    $('#selectall').click(function () {
        $('.awb_nos').attr('checked', this.checked);
    });

    $(".edit_record").click(function() {   
      
      var c_invno = $(this).closest('tr').find('td').eq(1).text();
      var c_invdt = $(this).closest('tr').find('td').eq(2).text(); 
      
      //alert(c_invno);
      //alert($(this).attr('data-info'));
      
      $('#edit_modal #ts_franchise_invoice_id').val($(this).val()) ;  
      $('#edit_modal #invoice_no').val(c_invno) ;  
      $('#edit_modal #invoice_date').val(c_invdt) ;  
      $('#edit_modal .cntn').html($(this).attr('data-info')) ;  
                
    });
     
    
    
     $('.del_record').click(function() {  
       // alert($(this).attr('data'));
       if (confirm('Are U sure want to delete ??')) {
             $.ajax({
                    url: "<?php echo site_url('delete-record');?>",
                    type: "post",
                    data: { tbl : $(this).attr('data'), id: $(this).val() },
                    success: function(d) {  
                        alert(d);
                        location.reload();
                    }
             });
         }
        
     });   
    
    

});
</script> 