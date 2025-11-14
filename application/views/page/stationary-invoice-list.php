<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
 <section class="content-header">
  <h1>Stationery Invoice List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-book"></i> Invoice</a></li> 
    <li class="active">Stationery Invoice List</li>
  </ol>
</section>
<!-- Main content -->
<section class="content"> 
  
        <div class="box box-info"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Search Filter</h3>
            </div>
        <div class="box-body">
             <form method="post" action="" id="frmsearch">          
             <div class="row">   
                 <div class="form-group col-md-3"> 
                    <label>From Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_from_date" name="srch_from_date" value="<?php echo set_value('srch_from_date',$srch_from_date);?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div> 
                 <div class="form-group col-md-3"> 
                    <label>To Date</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right datepicker" id="srch_to_date" name="srch_to_date" value="<?php echo set_value('srch_to_date',$srch_to_date);?>">
                    </div>
                    <!-- /.input group -->                                             
                 </div>
                 <div class="form-group col-md-4">
                    <label>Franchises</label> 
                        <?php echo form_dropdown('srch_franchise_id',array('' => 'Select the Franchise') + $franchise_opt  ,set_value('srch_franchise_id',$srch_franchise_id) ,' id="srch_franchise_id" class="form-control" required');?> 
                                                    
                 </div>   
                  
                 <div class="form-group col-md-2 text-left">
                    <br />
                    <button class="btn btn-success" name="btn_show" value="Show Reports'"><i class="fa fa-search"></i> Show Invoice</button>
                </div>
             </div>  
            </form>
         </div> 
         </div> 
         <?php if(($submit_flg)) { ?>         
         <div class="box box-success"> 
            <div class="box-header with-border">
              <h3 class="box-title text-white">Franchises Stationery Invoice List</h3> 
                <div class="pull-right">
                    <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
                </div>
            </div>
            <div class="box-body">  
                <?php  if(!empty($record_list)) { ?>    
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Invoice No</th>
                        <th>Date</th>
                        <th>Franchise</th>  
                        <th>Inv.Amount</th> 
                        <th colspan="3" class="text-center">Action</th> 
                    </tr> 
                    </thead>
                    <tbody>
                        <?php 
                        $tot = 0;
                        foreach($record_list as $j => $info) {   
                            $tot += $info['tot_amt'];
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td><?php echo $info['invoice_no']?></td>
                            <td><?php echo $info['invoice_date']?></td>
                            <td>
                                <?php echo $info['contact_person']?><br />
                                <?php echo $info['franchise_type']?>
                            </td>    
                            <td class="text-right"><?php echo number_format($info['tot_amt'],2)?></td>
                            <td class="text-center">
                                <a  href="<?php echo site_url('print-stationery-invoice/').$info['fr_stationery_invoice_id']?>" target="_blank" class="btn btn-info btn-xs" title="Print"><i class="fa fa-print"></i></a>
                            </td>
                             <td class="text-center">
                                <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $info['fr_stationery_invoice_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
                            </td>                                 
                            <td class="text-center">
                                <button value="<?php echo $info['fr_stationery_invoice_id']?>" data="fr_stationery_invoice_info" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                        <?php } ?> 
                    </tbody>
                     <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th class="text-right"><?php echo number_format($tot,2)?></th>
                        </tr>
                     </tfoot>
                </table>  
                 
                  <?php } ?>
            </div>
            <div class="box-footer with-border ">
               <div class="form-group col-sm-6 text-left">
                    <label>Total Records : <?php echo $total_records;?></label>
                </div>
                <div class="form-group col-sm-6 text-right">
                    <?php echo $pagination; ?>
                </div>
            </div>
            </div> 
            <?php } ?> 
        
            
  <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="" id="frmadd">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="scrollmodalLabel">Add Franchise Stationery Invoice</h2>
                <input type="hidden" name="mode" value="Add" />
            </div>
            <div class="modal-body"> 
                <div class="row">   
                     <div class="form-group col-md-4"> 
                        <label for="invoice_date">Invoice Date</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="invoice_date" name="invoice_date" value="<?php echo date('Y-m-d');?>">
                        </div>                                      
                     </div>
                     <div class="form-group col-md-8">
                        <label for="franchise_id">Franchise</label>
                        <?php echo form_dropdown('franchise_id',array('' => 'Select Franchise') + $franchise_opt,set_value('franchise_id' , $srch_franchise_id) ,' id="franchise_id"  class="form-control" required style="width:100%"');?> 
                     </div> 
                </div> 
                <div class="row">        
                     <div class="form-group col-md-3">
                        <label>Email ID Charges</label>
                        <input class="form-control bt_calc" type="number" step="any" name="email_chrg" id="email_chrg" value="0" required="true" > 
                     </div> 
                      <div class="form-group col-md-3">
                        <label>ID Card Charges </label>
                        <input class="form-control bt_calc" type="number" step="any" name="id_card_chrg" id="id_card_chrg" value="0" required="true" > 
                     </div> 
                      <div class="form-group col-md-3">
                        <label>Transport Charges</label>
                        <input class="form-control bt_calc" type="number" step="any" name="transit_chrg" id="transit_chrg" value="0" required="true"> 
                     </div> 
                     <div class="form-group col-md-3">
                        <label>Total Amount</label>
                        <input class="form-control" type="number" step="any" name="tot_amt" id="tot_amt" value="0" required="true" readonly="true"> 
                     </div> 
                 </div>  
                 
                 <div class="row">
                    <div class="col-md-12">
                       <div class="box box-info ">
                            <div class="box-body table-responsive">
                                <table class="table table-hover table-bordered table-striped table-responsive" id="inv_itm">
                                <thead> 
                                    <tr> 
                                        <th>Item</th>  
                                        <th>Qty</th>  
                                        <th>Rate</th> 
                                        <th>Amount</th> 
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php for($i=0;$i<10;$i++ ){?>
                                    <tr> 
                                        <td width="20%">
                                            <?php //echo form_dropdown('stationery_item_id['. $i . ']',array('' => 'Select Item') + $stationery_item_opt ,set_value('stationery_item_id') ,' class="form-control stationery_item_id" ');?>
                                            <select name="stationery_item_id[<?php echo $i; ?>]"  class="form-control stationery_item_id" >
                                               <option value="">Select</option>
                                                <?php foreach($stationery_item_opt as $id => $info) { ?>
                                                <option value="<?php echo $info['stationery_item_id']; ?>" data-rate="<?php echo $info['rate']?>" data-rindex="<?php echo $i?>"><?php echo $info['stationery_item_name']?></option>
                                                <?php } ?>
                                            </select>
                                        </td>  
                                        <td width="10%">
                                            <input class="form-control text-right qty qty_<?php echo $i; ?>" type="number" step="any" name="qty[<?php echo $i; ?>]" value="" placeholder="Qty" >
                                        </td> 
                                         <td width="10%">
                                            <input class="form-control text-right rate_<?php echo $i; ?>" type="number" step="any" name="rate[<?php echo $i; ?>]" value="" placeholder="Rate" readonly="true">
                                        </td>  
                                        <td width="10%">
                                            <input class="itmtot form-control text-right amount_<?php echo $i; ?>" type="number" step="any" name="amount[<?php echo $i; ?>]" value="0" placeholder="Amount" readonly="true" >
                                        </td> 
                                    </tr>
                                    <?php } ?> 
                                     
                                    
                                </tbody>
                                </table>      
                            </div>
                       </div> 
                    </div>
                      
                </div>  
                 
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <b class="text-blue totamt"></b>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                <input type="submit" name="Save" value="Save"  class="btn btn-primary" />
            </div> 
            </form>
        </div>
    </div>
  </div> 
  
  
  <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form method="post" action="" id="frmedit">
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title" id="scrollmodalLabel">Edit Franchise Stationery Invoice</h2>
                <input type="hidden" name="mode" value="Edit" />
                <input type="hidden" name="fr_stationery_invoice_id" id="fr_stationery_invoice_id" />
            </div>
            <div class="modal-body">
                  
                <div class="row">   
                     <div class="form-group col-md-4"> 
                        <label for="invoice_date">Invoice Date</label>
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="date" class="form-control pull-right" id="invoice_date" name="invoice_date" value="<?php echo date('Y-m-d');?>">
                        </div>                                      
                     </div>
                     <div class="form-group col-md-8">
                        <label for="franchise_id">Franchise</label>
                        <?php echo form_dropdown('franchise_id',array('' => 'Select Franchise') + $franchise_opt,set_value('franchise_id') ,' id="franchise_id" class="form-control" required');?> 
                     </div>   
                     <div class="form-group col-md-3">
                        <label>Invoice No</label>
                        <input class="form-control" type="number" step="any" name="invoice_no" id="invoice_no" value="" > 
                     </div>
                     <div class="form-group col-md-3">
                        <label>Email ID Charges</label>
                        <input class="form-control bt_calc" type="number" step="any" name="email_chrg" id="email_chrg" value="0" > 
                     </div> 
                      <div class="form-group col-md-3">
                        <label>ID Card Charges </label>
                        <input class="form-control bt_calc" type="number" step="any" name="id_card_chrg" id="id_card_chrg" value="0"  > 
                     </div> 
                      <div class="form-group col-md-3">
                        <label>Transport Charges</label>
                        <input class="form-control bt_calc" type="number" step="any" name="transit_chrg" id="transit_chrg" value="0"> 
                     </div> 
                     <div class="form-group col-md-3">
                        <label>Total Amount</label>
                        <input class="form-control" type="number" step="any" name="tot_amt" id="tot_amt" value="0" required="true" readonly="true"> 
                     </div> 
                 </div>  
                 
                 <div class="row">
                    <div class="col-md-12">
                       <div class="box box-info ">
                            <div class="box-body table-responsive">
                                <table class="table table-hover table-bordered table-striped table-responsive" id="inv_itm">
                                <thead> 
                                    <tr> 
                                        <th>Item</th>  
                                        <th>Qty</th>  
                                        <th>Rate</th> 
                                        <th>Amount</th> 
                                    </tr> 
                                </thead>
                                <tbody>
                                    <?php for($i=0;$i<10;$i++ ){?>
                                    <tr> 
                                        <td width="20%">
                                            <input type="hidden" name="fr_stationery_invoice_itm_id[]" id="fr_stationery_invoice_itm_id_<?php echo $i; ?>" value=""  /> 
                                            <select name="stationery_item_id[<?php echo $i; ?>]"  class="form-control stationery_item_id" id="stationery_item_id_<?php echo $i; ?>" >
                                               <option value="">Select</option>
                                                <?php foreach($stationery_item_opt as $id => $info) { ?>
                                                <option value="<?php echo $info['stationery_item_id']; ?>" data-rate="<?php echo $info['rate']?>" data-rindex="<?php echo $i?>"><?php echo $info['stationery_item_name']?></option>
                                                <?php } ?>
                                            </select>
                                        </td>  
                                        <td width="10%">
                                            <input class="form-control text-right qty qty_<?php echo $i; ?>" id="qty_<?php echo $i; ?>"  type="number" step="any" name="qty[<?php echo $i; ?>]" value="" placeholder="Qty" >
                                        </td> 
                                         <td width="10%">
                                            <input class="form-control text-right rate_<?php echo $i; ?>" id="rate_<?php echo $i; ?>" type="number" step="any" name="rate[<?php echo $i; ?>]" value="" placeholder="Rate" readonly="true">
                                        </td>  
                                        <td width="10%">
                                            <input class="itmtot form-control text-right amount_<?php echo $i; ?>" id="amount_<?php echo $i; ?>" type="number" step="any" name="amount[<?php echo $i; ?>]" value="0" placeholder="Amount" readonly="true" >
                                        </td> 
                                    </tr>
                                    <?php } ?> 
                                     
                                    
                                </tbody>
                                </table>      
                            </div>
                       </div> 
                    </div>
                      
                </div>  
                 
            </div>
            <div class="modal-footer">
                <div class="pull-left">
                    <b class="text-blue totamt"></b>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                <input type="submit" name="Save" value="Update"  class="btn btn-primary" />
            </div> 
            </form>
        </div>
    </div>
  </div> 
         
</section>
<!-- /.content -->
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
