<?php include_once(VIEWPATH . '/inc/header.php'); ?>
<section class="content-header">
  <h1>Receipt List</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-cubes"></i> Master</a></li> 
    <li class="active">Receipt List</li>
  </ol>
</section>

<section class="content"> 
  <!-- Search Box -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-search"></i> Search</h3>
    </div>
    <div class="box-body"> 
      <form action="<?php echo site_url('receipt-list');?>" method="post" id="frm">
        <div class="row"> 
          <div class="col-sm-3 col-md-3"> 
            <label for="srch_payment_type">Payment Type</label>
            <?php echo form_dropdown('srch_payment_type', array('' => 'All') + $payment_type_opt, set_value('srch_payment_type', $srch_payment_type), ' id="srch_payment_type" class="form-control"');?>
          </div>
          <div class="col-sm-3 col-md-6">
            <label>Search Receipt No, Branch, From, To or Cheque No</label>
            <input type="text" class="form-control" name="srch_key" id="srch_key" value="<?php echo set_value('srch_key', $srch_key) ?>" placeholder="Search..." />
          </div>
          <div class="col-sm-3 col-md-3"> 
            <br />
            <button class="btn btn-info" type="submit">Show</button>
          </div>
        </div>
      </form> 
    </div> 
  </div> 

  <!-- Receipt Table -->
  <div class="box box-success">
    <div class="box-header with-border">
      <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#add_modal"><span class="fa fa-plus-circle"></span> Add New </button>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>

    <div class="box-body table-responsive no-padding"> 
      <table class="table table-hover table-bordered table-striped">
        <thead> 
          <tr>
            <th>#</th>
            <th>Receipt Date</th>  
            <th>Receipt No</th>  
            <th>Payment Type</th>
            <th>From / To</th>  
            <th>Branch</th>
            <th>Payment Mode</th>
            <th>Amount</th>
            <th>Description</th>
            <th colspan="2" class="text-center">Action</th>  
          </tr> 
        </thead>
        <tbody>
          <?php
            foreach($record_list as $j => $ls){
              $payment_mode_display = '';
              if($ls['payment_mode'] == 'Cheque') {
                $payment_mode_display = 'Cheque #' . $ls['cheq_dd_no'];
              } elseif($ls['payment_mode'] == 'DD') {
                $payment_mode_display = 'DD #' . $ls['cheq_dd_no'];
              } else {
                $payment_mode_display = $ls['payment_mode'];
              }
          ?> 
          <tr> 
            <td class="text-center"><?php echo ($j + 1 + $sno);?></td> 
            <td><?php echo date('d-m-Y', strtotime($ls['receipt_date']));?></td>   
            <td><?php echo str_pad($ls['receipt_no'], 4, '0', STR_PAD_LEFT);?></td>
            <td><span class="badge badge-<?php echo ($ls['payment_type']=='Paid'?'danger':'success');?>"><?php echo $ls['payment_type'];?></span></td>   
            <td>
              <strong>From:</strong> <?php echo $ls['receipt_from'];?><br/>
              <strong>To:</strong> <?php echo $ls['receipt_to'];?>
            </td>   
            <td><?php echo $ls['branch'];?></td>   
            <td><?php echo $payment_mode_display;?></td>
            <td class="text-right">₹ <?php echo number_format($ls['payment_amt'], 2);?></td>
            <td><?php echo substr($ls['payment_desc'], 0, 30);?></td>

              <td class="text-center">
                 <a  href="<?php echo site_url('receipt-list-print/'.$ls['receipt_id']); ?>" target="_blank" class="btn btn-info btn-xs" title="Print"><i class="fa fa-print"></i></a>
              </td>

            <td class="text-center">
              <button data-toggle="modal" data-target="#edit_modal" value="<?php echo $ls['receipt_id']?>" class="edit_record btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></button>
            </td>                                  
            
            <td class="text-center">
                <button value="<?php echo $ls['receipt_id']?>" class="del_record btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></i></button>
            </td>  
                                              
          </tr>
          <?php
            }
          ?>                                 
        </tbody>
      </table>

      <!-- Add Receipt Modal -->
      <div class="modal fade" id="add_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form method="post" action="" id="frmadd">
              <div class="modal-header">
                <h3 class="modal-title" id="scrollmodalLabel">Add Receipt</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="mode" value="Add" />
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Receipt Date</label>
                    <input class="form-control" type="date" name="receipt_date" id="receipt_date" value="" required>                                             
                  </div> 
                   <div class="form-group col-md-6">
                    <label>Payment Type <span style="color:red;">*</span></label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="payment_type" value="Paid" checked="true" /> Paid
                      </label> 
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="payment_type" value="Received" /> Received
                      </label>
                    </div> 
                  </div>
                  <!-- <div class="form-group col-md-6">
                    <label>Receipt No</label>
                    <input class="form-control" type="number" name="receipt_no" id="receipt_no" value="" placeholder="0001" required>                                             
                  </div>   -->
                </div> 

                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label>Payment Mode <span style="color:red;">*</span></label>
                    <?php echo form_dropdown('payment_mode', $payment_mode_opt, '', ' id="payment_mode" class="form-control" required');?>
                  </div>
               
                   <div class="form-group col-md-6">
                    <label>Receipt From</label>
                    <input class="form-control" type="text" name="receipt_from" id="receipt_from" value="" placeholder="From" required>                                             
                  </div> 
                  </div> 

                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Receipt To</label>
                    <input class="form-control" type="text" name="receipt_to" id="receipt_to" value="" placeholder="To" required>                                             
                  </div>
                    <div class="form-group col-md-6">
                    <label>Branch</label>
                    <input class="form-control" type="text" name="branch" id="branch" value="" placeholder="Branch Name" required>                                             
                  </div> 
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Amount</label>
                    <input class="form-control" type="number" step="0.01" name="payment_amt" id="payment_amt" value="" placeholder="0.00" required>                                             
                  </div>
                     <div class="form-group col-md-6">
                    <label>Cheque/DD No</label>
                    <input class="form-control" type="text" name="cheq_dd_no" id="cheq_dd_no" value="" placeholder="Cheque/DD Number">                                             
                  </div> 
                </div>

                <div class="row" id="cheque_dd_row" style="display:none;">
                  <div class="form-group col-md-6">
                    <label>Cheque/DD Date</label>
                    <input class="form-control" type="date" name="cheq_dd_date" id="cheq_dd_date" value="">                                             
                  </div>
                      <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea class="form-control" name="payment_desc" id="payment_desc" placeholder="Payment Description"></textarea>                                             
                  </div>  
                </div>
                </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                <input type="submit" name="Save" value="Save" class="btn btn-primary" />
              </div> 
            </form>
          </div>
        </div>
      </div>

      <!-- Edit Receipt Modal -->
      <div class="modal fade" id="edit_modal" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <form method="post" action="" id="frmedit">
              <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel">Edit Receipt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="mode" value="Edit" />
                <input type="hidden" name="receipt_id" id="receipt_id" />
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Receipt Date</label>
                    <input class="form-control" type="date" name="receipt_date" id="receipt_date" value="" required>                                             
                  </div> 
                  <div class="form-group col-md-6">
                    <label>Receipt No</label>
                    <input class="form-control" type="number" name="receipt_no" id="receipt_no" value="" placeholder="0001" required readonly>                                             
                  </div>  
                </div> 

                <div class="row"> 
                  <div class="form-group col-md-6">
                    <label>Payment Type <span style="color:red;">*</span></label>
                    <div class="radio">
                      <label>
                        <input type="radio" name="payment_type" value="Paid" /> Paid
                      </label> 
                    </div>
                    <div class="radio">
                      <label>
                        <input type="radio" name="payment_type" value="Received" /> Received
                      </label>
                    </div> 
                  </div>

                  <div class="form-group col-md-6">
                    <label>Payment Mode <span style="color:red;">*</span></label>
                    <?php echo form_dropdown('payment_mode', $payment_mode_opt, '', ' id="payment_mode" class="form-control" required');?>
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Receipt From</label>
                    <input class="form-control" type="text" name="receipt_from" id="receipt_from" value="" placeholder="From" required>                                             
                  </div> 
                  <div class="form-group col-md-6">
                    <label>Receipt To</label>
                    <input class="form-control" type="text" name="receipt_to" id="receipt_to" value="" placeholder="To" required>                                             
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Branch</label>
                    <input class="form-control" type="text" name="branch" id="branch" value="" placeholder="Branch Name" required>                                             
                  </div> 
                  <div class="form-group col-md-6">
                    <label>Amount</label>
                    <input class="form-control" type="number" step="0.01" name="payment_amt" id="payment_amt" value="" placeholder="0.00" required>                                             
                  </div>
                </div>

                <div class="row" id="cheque_dd_row" style="display:none;">
                  <div class="form-group col-md-6">
                    <label>Cheque/DD No</label>
                    <input class="form-control" type="text" name="cheq_dd_no" id="cheq_dd_no" value="" placeholder="Cheque/DD Number">                                             
                  </div> 
                  <div class="form-group col-md-6">
                    <label>Cheque/DD Date</label>
                    <input class="form-control" type="date" name="cheq_dd_date" id="cheq_dd_date" value="">                                             
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Description</label>
                    <textarea class="form-control" name="payment_desc" id="payment_desc" placeholder="Payment Description"></textarea>                                             
                  </div>  
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> 
                <input type="submit" name="Save" value="Update" class="btn btn-primary" />
              </div> 
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="box-footer">
      <div class="form-group col-sm-6">
        <label>Total Records : <?php echo $total_records;?></label>
      </div>
      <div class="form-group col-sm-6">
        <?php echo $pagination; ?>
      </div>
    </div>
  </div>
</section>

<?php include_once(VIEWPATH . 'inc/footer.php'); ?>