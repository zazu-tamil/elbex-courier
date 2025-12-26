<!-- <?php 
echo "<pre>";
print_r($record_list);  
echo "</pre>";
?> -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Elbex Customer Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>asset/dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    @media print{
       .noprint{
           display:none;
       }
    }
  </style>  
</head>
<body onload="window.print();">
<div class="wrapper1">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
        <span class="pull-right" ><img src="<?php echo base_url('asset/images/logo.png') ?>" class="img-responsive" width="80%" /></span>
          <i class="fa fa-globe"></i> Elbex Couriers Private Limited.
          
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <b>From</b>
        <address>
          <!-- <strong>Elbex Couriers Private Limited </strong><br>
          No.258 Avarampalayam Road,<br>
          New Siddapudur,<br>
          Coimbatore - 641 044.<br>  -->
          <?php echo str_replace("\n",'<br>', $record_list['franchise_address']); ?><br>
          Email: <?php echo $record_list['f_email']; ?> <br>
          <b>GST : <?php echo $record_list['f_gst_no']; ?></b>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>To</b>
        <address>
          <strong><?php echo $record_list['customer']?></strong><br>
          <?php echo str_replace("\n",'<br>', $record_list['address']);?><br>
          Email: <?php echo $record_list['email']?><br>
          Phone: <?php echo $record_list['phone']?> - Mobile: <?php echo $record_list['mobile']?><br />
          <b>GST: <?php echo $record_list['gst_no']?></b>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?php echo $record_list['invoice_no']?></b><br> 
        <b>Invoice Date :</b> <?php echo date('d-m-Y', strtotime($record_list['invoice_date']));?><br> 
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>S.No</th>
            <th>AWB No</th>
            <th>Date</th>
            <th>Origin</th> 
            <th>Destination</th> 
            <th>Cust.Ref.no</th> 
            <th>No of Pcs</th>
            <th>Weight</th> 
            <th>Amount</th> 
          </tr>
          </thead>
          <tbody>
          <?php 
          $subtot = $tax_amt = $cod_charges = $fod_charges = $fov_charges = $fuel_charges = 0;
          foreach($bill_list as $i => $info) 
          {
            $subtot += $info['rate'];
            $tax_amt += $info['tax_amt'];
            $cod_charges += $info['cod_charges']; 
            $fod_charges += $info['fod_charges']; 
            $fov_charges += $info['fov_charges']; 
            $fuel_charges += $info['fuel_charges']; 
          ?>
          <tr>
            <td><?php echo ($i + 1);?></td> 
            <td><?php echo $info['awbno']?></td>
            <td><?php echo date('d-m-Y', strtotime($info['booking_date'])); ?></td>
            <td><?php echo $info['origin_pincode'];?><br /><?php echo $info['origin_state_code'] . ' - ' . $info['origin_city_code'];?></td> 
            <td><?php echo $info['dest_pincode'];?><br /><?php echo $info['dest_state_code'] . ' - ' . $info['dest_city_code'];?></td> 
            <td class="text-center"><?php echo $info['customer_ref_no'];?></td> 
            <td class="text-right"><?php echo $info['no_of_pieces'];?></td> 
            <td class="text-right"><?php echo $info['chargable_weight']?></td>
            <td class="text-right"><?php echo number_format($info['rate'],2);?></td>  
          </tr>
           <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Terms & Conditions</p>
         
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; "> 

        1. Please Make Payment By Cash/ RTGS/ NEFT  Only.<br />
        
        2. The  Payment Should Be Transferred To  The Account Under   The Name Of 
        <br />
        <?php echo str_replace("\n","<br>",$record_list['bank_det']); ?>
        <br />        
        3. The Payment Should Be Made Within 7 Days From The Date Of Billing.<br />
        
        4. In Case The  Payment Is Not Made Within 15 Days From The Date Of Billing,  Interest Will Be Charged At The Rate Of  21 % Per Annum.<br />
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6 text-right"> 

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format($subtot,2);?></td>
            </tr> 
            <tr> 
                <th style="width:50%">COD Charges</th>
                <td><i class="fa fa-rupee"></i> <?php echo number_format($cod_charges,2);?></td>
            </tr>
            <tr> 
                <th style="width:50%">FOD Charges</th>
                <td><i class="fa fa-rupee"></i> <?php echo number_format($fod_charges,2);?></td>
            </tr>
            <tr> 
                <th style="width:50%">FOV Charges</th>
                <td><i class="fa fa-rupee"></i> <?php echo number_format($fov_charges,2);?></td>
            </tr>
            <?php //if($fuel_charges > 0) {?>
            <tr> 
                <th style="width:50%">Fuel Surcharges</th>
                <td><i class="fa fa-rupee"></i> <?php echo number_format($fuel_charges,2);?></td>
            </tr>
            <?php //} ?>
            <?php if($record_list['state_code'] != $record_list['f_state_code']) {?>
            <tr>
              <th>IGST (18%)</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format($tax_amt,2);?></td>
            </tr> 
            <?php } else {?>
            <tr>
              <th>CGST (9%)</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format(($tax_amt /2),2);?></td>
            </tr> 
            <tr>
              <th>SGST (9%)</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format(($tax_amt/2),2);?></td>
            </tr> 
            <?php } ?>
            <tr>
              <th>Total:</th>
              <td><i class="fa fa-rupee"></i> <strong><?php echo number_format((($subtot + $cod_charges + $fod_charges + $fov_charges + $fuel_charges) + $tax_amt),2);?></strong></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div class="text-center noprint">
        <a href="<?php echo site_url('customer-invoice-list')?>" class="btn btn-info" >Back to Invoice List</a>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
