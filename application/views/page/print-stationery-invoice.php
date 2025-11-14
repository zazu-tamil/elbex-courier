 
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
        From
        <address>
          <strong>Elbex Couriers Private Limited </strong><br>
          No.258 Avarampalayam Road,<br>
          New Siddapudur,<br>
          Coimbatore - 641 044.<br> 
          Email: info@elbex.in <br />
          Phone : 0422 - 4388573 <br />
          GST : 33AACCE3779K2ZD.
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $bill_list[0]['contact_person']?></strong><br>
          <?php echo str_replace("\n",'<br>', $bill_list[0]['address']);?><br> 
          Mobile: <?php echo $bill_list[0]['mobile']?>  <br />
          GST: <?php echo $bill_list[0]['gst_no']?>  
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Invoice #<?php echo $bill_list[0]['invoice_no']?></b><br> 
        <b>Invoice Date :</b> <?php echo date('d-m-Y', strtotime($bill_list[0]['invoice_date']));?><br> 
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered table-striped">
                    <thead>
                    <tr class="bg-blue-gradient">
                        <th>SNo</th>
                        <th>Items</th>
                        <th>Qty</th>
                        <th>Rate</th> 
                        <th>Amount</th>  
                    </tr> 
                    </thead>
                    <tbody>
                        <?php 
                            $subtot = $tot['qty'] =  $tot['amt'] = 0;
                        foreach($bill_list as $j => $info) { 
                         $tot['qty'] += $info['qty'];  
                        // $tot['weight'] += $info['chargable_weight'];  
                          $tot['amt'] += $info['amount'];  
                        ?>
                        <tr>
                            <td><?php echo ($j+1)?></td>
                            <td><?php echo $info['stationery_item_name']?></td>  
                            <td class="text-right"><?php echo $info['qty']?></td> 
                            <td class="text-right"><?php echo number_format($info['rate'],2);?></td>  
                            <td class="text-right"><?php echo number_format($info['amount'],2);?></td>   
                        </tr>
                        <?php } ?> 
                            <tr> 
                                <th class="text-right" colspan="2">Total</th>
                                <th class="text-right"><?php echo number_format($tot['qty'],0)?></th> 
                                <th></th>
                                <th class="text-right"><?php echo number_format($tot['amt'],2)?></th> 
                            </tr> 
                    </tbody>
                     
                </table>  
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead"><strong>Terms & Conditions</strong></p>
         
        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px; text-transform:uppercase;"> 

        1. Please Make Payment By Cash/ Rtgs/ Neft  Only.<br />
        
        2. The  Payment Should Be Transferred To The Account Under The Name Of <br /> "<strong>Elbex Couriers Pvt Limited</strong>".<br /><b>A/C Number : 50200007833315.<br /> Ifsc Code :Hdfc 0000031,<br /> Hdfc Bank Ltd, Trichy Road Branch.<br /> Coimbatore.</b><br />
        
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
              <td><i class="fa fa-rupee"></i> <?php echo number_format($tot['amt'],2);?></td>
            </tr>  
            <?php if($bill_list[0]['state_code'] != 'TN') {?>
            <tr>
              <th>IGST (18%)</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format(($tot['amt'] * 18 /100),2);?></td>
            </tr> 
            <?php } else {?>
            <tr>
              <th>CGST (9%)</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format((($tot['amt'] * 18 /100) /2),2);?></td>
            </tr> 
            <tr>
              <th>SGST (9%)</th>
              <td><i class="fa fa-rupee"></i> <?php echo number_format((($tot['amt'] * 18 /100)/2),2);?></td>
            </tr> 
            <?php } 
            $total_amt = ($tot['amt'] + ($tot['amt'] * 18 /100));
            ?>
            <tr>
              <td>Email ID</td>
              <td><i class="fa fa-rupee"></i>  <?php echo number_format($bill_list[0]['email_chrg'],2);?></td>
            </tr>
            <tr>
              <td>ID Card</td>
              <td><i class="fa fa-rupee"></i>  <?php echo number_format($bill_list[0]['id_card_chrg'],2);?></td>
            </tr>
            <tr>
              <td>Transport</td>
              <td><i class="fa fa-rupee"></i> <?php echo number_format($bill_list[0]['transit_chrg'],2);?></td>
            </tr>
            <tr>
              <th>Total</th>
              <td><i class="fa fa-rupee"></i> <strong><?php echo number_format(($total_amt +$bill_list[0]['email_chrg'] + $bill_list[0]['id_card_chrg']+ $bill_list[0]['transit_chrg'] ),2);?></strong></td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <div class="text-center noprint">
        <a href="<?php echo site_url('stationery-invoice-list')?>" class="btn btn-info" >Back to Invoice List</a>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
    <?php
            $tot_amt = ($total_amt +$bill_list[0]['email_chrg'] + $bill_list[0]['id_card_chrg']+ $bill_list[0]['transit_chrg'] );
            $this->db->where('fr_stationery_invoice_id', $invoice_id);
            $this->db->update('crit_fr_stationery_invoice_info', array('tot_amt' => $tot_amt)); 
    ?>
</div>
<!-- ./wrapper -->
</body>
</html>
