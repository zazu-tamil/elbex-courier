<?php  include_once(VIEWPATH . '/inc/header.php'); ?>
<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span> 
            <div class="info-box-content">
              <span class="info-box-text">Today's</span>
              <span class="info-box-text">Bookings</span>
              <span class="info-box-number"><?php echo $fr_no_of_booking; ?></span>
            </div> 
          </div> 
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-maroon"><i class="fa fa-book"></i></span> 
            <div class="info-box-content">
              <span class="info-box-text"><?php echo date('F');?></span>
              <span class="info-box-text">Bookings</span>
              <span class="info-box-number"><?php echo $fr_no_of_booking_month; ?></span>
            </div> 
          </div> 
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-book"></i></span> 
            <div class="info-box-content">
              <span class="info-box-text">Last Month</span>
              <span class="info-box-text">Bookings</span>
              <span class="info-box-number"><?php echo $fr_last_month_book; ?></span>
            </div> 
          </div> 
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-orange"><i class="fa fa-rupee"></i></span> 
            <div class="info-box-content">
              <span class="info-box-text">Today's</span>
              <span class="info-box-text">Revenue</span>
              <span class="info-box-number"><?php echo number_format($fr_day_amt,2); ?></span>
            </div> 
          </div> 
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-rupee"></i></span> 
            <div class="info-box-content">
              <span class="info-box-text"><?php echo date('F');?></span>
              <span class="info-box-text">Revenue</span>
              <span class="info-box-number"><?php echo number_format($fr_month_amt,2); ?></span>
            </div> 
          </div> 
        </div>
        
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-fuchsia-active"><i class="fa fa-rupee"></i></span> 
            <div class="info-box-content">
              <span class="info-box-text">Last Month </span>
              <span class="info-box-text">Revenue</span>
              <span class="info-box-number"><?php echo number_format($fr_last_month_amt,2); ?></span>
            </div> 
          </div> 
        </div>
        
     </div> 
      <!-- Main row -->
       <div class="row"> 
        <div class="col-md-6">
            <?php if(!empty($last_month_fr_booking)) {?> 
              <div class="box box-success collapsed-box">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i> 
                  <h3 class="box-title">Last Month Booking Summary [ <?php echo date('M-Y', strtotime('last month'));?> ]</h3> 
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"  title="Collapse"> <i class="fa fa-plus"></i></button>
                  </div>
                </div> 
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th> 
                            <th>Franchisee</th> 
                            <th class="text-right">No.of Booking</th> 
                            <th class="text-right">Booking Amount</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php   foreach($last_month_fr_booking as $j => $info) {  ?>
                        <tr>
                            <td><?php echo ($j + 1)?></td>  
                            <td class="text-capitalize"><?php echo strtolower($info['hub_branch_name']) ;?> [ <?php echo $info['branch_code'] ;?> ]<br /><label class="label label-success"><?php echo strtolower($info['franchise_type_name']) ;?></label></td>  
                            <td class="text-right"><?php echo number_format($info['no_of_booking'],0);?></td> 
                            <td class="text-right"><?php echo number_format($info['amount'],2);?></td> 
                        </tr>
                        <?php } ?> 
                    </tbody>
                   </table>
                </div> 
              </div>
             <?php } ?>
        </div>
        
        <div class="col-md-6">
            <?php if(!empty($fr_booking)) {?> 
              <div class="box box-success collapsed-box">
                <div class="box-header">
                  <i class="ion ion-clipboard"></i> 
                  <h3 class="box-title">Booking Summary [ <?php echo date('M-Y');?> ]</h3> 
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"  title="Collapse"> <i class="fa fa-plus"></i></button>
                  </div>
                </div> 
                <div class="box-body table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th> 
                            <th>Franchisee</th> 
                            <th class="text-right">No.of Booking</th> 
                            <th class="text-right">Booking Amount</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php   foreach($fr_booking as $j => $info) {  ?>
                        <tr>
                            <td><?php echo ($j + 1)?></td>  
                            <td class="text-capitalize"><?php echo strtolower($info['hub_branch_name']) ;?> [ <?php echo $info['branch_code'] ;?> ]<br /><label class="label label-success"><?php echo strtolower($info['franchise_type_name']) ;?></label></td>  
                            <td class="text-right"><?php echo number_format($info['no_of_booking'],0);?></td> 
                            <td class="text-right"><?php echo number_format($info['amount'],2);?></td> 
                        </tr>
                        <?php } ?> 
                    </tbody>
                   </table>
                </div> 
              </div>
             <?php } ?>
        </div>
       </div> 
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
            
          <?php if(!empty($incoming_manifest)) {?> 
          <div class="box box-success">
            <div class="box-header">
              <i class="ion ion-clipboard"></i> 
              <h3 class="box-title">Incoming Manifest to be received</h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Manifest No</th>
                        <th>From</th>
                        <th>AWB Nos</th>
                        <th class="text-right">No.of Pcs</th> 
                        <th class="text-right">Weight</th>
                        <th class="text-left">Co-Loader</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        foreach($incoming_manifest as $j => $info) {  
                    ?>
                    <tr>
                        <td><?php echo ($j + 1)?></td>
                        <td><?php echo date('d-m-Y', strtotime($info['manifest_date'])) ;?></td>
                        <td><?php echo $info['manifest_no'] ;?></td> 
                        <td><?php echo $info['from_city_code'] ;?></td> 
                        <td><?php echo $info['awbno'] ;?></td> 
                        <td class="text-right"><?php echo number_format($info['no_of_pieces'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['weight'],3);?></td>
                        <td>
                            <?php echo $info['co_loader'] ;?> <br /> 
                            <?php echo $info['co_loader_awb_no'] ;?><br /> 
                            <?php echo $info['co_loader_remarks'] ;?>
                        </td> 
                       
                    </tr>
                    <?php } ?> 
                </tbody>
               </table>
            </div> 
          </div>
         <?php } ?>

        <?php if(!empty($drs_to_be_prepared)) {?> 
          <div class="box box-success">
            <div class="box-header">
              <i class="ion ion-clipboard"></i> 
              <h3 class="box-title">DRS to be Prepared</h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Received Date</th>
                        <th>Booking Date</th> 
                        <th>From</th>
                        <th>Pincode</th>
                        <th>AWB No</th>
                        <th class="text-right">No.of Pcs</th> 
                        <th class="text-right">Weight</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        foreach($drs_to_be_prepared as $j => $info) {  
                    ?>
                    <tr>
                        <td><?php echo ($j + 1)?></td>
                        <td><?php echo date('d-m-Y', strtotime($info['received_date'])) ;?></td>
                        <td><?php echo date('d-m-Y', strtotime($info['booking_date'])) ;?></td>
                        <td><?php echo $info['from_city_code'] ;?></td> 
                        <td><?php echo $info['dest_pincode'] ;?></td> 
                        <td><?php echo $info['awbno'] ;?></td> 
                        <td class="text-right"><?php echo number_format($info['no_of_pieces'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['weight'],3);?></td> 
                    </tr>
                    <?php } ?> 
                </tbody>
               </table>
            </div> 
          </div>
         <?php } ?>
         
         <?php if(!empty($out_for_delivery)) {?> 
          <div class="box box-success">
            <div class="box-header">
              <i class="ion ion-clipboard"></i> 
              <h3 class="box-title">Out for Delivery</h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>DRS Date & Time</th>
                        <th>AWB No</th>
                        <th>Pincode</th>  
                        <th class="text-right">No.of Pcs</th> 
                        <th class="text-right">Weight</th> 
                        <th>Delivery</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        foreach($out_for_delivery as $j => $info) {  
                    ?>
                    <tr>
                        <td><?php echo ($j + 1)?></td>
                        <td><?php echo date('d-m-Y', strtotime($info['drs_date'])) ;?> <?php echo date('h:i a', strtotime($info['drs_time'])) ;?></td>
                        <td><?php echo $info['awbno'] ;?></td> 
                        <td><?php echo $info['dest_pincode'] ;?></td> 
                        <td class="text-right"><?php echo number_format($info['no_of_pieces'],0);?></td> 
                        <td class="text-right"><?php echo number_format($info['weight'],3);?></td>
                        <td><?php echo $info['delivery_by'] ;?></td> 
                    </tr>
                    <?php } ?> 
                </tbody>
               </table>
            </div> 
          </div>
         <?php } ?>

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-4 connectedSortable">
          <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Servicable Pincode Search</h3>
            </div>
            <div class="box-body">
                <form method="post" action="<?php echo site_url('servicable-pincode-report') ?>" id="frmsearch">
                      <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="srch_pincode" name="srch_pincode" placeholder="Pincode Search">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search" ></i></button>
                            </span>
                      </div>
                </form>
            </div>
          </div>  
          <!--
         <div class="box box-success">
            <div class="box-header">
                <h3 class="box-title">Franchise Search</h3>
            </div>
            <div class="box-body">
                <form method="post" action="<?php echo site_url('dash') ?>" id="frmsearch">
                      <div class="input-group input-group-sm">
                            <?php echo form_dropdown('srch_state',array('' => 'All') + $state_opt,set_value('srch_state',$srch_state) ,' id="srch_state" class="form-control"');?>
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-search" ></i></button>
                            </span>
                      </div>
                </form>
            </div>
          </div> -->
        </section>
        <!-- right col -->
        <section class="col-lg-8 connectedSortable">
            <?php /* if(!empty($franchise_info)) {?> 
          <div class="box box-success">
            <div class="box-header">
              <i class="ion ion-umbrella"></i> 
              <h3 class="box-title">Franchise</h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Franchise Type</th>
                        <th>Contact Person</th>
                        <th>Contact Info</th>
                        <th>Address</th> 
                        <th>City</th>
                    </tr>
                </thead>
                <tbody>
                    <?php   
                        foreach($franchise_info as $j => $info) {  
                    ?>
                    <tr>
                        <td><?php echo ($j + 1)?></td>
                        <td><?php echo $info['franchise_type_name'] ;?></td> 
                        <td><?php echo $info['contact_person'] ;?></td> 
                        <td><?php echo $info['mobile'] ;?><br /><?php echo $info['phone'] ;?><br /><?php echo $info['email'] ;?></td>  
                        <td><?php echo str_replace("\n","<br>", $info['address']) ;?></td> 
                        <td><?php echo $info['city_code'] ;?></td> 
                    </tr>
                    <?php } ?> 
                </tbody>
               </table>
            </div> 
          </div>
         <?php }  */?>
        </section>
      </div>
      <!-- /.row (main row) -->

    </section>
<?php  include_once(VIEWPATH . 'inc/footer.php'); ?>
