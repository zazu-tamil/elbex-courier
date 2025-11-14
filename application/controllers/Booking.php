<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

 
	public function index()
	{
		 
	}
    
    
    private function get_tracking_status_name($tracking_status_id)
    {
        
          $query = $this->db->query("  
                select 
                a.tracking_status
                from crit_tracking_status_info as a
                where a.tracking_status_id = '". $tracking_status_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row['tracking_status'];      
            }  
          
       return $rec_list;
    }
     
    public function create_booking()
	{
	     if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'create-booking.inc';  
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active' 
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.carrier_id,                
                a.carrier_name             
                from crit_carrier_info as a  
                where status = 'Active' 
                order by a.carrier_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['carrier_opt'][$row['carrier_id']] = $row['carrier_name'] ;     
        }
        
        $sql = "
                select 
                a.service_id,                
                a.service_name             
                from crit_service_info as a  
                where status = 'Active' 
                order by a.service_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['service_opt'][$row['service_id']] = $row['service_name'] ;     
        }
        
        $sql = "
                select 
                a.package_type_id,                
                a.package_type_name             
                from crit_package_type_info as a  
                where status = 'Active' 
                order by a.package_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['package_type_opt'][$row['package_type_id']] = $row['package_type_name'] ;     
        }
        
        $sql = "
                select 
                a.product_type_id,                
                a.product_type_name             
                from crit_product_type_info as a  
                where status = 'Active' 
                order by a.product_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['product_type_opt'][$row['product_type_id']] = $row['product_type_name'] ;     
        }
        
        $sql = "
                select                 
                a.commodity_type_name             
                from crit_commodity_type_info as a  
                where status = 'Active' 
                order by a.commodity_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['commodity_type_opt'][$row['commodity_type_name']] = $row['commodity_type_name'] ;     
        }
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
        
           
		 $this->load->view('page/create-booking',$data); 
	}
    
    public function in_scan()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
        
        $this->db->query("update `crit_booking_info` set awbno = trim(awbno) WHERE `awbno` like ' %'");
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if(($this->input->post('mode') == 'Add') && ($this->input->post('btn_inscan') == 'Single'))
        {
            $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => date('H:i:s' , strtotime($this->input->post('booking_time'))),
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s') , 
                        'status' => $this->get_tracking_status_name('1')                                              
                );                
            $this->db->insert('crit_booking_info', $ins);
          
            $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'tracking_status' => $this->get_tracking_status_name('1') ,                          
                        'city_code' => '0' ,                          
                        'status_date' => $this->input->post('booking_date') ,                          
                        'status_time' => date('H:i:s' , strtotime($this->input->post('booking_time'))),                          
                        'remarks' => '', 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
             $this->db->insert('crit_awb_tracking_info', $ins); 
          
          redirect('in-scan'); 
          //print_r($ins);
          //echo date('H:i:s' , strtotime($this->input->post('booking_time')));
        }
        
        if(($this->input->post('mode') == 'Add') && ($this->input->post('btn_inscan') == 'Multiple'))
        {
            $awbs = explode(',',$this->input->post('awbno'));
            foreach($awbs as $k => $awbno) {
                $ins  = array(
                        'awbno' => str_replace(array("\r", "\n"), '', $awbno),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => date('H:i:s' , strtotime($this->input->post('booking_time'))),
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s') , 
                        'status' => $this->get_tracking_status_name('1'),                                              
                );                
                $this->db->insert('crit_booking_info', $ins);
                
                
                $ins = array(
                        'awbno' => str_replace(array("\r", "\n"), '', $awbno),
                        'tracking_status' => $this->get_tracking_status_name('1') ,                          
                        'city_code' => 0  ,                          
                        'status_date' => $this->input->post('booking_date') ,                          
                        'status_time' => date('H:i:s' , strtotime($this->input->post('booking_time'))),                          
                        'remarks' => '', 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
                $this->db->insert('crit_awb_tracking_info', $ins); 
              /*echo "<pre>";
              print_r($ins);
              echo "</pre>";*/
          }
         
          redirect('in-scan'); 
           
        }
        
        $data['js'] = 'in-scan.inc';  
        $this->load->view('page/in-scan',$data); 
    } 
    
    
    public function in_scan_entry()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
        
        $this->db->query("update `crit_booking_info` set awbno = trim(awbno) WHERE `awbno` like ' %'");
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'Add')
        {
           $code = $this->input->post('awbno');
           
           if(!file_exists('barcodes/'.$code.'.png')){ 
            //load library
            $this->load->library('zend');
            //load in folder Zend
            $this->zend->load('Zend/Barcode');
            //generate barcode
            $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
            imagepng($imageResource, 'barcodes/'.$code.'.png');
            
            }
           
           
            $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => $this->input->post('booking_time'),
                        'origin_pincode' => $this->input->post('origin_pincode'),
                        'origin_state_code' => $this->input->post('origin_state_code'),
                        'origin_city_code' => $this->input->post('origin_city_code'),                       
                        'dest_pincode' => $this->input->post('dest_pincode'),                       
                        'dest_state_code' => $this->input->post('dest_state_code'),                       
                        'dest_city_code' => $this->input->post('dest_city_code') ,
                        'no_of_pieces' => $this->input->post('no_of_pieces') ,
                        'weight' => $this->input->post('weight') ,
                        'length' => $this->input->post('length') ,
                        'width' => $this->input->post('width') ,
                        'height' => $this->input->post('height') ,
                        'chargable_opt' => $this->input->post('chargable_opt') ,
                        'chargable_weight' => $this->input->post('chargable_weight') ,
                        'consignor_code' => $this->input->post('consignor_code') ,
                        'consignor_id' => $this->input->post('consignor_id') ,
                        'sender_company' => $this->input->post('sender_company') ,
                        'sender_name' => $this->input->post('sender_name') ,
                        'sender_mobile' => $this->input->post('sender_mobile') ,
                        'sender_address' => $this->input->post('sender_address') ,
                        //'sender_state_code' => $this->input->post('sender_state_code') ,
                        'consignee_code' => $this->input->post('consignee_code') ,
                        'consignee_id' => $this->input->post('consignee_id'),
                        'receiver_company' => $this->input->post('receiver_company') ,
                        'receiver_name' => $this->input->post('receiver_name') ,
                        'receiver_mobile' => $this->input->post('receiver_mobile') ,
                        'receiver_address' => $this->input->post('receiver_address') ,
                        'carrier_id' => $this->input->post('carrier_id'),
                        'service_id' => $this->input->post('service_id'),
                        'package_type_id' => $this->input->post('package_type_id'),
                        'product_type_id' => $this->input->post('product_type_id'),
                        'to_pay' => $this->input->post('to_pay'),
                        'cod' => $this->input->post('cod'),
                        'cod_amount' => $this->input->post('cod_amount'),
                        'commodity_type' => $this->input->post('commodity_type'),
                        'commodity_invoice_value' => $this->input->post('commodity_invoice_value'),
                        'description' => $this->input->post('description'),
                        'is_manual_rate' => $this->input->post('is_manual_rate'),
                        'rate' => $this->input->post('rate'),
                        'cod_charges' => $this->input->post('cod_charges'),
                        'fod_charges' => $this->input->post('fod_charges'),
                        'fov_charges' => $this->input->post('fov_charges'),
                        'fuel_charges' => $this->input->post('fuel_charges'),
                        'oda_charges' => $this->input->post('oda_charges'),
                        'sub_total' => $this->input->post('sub_total'),
                        'tax_percentage' => $this->input->post('tax_percentage'),
                        'tax_amt' => $this->input->post('tax_amt'),
                        'grand_total' => $this->input->post('grand_total'),
                        'payment_mode' => $this->input->post('payment_mode'),
                        'ewaybill_no' => $this->input->post('ewaybill_no'),
                        'franchise_id' => $this->session->userdata('cr_franchise_id'),                          
                        'created_by' => $this->session->userdata('cr_user_id'),                          
                        'created_datetime' => date('Y-m-d H:i:s') , 
                        'status' => $this->get_tracking_status_name('1'),                                             
                        'status_city_code' => $this->input->post('origin_city_code')                                              
                );                
          $this->db->insert('crit_booking_info', $ins);
          
          
            $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'tracking_status' => $this->get_tracking_status_name('1') ,                          
                        'city_code' => $this->input->post('origin_city_code')  ,                          
                        'status_date' => $this->input->post('booking_date')  ,                          
                        'status_time' => $this->input->post('booking_time'),                          
                        'remarks' => '', 
                        'created_by' =>  $this->session->userdata('cr_user_id') ,
                        'created_datetime' => date('Y-m-d H:i:s') 
                        );
             $this->db->insert('crit_awb_tracking_info', $ins);   
             
          $this->session->set_userdata(array('booked_success' => 'Successfully Booked'));   
          
          redirect('in-scan-entry');   
          
                 
        }
        	    
        $data['js'] = 'in-scan.inc';  
        
        if($this->session->userdata('booked_success')!= '')
        {
            $data['booked_success'] = $this->session->userdata('booked_success');
            $this->session->set_userdata(array('booked_success' => ''));
        }
        
       //$data['booked_success'] = 'Successfully Booked';
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active' 
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.carrier_id,                
                a.carrier_name             
                from crit_carrier_info as a  
                where status = 'Active' 
                order by a.carrier_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['carrier_opt'][$row['carrier_id']] = $row['carrier_name'] ;     
        }
        
        $sql = "
                select 
                a.service_id,                
                a.service_name             
                from crit_service_info as a  
                where status = 'Active' 
                order by a.service_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['service_opt'][$row['service_id']] = $row['service_name'] ;     
        }
        
        $sql = "
                select 
                a.package_type_id,                
                a.package_type_name             
                from crit_package_type_info as a  
                where status = 'Active' 
                order by a.package_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['package_type_opt'][$row['package_type_id']] = $row['package_type_name'] ;     
        }
        
        $sql = "
                select 
                a.product_type_id,                
                a.product_type_name             
                from crit_product_type_info as a  
                where status = 'Active' 
                order by a.product_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['product_type_opt'][$row['product_type_id']] = $row['product_type_name'] ;     
        }
        
        $sql = "
                select                 
                a.commodity_type_name             
                from crit_commodity_type_info as a  
                where status = 'Active' 
                order by a.commodity_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['commodity_type_opt'][$row['commodity_type_name']] = $row['commodity_type_name'] ;     
        }
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
           
		 $this->load->view('page/in-scan-entry',$data); 
	}
    
    public function in_scan_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*
        if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } 
        */
        
        if($this->input->post('mode') == 'Add')
        {
            
            $booking_id = $this->input->post('booking_id');
            
            $config['upload_path'] = 'booking-doc/';
            $config['file_name'] = $booking_id. "_". date('YmdHis');
    		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
            
            $this->load->library('upload', $config); 
            
            
            if ($this->upload->do_upload('doc_upload_path'))
            {
                $file_array = $this->upload->data();	
                //$image_path	= 'booking-doc/'. $booking_id. "_". date('YmdHis') . $file_array['file_name']; 
                $image_path	= 'booking-doc/'. $file_array['file_name']; 
           
            }
            else
            {
                 $image_path = '';    
            }
            
            $ins = array(
                    'booking_id' => $this->input->post('booking_id'),
                    'doc_upload_type' => $this->input->post('doc_upload_type'),
                    'doc_upload_path' => $image_path,
                    'status' => 'Active' ,                          
            );
            
            $this->db->insert('crit_booking_doc_upload_info', $ins); 
            redirect('in-scan-list');
        }
        
                
        
        	    
        $data['js'] = 'in-scan.inc';  
       if(isset($_POST['srch_awbno']) && $_POST['srch_awbno'] != '') {
           $data['srch_awbno'] = $srch_awbno = $this->input->post('srch_awbno');  
           $data['srch_from_date'] = $srch_from_date = '';
           $data['srch_to_date'] = $srch_to_date = ''; 
       }
       else {  
        
           if(isset($_POST['srch_from_date'])) {
               $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
               $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
               $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
               $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date')); 
               $data['srch_awbno'] = $srch_awbno = '';
           }
           elseif($this->session->userdata('srch_from_date')){
               $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
               $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ; 
               $data['srch_awbno'] = $srch_awbno = '';
           } else {
                $data['srch_from_date'] = $srch_from_date = date('Y-m-d');
                $data['srch_to_date'] = $srch_to_date = date('Y-m-d');
                $data['srch_awbno'] = $srch_awbno = ''; 
                
           } 
           
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date)  ){
        $where = " a.booking_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        
        $data['submit_flg'] = true;
         
       } else if(!empty($srch_awbno)){
        $where = " a.awbno = '" . $srch_awbno . "'";  
        $data['submit_flg'] = true;
         
       } else {
        $where = ' 1 ';
       }  
        
         
        
        $this->load->library('pagination');
        
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where($where); 
        if($this->session->userdata('cr_is_admin') != '1') {
            $this->db->where(" exists ( select w.user_id from crit_franchise_info as q left join crit_user_info as w on w.franchise_id = q.franchise_id where w.user_id = a.created_by and  q.franchise_id = '". $this->session->userdata('cr_franchise_id') ."')");
        }
        
        $this->db->from('crit_booking_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('in-scan-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] =  "Prev";
        $config['next_link'] =  "Next";
        $this->pagination->initialize($config);   
        
        $sql = "
                select 
                a.booking_id,
                a.awbno,                
                a.booking_date,                
                a.booking_time,                
                a.origin_pincode,                
                a.origin_state_code,                
                a.origin_city_code,                
                a.dest_pincode,                
                a.dest_state_code,                
                a.dest_city_code,                
                a.status,
                a.status_city_code,
                b.branch_code
                from crit_booking_info as a 
                left join crit_franchise_info as b on b.franchise_id = a.franchise_id
                where a.status != 'Delete' and $where ";
           if($this->session->userdata('cr_is_admin') != '1') 
                $sql .= " and exists ( select w.user_id from crit_franchise_info as q left join crit_user_info as w on w.franchise_id = q.franchise_id where w.user_id = a.created_by and  q.franchise_id = '". $this->session->userdata('cr_franchise_id') ."')";     
           
            $sql .= " order by a.booking_date desc, a.booking_time desc , a.awbno desc 
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $sql = "
                select 
                a.doc_upload_type_name    
                from crit_doc_upload_type_info as a  
                where status = 'Active' 
                order by a.doc_upload_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['doc_upload_type_opt'][$row['doc_upload_type_name']] = $row['doc_upload_type_name'];     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/in-scan-list',$data); 
	} 
    
    public function in_scan_edit($booking_id)
	{
	     if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                        'awbno' => $this->input->post('awbno'),
                        'booking_date' => $this->input->post('booking_date'),
                        'booking_time' => $this->input->post('booking_time'),
                        'customer_ref_no' => $this->input->post('customer_ref_no'),
                        'origin_pincode' => $this->input->post('origin_pincode'),
                        'origin_state_code' => $this->input->post('origin_state_code'),
                        'origin_city_code' => $this->input->post('origin_city_code'),                       
                        'dest_pincode' => $this->input->post('dest_pincode'),                       
                        'dest_state_code' => $this->input->post('dest_state_code'),                       
                        'dest_city_code' => $this->input->post('dest_city_code') ,
                        'no_of_pieces' => $this->input->post('no_of_pieces') ,
                        'weight' => $this->input->post('weight') ,
                        'length' => $this->input->post('length') ,
                        'width' => $this->input->post('width') ,
                        'height' => $this->input->post('height') ,
                        'chargable_opt' => $this->input->post('chargable_opt') ,
                        'chargable_weight' => $this->input->post('chargable_weight') ,
                        'consignor_code' => $this->input->post('consignor_code') ,
                        'consignor_id' => $this->input->post('consignor_id') ,
                        'sender_company' => $this->input->post('sender_company') ,
                        'sender_name' => $this->input->post('sender_name') ,
                        'sender_mobile' => $this->input->post('sender_mobile') ,
                        'sender_address' => $this->input->post('sender_address') ,
                        //'sender_state_code' => $this->input->post('sender_state_code') ,
                        
                        'consignee_code' => $this->input->post('consignee_code') ,
                        'consignee_id' => $this->input->post('consignee_id'),
                        'receiver_company' => $this->input->post('receiver_company') ,
                        'receiver_name' => $this->input->post('receiver_name') ,
                        'receiver_mobile' => $this->input->post('receiver_mobile') ,
                        'receiver_address' => $this->input->post('receiver_address') ,
                        
                        'carrier_id' => $this->input->post('carrier_id'),
                        'service_id' => $this->input->post('service_id'),
                        'package_type_id' => $this->input->post('package_type_id'),
                        'product_type_id' => $this->input->post('product_type_id'),
                        'to_pay' => $this->input->post('to_pay'),
                        'cod' => $this->input->post('cod'),
                        'cod_amount' => $this->input->post('cod_amount'),
                        'commodity_type' => $this->input->post('commodity_type'),
                        'commodity_invoice_value' => $this->input->post('commodity_invoice_value'),
                        'description' => $this->input->post('description'),
                        'rate' => $this->input->post('rate'),
                        'cod_charges' => $this->input->post('cod_charges'),
                        'fod_charges' => $this->input->post('fod_charges'),
                        'fov_charges' => $this->input->post('fov_charges'),
                        'fuel_charges' => $this->input->post('fuel_charges'),
                        'oda_charges' => $this->input->post('oda_charges'),
                        'sub_total' => $this->input->post('sub_total'),
                        'tax_percentage' => $this->input->post('tax_percentage'),
                        'tax_amt' => $this->input->post('tax_amt'),
                        'grand_total' => $this->input->post('grand_total'),
                        'payment_mode' => $this->input->post('payment_mode'),
                        'ewaybill_no' => $this->input->post('ewaybill_no'),
                        'status_city_code' => $this->input->post('origin_city_code'),
                        //'created_by' => $this->session->userdata('cr_user_id'),                          
                        //'created_datetime' => date('Y-m-d H:i:s') , 
                        //'status' => 'Booked'                                              
                );   
          
          $this->db->where('booking_id', $this->input->post('booking_id'));             
          $this->db->update('crit_booking_info', $upd);
          
          redirect('in-scan-list');   
          
                 
        }
        	    
        $data['js'] = 'in-scan-edit.inc';  
        
        $sql = "
                select 
                a.state_name,                
                a.state_code             
                from crit_states_info as a  
                where status = 'Active' 
                order by a.state_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
        }
        
        
        
        
        $sql = "
                select 
                a.carrier_id,                
                a.carrier_name             
                from crit_carrier_info as a  
                where status = 'Active' 
                order by a.carrier_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['carrier_opt'][$row['carrier_id']] = $row['carrier_name'] ;     
        }
        
        $sql = "
                select 
                a.service_id,                
                a.service_name             
                from crit_service_info as a  
                where status = 'Active' 
                order by a.service_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['service_opt'][$row['service_id']] = $row['service_name'] ;     
        }
        
        $sql = "
                select 
                a.package_type_id,                
                a.package_type_name             
                from crit_package_type_info as a  
                where status = 'Active' 
                order by a.package_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['package_type_opt'][$row['package_type_id']] = $row['package_type_name'] ;     
        }
        
        $sql = "
                select 
                a.product_type_id,                
                a.product_type_name             
                from crit_product_type_info as a  
                where status = 'Active' 
                order by a.product_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['product_type_opt'][$row['product_type_id']] = $row['product_type_name'] ;     
        }
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
        
        $data['customer_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
        
        $sql = "
                select                 
                a.commodity_type_name             
                from crit_commodity_type_info as a  
                where status = 'Active' 
                order by a.commodity_type_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['commodity_type_opt'][$row['commodity_type_name']] = $row['commodity_type_name'] ;     
        }
        
        
        $sql = "
                select 
                a.booking_id,
                a.awbno,                
                a.booking_date, 
                TIME_FORMAT(a.booking_time,'%h:%i %p') as booking_time,  
                a.customer_ref_no,
                a.origin_pincode,                
                a.origin_state_code,                
                a.origin_city_code,                
                a.dest_pincode,                
                a.dest_state_code,                
                a.dest_city_code,                
                a.status,
                a.no_of_pieces, 
                a.weight, 
                a.length, 
                a.width, 
                a.height, 
                consignor_code, 
                consignor_id, 
                sender_company, 
                sender_name, 
                sender_mobile, 
                sender_address, 
                sender_state_code, 
                sender_city_code, 
                sender_pincode, 
                consignee_code, 
                consignee_id, 
                receiver_company, 
                receiver_name, 
                receiver_mobile, 
                receiver_address, 
                receiver_state_code, 
                receiver_city_code, 
                receiver_pincode, 
                carrier_id, 
                service_id, 
                package_type_id, 
                product_type_id, 
                to_pay, 
                cod, 
                cod_amount, 
                commodity_type, 
                commodity_invoice_value, 
                description, 
                is_manual_rate,
                rate, 
                cod_charges, 
                fov_charges, 
                fod_charges, 
                fuel_charges, 
                oda_charges, 
                sub_total, 
                tax_percentage, 
                tax_amt, 
                grand_total ,
                a.payment_mode,
                chargable_opt,
                chargable_weight,
                status,
                ewaybill_no
                from crit_booking_info as a 
                where status != 'Delete' and a.booking_id = '". $booking_id."'
                order by a.awbno desc 
                            
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
        
        $cnt = $query->num_rows();
        if($cnt == 0){
            redirect('in-scan-list');
        }
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_edit'] = $row;     
        }
        
        
        $sql = "
                select 
                a.city_name,
                a.city_code 
                from crit_city_info as a
                where a.state_code = '". $data['record_edit']['origin_state_code'] ."'
                and a.`status` = 'Active' 
                order by a.city_name asc
        ";
        
        $query = $this->db->query($sql);
        
        $data['origin_city_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['origin_city_opt'][$row['city_code']] = $row['city_name']. ' [ ' . $row['city_code'] . ' ]';     
        }
        
        $sql = "
                select 
                a.city_name,
                a.city_code 
                from crit_city_info as a
                where a.state_code = '". $data['record_edit']['dest_state_code'] ."'
                and a.`status` = 'Active' 
                order by a.city_name asc
        ";
        
        $query = $this->db->query($sql);
        
        $data['dest_city_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['dest_city_opt'][$row['city_code']] = $row['city_name']. ' [ ' . $row['city_code'] . ' ]';     
        }
        
        
        
           
		 $this->load->view('page/in-scan-edit',$data); 
	}
    
    public function open_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        $data['submit_flg'] = false;
        
       /* if($this->input->post('btn_inscan') == 'Open Manifest')
        {
           $ins = array(
                        'manifest_no' => 000,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                       // 'co_loader_id' => $this->input->post('co_loader_id'),                          
                       // 'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                       // 'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $this->input->post('awbno') ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')  
                        );
           $this->db->insert('crit_manifest_info', $ins);     
           
           //print_r($ins);           
        }*/
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {                  
                foreach($ids as $j => $booking_id) {
                    $upd  = array(
                            'manifest_no' => $this->input->post('manifest_no'),
                            'manifest_date' => $this->input->post('manifest_date')  ,                          
                            'from_city_code' => $this->input->post('from_city_code')  ,                          
                            'to_city_code' => $this->input->post('to_city_code'),                          
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks'),  
                            'm_status' => 'Open Manifest',  
                            'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                    );
                    $this->db->where('awbno' , $booking_id);
                    $this->db->update('crit_manifest_info', $upd); 
                    
                    $ins = array(
                        'awbno' => $booking_id,
                        'tracking_status' => $this->get_tracking_status_name('2') ,                          
                        'city_code' => $this->input->post('from_city_code')  ,                          
                        'status_date' => $this->input->post('manifest_date')  ,                          
                        'status_time' => date('H:i:s'),                          
                        'remarks' => $this->input->post('from_city_code') . ' to ' . $this->input->post('to_city_code') . '[ ' . $this->input->post('from_type') .' ]', 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
                    $this->db->insert('crit_awb_tracking_info', $ins);
                    
                    
                } 
                         
                $this->db->where_in('awbno', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => $this->get_tracking_status_name('2'), 'status_city_code' => $this->input->post('from_city_code')));
                
                 
            }
            redirect('open-manifest');  
        } 
        
        if($this->input->post('from_city_code') != '' && $this->input->post('to_city_code') != '')
        {
             $data['submit_flg'] = true;
           
                $this->db->select('(ifnull(max(manifest_no),0) + 1) as manifest_no');
                $query = $this->db->get('crit_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $data['manifest_no'] = $row->manifest_no;
                }  
           
            // (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('to_city_code') ."')  and
            
            //and c.manifest_type = '". $this->input->post('manifest_type') ."' 
            
              $sql = "
                select 
                    c.manifest_id,
                    c.manifest_no,
                    c.manifest_date,
                    a.booking_id,
                    c.co_loader_id,
                    d.co_loader_name,
                    c.co_loader_awb_no,
                    c.co_loader_remarks,
                    a.awbno,
                    a.origin_state_code,
                    a.origin_city_code,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from  crit_manifest_info as c  
                    left join crit_booking_info as a on c.awbno = a.awbno
                    left join crit_co_loader_info as d on d.co_loader_id = c.co_loader_id
                    where c.from_city_code = '". $this->input->post('from_city_code') ."' 
                    and c.to_city_code = '". $this->input->post('to_city_code') ."' 
                    and c.manifest_date = '". $this->input->post('manifest_date') ."' 
                    and a.status != 'Delete' and c.m_status = 'Open Manifest'  
                    order by c.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
            
            
            $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = '". $this->input->post('from_type') ."'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['from_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }
            
            $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = '". $this->input->post('to_type') ."'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['to_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }
            
            
        } else {
            
            $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = 'HUB'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['from_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]'); 
                $data['to_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }
        }
        
         
        
        
       /* $sql = "
                select 
                c.state_name as state,
                a.state_code , 
                a.branch_code ,
                a.area
                from crit_servicable_pincode_info  as a
                left join crit_states_info as c on c.state_code = a.state_code
                where a.`status` = 'Active'
                group by a.state_code , a.branch_code
                order by a.state_code , a.branch_code              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state']][$row['branch_code']] =  ( $row['area']. ' [ ' . $row['branch_code'] . ' ]');     
        }
        */
        
        
        /*$sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        */
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        
        $this->load->view('page/open-manifest',$data); 
    } 
    
    
    public function generate_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        $data['submit_flg'] = false;
        
       /* if($this->input->post('btn_inscan') == 'Open Manifest')
        {
           $ins = array(
                        'manifest_no' => 000,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                       // 'co_loader_id' => $this->input->post('co_loader_id'),                          
                       // 'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                       // 'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $this->input->post('awbno') ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')  
                        );
           $this->db->insert('crit_manifest_info', $ins);     
           
           //print_r($ins);           
        }*/
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {                  
                foreach($ids as $j => $booking_id) {
                    $ins  = array(
                            'manifest_no' => $this->input->post('manifest_no'),
                            'manifest_date' => $this->input->post('manifest_date')  ,   
                            'manifest_type' => 'Branch - Branch',                       
                            'from_city_code' => $this->input->post('from_city_code')  ,                          
                            'to_city_code' => $this->input->post('to_city_code'),                          
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks'), 
                            'awbno' =>  $booking_id,
                            'm_status' => 'Open Manifest',  
                            'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                    );
                   // $this->db->where('awbno' , $booking_id);
                    $this->db->insert('crit_manifest_info', $ins); 
                    
                    $ins = array(
                        'awbno' => $booking_id,
                        'tracking_status' => $this->get_tracking_status_name('2') ,                          
                        'city_code' => $this->input->post('from_city_code')  ,                          
                        'status_date' => $this->input->post('manifest_date')  ,                          
                        'status_time' => date('H:i:s'),                          
                        'remarks' => $this->input->post('from_city_code') . ' to ' . $this->input->post('to_city_code') . '[ ' . $this->input->post('from_type') .' ]', 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
                    $this->db->insert('crit_awb_tracking_info', $ins);
                    
                    
                } 
                         
                $this->db->where_in('awbno', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => $this->get_tracking_status_name('2'), 'status_city_code' => $this->input->post('from_city_code')));
                
                 
            }
            redirect('generate-manifest');  
        } 
        
        if($this->input->post('from_city_code') != '')
        {
             $data['submit_flg'] = true;
           
                $this->db->select('(ifnull(max(manifest_no),0) + 1) as manifest_no');
                $query = $this->db->get('crit_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $data['manifest_no'] = $row->manifest_no;
                }  
           
            // (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('to_city_code') ."')  and
            
            //and c.manifest_type = '". $this->input->post('manifest_type') ."' 
            
              $sql = "
                select  
                    a.booking_id, 
                    a.awbno,
                    a.origin_state_code,
                    a.origin_city_code,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description,
                    'Booking' as mode
                    from crit_booking_info as a   
                    where a.status = 'Consignment Booked' and a.created_by in ( select w.user_id from crit_franchise_info as q left join crit_user_info as w on w.franchise_id = q.franchise_id where q.status='Active' and q.branch_code = '". $this->input->post('from_city_code') ."')
                    and a.booking_date between '". $this->input->post('booking_date') ."' and '". $this->input->post('booking_date_to') ."'
                    and a.status != 'Delete'  
                    order by a.awbno asc               
             "; 
             
             //and a.booking_date = '". $this->input->post('booking_date') ."' 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
            $data['record_list'] = array();
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            } 
            
            
           $sql = "
                    select 
                    c.booking_id, 
                    c.awbno,
                    c.origin_state_code,
                    c.origin_city_code,
                    c.dest_state_code,
                    c.dest_city_code,
                    c.no_of_pieces,
                    c.chargable_weight as weight ,
                    c.commodity_type,
                    c.description ,
                    'Received Manifest' as mode 
                    from crit_manifest_info as a
                    left join crit_booking_info as c on c.awbno = a.awbno
                    where a.m_status = 'Received Manifest' and a.to_city_code = '". $this->input->post('from_city_code') ."'
                    and a.received_date between '". $this->input->post('booking_date') ."' and '". $this->input->post('booking_date_to') ."'
                    and c.status !='Delete' and c.status != 'Consignment Delivered' and c.status != 'Out for Delivery' and c.status != 'Undelivered'
                    order by a.awbno asc
                                
             "; 
             // and a.received_date = '". $this->input->post('booking_date') ."' 
             
            $query = $this->db->query($sql); 
            
           // $data['re_manifest_row_count'] = $query->num_rows();
            //$data['re_manifest_record_list'] = array();
       
            foreach ($query->result_array() as $row)
            {
               // $data['re_manifest_record_list'][] = $row;     
                $data['record_list'][] = $row;     
            } 
           /* if(!empty($data['re_manifest_record_list']))
                array_push($data['record_list'],$data['re_manifest_record_list']);*/

            
            
        }  
        
        $sql = "
            select 
            b.state_code,
            a.hub_branch_name, 
            a.hub_branch_code 
            from crit_hub_branch_info as a 
            left join crit_franchise_info as b on b.branch_code = a.hub_branch_code
            where a.status='Active' and a.type = 'Branch'
            order by a.hub_branch_name asc           
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_code_opt'][$row['state_code']] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]'); 
            $data['to_city_code_opt'][$row['state_code']][$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
        }
            
            
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
        
        $data['js'] = 'manifest.inc';      
        $this->load->view('page/generate-manifest',$data); 
    }
    
    
    public function receive_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        $data['submit_flg'] = false; 
        
        
        if($this->input->post('from_date') != '' &&  $this->input->post('to_date') != '' && $this->input->post('to_city_code') != '')
        {
             $data['submit_flg'] = true;
           
            
              $sql = "
                select 
                a.manifest_no,
                a.manifest_date,
                a.from_city_code,
                d.co_loader_name as co_loader,
                a.co_loader_awb_no,
                a.co_loader_remarks,
                count(a.awbno) as open_mf,
                e.received as received_mf,
                sum(c.no_of_pieces) as no_of_pieces,
                sum(c.weight) as tot_weight
                from crit_manifest_info as a
                left join crit_booking_info as c on c.awbno = a.awbno
                left join crit_co_loader_info as d on d.co_loader_id = a.co_loader_id
                left join ( select w.manifest_no , count(w.awbno) as received from crit_manifest_info as w where w.m_status = 'Received Manifest' group by w.manifest_no ) as e on e.manifest_no = a.manifest_no 
                where a.to_city_code = '". $this->input->post('to_city_code') ."'    
                and a.manifest_date between '". $this->input->post('from_date') ."' and '". $this->input->post('to_date') ."'
                and a.awbno != ''
                and c.status != 'Delete'
                group by a.manifest_no 
                order by a.manifest_date, a.manifest_no asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
       
            foreach ($query->result_array() as $row)
            {
                if($row['open_mf'] != $row['received_mf'])
                    $data['record_list'][] = $row;     
            }
            
            
          /*  $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = '". $this->input->post('to_type') ."'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['to_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }*/
            
        } else {
           /* $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = 'HUB'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['to_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }*/
            
            
            
        }
            
            $sql = "
                select 
                b.state_code,
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                left join crit_franchise_info as b on b.branch_code = a.hub_branch_code
                where a.status='Active' and a.type = 'Branch'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['to_city_code_opt'][$row['state_code']] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }
        
        /*
        
        $sql = "
                select 
                c.state_name as state,
                a.state_code , 
                a.branch_code ,
                a.area
                from crit_servicable_pincode_info  as a
                left join crit_states_info as c on c.state_code = a.state_code
                where a.`status` = 'Active'
                group by a.state_code , a.branch_code
                order by a.state_code , a.branch_code              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state']][$row['branch_code']] =  ( $row['area']. ' [ ' . $row['branch_code'] . ' ]');     
        } */
        
        $sql = "
                select 
                c.state_name as state,
                c.state_code  
                from crit_states_info as c  
                where c.`status` = 'Active' 
                order by c.state_name              
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_code']] =   $row['state']  ;     
        }
        
        
        /*$sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        */
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        
        $this->load->view('page/receive-manifest',$data); 
    } 
    
    public function delivery_runsheet()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        //$data['record_list'] = array();
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {
                $this->db->select('(ifnull(max(drs_no),0) + 1) as drs_no');
                $query = $this->db->get('crit_drs_info');
                $row = $query->row();
                if (isset($row)) {
                    $drs_no = $row->drs_no;
                }
                 
                foreach($ids as $j => $awbno) {
                    $ins[] = array(
                            'drs_no' => $drs_no,
                            'drs_date' => $this->input->post('runsheet_date')  ,                          
                            'drs_time' => date('H:i:s' , strtotime($this->input->post('runsheet_time'))) ,                          
                            'branch_city_code' => $this->input->post('to_city_code'), 
                            'awbno' => $awbno ,                          
                            'delivery_by' => $this->input->post('delivery_by'),                          
                            'drs_status' => 'Out for Delivery',  
                            'drs_created_by' =>  $this->session->userdata('cr_user_id')                      
                    );
                    
                    $ins_track[] = array(
                        'awbno' => $awbno,
                        'tracking_status' => $this->get_tracking_status_name('7') ,                          
                        'city_code' => $this->input->post('to_city_code')  ,                          
                        'status_date' => $this->input->post('runsheet_date')  ,                          
                        'status_time' => date('H:i:s' , strtotime($this->input->post('runsheet_time'))),                          
                        'remarks' => $this->input->post('to_city_code') . '[ '. $this->input->post('to_type').' ]', 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
                }
                $this->db->insert_batch('crit_drs_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('awbno', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => $this->get_tracking_status_name('9'), 'status_city_code' => $this->input->post('to_city_code')));
                
                
                
             $this->db->insert_batch('crit_awb_tracking_info', $ins_track);   
            }
            redirect('delivery-runsheet');  
        } 
        
        
        $data['submit_flg'] = false; 
        
        
        if( $this->input->post('to_city_code') != '')
        {
             $data['submit_flg'] = true; 
            
           /*  $sql = "
                select 
                a.awbno, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total
                from crit_booking_info  as a  
                where a.dest_city_code = '". $this->input->post('branch_city_code') ."' 
                and a.`status` = 'Received Manifest'
                and a.status_city_code  = '". $this->input->post('branch_city_code') ."' 
                and a.status != 'Delete'
                order by a.dest_pincode asc 
                              
             "; */
             
             $sql = "
                select 
                a.awbno, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total
                from crit_booking_info  as a  
                where  a.status != 'Delete' and a.status != 'Out for Delivery' and a.status != 'Consignment Delivered' 
                and exists ( select * from crit_manifest_info as z where z.awbno = a.awbno and z.to_city_code = '". $this->input->post('to_city_code') ."' and m_status = 'Received Manifest' )
                order by a.dest_pincode asc 
                              
             "; 
             
              $sql = "
                select 
                a.awbno, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total
                from crit_booking_info  as a  
                left join crit_manifest_info as z on z.awbno = a.awbno and z.to_city_code = '". $this->input->post('to_city_code') ."' and m_status = 'Received Manifest'
                where  a.status != 'Delete' and a.status != 'Out for Delivery' and a.status != 'Consignment Delivered' 
                and z.manifest_id != '' 
                order by a.dest_pincode asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
            
            $data['row_count'] = $query->num_rows();
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
            
          /*  $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = '". $this->input->post('to_type') ."'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['to_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            } */
            
        }
        
        
        
        
        $sql = "
                select 
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                where a.status='Active' and a.type = 'Branch'
                order by a.hub_branch_name asc           
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['to_city_code_opt'] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
            }
        
        
        /*$sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        */
        $sql = "
                select 
                a.user_id,
                a.first_name 
                from crit_user_info as a  
                where status = 'Active' and a.franchise_id = '". $this->session->userdata('cr_franchise_id') ."'      
                order by a.first_name                
        "; 
        
        $query = $this->db->query($sql);
        
        $data['delivery_by_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['delivery_by_opt'][$row['user_id']] = $row['first_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        
        $this->load->view('page/delivery-runsheet',$data); 
    } 
    
    public function drs_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'manifest.inc';   
        
        if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date');  
           $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date')); 
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ; 
       } else {
        $data['srch_from_date'] = $srch_to_date = date('Y-m-d');
        $data['srch_to_date'] = $srch_to_date = date('Y-m-d'); 
       }
       
       
       $where = '1=1';
       if(!empty($srch_from_date) && !empty($srch_to_date)  ){
        $where = " a.drs_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        
        if($this->session->userdata('cr_is_admin') == '1' or $this->session->userdata('cr_is_admin') == '111')            
             $where .=" and 1";
        else   
            $where .= " and a.delivery_by in (select a.user_id from crit_user_info as a  where a.franchise_id =  '". $this->session->userdata('cr_franchise_id') ."') ";
        
        $data['submit_flg'] = true;
         
       }  
         
         
        
        $this->load->library('pagination'); 
        
        $this->db->where('a.drs_status != ', 'Delete'); 
        $this->db->where($where); 
        $this->db->from('crit_drs_info as a');  
        $this->db->group_by("a.drs_no , a.drs_date");        
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('drs-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] =  "Prev";
        $config['next_link'] =  "Next";
        $this->pagination->initialize($config);   
        
        $sql = "
                select 
                a.drs_no,
                a.drs_date,                
                a.drs_time,
                a.branch_city_code,
                count(a.awbno) as no_of_awb,
                c.first_name as delivery_by,
                a.remarks,
                a.drs_status
                from crit_drs_info as a 
                left join crit_user_info as c on c.user_id = a.delivery_by
                where a.drs_status != 'Delete' 
                and $where
                group by a.drs_no , a.drs_date
                order by a.drs_no  ,a.drs_date , a.drs_time
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        //a.status = 'Booked'  
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        
        $this->load->view('page/drs-list',$data); 
	} 
    
    public function delivery_updation()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        if(($this->input->post('btn_save') == 'delivered'))
        {
            if(($this->input->post('status') == 'Delivered'))
            {
                $config['upload_path'] = 'delivered-pod/';
        		$config['allowed_types'] = 'gif|jpg|png|jpeg';
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('pod_img'))
                {
                    $file_array = $this->upload->data();	
                    $image_path	= 'delivered-pod/'.date('YmdHis') . $file_array['file_name']; 
               
                }
                else
                {
                     $image_path = '';    
                }
                
                $upd = array(
                             'pod_img' => $image_path  ,
                             'drs_status' => $this->input->post('status'),         
                             'remarks' => $this->input->post('remarks'),         
                             'delivered_to' => $this->input->post('delivered_to'),         
                             'delivered_to_mobile' => $this->input->post('delivered_to_mobile'),  
                             'delivered_date' => $this->input->post('delivered_date'),  
                             'delivered_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),    
                            );
            
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_drs_info', $upd); 
                
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => $this->get_tracking_status_name('8') )); 
                
                $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'tracking_status' => $this->get_tracking_status_name('8'),                   
                        'status_date' => $this->input->post('delivered_date') ,                          
                        'status_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),                          
                        'remarks' => '', 
                        'created_by' =>  $this->session->userdata('cr_user_id') ,
                        'created_datetime' => date('Y-m-d H:i:s') 
                        );
               $this->db->insert('crit_awb_tracking_info', $ins);  
                
                redirect('delivery-updation');
                 
            } else {
                 
                $upd = array( 
                             'drs_status' => $this->input->post('status'),         
                             'remarks' => $this->input->post('remarks'),  
                            );
            
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_drs_info', $upd); 
                
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->where('status != "Delete"');
                $this->db->update('crit_booking_info', array('status' => $this->input->post('status')));
                
                 $ins = array( 
                             'drs_no' => $this->input->post('drs_no'),         
                             'awbno' => $this->input->post('awbno'),         
                             'ndr_id' => $this->input->post('ndr_id'),         
                             'remarks' => $this->input->post('remarks'), 
                             'ndr_date' => $this->input->post('delivered_date'),  
                             'ndr_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),  
                            );
                 $this->db->insert('crit_drs_ndr_info', $ins);    
                 
                 $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'tracking_status' => $this->get_tracking_status_name('7'),                   
                        'status_date' => $this->input->post('delivered_date') ,                          
                        'status_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),                          
                        'remarks' => $this->input->post('remarks'), 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
               $this->db->insert('crit_awb_tracking_info', $ins); 
                 
                 redirect('delivery-updation');        
                
            }
            
        }
        $data['sflg'] = false;
        if(($this->input->post('btn_inscan') == 'Delivery'))
        {
            $data['sflg'] = true;
            $sql = "
                select 
                a.awbno,
                c.drs_no, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total,
                a.status
                from crit_booking_info  as a  
                left join crit_drs_info as c on c.awbno = a.awbno
                where c.awbno = '". $this->input->post('awbno') ."'  
                and (a.status = '".$this->get_tracking_status_name('7') ."' or a.status = '".$this->get_tracking_status_name('9')."')
                and a.status != 'Delete'
                order by a.dest_pincode asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            } 
            
            
            $sql = " 
                select 
                a.ndr_date,
                a.ndr_time,
                c.ndr_code,
                c.ndr_details,
                a.remarks 
                from crit_drs_ndr_info as a
                left join crit_ndr_info as c on c.ndr_id = a.ndr_id
                where a.awbno = '". $this->input->post('awbno') ."'  
                order by a.ndr_date , a.ndr_time asc 
            "; 
            
            $query = $this->db->query($sql); 
            $data['ndr_info'] = array();
       
            foreach ($query->result_array() as $row)
            {
                $data['ndr_info'][] = $row;     
            } 
            
            
        }
        
        $sql = "
                select 
                a.ndr_id,
                a.ndr_code ,
                a.ndr_details
                from crit_ndr_info as a  
                where status = 'Active'                 
                order by a.ndr_code, a.ndr_details                
        "; 
        
        $query = $this->db->query($sql);
        
        $data['ndr_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['ndr_opt'][$row['ndr_id']] = $row['ndr_code']. ' => ' . $row['ndr_details'];     
        }
        
        
        
        $data['js'] = 'delivery.inc';  
        $this->load->view('page/delivery-updation',$data); 
    } 
    
     public function tracking_entry()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        /*
        if(($this->input->post('btn_save') == 'delivered'))
        {
            if(($this->input->post('status') == 'Delivered'))
            {
                $config['upload_path'] = 'delivered-pod/';
        		$config['allowed_types'] = 'gif|jpg|png|jpeg';
                
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('pod_img'))
                {
                    $file_array = $this->upload->data();	
                    $image_path	= 'delivered-pod/'.date('YmdHis') . $file_array['file_name']; 
               
                }
                else
                {
                     $image_path = '';    
                }
                
                $upd = array(
                             'pod_img' => $image_path  ,
                             'drs_status' => $this->input->post('status'),         
                             'remarks' => $this->input->post('remarks'),         
                             'delivered_to' => $this->input->post('delivered_to'),         
                             'delivered_to_mobile' => $this->input->post('delivered_to_mobile'),  
                             'delivered_date' => $this->input->post('delivered_date'),  
                             'delivered_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),    
                            );
            
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_drs_info', $upd); 
                
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_booking_info', array('status' => $this->input->post('status'))); 
                
                redirect('delivery-updation');
                 
            } else {
                 
                $upd = array( 
                             'drs_status' => $this->input->post('status'),         
                             'remarks' => $this->input->post('remarks'),  
                            );
            
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_drs_info', $upd); 
                
                $this->db->where('awbno', $this->input->post('awbno'));
                $this->db->update('crit_booking_info', array('status' => $this->input->post('status')));
                
                 $ins = array( 
                             'drs_no' => $this->input->post('drs_no'),         
                             'awbno' => $this->input->post('awbno'),         
                             'ndr_id' => $this->input->post('ndr_id'),         
                             'remarks' => $this->input->post('remarks'), 
                             'ndr_date' => $this->input->post('delivered_date'),  
                             'ndr_time' => date('H:i:s' , strtotime($this->input->post('delivered_time'))),  
                            );
                 $this->db->insert('crit_drs_ndr_info', $ins);    
                 
                 redirect('delivery-updation');        
                
            }
            
        }
        */
        $data['sflg'] = false;
        
         $curr_status = '';
         
         
        if(($this->input->post('btn_inscan') == 'Tracking'))
        {
            $data['sflg'] = true;
           $sql = "
                select 
                a.awbno,
                c.drs_no, 
                a.origin_state_code,
                a.origin_city_code,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                a.sender_name,
                a.sender_mobile,
                a.sender_address,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total,
                a.status,
                a.status_city_code
                from crit_booking_info  as a  
                left join crit_drs_info as c on c.awbno = a.awbno
                where a.awbno = '". $this->input->post('awbno') ."'  
                and a.status !='Delete'
                order by a.dest_pincode asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
           
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;  
                
                $curr_status = $row['status'];   
            } 
            
            
            $sql = " 
                select 
                a.manifest_no,
                a.manifest_date,
                a.manifest_type,
                a.from_city_code,
                a.to_city_code,
                c.co_loader_name as co_loader, 
                a.co_loader_awb_no, 
                a.co_loader_remarks, 
                a.m_status, 
                a.received_date, 
                a.remarks 
                from crit_manifest_info as a
                left join crit_co_loader_info as c on c.co_loader_id = a.co_loader_id
                where a.awbno = '". $this->input->post('awbno') ."'  
                order by a.manifest_date  asc 
            "; 
            
            $query = $this->db->query($sql); 
            $data['manifest_info'] = array();
       
            foreach ($query->result_array() as $row)
            {
                $data['manifest_info'][] = $row;     
            } 
            
            
        }
        
        $sql = " 
            select 
            a.drs_no,
            a.drs_date,
            a.drs_time,
            a.branch_city_code,
            a.drs_status, 
            a.remarks, 
            a.pod_img, 
            a.delivered_to, 
            a.delivered_to_mobile, 
            a.delivered_date, 
            a.delivered_time  
            from crit_drs_info as a 
            where a.awbno = '". $this->input->post('awbno') ."'  
            order by a.drs_date , a.drs_time asc 
        "; 
        
        $query = $this->db->query($sql); 
        $data['delivery_info'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['delivery_info'][] = $row;     
        } 
        
        $sql = " 
            select 
            a.ndr_date,
            a.ndr_time,
            c.ndr_code,
            c.ndr_details,
            a.remarks 
            from crit_drs_ndr_info as a
            left join crit_ndr_info as c on c.ndr_id = a.ndr_id
            where a.awbno = '". $this->input->post('awbno') ."'  
            order by a.ndr_date , a.ndr_time asc 
        "; 
        
        $query = $this->db->query($sql); 
        $data['ndr_info'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['ndr_info'][] = $row;     
        } 
        
        $sql = " 
            select 
            a.awb_tracking_id,
            a.tracking_status,
            a.city_code,
            a.status_date,
            a.status_time,
            a.remarks 
            from crit_awb_tracking_info as a 
            where a.awbno = '". $this->input->post('awbno') ."'  
            order by a.status_date, a.status_time asc 
        "; 
        
        $query = $this->db->query($sql); 
        $data['awb_tracking_info'] = array();
        
        $trk_last_status = $trk_last_city = '';
        
        foreach ($query->result_array() as $row)
        {
            $data['awb_tracking_info'][] = $row;  
            $trk_last_status =  $row['tracking_status'];  
            $trk_last_city =  $row['city_code'];  
        }
        
        if( $curr_status != $trk_last_status ){
                
                 $upd = array(
                    'status' => $trk_last_status  , 
                    'status_city_code' => $trk_last_city
                    );
                    
                $this->db->where('awbno', $this->input->post('awbno'));         
                $this->db->update('crit_booking_info', $upd);         
        }
        
        
        
        $sql = "
                select 
                a.tracking_status
                from crit_tracking_status_info as a  
                where status = 'Active'                 
                order by a.sort asc                
        "; 
        
        $query = $this->db->query($sql);
        
        
       
        foreach ($query->result_array() as $row)
        {
            $data['tracking_opt'][$row['tracking_status']]  = $row['tracking_status'];     
        } 
        
        
      /*  $sql = "
                select 
                c.state_name as state,
                a.state_code , 
                a.branch_code ,
                a.area
                from crit_servicable_pincode_info  as a
                left join crit_states_info as c on c.state_code = a.state_code
                where a.`status` = 'Active' and b.`status` = 'Active' 
                group by a.state_code , a.branch_code
                order by a.state_code , a.branch_code              
        "; 
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state']][$row['branch_code']] =  ( $row['area']. ' [ ' . $row['branch_code'] . ' ]');     
        } */
        
        /*
        $sql = "
                select 
                a.city_name,
                a.city_code,
                b.state_name 
                from crit_city_info as a
                left join crit_states_info as b on b.state_code = a.state_code 
                where a.`status` = 'Active' and b.`status` = 'Active'
                order by b.state_name , a.city_name asc
        
        ";
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_name']][$row['city_code']] =  ( $row['city_name']. ' [ ' . $row['city_code'] . ' ]');     
        } 
        */
        
        
        $sql = "
            select 
            b.state_code,
            c.state_name,
            a.hub_branch_name, 
            a.hub_branch_code 
            from crit_hub_branch_info as a
            left join crit_franchise_info as b on b.branch_code = a.hub_branch_code
            left join crit_states_info as c on c.state_code = b.state_code
            where a.status='Active' and a.type = 'Branch'
            order by a.hub_branch_name asc           
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['state_opt'][$row['state_name']] [$row['hub_branch_code']] =  ( $row['hub_branch_name']. ' [ ' . $row['hub_branch_code'] . ' ]');     
        }
        
        
        $data['js'] = 'tracking-entry.inc';  
        $this->load->view('page/tracking-entry',$data); 
    } 
    
     public function tracking()
    {
         
        $data['sflg'] = false;
        if(($this->input->post('btn_search') == 'Tracking') || ($this->input->post('btn-track') == 'Tracking') && ($this->input->post('awbno') != ''))
        {
            $data['sflg'] = true;
            
            $query = $this->db->query(" set SQL_BIG_SELECTS=1 ");
            
          $sql = "
                select DISTINCT
                a.booking_id,
                a.awbno,
                c.drs_no, 
                a.origin_pincode,
                b.state_name as origin_state,
                d.city_name as origin_city,
                a.no_of_pieces,
                a.weight, 
                a.dest_pincode,
                b1.state_name as dest_state,
                d1.city_name as dest_city,
                a.sender_name,
                a.sender_mobile,
                a.sender_address,
                a.receiver_name,
                a.receiver_mobile,
                a.receiver_address,
                ifnull(a.cod,0) as cod,
                a.cod_amount,
                ifnull(a.to_pay,0) as to_pay,
                a.grand_total,
                a.status,
                a.status_city_code
                from crit_booking_info  as a  
                left join crit_states_info as b on b.state_code = a.origin_state_code and b.status = 'Active'
                left join crit_city_info as d on d.city_code = a.origin_city_code and d.status = 'Active'
                left join crit_drs_info as c on c.awbno = a.awbno
                left join crit_states_info as b1 on b1.state_code = a.dest_state_code and b.status = 'Active'
                left join crit_city_info as d1 on d1.city_code = a.dest_city_code and d.status = 'Active'
                where a.awbno in ( ". $this->input->post('awbno') .")  
                and a.status !='Delete' 
                order by a.dest_pincode asc 
                              
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['awbno']] = $row;     
            } 
            
           /* 
             $sql = " 
            select 
            a.drs_no,
            a.drs_date,
            a.drs_time,
            a.branch_city_code,
            a.drs_status, 
            a.remarks, 
            a.pod_img, 
            a.delivered_to, 
            a.delivered_to_mobile, 
            a.delivered_date, 
            a.delivered_time  
            from crit_drs_info as a 
            where a.awbno = '". $this->input->post('awbno') ."'  
            order by a.drs_date , a.drs_time asc 
        "; 
        
        $query = $this->db->query($sql); 
        $data['delivery_info'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['delivery_info'][] = $row;     
        } 
        
        $sql = " 
            select 
            a.ndr_date,
            a.ndr_time,
            c.ndr_code,
            c.ndr_details,
            a.remarks 
            from crit_drs_ndr_info as a
            left join crit_ndr_info as c on c.ndr_id = a.ndr_id
            where a.awbno = '". $this->input->post('awbno') ."'  
            order by a.ndr_date , a.ndr_time asc 
        "; 
        
        $query = $this->db->query($sql); 
        $data['ndr_info'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['ndr_info'][] = $row;     
        } 
        */
        
        $sql = " 
            select 
            a.awbno ,
            a.awb_tracking_id,
            a.tracking_status,
            a.city_code,
            b.city_name  as city,
            a.status_date,
            a.status_time,
            a.remarks 
            from crit_awb_tracking_info as a 
            left join crit_city_info as b on b.city_code = a.city_code and b.status= 'Active'
            where a.awbno in (". $this->input->post('awbno') .")  
            group by a.awb_tracking_id
            order by a.status_date, a.status_time asc 
        "; 
        
        $query = $this->db->query($sql); 
        $data['awb_tracking_info'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $data['awb_tracking_info'][$row['awbno']][] = $row;     
        }
            
            
        } else {
            
        }
        
        
        
        $data['js'] = '';  
        $this->load->view('page/tracking',$data); 
    } 
    
    public function b2h_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        
        if($this->input->post('btn_show') == 'Show AWB')
        {
             $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {
                $this->db->select('(ifnull(max(b2h_manifest_no),0) + 1) as b2h_manifest_no');
                $query = $this->db->get('crit_b2h_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $b2h_manifest_no = $row->b2h_manifest_no;
                }
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $b2h_manifest_no,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code'))); 
            }
            redirect('b2h-manifest');  
        } 
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/b2h-manifest',$data); 
    } 
    
    public function b2h_manifest_list()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        $data['new_record_list'] = array();
        
        if($this->input->post('btn_search') == 'Search')
        {
             $sql = "
                select 
                    c.b2h_manifest_no,
                    c.manifest_date,
                    a.booking_id,
                    c.co_loader_id,
                    d.co_loader_name,
                    c.co_loader_awb_no,
                    c.co_loader_remarks,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    left join crit_b2h_manifest_info as c on c.booking_id = a.booking_id
                    left join crit_co_loader_info as d on d.co_loader_id = c.co_loader_id
                    where (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('from_city_code') ."')  
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    and a.status != 'Delete'
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['b2h_manifest_no']][] = $row;     
            }
            
            $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['new_record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Update')
        { 
            $ids = $this->input->post('booking_ids');
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            if(!empty($ids))
            {
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $this->input->post('b2h_manifest_no'),
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code')  ,
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                           
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code')));
                 
            } else {
                // Update Co-loader Details
                $upd = array( 
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks')
                            );
                
                $this->db->where('b2h_manifest_no', $this->input->post('b2h_manifest_no')); 
                $this->db->update('crit_b2h_manifest_info', $upd);
            }
            redirect('b2h-manifest-list');  
        }
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/b2h-manifest-list',$data); 
    } 
    
    public function h2h_manifest()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        
        if($this->input->post('btn_show') == 'Show AWB')
        {
             $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Save')
        { 
            $ids = $this->input->post('booking_ids');
            if(!empty($ids))
            {
                $this->db->select('(ifnull(max(b2h_manifest_no),0) + 1) as b2h_manifest_no');
                $query = $this->db->get('crit_b2h_manifest_info');
                $row = $query->row();
                if (isset($row)) {
                    $b2h_manifest_no = $row->b2h_manifest_no;
                }
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $b2h_manifest_no,
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code'),                          
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code'))); 
            }
            redirect('b2h-manifest');  
        } 
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Booked' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/h2h-manifest',$data); 
    } 
    
    public function h2h_manifest_list()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
         
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        $data['record_list'] = array();
        $data['new_record_list'] = array();
        
        if($this->input->post('btn_search') == 'Search')
        {
             $sql = "
                select 
                    c.b2h_manifest_no,
                    c.manifest_date,
                    a.booking_id,
                    c.co_loader_id,
                    d.co_loader_name,
                    c.co_loader_awb_no,
                    c.co_loader_remarks,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    left join crit_b2h_manifest_info as c on c.booking_id = a.booking_id
                    left join crit_co_loader_info as d on d.co_loader_id = c.co_loader_id
                    where (a.status = 'Despatched to HUB' and a.status_city_code = '". $this->input->post('from_city_code') ."')  
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    and a.status != 'Delete'
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['record_list'][$row['b2h_manifest_no']][] = $row;     
            }
            
            $sql = "
                select 
                    a.booking_id,
                    a.awbno,
                    a.dest_state_code,
                    a.dest_city_code,
                    a.no_of_pieces,
                    a.chargable_weight as weight ,
                    a.commodity_type,
                    a.description
                    from crit_booking_info as a  
                    where status = 'Booked' 
                    and a.origin_city_code = '". $this->input->post('from_city_code') ."' 
                    and a.dest_city_code = '". $this->input->post('to_city_code') ."' 
                    order by a.awbno asc               
             "; 
             
            $query = $this->db->query($sql); 
       
            foreach ($query->result_array() as $row)
            {
                $data['new_record_list'][] = $row;     
            }
        }
        
        if($this->input->post('btn_save') == 'Update')
        { 
            $ids = $this->input->post('booking_ids');
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            if(!empty($ids))
            {
                 
                foreach($ids as $j => $booking_id)
                $ins[] = array(
                        'b2h_manifest_no' => $this->input->post('b2h_manifest_no'),
                        'manifest_date' => $this->input->post('manifest_date')  ,                          
                        'from_city_code' => $this->input->post('from_city_code')  ,                          
                        'to_city_code' => $this->input->post('to_city_code')  ,
                        'co_loader_id' => $this->input->post('co_loader_id'),                          
                        'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                        'co_loader_remarks' => $this->input->post('co_loader_remarks'),                           
                        'booking_id' => $booking_id ,                          
                        'm_status' => 'Despatched to HUB',  
                        'despatch_by' =>  $this->session->userdata('cr_user_id')                      
                );
                $this->db->insert_batch('crit_b2h_manifest_info', $ins); 
                
                // Changed status 'Booked' to 'Despatched to HUB'            
                $this->db->where_in('booking_id', $ids);
                $this->db->where('status !="Delete"');
                $this->db->update('crit_booking_info', array('status' => 'Despatched to HUB', 'status_city_code' => $this->input->post('from_city_code')));
                 
            } else {
                // Update Co-loader Details
                $upd = array( 
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks')
                            );
                
                $this->db->where('b2h_manifest_no', $this->input->post('b2h_manifest_no')); 
                $this->db->update('crit_b2h_manifest_info', $upd);
            }
            redirect('b2h-manifest-list');  
        }
        
        
        $sql = "
                select 
                a.origin_state_code,
                a.origin_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.origin_city_code                
                order by a.origin_state_code, a.origin_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['from_city_opt'][$row['origin_city_code']] = $row['origin_state_code']. ' - ' . $row['origin_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.dest_state_code,
                a.dest_city_code 
                from crit_booking_info as a  
                where status = 'Despatched to HUB' 
                group by a.dest_city_code                
                order by a.dest_state_code, a.dest_city_code                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['to_city_opt'][$row['dest_city_code']] = $row['dest_state_code']. ' - ' . $row['dest_city_code'] . '';     
        }
        
        $sql = "
                select 
                a.co_loader_id,
                a.co_loader_name 
                from crit_co_loader_info as a  
                where status = 'Active'       
                order by a.co_loader_name                
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['co_loader_opt'][$row['co_loader_id']] = $row['co_loader_name'];     
        }
         
        
        $data['js'] = 'manifest.inc';  
        $this->load->view('page/h2h-manifest-list',$data); 
    }
    
    public function ts_invoice_generate()
    {
        if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        
        /*$query = $this->db->query("select `generate_invoice_no`('2024-09-11') as invoice_no ");
        $row = $query->row();
        if (isset($row)) {
            echo $invoice_no = $row->invoice_no;
        }*/
        
        
        if($this->input->post('btn_generate') == 'Generate Invoice')
        { 
            $awb_nos = $this->input->post('awb_nos');
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            if(!empty($awb_nos))
            {
                
               /* $this->db->select('(ifnull(max(invoice_no),0) + 1) as invoice_no');
                $this->db->from('crit_ts_invoice_info');
                $this->db->where('status != "Delete"');
                $query = $this->db->get();
                $row = $query->row();
                if (isset($row)) {
                    $invoice_no = $row->invoice_no;
                } 
                */
                $query = $this->db->query("select `generate_invoice_no`('". $this->input->post('invoice_date') ."') as invoice_no ");
                $row = $query->row();
                if (isset($row)) {
                    $invoice_no = $row->invoice_no;
                }
                
                $invoice_amt = $this->input->post('invoice_amt');
                $fod = $this->input->post('fod');
                $cod = $this->input->post('cod');
                $ts = $this->input->post('ts');
                $oda = $this->input->post('oda');
                $awb_nos = $this->input->post('awb_nos');
                $fsc = $this->input->post('fsc');
                
                    $ins  = array(
                            'invoice_date' => $this->input->post('invoice_date'),
                            'franchise_id' => $this->input->post('franchise_id')  ,                          
                            'awb_nos' => implode(',',$awb_nos)  ,            
                            'invoice_no' => $invoice_no  ,                          
                            'status' => 'Pending' , 
                            'created_by' =>  $this->session->userdata('cr_user_id'),
                            'created_datetime' => date('Y-m-d H:i:s')   
                                                  
                    );
                    $this->db->insert('crit_ts_franchise_invoice_info', $ins); 
                    
                    $ts_franchise_invoice_id = $this->db->insert_id();
                
                
                foreach($awb_nos as $awb_no) {
                
                    $ins  = array(
                            'ts_franchise_invoice_id' => $ts_franchise_invoice_id,
                            'invoice_date' => $this->input->post('invoice_date'),
                            'franchise_id' => $this->input->post('franchise_id')  ,                          
                            'awb_no' => $awb_no  ,                          
                            'gst' => '18'  ,                          
                            'fsc' => ($fsc == '' ? 0 : $fsc)  ,                          
                            'ts_amount' => $invoice_amt[$awb_no] ,                          
                            'ts_amt' => $ts[$awb_no] ,                          
                            'fod' => $fod[$awb_no] ,                          
                            'cod' => $cod[$awb_no] ,                          
                            'oda' => $oda[$awb_no] ,                          
                            'invoice_no' => $invoice_no  ,                          
                            'status' => 'Pending' , 
                            'created_by' =>  $this->session->userdata('cr_user_id'),
                            'created_datetime' => date('Y-m-d H:i:s')   
                                                  
                    );
                    $this->db->insert('crit_ts_invoice_info', $ins); 
                }
                
               // $ts_invoice_id = $this->db->insert_id();
                
               // redirect('print-ts-invoice-v2/' . $invoice_no . '/'. strtotime($this->input->post('invoice_date')));    
                redirect('ts-invoice-list');    
            }  
             
        }
        
        	    
        //$data['js'] = 'reports.inc'; 
        $data['js'] = 'ts_invoice.inc'; 
        $data['submit_flg'] = false;
        
      if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_franchise_id'] = $srch_franchise_id = $this->input->post('srch_franchise_id'); 
            
       } else {
        $data['srch_from_date'] = date('Y-m-d');
        $data['srch_to_date'] = date('Y-m-d');
        $data['srch_franchise_id'] = '';
       }
       
       if(isset($_POST['srch_connection_ts_charges'])) {
           $data['srch_connection_ts_charges'] = $srch_connection_ts_charges = $this->input->post('srch_connection_ts_charges');  
       } else {
        $data['srch_connection_ts_charges'] = $srch_connection_ts_charges = 0;
       }
       
       if(isset($_POST['srch_delivery_ts_charges'])) {
           $data['srch_delivery_ts_charges'] = $srch_delivery_ts_charges = $this->input->post('srch_delivery_ts_charges');  
       } else {
        $data['srch_delivery_ts_charges'] = $srch_delivery_ts_charges = 0;
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date) ){
        $where = " a.booking_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'"; 
        $data['submit_flg'] = true; 
       }  
       
       if(!empty($srch_franchise_id) ){
        // $where .= " and a.created_by in ( select a.user_id from crit_user_info as a  where a.franchise_id =  '". $srch_franchise_id ."') ";
         $where .= " and f.franchise_id =  '". $srch_franchise_id ."'";
         $data['submit_flg'] = true; 
       }     
        
        
      /* $sql = "
                    select 
                    c.franchise_type_name,
                    a.franchise_id,
                    a.contact_person,
                    a.state_code,
                    a.city_code,
                    b.city_name as city
                    from crit_franchise_info as a
                    left join crit_franchise_type_info as c on c.franchise_type_id = a.franchise_type_id
                    left join crit_city_info as b on b.city_code = a.city_code  
                    left join franchises_ts_rate_info as d on d.franchise_id = a.franchise_id
                    where a.`status` = 'Active' and d.`status` = 'Active'
                    group by a.franchise_id
                    order by c.franchise_type_name asc , a.state_code , b.city_name, a.contact_person asc         
            "; 
        
        $query = $this->db->query($sql);
        
        $data['franchise_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['franchise_opt'][$row['franchise_type_name']][$row['franchise_id']] =  $row['state_code'] . ' - ' . $row['city'] .' [ ' . $row['contact_person']. ' ]';     
        } */
        
            $sql = "
                    select 
                    c.franchise_type_name,
                    a.franchise_id,
                    a.contact_person,
                    a.state_code,
                    a.city_code,
                    b.city_name as city
                    from crit_franchise_info as a
                    left join crit_franchise_type_info as c on c.franchise_type_id = a.franchise_type_id
                    left join crit_city_info as b on b.city_code = a.city_code  and b.`status` = 'Active'
                    where a.`status` = 'Active' 
                    group by a.franchise_id
                    order by c.franchise_type_name asc , a.state_code , b.city_name, a.contact_person asc          
            "; 
        
        $query = $this->db->query($sql);
        
        $data['franchise_opt'] = array();   
       
        foreach ($query->result_array() as $row)
        {
            $data['franchise_opt'][$row['franchise_type_name']][$row['franchise_id']] =  $row['state_code'] . ' - ' . $row['city'] .' [ ' . $row['contact_person']. ' ]';     
        }
        
        if($data['submit_flg']) {
        
          $this->db->query('SET SQL_BIG_SELECTS=1');
        
        /*
         $sql = "  
              select  distinct
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.to_pay,
                a.cod,
                a.chargable_weight,
                b.zone,
                c.zone,
                b.state_code as org_state_code,
                c.state_code as dest_state_code,
                b.branch_code,
                c.branch_code as dest_city_code,
                c.metro_city,
                c.serve_type,
                (if(a.to_pay = 1 , 100 , 0)) as fod_chrges,
                (if(a.cod = 1 , 100 , 0)) as cod_chrges,
                (if(c.serve_type = 'ODA', (e.init_charges + if((ceil(a.chargable_weight) > e.init_wt), ((((a.chargable_weight) - e.init_wt) / e.addt_wt ) * e.addt_charges) , 0)),0)) as oda_chrg,
                (d.min_charges * ceil(a.chargable_weight)) as ts_amt,
                (d.min_charges * ceil(a.chargable_weight)) as connection_ts_charges,
                (d.delivery_charges * ceil(a.chargable_weight)) as delivery_ts_charges,
                (
                (d.min_charges * ceil(a.chargable_weight)) +
                (if(c.serve_type = 'ODA', (e.init_charges + if((ceil(a.chargable_weight) > e.init_wt), ((((a.chargable_weight) - e.init_wt) / e.addt_wt ) * e.addt_charges) , 0)),0)) +
                (if(a.to_pay = 1 , 100 , 0)) +
                (if(a.cod = 1 , 100 , 0))
                ) as ts_charges, 
                a.`status`
                from crit_booking_info as a
                left join crit_servicable_pincode_info as b on b.pincode = a.origin_pincode
                left join crit_servicable_pincode_info as c on c.pincode = a.dest_pincode
                left join crit_transhipment_rate_info as d on 
                	d.flg_region = (if(b.zone = c.zone,1,0))
                   and d.flg_state = (if(b.state_code = c.state_code,1,0)) 
                   and d.flg_city = (if(b.branch_code = c.branch_code,1,0))             
                   and (if(b.zone = c.zone,1,d.flg_metro = (if(c.metro_city = 'Y',1,0)))) 
                   and d.from_weight <= a.chargable_weight and d.to_weight >= a.chargable_weight
                left join crit_ts_oda_charges_info as e on e.status= 'Active'   
                where a.`status` != 'Delete' and
                 $where  
                group by a.awbno 
                order by a.awbno, a.booking_date asc , a.booking_time asc  
        ";
        */
        
        $sql = "  
              select  distinct
                a.booking_id,
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.to_pay,
                a.cod,
                a.chargable_weight,
                b.zone as s_reg,
                c.zone as d_reg,
                b.state_code as org_state_code,
                c.state_code as dest_state_code,
                b.branch_code,
                c.branch_code as dest_city_code,
                c.metro_city,
                c.serve_type,
                (if(a.to_pay = 1 , 100 , 0)) as fod_chrges,
                (if(a.cod = 1 , 100 , 0)) as cod_chrges,
                (if(c.serve_type = 'ODA', (e.init_charges + if((ceil(a.chargable_weight) > e.init_wt), ((((a.chargable_weight) - e.init_wt) / e.addt_wt ) * e.addt_charges) , 0)),0)) as oda_chrg,
                (d.min_charges * ceil(a.chargable_weight)) as ts_amt,
                (d.min_charges * ceil(a.chargable_weight)) as connection_ts_charges,
                (d.delivery_charges * ceil(a.chargable_weight)) as delivery_ts_charges1,
                ((1 * 10) + (ceil(a.chargable_weight) - 1) * 8) as delivery_ts_charges,
                (
                (d.min_charges * ceil(a.chargable_weight)) +
                (if(c.serve_type = 'ODA', (e.init_charges + if((ceil(a.chargable_weight) > e.init_wt), ((((a.chargable_weight) - e.init_wt) / e.addt_wt ) * e.addt_charges) , 0)),0)) +
                (if(a.to_pay = 1 , 100 , 0)) +
                (if(a.cod = 1 , 100 , 0))
                ) as ts_charges, 
                a.`status`,
                g.service_name AS s_mode
                from crit_booking_info as a
                left join crit_servicable_pincode_info as b on b.pincode = a.origin_pincode
                left join crit_servicable_pincode_info as c on c.pincode = a.dest_pincode
                left join crit_user_info as f on f.user_id = a.created_by  
                left join franchises_ts_rate_info as d on 
                	d.flg_region = (if(b.zone = c.zone,1,0))
                   and d.flg_state = (if(b.state_code = c.state_code,1,0)) 
                   and d.flg_city = (if(b.branch_code = c.branch_code,1,0))             
                   and (if(b.zone = c.zone,1,d.flg_metro = (if(c.metro_city = 'Y',1,0)))) 
                   and d.from_weight <= a.chargable_weight 
                   and d.to_weight >= a.chargable_weight
                   and d.franchise_id = f.franchise_id
                   and d.service_id = a.service_id
                left join crit_ts_oda_charges_info as e on e.status= 'Active'   
                left join crit_service_info as g on g.service_id = a.service_id
                where a.`status` != 'Delete' and
                 $where  
                group by a.awbno 
                order by a.awbno, a.booking_date asc , a.booking_time asc  
        ";
        
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
         
        }
        
        $this->load->view('page/ts-invoice-generate',$data); 
    }
    
    public function ts_invoice_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        if($this->session->userdata('cr_is_admin') != '1') {   
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        }  
        
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'invoice_no' => $this->input->post('invoice_no'),
                    'invoice_date' => $this->input->post('invoice_date'), 
                    'updated_by' => $this->session->userdata('cr_user_id'),                          
                    'updated_datetime' => date('Y-m-d H:i:s')                  
            );
            
            $this->db->where('ts_franchise_invoice_id', $this->input->post('ts_franchise_invoice_id'));
            $this->db->update('crit_ts_invoice_info', $upd); 
            
            $upd1 = array(
                    'invoice_no' => $this->input->post('invoice_no'),
                    'invoice_date' => $this->input->post('invoice_date'),   
            );
            
            $this->db->where('ts_franchise_invoice_id', $this->input->post('ts_franchise_invoice_id'));
            $this->db->update('crit_ts_franchise_invoice_info', $upd1); 
                            
            redirect('ts-invoice-list/' . $this->uri->segment(2, 0)); 
        } 
        	    
        $data['js'] = 'ts_invoice.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_franchise_id'] = $srch_franchise_id = $this->input->post('srch_franchise_id'); 
           $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           $this->session->set_userdata('srch_franchise_id', $this->input->post('srch_franchise_id'));
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_franchise_id'] = $srch_franchise_id = $this->session->userdata('srch_franchise_id') ;
       } else {
        $data['srch_from_date'] = date('Y-m-01');
        $data['srch_to_date'] = date('Y-m-d');
        $data['srch_franchise_id'] = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date) ){
        $where = " a.invoice_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
          
        $data['submit_flg'] = true;
         
       }   
       if(!empty($srch_franchise_id) ){
          $where .= " and a.franchise_id = '". $srch_franchise_id ."' ";
          $data['submit_flg'] = true; 
       }    
        
        
        /*   $sql = "
                    select 
                    c.franchise_type_name,
                    a.franchise_id,
                    a.contact_person,
                    a.state_code,
                    a.city_code,
                    b.city_name as city
                    from crit_franchise_info as a
                    left join crit_franchise_type_info as c on c.franchise_type_id = a.franchise_type_id
                    left join crit_city_info as b on b.city_code = a.city_code
                    left join franchises_ts_rate_info as d on d.franchise_id = a.franchise_id
                    where a.`status` = 'Active' and d.`status` = 'Active'
                    group by a.franchise_id
                    order by c.franchise_type_name asc , a.state_code , b.city_name, a.contact_person asc          
            "; */
            
            $sql = "
                    select 
                    c.franchise_type_name,
                    a.franchise_id,
                    a.contact_person,
                    a.state_code,
                    a.city_code,
                    b.city_name as city
                    from crit_franchise_info as a
                    left join crit_franchise_type_info as c on c.franchise_type_id = a.franchise_type_id
                    left join crit_city_info as b on b.city_code = a.city_code  and b.`status` = 'Active'
                    where a.`status` = 'Active' 
                    group by a.franchise_id
                    order by c.franchise_type_name asc , a.state_code , b.city_name, a.contact_person asc          
            "; 
        
        $query = $this->db->query($sql);
        
         $data['franchise_list'] =  $data['franchise_opt'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['franchise_opt'][$row['franchise_type_name']][$row['franchise_id']] =  $row['state_code'] . ' - ' . $row['city'] .' [ ' . $row['contact_person']. ' ]';     
            $data['franchise_list'][$row['franchise_id']] =  $row['state_code'] . ' - ' . $row['city'] .' [ ' . $row['contact_person']. ' ]';     
        }
        
        
        if($data['submit_flg']) {
        
        $this->load->library('pagination'); 
        
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where($where); 
        $this->db->from('crit_ts_invoice_info as a');         
        $this->db->group_by('a.invoice_no');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('stationery-invoice-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] =  "Prev";
        $config['next_link'] =  "Next";
        $this->pagination->initialize($config);   
        
        $sql = "
                select  
                a.ts_franchise_invoice_id,
                a.franchise_id,                
                a.invoice_no,
                a.invoice_date, 
                count(a.awb_no) as awb_nos,
                round
                (
                     round
                        (
                            SUM(a.ts_amount) + (SUM(a.ts_amount) * (a.fsc) / 100)
                        ) + 
                    (  
                        round
                        (
                            SUM(a.ts_amount) + (SUM(a.ts_amount) * (a.fsc) / 100)
                        )  * (a.gst) / 100)
                ,2) AS ts_amount, 
                a.`status`
                from crit_ts_invoice_info as a 
                where a.`status` != 'Delete' and
                $where      
                group by a.invoice_no                             
                order by a.invoice_no desc , a.invoice_date desc                             
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        }
        
        $this->load->view('page/ts-invoice-list',$data); 
	}  
    
    
    public function stationery_invoice_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        if($this->session->userdata('cr_is_admin') != 1) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } 
        	    
        $data['js'] = 'stationery-invoice.inc'; 
        
        if($this->input->post('mode') == 'Add')
        {
            
            $query = $this->db->query("select `generate_invoice_no`('". $this->input->post('invoice_date') ."') as invoice_no ");
            $row = $query->row();
            if (isset($row)) {
                $invoice_no = $row->invoice_no;
            }
            
            $ins = array(
                    'invoice_no' => $invoice_no ,
                    'franchise_id' => $this->input->post('franchise_id'),
                    'invoice_date' => $this->input->post('invoice_date'),               
                    'id_card_chrg' => $this->input->post('id_card_chrg'),               
                    'email_chrg' => $this->input->post('email_chrg'),               
                    'transit_chrg' => $this->input->post('transit_chrg'),               
                    'tot_amt' => $this->input->post('tot_amt'),               
            );
            
            $this->db->insert('crit_fr_stationery_invoice_info', $ins); 
            
            $fr_stationery_invoice_id = $this->db->insert_id();
            $stationery_item_ids = $this->input->post('stationery_item_id');
            $qty = $this->input->post('qty');
            $rate = $this->input->post('rate');
            $amount = $this->input->post('amount');
            
            foreach($stationery_item_ids as $i => $stationery_item_id){ 
            
              if(!empty($stationery_item_id)){  
                     $ins1 = array(
                            'fr_stationery_invoice_id' => $fr_stationery_invoice_id,
                            'stationery_item_id' => $stationery_item_id,               
                            'qty' => $qty[$i],               
                            'rate' => $rate[$i],               
                            'amount' => $amount[$i],               
                    );
                    
                    $this->db->insert('crit_fr_stationery_invoice_itm_info', $ins1); 
                }
            }
            
            
            
            redirect('stationery-invoice-list');
        }
        
        if($this->input->post('mode') == 'Edit')
        {
            $upd = array(
                    'franchise_id' => $this->input->post('franchise_id'),
                    'invoice_no' => $this->input->post('invoice_no'),
                    'invoice_date' => $this->input->post('invoice_date'),
                    'email_chrg' => $this->input->post('email_chrg'),
                    'id_card_chrg' => $this->input->post('id_card_chrg'),
                    'transit_chrg' => $this->input->post('transit_chrg'),
                    'tot_amt' => $this->input->post('tot_amt'),
                    'status' => 'Active',                 
            );
            
            $this->db->where('fr_stationery_invoice_id', $this->input->post('fr_stationery_invoice_id'));
            $this->db->update('crit_fr_stationery_invoice_info', $upd); 
            
            
            $fr_stationery_invoice_id = $this->input->post('fr_stationery_invoice_id');
            $fr_stationery_invoice_itm_ids = $this->input->post('fr_stationery_invoice_itm_id');
            $stationery_item_ids = $this->input->post('stationery_item_id');
            $qty = $this->input->post('qty');
            $rate = $this->input->post('rate');
            $amount = $this->input->post('amount');
            
            foreach($fr_stationery_invoice_itm_ids as $i => $fr_stationery_invoice_itm_id){ 
            
              if(empty($fr_stationery_invoice_itm_id)){  
                 if(!empty($stationery_item_ids[$i])){  
                     $ins1 = array(
                            'fr_stationery_invoice_id' => $fr_stationery_invoice_id,
                            'stationery_item_id' => $stationery_item_ids[$i],               
                            'qty' => $qty[$i],               
                            'rate' => $rate[$i],               
                            'amount' => $amount[$i],               
                    );
                    
                    $this->db->insert('crit_fr_stationery_invoice_itm_info', $ins1); 
                 }
                } else {
                    
                  $upd = array(
                            'fr_stationery_invoice_id' => $fr_stationery_invoice_id,
                            'stationery_item_id' =>  $stationery_item_ids[$i],
                            'qty' => $qty[$i],               
                            'rate' => $rate[$i],               
                            'amount' => $amount[$i],                 
                    );
                    
                    $this->db->where('fr_stationery_invoice_itm_id', $fr_stationery_invoice_itm_id);
                    $this->db->update('crit_fr_stationery_invoice_itm_info', $upd);   
                    
                }
            }
                            
            redirect('stationery-invoice-list/' . $this->uri->segment(2, 0)); 
        } 
        
        
        
        
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_franchise_id'] = $srch_franchise_id = $this->input->post('srch_franchise_id'); 
           $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           $this->session->set_userdata('srch_franchise_id', $this->input->post('srch_franchise_id'));
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_franchise_id'] = $srch_franchise_id = $this->session->userdata('srch_franchise_id') ;
       } else {
        $data['srch_from_date'] = date('Y-m-01');
        $data['srch_to_date'] = date('Y-m-d');
        $data['srch_franchise_id'] = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date) && !empty($srch_franchise_id) ){
        $where = " a.invoice_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        $where .= " and a.franchise_id = '". $srch_franchise_id ."' ";
        
        $data['submit_flg'] = true;
         
       }    
        
        
        /*   $sql = "
                    select 
                    c.franchise_type_name,
                    a.franchise_id,
                    a.contact_person,
                    a.state_code,
                    a.city_code,
                    b.city_name as city
                    from crit_franchise_info as a
                    left join crit_franchise_type_info as c on c.franchise_type_id = a.franchise_type_id
                    left join crit_city_info as b on b.city_code = a.city_code
                    left join franchises_ts_rate_info as d on d.franchise_id = a.franchise_id
                    where a.`status` = 'Active' and d.`status` = 'Active'
                    group by a.franchise_id
                    order by c.franchise_type_name asc , a.state_code , b.city_name, a.contact_person asc          
            "; */
            
            $sql = "
                    select 
                    c.franchise_type_name,
                    a.franchise_id,
                    a.contact_person,
                    a.state_code,
                    a.city_code,
                    b.city_name as city
                    from crit_franchise_info as a
                    left join crit_franchise_type_info as c on c.franchise_type_id = a.franchise_type_id
                    left join crit_city_info as b on b.city_code = a.city_code  and b.`status` = 'Active'
                    where a.`status` = 'Active' 
                    group by a.franchise_id
                    order by c.franchise_type_name asc , a.state_code , b.city_name, a.contact_person asc          
            "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['franchise_opt'][$row['franchise_type_name']][$row['franchise_id']] =  $row['state_code'] . ' - ' . $row['city'] .' [ ' . $row['contact_person']. ' ]';     
        }
        
        
        if($data['submit_flg']) {
        
        $this->load->library('pagination'); 
        
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where($where); 
        $this->db->from('crit_fr_stationery_invoice_info as a');         
        $this->db->group_by('a.invoice_no');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('stationery-invoice-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] =  "Prev";
        $config['next_link'] =  "Next";
        $this->pagination->initialize($config);   
        
        $sql = "
                select  
                a.invoice_no,
                a.invoice_date,
                b.contact_person, 
                c.franchise_type_name as franchise_type,
                a.*
                from crit_fr_stationery_invoice_info as a
                left join crit_franchise_info as b on b.franchise_id= a.franchise_id
                left join crit_franchise_type_info as c on c.franchise_type_id= b.franchise_type_id
                where a.`status` != 'Delete' and
                $where      
                group by a.invoice_no                             
                order by a.invoice_date desc                             
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        }
        
        
        $sql = "
                select 
                a.stationery_item_id,                
                a.stationery_item_name ,
                a.rate           
                from crit_stationery_item_info as a  
                where status = 'Active' 
                order by a.stationery_item_name asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['stationery_item_opt'][] = $row;     
        }
        
        $this->load->view('page/stationary-invoice-list',$data); 
	}  
    
    public function customer_invoice_generate()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        date_default_timezone_set("Asia/Calcutta"); 
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        
        
        if($this->input->post('btn_generate') == 'Generate Invoice')
        { 
            $awb_nos = $this->input->post('awb_nos');
            /*echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();*/
            if(!empty($awb_nos))
            {
                
                /*
                $this->db->select('(ifnull(max(invoice_no),0) + 1) as invoice_no');
                $this->db->from('crit_customer_invoice_info');
                $this->db->where('status != "Delete"');
                $this->db->where('invoice_date >= "2024-09-01"');
                $query = $this->db->get();
                $row = $query->row();
                if (isset($row)) {
                    $invoice_no = $row->invoice_no;
                }
                */
                
                $query = $this->db->query("select `generate_invoice_no`('". $this->input->post('invoice_date') ."') as invoice_no ");
                $row = $query->row();
                if (isset($row)) {
                    $invoice_no = $row->invoice_no;
                }
                
                
                
                $this->db->select(' sum(grand_total) as invoice_amount');
                $this->db->from('crit_booking_info');
                $this->db->where_in('awbno', $awb_nos);
                $query = $this->db->get();
                $row = $query->row();
                if (isset($row)) {
                    $invoice_amount = $row->invoice_amount;
                }  
                
                $ins  = array(
                        'invoice_date' => $this->input->post('invoice_date'),
                        'customer_id' => $this->input->post('customer_id')  ,                          
                        'awb_nos' => implode(',',$awb_nos)  ,                          
                        'invoice_amount' => $invoice_amount  ,                          
                        'invoice_no' => $invoice_no  ,                          
                        'status' => 'Pending' , 
                        'created_by' =>  $this->session->userdata('cr_user_id'),
                        'created_datetime' => date('Y-m-d H:i:s')   
                                              
                );
                $this->db->insert('crit_customer_invoice_info', $ins); 
                
                $customer_invoice_id = $this->db->insert_id();
                
                redirect('print-invoice/' . $customer_invoice_id);    
               // redirect('customer-invoice-generate');    
            }  
             
        }
        
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
      if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
            
       } else {
        $data['srch_from_date'] = date('Y-m-d');
        $data['srch_to_date'] = date('Y-m-d');
        $data['srch_customer_id'] = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date) && !empty($srch_customer_id) ){
        $where = " a.booking_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        $where .= " and a.consignor_id = '". $srch_customer_id ."' ";
        
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['customer_code'] . ':' . $row['company']. ' - ' . $row['contact_person']  ;     
        }
        
        if($data['submit_flg']) {
        
          
        
        $sql = "
                select  
                a.booking_id,
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.chargable_weight,
                a.grand_total,
                a.`status`
                from crit_booking_info as a
                where a.`status` != 'Delete' and
                $where      
                order by a.booking_date asc , a.booking_time asc                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
         
        }
        
        $this->load->view('page/customer-invoice-generate',$data); 
	}
    
    public function customer_invoice_list()
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
        $data['js'] = 'reports.inc'; 
        $data['submit_flg'] = false;
        
       if(isset($_POST['srch_from_date'])) {
           $data['srch_from_date'] = $srch_from_date = $this->input->post('srch_from_date'); 
           $data['srch_to_date'] = $srch_to_date = $this->input->post('srch_to_date'); 
           $data['srch_customer_id'] = $srch_customer_id = $this->input->post('srch_customer_id'); 
           $this->session->set_userdata('srch_from_date', $this->input->post('srch_from_date'));
           $this->session->set_userdata('srch_to_date', $this->input->post('srch_to_date'));
           $this->session->set_userdata('srch_customer_id', $this->input->post('srch_customer_id'));
       }
       elseif($this->session->userdata('srch_from_date')){
           $data['srch_from_date'] = $srch_from_date = $this->session->userdata('srch_from_date') ;
           $data['srch_to_date'] = $srch_to_date = $this->session->userdata('srch_to_date') ;
           $data['srch_customer_id'] = $srch_customer_id = $this->session->userdata('srch_customer_id') ;
       } else {
        $data['srch_from_date'] = date('Y-m-d');
        $data['srch_to_date'] = date('Y-m-d');
        $data['srch_customer_id'] = '';
       }
       
       if(!empty($srch_from_date) && !empty($srch_to_date) && !empty($srch_customer_id) ){
        $where = " a.invoice_date between '" . $srch_from_date . "' and  '". $srch_to_date ."'";
        $where .= " and a.customer_id = '". $srch_customer_id ."' ";
        
        $data['submit_flg'] = true;
         
       }    
        
        
        $sql = "
                select 
                a.customer_id,                
                a.company ,
                a.contact_person,
                a.customer_code            
                from crit_customer_info as a  
                where status = 'Active' 
                order by a.company , a.contact_person asc                 
        "; 
        
        $query = $this->db->query($sql);
       
        foreach ($query->result_array() as $row)
        {
            $data['customer_opt'][$row['customer_id']] = $row['company']. ' - ' . $row['contact_person']  ;     
        }
        
        if($data['submit_flg']) {
        
        $this->load->library('pagination'); 
        
        $this->db->where('a.status != ', 'Delete'); 
        $this->db->where($where); 
        $this->db->from('crit_customer_invoice_info as a');         
        $data['total_records'] = $cnt  = $this->db->count_all_results();  
        
        $data['sno'] = $this->uri->segment(2, 0);		
        	
        $config['base_url'] = trim(site_url('customer-invoice-list/'), '/'. $this->uri->segment(2, 0));
        $config['total_rows'] = $cnt;
        $config['per_page'] = 20;
        $config['uri_segment'] = 2;
        //$config['num_links'] = 2; 
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] =  "Prev";
        $config['next_link'] =  "Next";
        $this->pagination->initialize($config);   
        
        $sql = "
                select  
                a.customer_invoice_id,
                a.invoice_no,
                a.invoice_date,
                b.company as customer,
                a.awb_nos,
                a.invoice_amount, 
                a.`status`
                from crit_customer_invoice_info as a
                left join crit_customer_info as b on b.customer_id= a.customer_id
                where a.`status` != 'Delete' and
                $where      
                order by a.invoice_date desc                             
                limit ". $this->uri->segment(2, 0) .",". $config['per_page'] ."                
        ";
        
        
        $query = $this->db->query($sql);
        
        //$data['record_list'] = array();
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list'][] = $row;     
        }
        
        $data['pagination'] = $this->pagination->create_links();
        }
        
        $this->load->view('page/customer-invoice-list',$data); 
	}  
    
    public function print_invoice($invoice_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
          
        
         
        
        $sql = "
                select  
                a.customer_invoice_id,
                a.invoice_no,
                a.invoice_date,
                b.company as customer,
                b.contact_person,
                b.address,
                b.email,
                b.phone,
                b.mobile,
                b.gst_no,
                b.state_code,
                a.awb_nos,
                a.invoice_amount, 
                a.`status`
                from crit_customer_invoice_info as a
                left join crit_customer_info as b on b.customer_id= a.customer_id
                where a.`status` != 'Delete' 
                and a.customer_invoice_id = '". $invoice_id ."'      
                order by a.invoice_date desc                 
        ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['record_list']  = $row;   
            $awb_nos = $row['awb_nos'];  
        }
        
        $sql = "
                select  
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.chargable_weight,
                a.cod_charges,
                a.fod_charges,
                a.fov_charges,
                a.fuel_charges,
                a.rate,
                a.sub_total,
                a.tax_percentage,
                a.tax_amt,
                a.grand_total 
                from crit_booking_info as a
                where a.`status` != 'Delete' 
                and a.awbno in (". $awb_nos .")     
                order by a.booking_date asc , a.awbno asc                 
        ";
        
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
         
        
        $this->load->view('page/print-invoice',$data); 
	}   
    
    
    public function print_awb_label($booking_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */ 
        
        $sql = "
                select  
                a.*
                from crit_booking_info as a
                where a.`status` != 'Delete' 
                and a.booking_id  = $booking_id   
                order by a.booking_date asc , a.awbno asc                 
        ";
        
        
        $query = $this->db->query($sql); 
        $code = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['label']  = $row;   
            $code = $row['awbno'];   
        }
        
        
        if(!file_exists('barcodes/'.$code.'.png')){
        
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
        imagepng($imageResource, 'barcodes/'.$code.'.png');
        
        }
        
        $data['barcode'] = 'barcodes/'.$code.'.png';
         
        
        $this->load->view('page/print-awb-label',$data); 
	}  
    
    public function print_awbno($booking_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	 
        
        
        $sql = "
                select  
                a.*,
                b.service_name
                from crit_booking_info as a
                left join crit_service_info as b on b.service_id = a.service_id
                where a.`status` != 'Delete' 
                and a.booking_id  = $booking_id   
                order by a.booking_date asc , a.awbno asc                 
        ";
        
        
        $query = $this->db->query($sql); 
        
        $code = 0;
       
        foreach ($query->result_array() as $row)
        {
            $data['label']  = $row; 
            
            $code = $row['awbno'];    
        }
        
        
        //echo file_exists('barcodes/'.$code.'.png');
        
        if(!file_exists('barcodes/'.$code.'.png')){
        
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');
        //generate barcode
        $imageResource = Zend_Barcode::factory('code128', 'image', array('text'=>$code), array())->draw();
        imagepng($imageResource, 'barcodes/'.$code.'.png');
        
        }
        
        
        $data['barcode'] = 'barcodes/'.$code.'.png'; 
        
         
        
        $this->load->view('page/print-awbno',$data); 
	}   
    
    public function print_ts_invoice($invoice_no)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
          
        
         
        $this->db->query('SET SQL_BIG_SELECTS=1');
         
        
       /* $sql = " 
                
                select  distinct
                z.invoice_no,
                z.invoice_date,
                z.franchise_id,
                e.contact_person,
                e.mobile,
                e.address, 
                e.state_code as fr_state_code,               
                z.gst,
                z.ts_amount,
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.chargable_weight, 
                b.state_code as org_state_code,
                c.state_code as dest_state_code,
                b.branch_code,
                c.branch_code as dest_city_code,
                c.metro_city,
                a.`status`,
                z.ts_amt,
                z.fod,
                z.cod,
                z.oda
                from crit_ts_invoice_info as z
                left join crit_booking_info as a on a.awbno = z.awb_no
                left join crit_servicable_pincode_info as b on b.pincode = a.origin_pincode
                left join crit_servicable_pincode_info as c on c.pincode = a.dest_pincode
                left join crit_transhipment_rate_info as d on 
                	d.flg_region = (if(b.zone = c.zone,1,0))
                   and d.flg_state = (if(b.state_code = c.state_code,1,0)) 
                   and d.flg_city = (if(b.branch_code = c.branch_code,1,0))             
                   and (if(b.zone = c.zone,1,d.flg_metro = (if(c.metro_city = 'Y',1,0)))) 
                   and d.from_weight <= a.chargable_weight and d.to_weight >= a.chargable_weight
                left join crit_franchise_info as e on e.franchise_id = z.franchise_id   
                where a.`status` != 'Delete' and z.invoice_no = '". $invoice_no ."'
                group by a.awbno 
                order by a.awbno, a.booking_date asc , a.booking_time asc           
        ";
        */
        
        $sql = "
            select 
            z.invoice_no,
            z.invoice_date,
            a.booking_date,
            e.contact_person,
            e.mobile,
            e.address, 
            e.state_code as fr_state_code, 
            z.awb_no,
            a.origin_pincode,
            a.origin_state_code,
            a.origin_city_code,
            a.dest_pincode,
            a.dest_state_code,
            a.dest_city_code,
            a.chargable_weight,
            a.no_of_pieces,
            z.ts_amt,
            z.fod,
            z.cod,
            z.oda,
            z.gst,
            z.ts_amount    
            from crit_ts_invoice_info as z
            left join crit_booking_info as a 
                    on a.awbno = z.awb_no 
                    and a.`status` != 'Delete'
                    and a.created_by in ( select q.user_id from crit_user_info as q where q.franchise_id = z.franchise_id )
            left join crit_franchise_info as e on e.franchise_id = z.franchise_id   
            where z.invoice_no = '". $invoice_no ."'  and z.`status` != 'Delete'
            order by z.invoice_no , z.awb_no 
        
        ";
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
         
        
        $this->load->view('page/print-ts-invoice',$data); 
	}  
    
    
    public function print_ts_invoice_v2_old($invoice_no , $inv_date)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
          
        //echo $inv_date;
         
        $this->db->query('SET SQL_BIG_SELECTS=1');
         
        
       /* $sql = " 
                
                select  distinct
                z.invoice_no,
                z.invoice_date,
                z.franchise_id,
                e.contact_person,
                e.mobile,
                e.address, 
                e.state_code as fr_state_code,               
                z.gst,
                z.ts_amount,
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.chargable_weight, 
                b.state_code as org_state_code,
                c.state_code as dest_state_code,
                b.branch_code,
                c.branch_code as dest_city_code,
                c.metro_city,
                a.`status`,
                z.ts_amt,
                z.fod,
                z.cod,
                z.oda
                from crit_ts_invoice_info as z
                left join crit_booking_info as a on a.awbno = z.awb_no
                left join crit_servicable_pincode_info as b on b.pincode = a.origin_pincode
                left join crit_servicable_pincode_info as c on c.pincode = a.dest_pincode
                left join crit_transhipment_rate_info as d on 
                	d.flg_region = (if(b.zone = c.zone,1,0))
                   and d.flg_state = (if(b.state_code = c.state_code,1,0)) 
                   and d.flg_city = (if(b.branch_code = c.branch_code,1,0))             
                   and (if(b.zone = c.zone,1,d.flg_metro = (if(c.metro_city = 'Y',1,0)))) 
                   and d.from_weight <= a.chargable_weight and d.to_weight >= a.chargable_weight
                left join crit_franchise_info as e on e.franchise_id = z.franchise_id   
                where a.`status` != 'Delete' and z.invoice_no = '". $invoice_no ."'
                group by a.awbno 
                order by a.awbno, a.booking_date asc , a.booking_time asc           
        ";
        */
        
        $sql = "
            select 
            z.invoice_no,
            z.invoice_date,
            a.booking_date,
            e.contact_person,
            e.mobile,
            e.address, 
            e.state_code as fr_state_code, 
            z.awb_no,
            a.origin_pincode,
            a.origin_state_code,
            a.origin_city_code,
            a.dest_pincode,
            a.dest_state_code,
            a.dest_city_code,
            a.chargable_weight,
            a.no_of_pieces,
            z.ts_amt,
            z.fod,
            z.cod,
            z.oda,
            z.gst,
            z.fsc,
            z.ts_amount    
            from crit_ts_invoice_info as z
            left join crit_booking_info as a 
                    on a.awbno = z.awb_no 
                    and a.`status` != 'Delete'
                    and a.created_by in ( select q.user_id from crit_user_info as q where q.franchise_id = z.franchise_id )
            left join crit_franchise_info as e on e.franchise_id = z.franchise_id   
            where z.invoice_no = '". $invoice_no ."' 
             and z.`invoice_date` =  '". date('Y-m-d',$inv_date) ."' 
             and z.`status` != 'Delete'
            order by z.invoice_no , z.awb_no 
        
        ";
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
         
        
        $this->load->view('page/print-ts-invoice',$data); 
	}
    
    
    public function print_ts_invoice_v2($ts_franchise_invoice_id , $inv_date)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
          
        //echo $inv_date;
         
        $this->db->query('SET SQL_BIG_SELECTS=1');
         
        
       /* $sql = " 
                
                select  distinct
                z.invoice_no,
                z.invoice_date,
                z.franchise_id,
                e.contact_person,
                e.mobile,
                e.address, 
                e.state_code as fr_state_code,               
                z.gst,
                z.ts_amount,
                a.awbno,
                a.booking_date,
                a.booking_time,
                a.origin_pincode,
                a.origin_state_code,
                a.origin_city_code,
                a.dest_pincode,
                a.dest_state_code,
                a.dest_city_code,
                a.customer_ref_no,
                a.no_of_pieces,
                a.chargable_weight, 
                b.state_code as org_state_code,
                c.state_code as dest_state_code,
                b.branch_code,
                c.branch_code as dest_city_code,
                c.metro_city,
                a.`status`,
                z.ts_amt,
                z.fod,
                z.cod,
                z.oda
                from crit_ts_invoice_info as z
                left join crit_booking_info as a on a.awbno = z.awb_no
                left join crit_servicable_pincode_info as b on b.pincode = a.origin_pincode
                left join crit_servicable_pincode_info as c on c.pincode = a.dest_pincode
                left join crit_transhipment_rate_info as d on 
                	d.flg_region = (if(b.zone = c.zone,1,0))
                   and d.flg_state = (if(b.state_code = c.state_code,1,0)) 
                   and d.flg_city = (if(b.branch_code = c.branch_code,1,0))             
                   and (if(b.zone = c.zone,1,d.flg_metro = (if(c.metro_city = 'Y',1,0)))) 
                   and d.from_weight <= a.chargable_weight and d.to_weight >= a.chargable_weight
                left join crit_franchise_info as e on e.franchise_id = z.franchise_id   
                where a.`status` != 'Delete' and z.invoice_no = '". $invoice_no ."'
                group by a.awbno 
                order by a.awbno, a.booking_date asc , a.booking_time asc           
        ";
        */
        
        $sql = "
            select 
            z.invoice_no,
            z.invoice_date,
            a.booking_date,
            e.contact_person,
            e.mobile,
            e.address, 
            e.state_code as fr_state_code, 
            z.awb_no,
            a.origin_pincode,
            a.origin_state_code,
            a.origin_city_code,
            a.dest_pincode,
            a.dest_state_code,
            a.dest_city_code,
            a.chargable_weight,
            a.no_of_pieces,
            z.ts_amt,
            z.fod,
            z.cod,
            z.oda,
            z.gst,
            z.fsc,
            z.ts_amount    
            from crit_ts_invoice_info as z
            left join crit_booking_info as a 
                    on a.awbno = z.awb_no 
                    and a.`status` != 'Delete'
                    and a.created_by in ( select q.user_id from crit_user_info as q where q.franchise_id = z.franchise_id )
            left join crit_franchise_info as e on e.franchise_id = z.franchise_id   
            where z.ts_franchise_invoice_id = '". $ts_franchise_invoice_id ."'  
            and z.`status` != 'Delete'
            order by z.invoice_no , z.awb_no 
        
        ";
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
         
        
        $this->load->view('page/print-ts-invoice',$data); 
	}  
    
    public function print_stationery_invoice($invoice_id)
	{
	    if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        /*if($this->session->userdata('m_is_admin') != USER_ADMIN) 
        {
            echo "<h3 style='color:red;'>Permission Denied</h3>"; exit;
        } */
        	    
          
        
         
        $this->db->query('SET SQL_BIG_SELECTS=1');
         
        
         
        $sql = "
         select 
        a.fr_stationery_invoice_id,
        a.franchise_id,
        a.invoice_no,
        a.invoice_date,
        a.email_chrg,
        a.id_card_chrg,
        a.transit_chrg,
        d.contact_person,
        d.address,
        d.state_code,
        d.gst_no,
        d.mobile,
        c.stationery_item_name,
        b.qty ,
        b.rate,
        b.amount 
        from crit_fr_stationery_invoice_info as a
        left join crit_fr_stationery_invoice_itm_info as b on b.fr_stationery_invoice_id = a.fr_stationery_invoice_id
        left join crit_stationery_item_info as c on c.stationery_item_id = b.stationery_item_id
        left join crit_franchise_info as d on d.franchise_id = a.franchise_id
        where a.fr_stationery_invoice_id = $invoice_id
        order by a.fr_stationery_invoice_id , c.stationery_item_name asc
         
        
        ";
        
        $query = $this->db->query($sql); 
       
        foreach ($query->result_array() as $row)
        {
            $data['bill_list'][] = $row;     
        }
        
         
        $data['invoice_id'] = $invoice_id;
        
        $this->load->view('page/print-stationery-invoice',$data); 
	}  
    
    
}
