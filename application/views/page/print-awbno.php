<?php
  /*	 echo "<pre>";
     print_r($label);
	 echo "</pre>"; */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $label['awbno']; ?></title>
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
  <script src="<?php echo base_url() ?>asset/bower_components/jquery/dist/jquery.min.js"></script>
  <!--<script src="<?php echo base_url() ?>asset/bower_components/jquery.excelexportjs.js"></script>-->
  <script src="<?php echo base_url() ?>asset/bower_components/excelexport.js"></script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    @media print{
       .noprint{
           display:none;
       }
       
        body {
          overflow-y: hidden; /* Hide vertical scrollbar */
          overflow-x: hidden; /* Hide horizontal scrollbar */
        }
    }
    i{font-size: 12px;}
    p{padding: 0px; margin: 0px;}
    #sts tr {border: 1px solid black;}
    #content-table td {border: 1px solid black;}
    
    .div-txt {
      writing-mode: vertical-lr; 
      display: inline-block;
     
      margin: 5px;
    }
    
    
    .div-txt .b {
      text-orientation: upright;
    }
  </style>  
 
</head>
<body onload="window.print();" style="font-size: 12px;">
 
<div class="wrapper1">
  <!-- Main content -->
  <section class="invoice">
    
    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12" id="mtc">
            <table class="table table-condensed table-bordered " id="content-table"> 
                <tr>
                    <td colspan="5" class="text-center"><b>Elbex Couriers Private Limited</b></td>
                    <td rowspan="3" class="text-center">
                        <img src="<?php echo base_url('asset/images/logo.png')?>" alt="" width="50%" class="img-fluid"/> 
                    </td>
                    <td colspan="2" rowspan="3" class="text-center">
                        <?php if(file_exists($barcode)) { ?>
                        <img src="<?php echo base_url($barcode);?>" alt="" class="img-fluid" width="70%"/>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center">No.258,Avarampalayam Road, New Siddapudur,Coimbatore - 641 044, Tamil Nadu, India</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-center"><strong>GST : 33AACCE3779K2ZD</strong></td>
                </tr>
                <tr>
                    <td class="text-left">AWB No</td>
                    <td class="text-left"><strong><?php echo $label['awbno'];?></strong></td>
                    <td class="text-left">Date</td>
                    <td class="text-left"><?php echo date('d-m-Y', strtotime($label['booking_date']));?></td>
                    <td class="text-left"><?php echo date('h:i A', strtotime($label['booking_date'] . ' ' . $label['booking_time']));?></td> 
                    <td class="text-left" colspan="3">Declared Values : <?php echo $label['commodity_invoice_value'];?></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center"><strong>Consignor</strong></td>
                    <td colspan="4" class="text-center"><strong>Consignee</strong></td>
                </tr>  
                <tr>
                    <td class="text-left">Company/Name</td>
                    <td class="text-left" colspan="3"><?php echo $label['sender_company'];?><br /><?php echo $label['sender_name'];?></td>
                    <td class="text-left">Company/Name</td>
                    <td class="text-left" colspan="3"><?php echo $label['receiver_company'];?><br /><?php echo $label['receiver_name'];?></td> 
                </tr>  
                <tr>
                    <td class="text-left">Address</td>
                    <td class="text-left" colspan="3"><?php echo $label['sender_address'];?></td>
                    <td class="text-left">Address</td>
                    <td class="text-left" colspan="3"><?php echo $label['receiver_address'];?></td> 
                </tr> 
                <tr>
                    <td class="text-left">Contact No</td>
                    <td class="text-left" colspan="3"><?php echo $label['sender_mobile'];?></td>
                    <td class="text-left">Contact No</td>
                    <td class="text-left" colspan="3"><?php echo $label['receiver_mobile'];?></td> 
                </tr> 
                <!--<tr>
                    <td class="text-left">GST</td>
                    <td class="text-left" colspan="3"><?php echo $label['awbno'];?></td>
                    <td class="text-left">GST</td>
                    <td class="text-left" colspan="3"><?php echo $label['awbno'];?></td> 
                </tr>-->
                <tr>
                    <td class="text-left">Origin</td>
                    <td class="text-left"><?php echo $label['origin_city_code'] . " - " . $label['origin_pincode'];?></td>
                    <td class="text-left">Destination</td>
                    <td class="text-left"><?php echo $label['dest_city_code']. " - " . $label['dest_pincode'];?></td> 
                    <td class="text-left">Transport Mode</td> 
                    <td class="text-left" colspan="3"><?php echo $label['service_name'];?></td> 
                </tr>
                <tr>
                    <td class="text-left">No Of Pcs</td> 
                    <td class="text-left"><?php echo $label['no_of_pieces'];?></td>
                    <td class="text-left"></td>
                    <td class="text-left"></td>
                    <td class="text-left">Actual Weight</td> 
                    <td class="text-left"><?php echo $label['weight'];?></td> 
                    <td class="text-left">Chargable Weight </td> 
                    <td class="text-left"><?php echo $label['chargable_weight'];?></td>  
                </tr>
                <tr>
                    <td class="text-left">Doc Attached</td> 
                    <td class="text-left"></td>
                    <td class="text-left">Mode of Payment</td>
                    <td class="text-left"><?php echo $label['payment_mode'];?></td>
                    <td class="text-left">Commodity Type</td> 
                    <td class="text-left"><?php echo $label['commodity_type'];?></td>  
                    <td class="text-left" colspan="2">Dimension:<?php echo $label['length'];?>x<?php echo $label['width'];?>x<?php echo $label['height'];?></td>  
                </tr>
                <tr>
                    <td class="text-left" rowspan="<?php if($label['origin_state_code'] == 'TN') echo "4"; else echo "3"; ?>" colspan="5">Description of Goods: <br /><?php echo $label['description'];?></td>
                    <td class="text-left">Freight Charges</td>
                    <td class="text-right" colspan="3"><?php echo ($label['rate']);?></td> 
                </tr>
                <?php if($label['origin_state_code'] == 'TN') {  ?>
                <tr> 
                    <td class="text-left">CGST - <?php echo ($label['tax_percentage']/2);?>%</td>
                    <td class="text-right" colspan="3"><?php echo number_format(($label['tax_amt']/2),2);?></td> 
                </tr>
                <tr> 
                    <td class="text-left">SGST - <?php echo ($label['tax_percentage']/2);?>%</td>
                    <td class="text-right" colspan="3"><?php echo number_format(($label['tax_amt']/2),2);?></td> 
                </tr>
                <?php } else {?>
                <tr> 
                    <td class="text-left">IGST - <?php echo ($label['tax_percentage']);?>%</td>
                    <td class="text-right" colspan="3"><?php echo number_format(($label['tax_amt']),2);?></td> 
                </tr>
                <?php } ?>
                <tr> 
                    <td class="text-left">Total</td>
                    <td class="text-right" colspan="3"><?php echo ($label['grand_total']);?></td> 
                </tr>
                <tr style="font-size: 10px;"> 
                    <td class="text-left">Declaration</td>
                    <td class="text-left" colspan="7">I/We here by declare that I/We have read and understood the terms and conditions.</td> 
                </tr>
                <tr>
                    <td colspan="8" style="font-size: 10px;" class="text-center">
                        <strong>General Terms and Conditions of contract for carriage of Elbex Couriers Private Limited. </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="font-size: 10px;width:50%">
                         <p><strong>Registered Office:</strong> Elbex Couriers Private Limited, 258, Avarampalayam Road, New Siddhapudur, Coimbatore - 641044.<br /> Tel: +91-422-4388573, Web: www.elbex.in</p>
                        <p>The shipment is accepted by Elbex Couriers Private Limited by its employees and agents referred to collectivity hereinafter as "ECPL" subject to the terms and conditions set out hereunder.</p>
                        <strong>1. THE WAY BILL</strong><br />
                            1.1 The ECPL Way bill is non-negotiable and the shipper acknowledges that has been prepared by the shipper pr by ECPL on behalf of the shipment by affixing his signature on the Return to Original Copy and for the delivery sheet.
                        <br /><strong>2. SHIPPER'S OBLIGATION AND ACKNOWLEDGMENT</strong><br />
                            2.1 By tendering materials of shipments via ECPL. It's deemed that the shipper agrees to the terms and conditions stated thereon.<br />
                            2.2 The shipper warrants that he is the owner or the authorized agent of the owner of the goods transported hereunder and that the shipper here by accepts ECPL terms and conditions for itself and on behalf of any other person having any interest in the shipment.<br />
                            2.3 The shipper warrants that each article in the shipment is properly described on this is Waybill and it does not contravene the provisions of the Indian Post Office Act or any other law for the time being in force and has been declared by ECPL to be unacceptable for transport as specified under Section 12 below and that the shipments properly market and addressed and packed to ensure safe handling.<br />
                            2.4 The shipper shall be solely liable for all costs and expenses (which shall without limitation include Octroi, state and local taxes and imports related to the shipments and for costs incurred either in returning the shipment lot the shipper or warehousing the shipment pending such return).<br />
                            2.5 The shipper accepts the condition that the shipment is being carried by ECPL from point of rendering only up to the address shown on this waybill and in case this shipments has to be rerouted/redirected/returned/ for any reason whatsoever, the shipper shall pay in advance all charges leveled by ECPL for such rerouting/redirection/return as per the normal schedule of ECPL also by Octrol, State, Local Taxes, Taxes, Imports etc, applicable thereon. EE will hold such shipments at Destination mentioned on the Waybill for maximum period of 10 days from the date of shipment. The reather, ECPL reserves the rights to destroy the shipment without informing the shipper and the shipper indemnities ECPL against any claim or liability.<br />
                            2.6 Packing of the material rendered for the shipment is the responsibility of the shipper, including placement of such materials inside the container, if any, supplied by ECPL, not with standing anything else in these conditions.
                        <br /><strong>3. ECPL RIGHT OF INSPECTIONS OF SHIPMENT</strong><br />
                            3.1 ECPL has the right but not the obligation to open and/or inspect the shipment<br />
                            3.2 ECPL reserves the right to refuse shipments not conforming these terms and conditions without assigning any reason whatsoever.<br />
                        <br /><strong>4.INSURANCE</strong><br />
                            4.1 White EE has developed a sophisticated tracking system for all shipments carried in the network and has experienced manpower to handle all shipments, the Shipper may, if he so desires, insure his shipments at his own costs.
                        <br /><strong>5.OCTROI</strong><br />
                            5.1 Any Octroi Sales Tax of Duties as may be applicable on this shipment will be payable by the consignee at the time of delivery of the shipment. ECPL reserves the right of lien on shipment till all its duties are paid in fill in respect of freight, octroi, taxes and other charges.
                        <br /><strong>6. CHARGEABLE WEIGHT</strong><br />
                            6.1 Every shipment shall be charged by its chargeable weight, as defined hereunder and not the actual weight. The chargeable weight shall be the higher of (a) the actual weight rounded off to the next higher half kg or one kg as per the rate category agreed to or<br />
                            (b) the volume weight similarly rounded off as in (a) above.
                            6.2 Volume weight of the shipment, in kilograms, is its gross cubic volume cubic centimeters divided by 6000
                        <br /><strong>7. LIEN GOODS SHIPPED</strong><br />
                            7.1 ECPL will have a lien on goods for all fright charge, Octroi, State and Local Taxes, advance of any kind arising out transportation hereunder, and any refuse to surrender possession of goods until such charges are paid.
                        
                        
                        
                    </td>
                    <td colspan="4" style="font-size: 10px;">
                         <strong>8. LIMITATION OF LIABILITY</strong><br />
                            8.1 without prejudice to Section 9 and Section 10, the liability of ECPL for any loss or damage to the shipment (which terms shall include all documents or parcels
                            consigned through ECPL), shall be the lowest of <br />(a) Rs.500/-or
                            <br />(b) The amount of loss or damage to the document or parcel actually sustained or
                            <br />(c) The actual value of the document or parcel as determined without regard to the commercial utility or special value to the shipper.<br />
                            i) The actual value of the document or parcel shall be ascertained by reference to the cost of preparation or replacement/reconstruction value at the time and place of shipment, but under no circumstances shall exceed Rs.500/-.<br />
                            i) The actual value of a parcel which term shall include any term of commercial value which is transported hereunder) shall be ascertained by reference to the cost by repair or replacement/resale of fair market value not exceeding the original cost of the article actually paid by shipper always within the overall limited of Rs.500/-.
                         <br /><strong>9. CONSEQUENTIAL DAMAGES EXCLUDED</strong><br />
                            9.1 ECPL SHALL NOT BE LIABLE IN ANY EVENT FOR ANY CONSEQUENTIAL OR SPECIAL DAMAGES OR OTHER DIRECT OR INDIRECT LOSS. HOWSOEVER ARISING, whether or not ECPL has knowledge that such damages might be incurred including but not limited to loss of income, profits interest, utility or loss of market.<br />
                         <strong>10. LIABILITIES NOT ASSUMED</strong><br />
                            10.1 In particular, ECPL will not be liable for an loss or damage to the shipment or a delay in picking up or delivery shipments it is.<br />
                            a) Due to acts of God, force majeure occurrence of any cause reasonably beyond the control of ECPL, or loss or damage caused through strikes, riots, political and other disturbances such as fire, accident of the vehicle carrying the goods, explosion, beyond the control of ECPL for the goods that are carried by ECPL.<br />
                             b) Caused by:<br />
                            (1) The act, fault or commission for the shipper, the consignee or any other party claiming an interest in the shipment. (including violation of any terms and conditions, thereof) or any other person.<br />
                            (II) Carriers such as Airlines or Airways not adhering to schedule for any reason what so ever.<br />
                            (III) Government officials in discharge of there officials duties, characteristics, inherent voice thereof.<br />
                            (IV) Electrical or magnetic injury, are sure or other such damaged to photographic images or recording in any form.<br />
                            10.2 The shipper indemnities ECPL against Loss, damages, penalties, action, proceedings etc that may be instituted by any Government Officials in discharge of their official duties such as Customs/Taxation/Octrol inspection.<br />
                            10.3 Not withstanding what is staled above, whilst ECPL will endeavor to exercise its best efforts to provide expeditors delivery, in accordance with its regular deliver. ECPL WILL NOT UNDER ANY CIRCUMSTANCE BE LIABLE FOR DELAY IN PICKUP TRANSPORTATION OR DELIVERY OF ANY SHIPMENTS REGARDLESS OF CAUSE OF SUCH DELAYS.<br />
                            10.4 No liability is assumed for any errors/or omissions in any information/data/which is imparted in respect of the shipment travelling under the Airway bill. <br />
                         <strong>11. CLAIMS</strong><br />
                                11.1 Any claim must be brought by the shipper and delivered in writing to the office of ECPL nearest to the location at which the shipment is accepted within 30 days of the date of such acceptance. No claim can be made against ECPL beyond this time limit.<br />
                                11.2 No claim for loss or damage will be entertained until all charges have been paid. The amount of any such claims will not be deducted from any transportation charges owed to ECPL.
                        <br /><strong>12. MATERIAL NOT ACCEPTED FOR CARRIAGE</strong><br />
                                    12.1 Except as per written agreement between shippers and ECPL. ECPL will not carry materials.<br />
                                    (a) Not permitted by the laws/rules restrictions in force and <br />
                                    (b) Any items notified by ECPL shall not be liable for any such shipment and the Shipper shall keep ECPL indemnified against all claims changes and expenses incurred by ECPL due to such Restricted/Banned/Dangerous/Prohibited items entering into the network through the Shipper.<br />
                                    12.2 A detailed list of materials not accepted for available on request.<br />
                                    NOT ALL DISPUTES & CLAIMS ARE SUBJECT TO EXCLUSIVE AND IRREVOCABLE JURISDICTION OF COURTS IN COIMBATORE ONLY.
                    </td>
                </tr>
            </table>
            
             
        </div>
    </div>
     

     
    <div class="row text-center noprint">
        <div class="col-md-12">
            <a href="<?php echo site_url('in-scan-list')?>" class="btn btn-info" >Back to In-Scan List</a> 
        </div>
        
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
