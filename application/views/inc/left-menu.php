<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url() ?>/asset/images/user.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('cr_user_name');?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
       
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Dashboard</li>
        <li <?php if($this->uri->segment(1, 0) === 'dash') echo 'class="active"'; ?>><a href="<?php echo site_url('dash') ?>"><i class="fa fa-circle-o"></i> Dashboard</a></li>
        <li class="header">AWB Booking</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('in-scan-entry','in-scan','in-scan-list','in-scan-edit'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Booking</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'in-scan') echo 'class="active"'; ?>><a href="<?php echo site_url('in-scan') ?>"><i class="fa fa-circle-o"></i> In Scan Entry</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'in-scan-list') echo 'class="active"'; ?>><a href="<?php echo site_url('in-scan-list') ?>"><i class="fa fa-circle-o"></i> In Scan List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'in-scan-entry') echo 'class="active"'; ?>><a href="<?php echo site_url('in-scan-entry') ?>"><i class="fa fa-circle-o"></i> EDP Entry</a></li>
            <!--<li <?php if($this->uri->segment(1, 0) === 'create-booking') echo 'class="active"'; ?>><a href="<?php echo site_url('create-booking') ?>"><i class="fa fa-circle-o"></i> EDP Entry</a></li>-->
          </ul>
        </li>
        <li class="header">Manifest</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('open-manifest','receive-manifest'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Manifest</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'generate-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('generate-manifest') ?>"><i class="fa fa-circle-o"></i> Generate Manifest</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'open-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('open-manifest') ?>"><i class="fa fa-circle-o"></i> Open Manifest</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'receive-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('receive-manifest') ?>"><i class="fa fa-circle-o"></i> Receive Manifest</a></li>
          </ul>
        </li>
        <li class="header">Delivery</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('delivery-runsheet','delivery-updatation','drs-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Delivery</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'delivery-runsheet') echo 'class="active"'; ?>><a href="<?php echo site_url('delivery-runsheet') ?>"><i class="fa fa-circle-o"></i> Delivery Runsheet</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'drs-list') echo 'class="active"'; ?>><a href="<?php echo site_url('drs-list') ?>"><i class="fa fa-circle-o"></i> DRS Print</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'delivery-updation') echo 'class="active"'; ?>><a href="<?php echo site_url('delivery-updation') ?>"><i class="fa fa-circle-o"></i> Delivery Updation</a></li>
          </ul>
        </li>
        <li class="header">AWB No Tracking</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('tracking-entry','awb-tracking'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>AWB Tracking</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li <?php if($this->uri->segment(1, 0) === 'awb-tracking') echo 'class="active"'; ?>><a href="<?php echo site_url('awb-tracking') ?>" target="_blank"><i class="fa fa-circle-o"></i> AWB No Tracking </a></li>
             <li <?php if($this->uri->segment(1, 0) === 'tracking-entry') echo 'class="active"'; ?>><a href="<?php echo site_url('tracking-entry') ?>"><i class="fa fa-circle-o"></i> Tracking Status Entry</a></li>
          </ul>
        </li>
        <li class="header">Invoice</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('customer-invoice-generate',))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Customer Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li <?php if($this->uri->segment(1, 0) === 'customer-invoice-generate') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-invoice-generate') ?>"><i class="fa fa-circle-o"></i> Customer Invoice Generate</a></li>
             <li <?php if($this->uri->segment(1, 0) === 'customer-invoice-list') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-invoice-list') ?>"><i class="fa fa-circle-o"></i> Customer Invoice List</a></li>
          </ul>
        </li>
        <?php if($this->session->userdata('cr_is_admin') == '1') {  ?>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('ts-invoice-generate','ts-invoice-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>TS Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li <?php if($this->uri->segment(1, 0) === 'ts-invoice-generate') echo 'class="active"'; ?>><a href="<?php echo site_url('ts-invoice-generate') ?>"><i class="fa fa-circle-o"></i> TS Invoice Generate</a></li>
             <li <?php if($this->uri->segment(1, 0) === 'ts-invoice-list') echo 'class="active"'; ?>><a href="<?php echo site_url('ts-invoice-list') ?>"><i class="fa fa-circle-o"></i> TS Invoice List</a></li>
          </ul>
        </li>
         <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('ts-invoice-generate',))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Stationary Invoice</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
              <li <?php if($this->uri->segment(1, 0) === 'stationery-invoice-list') echo 'class="active"'; ?>><a href="<?php echo site_url('stationery-invoice-list') ?>"><i class="fa fa-circle-o"></i> Stationery Invoice List</a></li>
          </ul>
        </li>
        <?php }  ?> 
        <li class="header">Reports</li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('customer-booking-report','city-wise-booking-summary','franchise-booking-report','franchise-NDR-report','manifest-report','drs-report','inbound-consignment-report','servicable-pincode-report' ))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'customer-booking-report') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-booking-report') ?>"><i class="fa fa-file-text-o"></i> Customer Wise Consignment</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-booking-report') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-booking-report') ?>"><i class="fa fa-file-text-o"></i> Franchise Wise Consignment[Out-Bound]</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-NDR-report') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-NDR-report') ?>"><i class="fa fa-file-text-o"></i> NDR Report</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'city-wise-booking-summary') echo 'class="active"'; ?>><a href="<?php echo site_url('city-wise-booking-summary') ?>"><i class="fa fa-file-text-o"></i> City Wise Summary </a></li>
            <li <?php if($this->uri->segment(1, 0) === 'manifest-report') echo 'class="active"'; ?>><a href="<?php echo site_url('manifest-report') ?>"><i class="fa fa-file-text-o"></i> Manifest Report </a></li>
            <li <?php if($this->uri->segment(1, 0) === 'drs-report') echo 'class="active"'; ?>><a href="<?php echo site_url('drs-report') ?>"><i class="fa fa-file-text-o"></i> DRS Report </a></li>
            <li <?php if($this->uri->segment(1, 0) === 'inbound-consignment-report') echo 'class="active"'; ?>><a href="<?php echo site_url('inbound-consignment-report') ?>"><i class="fa fa-file-text-o"></i>In-bound Consignment </a></li>
            <li <?php if($this->uri->segment(1, 0) === 'servicable-pincode-report') echo 'class="active"'; ?>><a href="<?php echo site_url('servicable-pincode-report') ?>"><i class="fa fa-file-text-o"></i>Servicable Pincode With Franchis Details </a></li>
            
          </ul>
        </li>
        <!--
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('b2h-manifest','b2h-manifest-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Branch to HUB</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'b2h-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('b2h-manifest') ?>"><i class="fa fa-circle-o"></i> B2H Manifest</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'b2h-manifest-list') echo 'class="active"'; ?>><a href="<?php echo site_url('b2h-manifest-list') ?>"><i class="fa fa-circle-o"></i> B2H Manifest List</a></li>
            
          </ul>
        </li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('h2h-manifest','h2h-manifest-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>HUB to HUB</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'h2h-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('h2h-manifest') ?>"><i class="fa fa-circle-o"></i> H2H Manifest</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'h2h-manifest-list') echo 'class="active"'; ?>><a href="<?php echo site_url('h2h-manifest-list') ?>"><i class="fa fa-circle-o"></i> H2H Manifest List</a></li>
            
          </ul>
        </li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('h2b-manifest','h2b-manifest-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>HUB to Branch</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'h2b-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('h2b-manifest') ?>"><i class="fa fa-circle-o"></i> H2B Manifest</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'h2b-manifest-list') echo 'class="active"'; ?>><a href="<?php echo site_url('h2b-manifest-list') ?>"><i class="fa fa-circle-o"></i> H2B Manifest List</a></li>
            
          </ul>
        </li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('b2b-manifest','b2b-manifest-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-book"></i> <span>Branch to Branch</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'b2b-manifest') echo 'class="active"'; ?>><a href="<?php echo site_url('b2b-manifest') ?>"><i class="fa fa-circle-o"></i> B2B Manifest</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'b2b-manifest-list') echo 'class="active"'; ?>><a href="<?php echo site_url('b2b-manifest-list') ?>"><i class="fa fa-circle-o"></i> B2B Manifest List</a></li>
            
          </ul>
        </li> -->
        
        <li class="header">Masters</li>
        <?php if($this->session->userdata('cr_is_admin') == '1') {  ?>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('co-loader-list','staff-doc-upload-list','stationery-item-list','doc-upload-type-list','tracking-status-list','ndr-list','pincode-list','servicable-pincode-list','country-list','state-list','city-list','domestic-rate','carrier-list','service-list','package-type-list','product-type-list','customer-type-list','commodity-type-list','hub-branch-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-cubes"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu"> 
            <li <?php if($this->uri->segment(1, 0) === 'pincode-list') echo 'class="active"'; ?>><a href="<?php echo site_url('pincode-list') ?>"><i class="fa fa-circle-o"></i> Mst.Pincode List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'servicable-pincode-list') echo 'class="active"'; ?>><a href="<?php echo site_url('servicable-pincode-list') ?>"><i class="fa fa-circle-o"></i> Servicable Pincode List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'country-list') echo 'class="active"'; ?>><a href="<?php echo site_url('country-list') ?>"><i class="fa fa-circle-o"></i> Country List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'state-list') echo 'class="active"'; ?>><a href="<?php echo site_url('state-list') ?>"><i class="fa fa-circle-o"></i> State List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'city-list') echo 'class="active"'; ?>><a href="<?php echo site_url('city-list') ?>"><i class="fa fa-circle-o"></i> City List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'hub-branch-list') echo 'class="active"'; ?>><a href="<?php echo site_url('hub-branch-list') ?>"><i class="fa fa-circle-o"></i> HUB/Branch Code List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'domestic-rate') echo 'class="active"'; ?>><a href="<?php echo site_url('domestic-rate') ?>"><i class="fa fa-rupee"></i> MST Domestic Rate</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'transhipment-rate') echo 'class="active"'; ?>><a href="<?php echo site_url('transhipment-rate') ?>"><i class="fa fa-rupee"></i> Transhipment Rate</a></li>
            <hr /> 
            <li <?php if($this->uri->segment(1, 0) === 'ndr-list') echo 'class="active"'; ?>><a href="<?php echo site_url('ndr-list') ?>"><i class="fa fa-circle-o"></i> NDR List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'carrier-list') echo 'class="active"'; ?>><a href="<?php echo site_url('carrier-list') ?>"><i class="fa fa-circle-o"></i> Carrier List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'co-loader-list') echo 'class="active"'; ?>><a href="<?php echo site_url('co-loader-list') ?>"><i class="fa fa-circle-o"></i> Co-Loader List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'service-list') echo 'class="active"'; ?>><a href="<?php echo site_url('service-list') ?>"><i class="fa fa-circle-o"></i> Service List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'package-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('package-type-list') ?>"><i class="fa fa-circle-o"></i> Package Type List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'product-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('product-type-list') ?>"><i class="fa fa-circle-o"></i> Product Type List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'commodity-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('commodity-type-list') ?>"><i class="fa fa-circle-o"></i> Commodity Type List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'customer-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-type-list') ?>"><i class="fa fa-circle-o"></i> Customer Type List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'tracking-status-list') echo 'class="active"'; ?>><a href="<?php echo site_url('tracking-status-list') ?>"><i class="fa fa-circle-o"></i> Tracking Status List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'doc-upload-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('doc-upload-type-list') ?>"><i class="fa fa-circle-o"></i> Doc Upload Type List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'stationery-item-list') echo 'class="active"'; ?>><a href="<?php echo site_url('stationery-item-list') ?>"><i class="fa fa-circle-o"></i> Stationery Item List</a></li>
            <hr /> 
            <li <?php if($this->uri->segment(1, 0) === 'staff-doc-upload-list') echo 'class="active"'; ?>><a href="<?php echo site_url('staff-doc-upload-list') ?>"><i class="fa fa-circle-o"></i> Staff Doc Upload</a></li>
          </ul>
        </li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('franchise-type-list','franchise-list','franchise-domestic-rate','franchise-doc-upload-list','franchise-transhipment-rate-v2','franchise-awbill-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-table"></i> <span>Franchises</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'franchise-type-list') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-type-list') ?>"><i class="fa fa-circle-o"></i> Franchise Type List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-list') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-list') ?>"><i class="fa fa-circle-o"></i> Franchise List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-awbill-list') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-awbill-list') ?>"><i class="fa fa-circle-o"></i> Franchise AWBill List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-doc-upload-list') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-doc-upload-list') ?>"><i class="fa fa-circle-o"></i> Franchise Doc Upload List</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-domestic-rate') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-domestic-rate') ?>"><i class="fa fa-circle-o"></i> Franchise Domestic Rate</a></li>
            <li <?php if($this->uri->segment(1, 0) === 'franchise-transhipment-rate-v2') echo 'class="active"'; ?>><a href="<?php echo site_url('franchise-transhipment-rate-v2') ?>"><i class="fa fa-rupee"></i> Franchise TS Rate</a></li>
          </ul>
        </li>
        <?php } ?>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('agent-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-table"></i> <span>Agents</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'agent-list') echo 'class="active"'; ?>><a href="<?php echo site_url('agent-list') ?>"><i class="fa fa-circle-o"></i> Agent List</a></li>
          </ul>
        </li>
        <li class="treeview <?php if(in_array($this->uri->segment(1, 0),array('customer-list'))) echo 'active'; ?>">
          <a href="#">
            <i class="fa fa-table"></i> <span>Customer</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if($this->uri->segment(1, 0) === 'customer-list') echo 'class="active"'; ?>><a href="<?php echo site_url('customer-list') ?>"><i class="fa fa-circle-o"></i> Customer List</a></li>
          </ul>
        </li>
        <li><a href="<?php echo site_url('logout') ?>" class="text-fuchsia"><i class="fa fa-sign-out"></i> Logout</a></li> 
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  