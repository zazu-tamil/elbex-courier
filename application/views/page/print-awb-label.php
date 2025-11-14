<?php
/*	echo "<pre>";
    print_r($label);
	echo "</pre>";
    */
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Elbex AWB Label</title>
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
     
    .wrapper{ 
        border:0px solid black;
        padding: 0px;
    }
    .invoice { 
        border:2px solid black;
    }
    .border-right{
         border-right:1px solid black;
    }
    .border-left{
         border-left:1px solid black;
    }
    .border-top{
         border-top:1px solid black;
    }
    
    .border-bottom{
         border-bottom:1px solid black;
    }
     
    
  </style>  
</head>
<body onload="window.print();" style="font-size: 12px;">
<div class="wrapper1" > 
        <?php
	       for($i=1;$i<= $label['no_of_pieces'];$i++){
        ?>
        <table class="table table-bordered table-condensed ">
            <tr>
                 <td class="text-center" width="50%"><img src="<?php echo base_url('asset/images/logo.png')?>" alt="elbex" width="30%"/></td>
                 <td class="text-center"> 
                 <?php if(file_exists($barcode)) { ?>
                    <img src="<?php echo base_url($barcode);?>" alt="" class="img-fluid" width="30%"/>
                 <?php } ?>
                 </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center"><h4><?php echo $label['origin_city_code'];?> <i class="fa  fa-long-arrow-right"></i> <?php echo $label['dest_city_code'];?></h4></td>
            </tr>
            <tr> 
                <td><h4>No of Pcs: <?php echo $i;?>/<?php echo $label['no_of_pieces'];?></h4></td>
                <td><h4>Weight: <?php echo $label['weight'];?>Kgs</h4><h4>Dimension: <?php echo $label['length'];?>X<?php echo $label['width'];?>X<?php echo $label['height'];?></h4></td>
            </tr>
             <tr>
                 <td>
                 <h4>Sender:<br /> 
                    <?php echo $label['sender_company'];?><br />
                    <?php echo $label['sender_name'];?><br />
                    <?php echo $label['sender_mobile'];?><br />
                    <?php echo str_replace("\n","<br>",$label['sender_address']) ;?> 
                 </h4>
                 </td>
                  <td>
                 <h4>Receiver:<br /> 
                    <?php echo $label['receiver_company'];?><br />
                    <?php echo $label['receiver_name'];?><br /> 
                    <?php echo $label['receiver_mobile'];?><br /> 
                    <?php echo str_replace("\n","<br>",$label['receiver_address']) ;?>
                 </h4>
                 </td>
            </tr> 
        </table>  
        
        <?php if(($i % 2) == 0 ) echo '<div style="page-break-after: always;"></div>'?>
        <?php } ?>
</div> 
</body>
</html>
