<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('page/dashboard');
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
    
    public function update_data()  
    {
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
        
        
       $table = $this->input->post('tbl') ;
       $rec_id =$this->input->post('id');
       
       if($table == 'franchise-domestic-rate')
       { 
            
            $this->db->where('franchise_domestic_rate_id', $rec_id);
            $this->db->update('crit_franchise_domestic_rate_info', 
                        array(
                                'status' => 'In-Active' ,
                                'updated_by' => $this->session->userdata('cr_user_id'),                          
                                'update_datetime' => date('Y-m-d H:i:s')   
                              )); 
            
            $ins = array(
                    'franchise_id' => $this->input->post('franchise_id'),
                    'flg_region' => $this->input->post('flg_region'),
                    'flg_state' => $this->input->post('flg_state'),
                    'flg_city' => $this->input->post('flg_city'),
                    'flg_metro' => $this->input->post('flg_metro'),
                    'min_weight' => $this->input->post('min_weight'),
                    'min_charges' => $this->input->post('min_charges'),
                    'addt_weight' => $this->input->post('addt_weight'),
                    'addt_charges' => $this->input->post('addt_charges'),              
                    'c_type' => $this->input->post('c_type'),              
                    'rate_as_on' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')             
            );
            
            $this->db->insert('crit_franchise_domestic_rate_info', $ins);            
       }
       
       if($table == 'customer-domestic-rate')
       {             
            $this->db->where('customer_domestic_rate_id', $rec_id);
            $this->db->update('crit_customer_domestic_rate_info', 
                        array(
                                'status' => 'In-Active' ,
                                'updated_by' => $this->session->userdata('cr_user_id'),                          
                                'update_datetime' => date('Y-m-d H:i:s')   
                              )); 
            
            $ins = array(
                    'customer_id' => $this->input->post('customer_id'),
                    'flg_region' => $this->input->post('flg_region'),
                    'flg_state' => $this->input->post('flg_state'),
                    'flg_city' => $this->input->post('flg_city'),
                    'flg_metro' => $this->input->post('flg_metro'),
                    'min_weight' => $this->input->post('min_weight'),
                    'min_charges' => $this->input->post('min_charges'),
                    'addt_weight' => $this->input->post('addt_weight'),
                    'addt_charges' => $this->input->post('addt_charges'),              
                    'c_type' => $this->input->post('c_type'),              
                    'rate_as_on' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')             
            );
            
            $this->db->insert('crit_customer_domestic_rate_info', $ins);            
       }
       
       if($table == 'customer-domestic-rate-v2')
       {             
            $this->db->where('customer_domestic_rate_id', $rec_id);
            $this->db->update('crit_customer_domestic_rate_info_v2', 
                        array(
                                'customer_id' => $this->input->post('customer_id'),                    
                                'flg_region' => $this->input->post('flg_region'),
                                'flg_state' => $this->input->post('flg_state'),
                                'flg_city' => $this->input->post('flg_city'),
                                'flg_metro' => $this->input->post('flg_metro'),
                                'min_weight' => $this->input->post('min_weight'),
                                'min_charges' => $this->input->post('min_charges'), 
                                'addt_weight' => $this->input->post('addt_weight'),
                                'addt_charges' => $this->input->post('addt_charges'),              
                                'c_type' => $this->input->post('c_type'),              
                                'rate_as_on' => date('Y-m-d'),
                                'updated_by' => $this->session->userdata('cr_user_id'),                          
                                'update_datetime' => date('Y-m-d H:i:s')   
                              ));          
       }
       
       if($table == 'received-manifest')
         {       
            $sql = "
                select 
                manifest_no 
                from crit_manifest_info where  
                awbno = '".$rec_id ."' and 
                to_city_code = '".$this->input->post('city_code') ."' and
                m_status = 'Open Manifest' 
                and exists (select * from crit_booking_info as c where c.awbno = awbno )
            ";
            $query = $this->db->query($sql);

           $cnt = $query->num_rows($sql);
           
           if($cnt == 1) {
            
            $this->db->where('awbno', $rec_id);
            $this->db->where('m_status', 'Open Manifest');
            $this->db->update('crit_manifest_info', array('received_by' => $this->session->userdata('cr_user_id'),'received_date' => date('Y-m-d H:i:s'),'m_status' => 'Received Manifest'));  
            
            $this->db->where('awbno', $rec_id);
            $this->db->update('crit_booking_info', array('status' => $this->get_tracking_status_name('4') ,'status_city_code' => $this->input->post('city_code') ));   
           
           
            $ins = array(
                        'awbno' => $rec_id,
                        'tracking_status' => $this->get_tracking_status_name('4') ,                          
                        'city_code' => $this->input->post('city_code')  ,                          
                        'status_date' => date('Y-m-d')  ,                          
                        'status_time' => date('H:i:s'),                          
                        'remarks' => $this->input->post('city_code') . '[ '. $this->input->post('m_type').' ]', 
                        'created_by' =>  $this->session->userdata('cr_user_id')  ,
                        'created_datetime' => date('Y-m-d H:i:s')
                        );
             $this->db->insert('crit_awb_tracking_info', $ins);  
           
             echo 'Record Successfully Updated'; 
            } else {
                echo 'Invalid AWB No'; 
            }
         } 
       
        
    }
    
    public function insert_data()  
    {
        //if(!$this->session->userdata('cr_logged_in'))  redirect();
        
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
        
        
       $table = $this->input->post('tbl') ; 
       
       if($table == 'co-loader')
       {    
            $ins = array(
                    'co_loader_name' => $this->input->post('co_loader_name'), 
                    'created_by' => $this->session->userdata('cr_user_id'),                          
                    'created_datetime' => date('Y-m-d H:i:s')             
            );
            
            $this->db->insert('crit_co_loader_info', $ins); 
            
            return $this->db->insert_id();         
       } 
       
       if($table == 'open-manifest')
       {    
        
            $sql = "
                select 
                manifest_no 
                from crit_manifest_info where 
                manifest_date = '".$this->input->post('manifest_date') ."' and 
                from_city_code = '".$this->input->post('from_city_code') ."' and 
                to_city_code = '".$this->input->post('to_city_code') ."' and
                m_status = 'Open Manifest' 
            ";
            $query = $this->db->query($sql);

           $cnt = $query->num_rows($sql);

            if($cnt == 0) {
                 $ins = array(
                            'manifest_no' => $this->input->post('manifest_no'),
                            'manifest_date' => $this->input->post('manifest_date')  ,                          
                            'manifest_type' => $this->input->post('manifest_type')  ,                          
                            'from_city_code' => $this->input->post('from_city_code')  ,                          
                            'to_city_code' => $this->input->post('to_city_code'),                          
                            'co_loader_id' => $this->input->post('co_loader_id'),                          
                            'co_loader_awb_no' => $this->input->post('co_loader_awb_no'),                          
                            'co_loader_remarks' => $this->input->post('co_loader_remarks'),                          
                            'awbno' => $this->input->post('awbno') ,                          
                            'm_status' => 'Open Manifest',  
                            'despatch_by' =>  $this->session->userdata('cr_user_id')  
                            );
                 $this->db->insert('crit_manifest_info', $ins);  
             }   
            
                     
       } 
       if($table == 'awb_tracking_info')
       {    
             $ins = array(
                        'awbno' => $this->input->post('awbno'),
                        'tracking_status' => $this->input->post('tracking_status')  ,                          
                        'city_code' => $this->input->post('city_code')  ,                          
                        'status_date' => $this->input->post('status_date')  ,                          
                        'status_time' => $this->input->post('status_time'),                          
                        'remarks' => $this->input->post('remarks'), 
                        'created_by' =>  $this->session->userdata('cr_user_id') ,
                        'created_datetime' => date('Y-m-d H:i:s') 
                        );
             $this->db->insert('crit_awb_tracking_info', $ins);      
             
             $upd = array(
                    'status' => $this->input->post('tracking_status')  , 
                    'status_city_code' => $this->input->post('city_code')
                    );
                    
             $this->db->where('awbno', $this->input->post('awbno'));         
             $this->db->update('crit_booking_info', $upd);         
                     
       } 
       
       if($table == 'ODA-pincode')
       {    
            $ins = array(
                    'pincode' => $this->input->post('pincode'),
                    'area' => $this->input->post('area'),
                    'premium_express' => 'Y',
                    'business_express' => 'Y',
                    'state_code' => $this->input->post('state_code'),
                    'zone' => $this->input->post('zone'),
                    'branch_code' => $this->input->post('branch_code'),  
                    'metro_city' => 'N',
                    'status' => 'Active'  ,                          
                    'serve_type' =>$this->input->post('serve_type')  ,                          
            );
            
            $this->db->insert('crit_servicable_pincode_info', $ins); 
            
            echo $this->input->post('pincode');         
       } 
        
        
    }
    
     
    
    public function get_courier_charges()
    {
        //$booking_id = $this->input->post('booking_id');
        $origin_pincode = $this->input->post('origin_pincode');
        $dest_pincode = $this->input->post('dest_pincode');
        $consignor_id = $this->input->post('consignor_id');
        $weight = $this->input->post('weight');
        $c_type = $this->input->post('c_type');
        
       /* $sql = "
            select 
            a.booking_id,
            a.awbno,
            a.origin_pincode,
            a.origin_state_code,
            a.origin_city_code,
            a.dest_pincode,
            a.dest_state_code,
            a.origin_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges,
            a.weight,
            a.no_of_pieces,
            if(c.min_weight <= a.weight, (a.weight - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from crit_booking_info as a
            left join crit_customer_domestic_rate_info as c on c.customer_id = a.consignor_id and c.flg_state = (if(a.origin_state_code = a.dest_state_code,1,0)) and c.flg_city = (if(a.origin_city_code = a.dest_city_code,1,0)) and c.`status` = 'Active'
            where a.booking_id = '". $booking_id ."'  and c.c_type = 'Air'
        
        "; */
        
        
        $this->db->query('SET SQL_BIG_SELECTS=1');
        
        /*
         $sql = "
            select 
            a.origin_state_code,
            a.origin_city_code, 
            b.dest_state_code,
            b.dest_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges, 
            if(c.min_weight <= '".$weight."', ('".$weight."' - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from (select q.state_code as origin_state_code, q.branch_code as origin_city_code  from crit_servicable_pincode_info as q where q.pincode = '". $origin_pincode ."'  and q.status = 'Active') as a  
            left join (select q1.state_code as dest_state_code, q1.branch_code as dest_city_code  from crit_servicable_pincode_info as q1 where q1.pincode = '". $dest_pincode ."'  and q1.status = 'Active') as b on 1=1
            left join crit_customer_domestic_rate_info as c on c.customer_id = '". $consignor_id ."' and c.flg_state = (if(b.dest_state_code = a.origin_state_code,1,0)) and c.flg_city = (if(b.dest_city_code = a.origin_city_code,1,0)) and c.`status` = 'Active'
            where 1 and c.c_type = '". $c_type ."'
        
        "; */
        
         $sql = "
            select 
            a.origin_state_code,
            a.origin_city_code, 
            b.dest_state_code,
            b.dest_city_code,
            c.min_weight,
            c.min_charges,
            if(c.min_weight >= CEILING('".$weight."'), (c.min_weight * c.min_charges), CEILING('".$weight."') * c.min_charges ) as tot_charges1,
           (c.min_charges + (if(c.min_weight <= '". $weight ."', CEILING(('". $weight ."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from (select q.state_code as origin_state_code, q.branch_code as origin_city_code, q.zone as origin_region, q.metro_city as origin_metro_city   from crit_servicable_pincode_info as q where q.pincode = '". $origin_pincode ."'  and q.status = 'Active') as a  
            left join (select q1.state_code as dest_state_code, q1.branch_code as dest_city_code ,q1.zone as dest_region, q1.metro_city as dest_metro_city  from crit_servicable_pincode_info as q1 where q1.pincode = '". $dest_pincode ."'  and q1.status = 'Active') as b on 1=1
            left join crit_customer_domestic_rate_info_v2 as c on c.customer_id = '". $consignor_id ."' 
            and c.flg_region = (if(b.dest_region = a.origin_region,1,0))
            and c.flg_state = (if(b.dest_state_code = a.origin_state_code,1,0)) 
            and c.flg_city = (if(b.dest_city_code = a.origin_city_code,1,0))             
            and (if(b.dest_region = a.origin_region,1,c.flg_metro = (if(b.dest_metro_city = 'Y',1,0))))
            and c.`status` = 'Active'
            where 1 and c.c_type = '". $c_type ."'
            and c.from_weight <= '". number_format($weight,0) ."'  and c.to_weight >= '". number_format($weight,0) ."' 
        
        ";
        //and c.flg_metro = (if(b.dest_metro_city = 'Y',1,0)) 
        //and c.from_weight <= CEILING('". $weight ."')  and c.to_weight >= CEILING('". $weight ."')
        
        $query = $this->db->query($sql);
        
        $charges = array();
        
        foreach ($query->result_array() as $row)
        {
          $charges = $row ;    
        }  
        
        $charges['sql'] = $sql;
        
        header('Content-Type: application/x-json; charset=utf-8');
        
        echo (json_encode($charges));
        
        //echo $sql;
        
    }
    
    public function get_courier_charges_old()
    {
        //$booking_id = $this->input->post('booking_id');
        $origin_pincode = $this->input->post('origin_pincode');
        $dest_pincode = $this->input->post('dest_pincode');
        $consignor_id = $this->input->post('consignor_id');
        $weight = $this->input->post('weight');
        $c_type = $this->input->post('c_type');
        
       /* $sql = "
            select 
            a.booking_id,
            a.awbno,
            a.origin_pincode,
            a.origin_state_code,
            a.origin_city_code,
            a.dest_pincode,
            a.dest_state_code,
            a.origin_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges,
            a.weight,
            a.no_of_pieces,
            if(c.min_weight <= a.weight, (a.weight - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= a.weight, CEILING((a.weight - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from crit_booking_info as a
            left join crit_customer_domestic_rate_info as c on c.customer_id = a.consignor_id and c.flg_state = (if(a.origin_state_code = a.dest_state_code,1,0)) and c.flg_city = (if(a.origin_city_code = a.dest_city_code,1,0)) and c.`status` = 'Active'
            where a.booking_id = '". $booking_id ."'  and c.c_type = 'Air'
        
        "; */
        
        
        $this->db->query('SET SQL_BIG_SELECTS=1');
        
        /*
         $sql = "
            select 
            a.origin_state_code,
            a.origin_city_code, 
            b.dest_state_code,
            b.dest_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges, 
            if(c.min_weight <= '".$weight."', ('".$weight."' - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from (select q.state_code as origin_state_code, q.branch_code as origin_city_code  from crit_servicable_pincode_info as q where q.pincode = '". $origin_pincode ."'  and q.status = 'Active') as a  
            left join (select q1.state_code as dest_state_code, q1.branch_code as dest_city_code  from crit_servicable_pincode_info as q1 where q1.pincode = '". $dest_pincode ."'  and q1.status = 'Active') as b on 1=1
            left join crit_customer_domestic_rate_info as c on c.customer_id = '". $consignor_id ."' and c.flg_state = (if(b.dest_state_code = a.origin_state_code,1,0)) and c.flg_city = (if(b.dest_city_code = a.origin_city_code,1,0)) and c.`status` = 'Active'
            where 1 and c.c_type = '". $c_type ."'
        
        "; */
        
         $sql = "
            select 
            a.origin_state_code,
            a.origin_city_code, 
            b.dest_state_code,
            b.dest_city_code,
            c.min_weight,
            c.min_charges,
            c.addt_weight,
            c.addt_charges, 
            if(c.min_weight <= '".$weight."', ('".$weight."' - c.min_weight) , 0 ) as addt_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) , 0 ) as addt_no_of_wt,
            if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ) as addt_charges_value,
            (c.min_charges + (if(c.min_weight <= '".$weight."', CEILING(('".$weight."' - c.min_weight) / c.addt_weight) * c.addt_charges  , 0 ))) as tot_charges
            from (select q.state_code as origin_state_code, q.branch_code as origin_city_code, q.zone as origin_region, q.metro_city as origin_metro_city   from crit_servicable_pincode_info as q where q.pincode = '". $origin_pincode ."'  and q.status = 'Active') as a  
            left join (select q1.state_code as dest_state_code, q1.branch_code as dest_city_code ,q1.zone as dest_region, q1.metro_city as dest_metro_city  from crit_servicable_pincode_info as q1 where q1.pincode = '". $dest_pincode ."'  and q1.status = 'Active') as b on 1=1
            left join crit_customer_domestic_rate_info as c on c.customer_id = '". $consignor_id ."' 
            and c.flg_region = (if(b.dest_region = a.origin_region,1,0))
            and c.flg_state = (if(b.dest_state_code = a.origin_state_code,1,0)) 
            and c.flg_city = (if(b.dest_city_code = a.origin_city_code,1,0))             
            and (if(b.dest_region = a.origin_region,1,c.flg_metro = (if(b.dest_metro_city = 'Y',1,0))))
            and c.`status` = 'Active'
            where 1 and c.c_type = '". $c_type ."'
        
        ";
        //and c.flg_metro = (if(b.dest_metro_city = 'Y',1,0)) 
        
        $query = $this->db->query($sql);
        
        $charges = array();
        
        foreach ($query->result_array() as $row)
        {
          $charges = $row ;    
        }  
        
        $charges['sql'] = $sql;
        
        header('Content-Type: application/x-json; charset=utf-8');
        
        echo (json_encode($charges));
        
        //echo $sql;
        
    }
    
    public function get_api_service($callback) 
    {
         $table = $this->input->post('tbl') ;
         $rec_id =$this->input->post('id');
         
         $this->db->query('SET SQL_BIG_SELECTS=1');
         
          $query = $this->db->query(" 
                select 
                COUNT(a.pincode_id) as cnt,
                c.state_name as state,
                a.state_code ,
                a.branch_code as city_code,
                d.city_name as city,
                a.serve_type
                from crit_servicable_pincode_info as a
                left join crit_states_info as c on c.state_code = a.state_code
                left join crit_city_info as d on d.city_code = a.branch_code
                where a.pincode like '%". $rec_id ."%'
                and a.`status` = 'Active' 
                group by a.pincode
                order by a.pincode, a.state_code asc 
            ");
            
            
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }  
             
          //  $rec_list['cnt'] = 'hi';     
            
           
       
       
            header('Content-Type: application/x-json; charset=utf-8');

            echo (json_encode($rec_list));     
       
       
    }
     
    public function get_data()  
	{
	   //if(!$this->session->userdata('zazu_logged_in'))  redirect();
       
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
       
       $table = $this->input->post('tbl') ;
       $rec_id =$this->input->post('id');
       
        $this->db->query('SET SQL_BIG_SELECTS=1');
        
        if($table == 'franchise_awbill_info')
       {
          $query = $this->db->query(" 
                select 
                * 
                from crit_franchise_awbill_info as a
                where a.franchise_awbill_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'check-awbno1')
       {
            if($this->input->post('vchk')!= 1) {
                
            $sql ="  
               (
                    select 
                    1 as awbill_chk,
                    a.awbno as awb_book
                    from crit_booking_info as a
                    where a.status != 'Delete' 
                    and a.awbno = '". $rec_id ."'
                )  
            ";    
            $query = $this->db->query($sql); 
            
            
            } else { 
               
              $f_id = $this->input->post('f_id'); 
               
              if($f_id != 0 ){
                $sql =  "  
                    select 
                    a.franchise_awbill_id,
                    count(a.franchise_awbill_id) as awbill_chk,
                    ifnull(c.awbno,0) awb_book,
                    round('". $rec_id ."') as awbno
                    from crit_franchise_awbill_info as a
                    left join (
                                (
                                    select 
                                    b.awbno  
                                    from crit_booking_info as b 
                                    where b.status != 'Delete' 
                                    and b.awbno = '". $rec_id ."'
                                )   
                              ) as c on c.awbno = '". $rec_id ."' 
                    where a.`status` != 'Delete'
                    and a.franchise_id = '". $f_id ."'
                    and '". $rec_id ."' between a.awbill_from and a.awbill_to
                    order by a.franchise_awbill_id desc limit 1
                " ; 
              } else {
                $sql =  "  
                    select 
                    a.franchise_awbill_id,
                    count(a.franchise_awbill_id) as awbill_chk,
                    ifnull(c.awbno,0) awb_book,
                    round('". $rec_id ."') as awbno
                    from crit_franchise_awbill_info as a
                    left join (
                                (
                                    select 
                                    b.awbno  
                                    from crit_booking_info as b 
                                    where b.status != 'Delete' 
                                    and b.awbno = '". $rec_id ."'
                                )   
                              ) as c on c.awbno = '". $rec_id ."' 
                    where a.`status` != 'Delete' 
                    and '". $rec_id ."' between a.awbill_from and a.awbill_to
                    order by a.franchise_awbill_id desc limit 1
                " ; 
              }
              
              $query = $this->db->query($sql);   
            }
             
            $rec_list = array(); 
            
            if($query->num_rows() > 0) { 
                foreach($query->result_array() as $row)
                {  
                    $rec_list  = $row;      
                } 
            } else {
                $rec_list['awbill_chk'] = 1;
                $rec_list['awb_book'] = 0;
            }
            
            $rec_list['sql'] = $sql; 
            /*
            if($query->num_rows() > 0)
                $rec_list['cnt'] = $query->num_rows(); 
            else {
                $rec_list['cnt'] = 0;  
            }
            */
          
       }
        
        if($table == 'service')
       {
          /*$query = $this->db->query(" 
                select 
                COUNT(a.pincode_id) as cnt,
                c.state_name as state,
                a.state_code ,
                a.branch_code as city_code,
                d.city_name as city,
                a.serve_type
                from crit_servicable_pincode_info as a
                left join crit_states_info as c on c.state_code = a.state_code
                left join crit_city_info as d on d.city_code = a.branch_code
                where a.pincode like '%". $rec_id ."%'
                and a.`status` = 'Active' 
                group by a.pincode
                order by a.pincode, a.state_code asc 
            ");
            
            
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }  */
            $rec_list['cnt'] = 'hi';          
       }
       
       if($table == 'pin-state')
       {
          $query = $this->db->query(" 
                select 
                c.state_name as state,
                a.state_code ,
                a.branch_code as city_code,
                d.city_name as city,
                a.serve_type
                from crit_servicable_pincode_info as a
                left join crit_states_info as c on c.state_code = a.state_code
                left join crit_city_info as d on d.city_code = a.branch_code
                where a.pincode = '". $rec_id ."'
                and a.`status` = 'Active' and c.`status` = 'Active'  and d.`status` = 'Active' 
                group by a.state_code
                order by a.state_code asc
                 
            ");
            
            
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;      
            }            
       }
       
       
       if($table == 'state-city')
       {
          $query = $this->db->query(" 
                select 
                a.city_name,
                a.city_code 
                from crit_city_info as a
                where a.state_code = '". $rec_id ."'
                and a.`status` = 'Active' 
                order by a.city_name asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;      
            }            
       }
       
       if($table == 'franchise-type-state')
       {
          $query = $this->db->query(" 
                select  
                a.state_code,
                b.state_name as state
                from crit_franchise_info as a 
                left join crit_states_info as b on b.state_code = a.state_code
                where a.franchise_type_id = '". $rec_id ."'
                group by b.state_name
                order by b.state_name asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;      
            }            
       }
       if($table == 'state-franchise')
       {
          $query = $this->db->query(" 
                select 
                a.franchise_id,   
                a.contact_person, 
                a.mobile,
                a.city_code    
                from crit_franchise_info as a 
                where a.state_code = '". $rec_id ."'
                and a.status = 'Active'
                order by a.contact_person 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'state-city-franchise-type')
       {
          $query = $this->db->query(" 
                select 
                a.franchise_id,   
                a.contact_person, 
                a.mobile,
                a.city_code    
                from crit_franchise_info as a 
                where a.franchise_type_id = '". $rec_id ."' and a.state_code = '". $this->input->post('state_code') ."' and a.city_code = '". $this->input->post('city_code') ."'
                and a.status = 'Active'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'city-serv-pincode')
       {
          $query = $this->db->query(" 
                select 
                a.pincode
                from crit_servicable_pincode_info as a
                where a.branch_code = '". $rec_id ."'
                and a.`status` = 'Active' 
                order by a.branch_code asc
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;      
            }  
          
       }
       if($table == 'get-franchise')
       {
          $query = $this->db->query(" 
                select 
                a.franchise_id, 
                a.franchise_type_id, 
                a.contact_person, 
                a.mobile, 
                a.phone, 
                a.email, 
                a.gst_no, 
                a.address, 
                a.state_code, 
                a.city_code, 
                a.branch_code, 
                a.hub_code, 
                a.servicable_pincode,
                a.`status`
                from crit_franchise_info as a 
                where a.franchise_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-agent')
       {
          $query = $this->db->query(" 
                select 
                a.agent_id,  
                a.contact_person, 
                a.mobile, 
                a.phone, 
                a.email,  
                a.address, 
                a.state_code, 
                a.city_code, 
                a.servicable_pincode, 
                a.`status`   
                from crit_agent_info as a 
                where a.agent_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-servicable-pincode')
       {
          $query = $this->db->query(" 
                select 
                a.*  
                from crit_servicable_pincode_info as a 
                where a.pincode_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-customer')
       {
          $query = $this->db->query(" 
                select 
                a.customer_id, 
                a.customer_code,
                a.customer_type_id,
                a.company, 
                a.contact_person, 
                a.mobile, 
                a.phone, 
                a.email,  
                a.address, 
                a.state_code, 
                a.city_code, 
                a.pincode, 
                a.gst_no,
                a.aadhar_no,
                a.`status`,
                a.franchise_type_id,
                a.franchise_id 
                from crit_customer_info as a
                where a.customer_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'get-customer-contact')
       {
          $query = $this->db->query(" 
                select 
                a.customer_contact_id, 
                a.cc_code,
                a.customer_group,
                a.company, 
                a.contact_person, 
                a.mobile, 
                a.phone, 
                a.email,  
                a.address, 
                a.state_code, 
                a.city_code, 
                a.pincode, 
                a.gst_no,
                a.aadhar_no,
                a.`status` 
                from crit_customer_contact_info as a
                where a.customer_contact_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       if($table == 'get-consignee')
       {
          $query = $this->db->query(" 
                select 
                a.customer_contact_id, 
                a.cc_code, 
                a.company, 
                a.contact_person 
                from crit_customer_contact_info as a
                where a.status='Active' and 
                a.customer_group= 'Consignee' and 
                a.customer_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'get-hub-branch-code')
       {
          $query = $this->db->query(" 
                select  
                b.state_code,
                a.hub_branch_name, 
                a.hub_branch_code 
                from crit_hub_branch_info as a
                left join crit_franchise_info as b on b.branch_code = a.hub_branch_code
                where a.status='Active' and a.type = '". $rec_id ."'
                order by a.hub_branch_name asc
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list[]  = $row;      
            }  
          
       }
       
       
       if($table == 'get-franchise-user')
       {
          $query = $this->db->query("  
                select 
                a.user_id,
                a.first_name, 
                a.user_name, 
                a.pwd, 
                a.`level`, 
                a.email, 
                a.mobile, 
                a.state, 
                a.city, 
                a.pincodes, 
                a.franchise_id, 
                a.`status` 
                from crit_user_info as a
                where a.user_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'crit_transhipment_rate_info')
       {
          $query = $this->db->query("  
                select 
                *
                from crit_transhipment_rate_info as a
                where a.transhipment_rate_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'franchises_ts_rate_info')
       {
          $query = $this->db->query("  
                select 
                *
                from franchises_ts_rate_info as a
                where a.franchises_ts_rate_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
          
       }
       
       if($table == 'fr_stationery_invoice_info')
       {
          $query = $this->db->query("  
                select 
                a.*
                from crit_fr_stationery_invoice_info as a
                where a.fr_stationery_invoice_id = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            }  
            
            
            $query = $this->db->query("  
                select 
                a.*
                from crit_fr_stationery_invoice_itm_info as a
                where a.fr_stationery_invoice_id = '". $rec_id ."'
                order by a.fr_stationery_invoice_itm_id
                
            "); 
    
            foreach($query->result_array() as $row)
            {  
                $rec_list['itm'][]  = $row;      
            }  
          
       }
       
       
       
       
       
       if($table == 'check-awbno')
       {
          $query = $this->db->query("  
                select 
                a.awbno
                from crit_booking_info as a
                where a.status != 'Delete' and a.awbno = '". $rec_id ."'
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {  
                $rec_list  = $row;      
            } 
            if($query->num_rows() > 0)
                $rec_list['cnt'] = $query->num_rows(); 
            else
                $rec_list['cnt'] = 0; 
          
       }
       
       
       
       
       
       if($table == 'franchish')
       {
            /* 
                select 
                DATE_FORMAT(a.booked_date,'%b %d')  as v_date,
                DATE_FORMAT(a.booked_date,'%Y%m%d') as v_date_num,
                count(a.pickup_id) as cnt
                from rh_pickup_info as a
                where a.status != 'Delete'
                group by DATE_FORMAT(a.booked_date,'%d-%m-%Y') 
                order by DATE_FORMAT(a.booked_date,'%Y%m%d') desc 
                limit 10
            */
          $query = $this->db->query(" 
                  select 
                    count(a.booking_id) as no_of_booking 
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    where a.`status` != 'Delete' and a.booking_date = '". date('Y-m-d')."'
                    and b.franchise_id = '". $rec_id ."' 
                    order by a.booking_id ;
            ");
            
            
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['cnt'][]  = $row['cnt'];  
                $rec_list['date'][]  = $row['v_date'];  
                //$rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'pickup-permonths')
       {
            /*
            $query = $this->db->query(" 
                
                select 
                DATE_FORMAT(a.booked_date,'%b %Y')  as v_month,
                DATE_FORMAT(a.booked_date,'%Y%m') as v_month_num,
                count(a.pickup_id) as cnt
                from rh_pickup_info as a
                where a.status != 'Delete'
                group by DATE_FORMAT(a.booked_date,'%b %y') 
                order by DATE_FORMAT(a.booked_date,'%Y%m') desc 
                limit 5
                 
            ");
            */
          $query = $this->db->query(" 
                
                select 
                    w.v_month_num,
                    w.v_month,
                    sum(cnt)  as cnt
                    from (
                        (
                            select 
                            DATE_FORMAT(a.booked_date,'%b %Y')  as v_month,
                            DATE_FORMAT(a.booked_date,'%Y%m') as v_month_num,
                            count(a.pickup_id) as cnt
                            from rh_pickup_info as a
                            where a.status != 'Delete'
                            group by DATE_FORMAT(a.booked_date,'%b %y') 
                            order by DATE_FORMAT(a.booked_date,'%Y%m') desc 
                            limit 5
                        ) union all (
                            select 
                            DATE_FORMAT(a.book_date,'%b %Y')  as v_month,
                            DATE_FORMAT(a.book_date,'%Y%m') as v_month_num,
                            count(a.pick_pack_id) as cnt
                            from crit_pick_pack_info as a
                            where a.status != 'Delete'
                            group by DATE_FORMAT(a.book_date,'%b %y') 
                            order by DATE_FORMAT(a.book_date,'%Y%m') desc 
                            limit 5
                        )
                    ) as w 
                    group by w.v_month_num
                    order by w.v_month_num desc
                    limit 5
                 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['cnt'][]  = $row['cnt'];  
                $rec_list['month'][]  = $row['v_month'];  
                //$rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'domestic-pickup')
       {
          /*$query = $this->db->query("                 
                select 
                b.area as city,
                count(a.pickup_id) as cnt,
                (count(a.pickup_id) / d.total * 100) as p_avg
                from rh_pickup_info as a 
                left join rh_pincode_list as b on b.pincode = a.source_pincode
                left join (select count(pickup_id)  as total  from rh_pickup_info where courier_type = 'Domestic' and DATE_FORMAT(booked_date,'%Y%m') = DATE_FORMAT('". date('Y-m-d') ."','%Y%m') and status != 'Delete' ) as d on 1=1
                where DATE_FORMAT(a.booked_date,'%Y%m') = DATE_FORMAT('". date('Y-m-d') ."','%Y%m')
                and a.courier_type = 'Domestic'
                and a.status != 'Delete'
                group by b.area
                limit 10                 
            ");*/
            
            $this->db->query('SET SQL_BIG_SELECTS=1');
               
             
          $query = $this->db->query("                 
                select 
                b.district_name as city,
                count(a.pickup_id) as cnt 
                from rh_pickup_info as a 
                left join ( select q.pincode, q.state_name, q.district_name from  crit_pincode_info as q group by q.pincode ) as b on b.pincode = a.source_pincode
                where DATE_FORMAT(a.booked_date,'%Y%m') = DATE_FORMAT('". date('Y-m-d') ."','%Y%m')
                and a.courier_type = 'Domestic'
                and a.status != 'Delete'
                group by b.state_name , b.district_name
                limit 10                 
            ");   
            
          
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['cnt'][]  = $row['cnt'];  
                $rec_list['city'][]  = $row['city'] ;  
                //$rec_list[]  = $row;      
            }            
       }
       
       if($table == 'international-pickup')
       {
         /* $query = $this->db->query("                 
                select 
                b.area as city,
                count(a.pickup_id) as cnt,
                (count(a.pickup_id) / d.total * 100) as p_avg
                from rh_pickup_info as a 
                left join rh_pincode_list as b on b.pincode = a.source_pincode
                left join (select count(pickup_id)  as total  from rh_pickup_info where status != 'Delete' and courier_type != 'Domestic' and DATE_FORMAT(booked_date,'%Y%m') = DATE_FORMAT('". date('Y-m-d') ."','%Y%m') ) as d on 1=1
                where DATE_FORMAT(a.booked_date,'%Y%m') = DATE_FORMAT('". date('Y-m-d') ."','%Y%m')
                and a.courier_type != 'Domestic'
                and a.status != 'Delete'
                group by b.area
                limit 10                 
            "); */
            
             $this->db->query('SET SQL_BIG_SELECTS=1');
              
            
           $query = $this->db->query("                 
                select 
                b.district_name as city,
                count(a.pickup_id) as cnt 
                from rh_pickup_info as a 
                left join ( select q.pincode, q.state_name, q.district_name from  crit_pincode_info as q group by q.pincode ) as b on b.pincode = a.source_pincode
                where DATE_FORMAT(a.booked_date,'%Y%m') = DATE_FORMAT('". date('Y-m-d') ."','%Y%m')
                and a.courier_type != 'Domestic'
                and a.status != 'Delete'
                group by b.state_name , b.district_name
                limit 10                  
            ");  
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['cnt'][]  = $row['cnt'];  
                $rec_list['city'][]  = $row['city'] ;  
                //$rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'visitor-pickup')
       {
          $query = $this->db->query("                 
                 select 
                    dh.v_month_num,
                    dh.v_month,
                    sum(dh.v_cnt) as v_cnt,
                    sum(dh.p_cnt) as p_cnt
                    from 
                    (
                    	(
                    		select  
                    		 v.v_month  ,
                    		 v.v_month_num,
                    		 count(v.v_month) as v_cnt ,
                    		 0 as p_cnt
                    		 from  
                    		 (
                    		    select 
                    		    DATE_FORMAT(a.date_time,'%b %Y') as v_month,
                    		    DATE_FORMAT(a.date_time,'%Y%m') as v_month_num,
                    		    a.ip as v_ip
                    		    from rh_visitor as a 
                    		    group by  DATE_FORMAT(a.date_time,'%m-%Y') ,a.ip  
                    		 ) as v 
                    		 group by v.v_month_num  
                    		 order by v.v_month_num  desc 
                    		 limit 5 
                    	 ) union all (
                    	   select 
                    		DATE_FORMAT(a.booked_date,'%b %Y')  as v_month,
                    		DATE_FORMAT(a.booked_date,'%Y%m') as v_month_num,
                    		0 as v_cnt,
                    		count(a.pickup_id) as p_cnt
                    		from rh_pickup_info as a
                            where a.status != 'Delete'
                    		group by DATE_FORMAT(a.booked_date,'%b %y') 
                    		order by DATE_FORMAT(a.booked_date,'%Y%m') desc 
                    		limit 5
                    	 )
                     ) as dh
                     group by dh.v_month_num
                     order by dh.v_month_num desc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['v_month'][]  = $row['v_month'];  
                $rec_list['v_cnt'][]  = $row['v_cnt'] ;  
                $rec_list['p_cnt'][]  = $row['p_cnt'] ;  
                //$rec_list[]  = $row;      
            }  
          
       }
       
       if($table == 'visitor-pickup-perday')
       {
          $query = $this->db->query("                 
                   select  
                    v.v_date ,
                    v.v_date_num, 
                    count(v.v_date) as v_cnt ,
                    ifnull(r.cnt,0) as p_cnt
                    from  
                    (
                    select 
                    DATE_FORMAT(a.date_time,'%b %d') as v_date,
                    DATE_FORMAT(a.date_time,'%Y%m%d') as v_date_num,
                    a.ip as v_ip
                    from rh_visitor as a 
                    group by  DATE_FORMAT(a.date_time,'%Y%m%d') ,a.ip  
                    order by  DATE_FORMAT(a.date_time,'%Y%m%d') desc ,a.ip   
                    ) as v 
                    left join ( select DATE_FORMAT(w.booked_date,'%Y%m%d') as p_date , count(w.pickup_id) as cnt from rh_pickup_info as w where w.status != 'Delete' group by DATE_FORMAT(w.booked_date,'%Y%m%d')) as r on  r.p_date = v.v_date_num
                    group by v.v_date_num  
                    order by v.v_date_num  desc  
                    limit 10 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['v_date'][]  = $row['v_date'];  
                $rec_list['v_cnt'][]  = $row['v_cnt'] ;  
                $rec_list['p_cnt'][]  = $row['p_cnt'] ;  
                //$rec_list[]  = $row;      
            }  
          
       }
       if($table == 'pickup-revenue-per-month')
       {
          $query = $this->db->query("                 
                select 
                q.v_month,
                sum(q.pick_cnt) as pick_cnt, 
                sum(q.courier_charges) as courier_charges
                from  (
                                (
                                select 
                                DATE_FORMAT(a.booked_date,'%b\'%y')  as v_month,
                                DATE_FORMAT(a.booked_date,'%Y%m') as v_month_num,
                                sum(a.courier_charges) as courier_charges,
                                count(a.pickup_id) as pick_cnt
                                from rh_pickup_info as a
                                where (a.`status` = 'Picked' || a.status = 'Delivered')
                                and a.booked_date <= '2019-07-31'  
                                group by DATE_FORMAT(a.booked_date,'%b %y') 
                                order by DATE_FORMAT(a.booked_date,'%Y%m') desc 
                                limit 5 
                                )  union all (
                                select 
                                DATE_FORMAT(a.paid_date,'%b\'%y')  as v_month,
                                DATE_FORMAT(a.paid_date,'%Y%m') as v_month_num,
                                sum(a.courier_charges) as courier_charges,
                                count(a.pickup_id) as pick_cnt
                                from rh_pickup_info as a
                                where (a.`status` = 'Picked' || a.status = 'Delivered')
                                and a.paid_date >= '2019-08-01' 
                                group by DATE_FORMAT(a.paid_date,'%b %y') 
                                order by DATE_FORMAT(a.paid_date,'%Y%m') desc 
                                limit 5
                                ) union all (
                                select 
                                DATE_FORMAT(a.paid_date,'%b\'%y')  as v_month,
                                DATE_FORMAT(a.paid_date,'%Y%m') as v_month_num,
                                sum(a.pp_charges) as courier_charges ,
                                count(a.pick_pack_id) as pick_cnt
                                from crit_pick_pack_info as a
                                where (a.`status` = 'Packed' || a.status = 'Delivered') 
                                and DATE_FORMAT(a.paid_date,'%Y') != '0000'
                                group by DATE_FORMAT(a.paid_date,'%d-%m-%Y') 
                                order by DATE_FORMAT(a.paid_date,'%Y%m%d') desc 
                                limit 5
                                )
                    ) as q 
                    group by q.v_month_num
                    order by q.v_month_num desc
                    limit 5  
            ");
              
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list['cnt'][]  = $row['pick_cnt'];  
                $rec_list['amt'][]  = $row['courier_charges'] ;    
                $rec_list['month'][]  = $row['v_month'];    
            }  
          
        }
        
        if($table == 'pickup-revenue-per-day')
       {
            /*
            select 
                DATE_FORMAT(a.booked_date,'%b %d')  as v_date,
                DATE_FORMAT(a.booked_date,'%Y%m%d') as v_date_num,
                sum(a.courier_charges) as courier_charges,
                count(a.pickup_id) as pick_cnt
                from rh_pickup_info as a
                where (a.`status` = 'Picked' || a.status = 'Delivered')
                group by DATE_FORMAT(a.booked_date,'%d-%m-%Y') 
                order by DATE_FORMAT(a.booked_date,'%Y%m%d') desc 
                limit 10  
            */
          $query = $this->db->query("   
                select 
                q.v_date,
                q.v_date_num,  
                sum(q.courier_charges) as courier_charges
                from  
                (
                    (
                    select 
                    DATE_FORMAT(a.booked_date,'%b %d')  as v_date,
                    DATE_FORMAT(a.booked_date,'%Y%m%d') as v_date_num,
                    sum(a.courier_charges) as courier_charges 
                    from rh_pickup_info as a
                    where (a.`status` = 'Picked' || a.status = 'Delivered')
                    and a.booked_date <= '2019-07-31'  
                    group by DATE_FORMAT(a.booked_date,'%d-%m-%Y') 
                    order by DATE_FORMAT(a.booked_date,'%Y%m%d') desc 
                    limit 7 
                    ) union all (
                    select 
                    DATE_FORMAT(a.paid_date,'%b %d')  as v_date,
                    DATE_FORMAT(a.paid_date,'%Y%m%d') as v_date_num,
                    sum(a.courier_charges) as courier_charges 
                    from rh_pickup_info as a
                    where (a.`status` = 'Picked' || a.status = 'Delivered')
                    and a.paid_date >= '2019-08-01'  
                    group by DATE_FORMAT(a.paid_date,'%d-%m-%Y') 
                    order by DATE_FORMAT(a.paid_date,'%Y%m%d') desc 
                    limit 10
                    ) union all (
                    select 
                    DATE_FORMAT(a.paid_date,'%b %d')  as v_date,
                    DATE_FORMAT(a.paid_date,'%Y%m%d') as v_date_num,
                    sum(a.pp_charges) as courier_charges 
                    from crit_pick_pack_info as a
                    where (a.`status` = 'Packed' || a.status = 'Delivered') 
                    group by DATE_FORMAT(a.paid_date,'%d-%m-%Y') 
                    order by DATE_FORMAT(a.paid_date,'%Y%m%d') desc 
                    limit 10
                    )
                ) as q
                group by q.v_date_num 
                order by q.v_date_num desc
                limit 10     
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                //$rec_list['cnt'][]  = $row['pick_cnt'];  
                $rec_list['amt'][]  =  $row['courier_charges']; 
                $rec_list['v_date'][]  = $row['v_date'];    
                $rec_list['v_date_num'][]  = $row['v_date_num'];    
            }  
          
        }
       
       
       
       if($table == 'user')
       {
            $query = $this->db->query(" 
                select 
                a.*
                from rh_user_info as a
                where a.user_id =  $rec_id
                order by  a.first_name asc 
            ");
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row;     
            }
       }
        
          
       if($table == 'district_list')
       {
          $query = $this->db->query("
            select 
            a.districts_name as city  
            from zazu_districts_info as a
            left join zazu_states_info as b on b.state_id = a.state_id
            where b.state_name = '".$rec_id ."'
            order by a.districts_name asc
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;     
            }  
          
       }
       
       if($table == 'district_lookup')
       {
          $query = $this->db->query("
            select 
            a.district_name as district
            from crit_pincode_info as a
            where a.state_name = '".$rec_id ."'
            group by a.district_name 
            order by a.district_name asc 
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row;     
            }  
          
       }
       if($table == 'area_list')
       {
          $query = $this->db->query("
          select  
            a.area_name as area
            from zazu_city_area_info as a   
            left join zazu_districts_info as b on b.districts_id = a.districts_id
            where b.districts_name = '".$rec_id ."'
            order by a.area_name asc  
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;     
            }  
          
         }
       
       if($table == 'area')
       {
          $query = $this->db->query("
          select 
            a.city_area_id,
            a.state_id,
            a.districts_id,
            a.city_name,
            a.area_name 
            from zazu_city_area_info as a   
            where a.city_area_id =  '".$rec_id ."'
          "
          );
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;     
            }  
          
         } 
         
        if($table == 'pickup_info')
        {
              
            $query = $this->db->query("
            select 
            a.* ,
            DATE_FORMAT(a.pickup_schedule_timing,'%Y-%m-%dT%H:%i') as schedule_time,
            b.invoice_no,
            b.invoice_id
            from rh_pickup_info as a  
            left join crit_invoice_info as b on b.pickup_id = a.pickup_id 
            where a.pickup_id =  '".$rec_id ."'
            "
            );
             
            $rec_list = array();  
            
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;     
            }  
            
            //echo (json_encode($rec_list)); exit;
        
        }
        
        if($table == 'pick_pack_info')
        {
              
            $query = $this->db->query("
            select 
            a.*  
            from crit_pick_pack_info as a   
            where a.pick_pack_id =  '".$rec_id ."'
            "
            );
             
            $rec_list = array();  
            
            foreach($query->result_array() as $row)
            {
                $rec_list = $row;     
            }  
            
            //echo (json_encode($rec_list)); exit;
        
        }
        
        
        
       if($table == 'delivery_alert')
       {
            $query = $this->db->query(" set SQL_BIG_SELECTS=1 ");
            $query = $this->db->query("  
                select 
                a.pickup_id as ref_no,
                b.state_name as src_state,
                lower(b.district_name) as src_city,
                c.state_name as dest_state,
                lower(c.district_name) as  dest_city
                from rh_pickup_info as a
                left join ( select q.pincode, q.state_name, q.district_name from  crit_pincode_info as q group by q.pincode ) as b on b.pincode = a.source_pincode
                left join ( select q.pincode, q.state_name, q.district_name from  crit_pincode_info as q group by q.pincode ) as c on c.pincode = a.destination_pincode
                where a.`status` = 'Picked' and a.courier_type = 'Domestic'
                and a.delivered_date = '". date('Y-m-d') ."'  
                order by a.pickup_id asc 
            ");
             
           $rec_list = array();  
           
           $cnt = $query->num_rows(); 
           //$rec_list[]  = array(); 
            foreach($query->result_array() as $row)
            {
                $rec_list[]  = $row ;
            }  
       } 
       
       if($table == 'pincode-state-district')
       {
            $query = $this->db->query(" set SQL_BIG_SELECTS=1 ");
            $query = $this->db->query("  
                select 
                q.state_name as state, 
                q.district_name as district
                from crit_pincode_info as q 
                where q.pincode = '". $rec_id."' 
                and q.`status` = 'Active'
                group by q.state_name , q.district_name 
            ");
             
           $rec_list = array();  
           
            //$cnt = $query->num_rows();  
           
            foreach($query->result_array() as $row)
            {
                $rec_list  = $row ;
            } 
             
       } 
       if($table == 'account_head')
           {
              $query = $this->db->query(" 
                    select
                    a.account_head_id as id,
                    a.account_head_name as value
                    from crit_account_head as a 
                    where a.type =  '".$rec_id . "'
                    order by a.account_head_name asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list[]  = $row;     
                }  
              
           }
           
        if($table == 'sub_account_head')
        {
              $query = $this->db->query(" 
                    select
                    a.sub_account_head_id, 
                    a.type,
                    a.account_head_id,
                    a.sub_account_head_name,
                    a.status
                    from crit_sub_account_head as a 
                    where a.sub_account_head_id =  '".$rec_id . "'
                    order by a.sub_account_head_name asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }                
        } 
        
        
        if($table == 'load_sub_account_head')
        {
              $query = $this->db->query(" 
                    select
                    a.sub_account_head_id as id,  
                    a.sub_account_head_name as value 
                    from crit_sub_account_head as a 
                    where a.account_head_id =  '".$rec_id . "' 
                    and a.type = '". $this->input->post('typ') ."' 
                    and a.status='Active'
                    order by a.sub_account_head_name asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list[] = $row;     
                }  
              
        } 
       
       
        if($table == 'cash_inward')
        {
              $query = $this->db->query(" 
                    select
                    a.cash_inward_id, 
                    a.inward_date,
                    a.account_head_id,
                    a.sub_account_head_id,
                    a.amount,
                    a.remarks
                    from crit_cash_inward as a 
                    where a.cash_inward_id =  '".$rec_id . "'
                    order by a.cash_inward_id asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }  
              
        }     
        
        if($table == 'cash_outward')
        {
              $query = $this->db->query(" 
                    select
                    a.cash_outward_id, 
                    a.outward_date,
                    a.account_head_id,
                    a.sub_account_head_id,
                    a.amount,
                    a.cash_received_by,
                    a.remarks
                    from crit_cash_outward as a 
                    where a.cash_outward_id =  '".$rec_id . "'
                    order by a.cash_outward_id asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }  
              
        }
        
        if($table == 'invoice')
        {
              $query = $this->db->query(" 
                    select  
                    a.invoice_id,
                    a.invoice_no,   
                    a.invoice_date,   
                    a.client_name,  
                    a.address, 
                    a.state, 
                    a.contact_no, 
                    a.client_GSTIN,
                    a.way_bill,
                    a.weight,
                    a.amount,
                    a.GST_percentage,
                    a.total_amount        
                    from crit_invoice_info as a 
                    where a.invoice_id =  '".$rec_id . "'
                    order by a.invoice_id asc 
                ");
                 
               $rec_list = array();  
        
                foreach($query->result_array() as $row)
                {
                    $rec_list  = $row;     
                }  
              
        } 
       
       
       $this->db->close();
       
       header('Content-Type: application/x-json; charset=utf-8');

       echo (json_encode($rec_list));  
	}
    
    
    public function get_content($table = '', $rec_id = '')
    {
       //if(!$this->session->userdata('zazu_logged_in'))  redirect();
       
       if(empty($table) && empty($rec_id)) {
           $table = $this->input->post('tbl') ;
           $rec_id = $this->input->post('id'); 
           $edit_mode = $this->input->post('edit_mode'); 
           $del_mode = $this->input->post('del_mode'); 
           $flg = true;
       } else {
        $flg = false;
       }
       
       
       if($table == 'customer_contact')
       {
          $query = $this->db->query("
            select 
                a.customer_contact_id as id,
                a.customer_group,
                concat(a.company,' <br> ', a.cc_code) as company, 
                a.contact_person, 
                concat(a.gst_no,  a.aadhar_no) as gst_aadhar, 
                concat(a.mobile, '<br>' , a.phone ,'<br>',a.email) as contact,  
                concat(a.state_code,' - ',  a.city_code ,'<br>', a.pincode) as state_city_pincode,  
                a.address, 
                a.`status`
                from crit_customer_contact_info as a
                where a.customer_id =  '". $rec_id. "' 
                order by a.created_datetime , a.customer_contact_id  
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'franchises_users')
       {
          $query = $this->db->query("
             select 
                a.user_id as id,
                a.first_name,
                a.user_name,
                a.mobile,
                a.email,
                a.`status`
                from crit_user_info as a
                where a.franchise_id = '". $rec_id. "' 
                and a.status != 'Delete'
                order by a.first_name asc   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
       if($table == 'gen_enquiry_details')
       {
          $query = $this->db->query("
             select   
                 a.name,                 
                 a.address,              
                 a.phone,                
                 a.email,                
                 a.remarks as message,   
                 a.enquiry_date 
                 from cf_enquiry as a    
                 left join cf_locations as b on b.id = a.location 
                 left join cf_states as c on c.id = b.state_id 
                 where a.id = '". $rec_id. "'   
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row; 
            }  
          
       }
       
              
        
       
       if($table == 'pickup_info')
       {
          $query = $this->db->query("
            select
                a.pickup_id as pickup_ref_no,
                DATE_FORMAT(a.booked_date,'%d-%m-%Y %h:%i %p') as booked_date,
                a.courier_type,
                if(a.same_as_sender_address != 1 , concat(a.contact_person_name , '<br>' , a.contact_person_mobile , '<br>', a.pickup_address ),concat(a.sender_name , '<br>' , a.sender_phone , '<br>', a.sender_address )) as pickup_address,
                concat(a.source_pincode , '<br>' , a.sender_name , '<br>' , a.sender_phone , '<br>', a.sender_address ) as source_address,
                concat(if(a.courier_type = 'Domestic', a.destination_pincode, b.country_name ) , '<br>' , a.receiver_name , '<br>' , a.receiver_phone , '<br>', a.receiver_address ) as destination_address,
                concat(a.package_type,' , ',  if(a.courier_type = 'Domestic', concat(a.package_weight,' Kgs'), c.package_weight_name ) ) as package_details,
                (if(a.package_length != '' , concat(a.package_length , 'X' , a.package_width , ' X ', a.package_height),'') ) as package_dimension,
                a.approx_charges
                from rh_pickup_info as a 
                left join rh_country_info as b on b.country_id = a.destination_country
                left join crit_package_weight as c on c.package_weight_id = a.package_weight_int
             where a.pickup_id = '". $rec_id. "'
             order by a.booked_date desc 
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;
                /*foreach($row as $fld => $val){
                    $rec_list[$fld]  = $val;     
                }*/
            }  
          
       }
       
       if($table == 'franchise_enquiry')
       {
          $query = $this->db->query("
            select 
                DATE_FORMAT(a.franchise_enquiry_date,'%d-%m-%Y %h:%i %p') as enquiry_date,
                a.contact_person_name,
                a.email,
                a.mobile,
                a.interested_in,
                b.state_name as state,
                c.city_name as city,
                a.address,
                a.messages
                from rh_franchise_enquiry_info as a 
                left join rh_states_info as b on b.id = a.state_id
                left join rh_location_info as c on c.location_id = a.location_id
                where a.franchise_enquiry_id = '". $rec_id. "' 
                order by a.franchise_enquiry_id desc
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = $row;
                /*foreach($row as $fld => $val){
                    $rec_list[$fld]  = $val;     
                }*/
            }  
          
       } 
       
       if($table == 'booking_doc_upload_info')
       {
          $query = $this->db->query("
                select 
                a.booking_doc_upload_id as id,
                a.doc_upload_type,
                a.doc_upload_path  
                from crit_booking_doc_upload_info as a  
                where a.status !='Delete' and a.booking_id = '". $rec_id. "' 
                order by a.booking_doc_upload_id desc
          "
          ); 
             
           $rec_list = array();  
    
            foreach($query->result_array() as $row)
            {
                $rec_list[] = array('id' => $row['id'] , 'doc_upload_type' => $row['doc_upload_type'] , 'view' => "<a target='_blank' href='". base_url($row['doc_upload_path'])."'>". $row['doc_upload_path'] ."</a>"); 
            }  
          
       } 
       
       
       if($table == 'manifest-list')
       {
          /*
            a.manifest_no,
            a.manifest_date, 
            a.co_loader_awb_no,
            a.co_loader_remarks,
          */  
          $query = $this->db->query("
              select 
                a.awbno,
                concat(c.origin_state_code, ' - ', c.origin_city_code) as origin,
                concat(c.dest_state_code, ' - ', c.dest_city_code) as destination,
                c.no_of_pieces,
                c.weight,
                a.m_status as status
                from crit_manifest_info  as a
                left join crit_booking_info as c on c.awbno = a.awbno
                left join crit_co_loader_info as d on d.co_loader_id = a.co_loader_id
                where a.manifest_no = '". $rec_id. "' 
                and a.awbno != ''
                order by a.awbno asc
          "
          ); 
             
            $rec_list = array();  
    
            foreach($query->result_array() as $row)
            { 
                $rec_list[]  = $row;     
            }  
          
       } 
       
       
       if(!empty($rec_list)) {
        
        if(count($rec_list) > 1 ) {
       
           $content = '
           <table class="table table-bordered table-responsive table-striped" id="sts">
             <thead>
                <tr>';
                $content .= '<th>S.No</th>';
                foreach($rec_list[0] as $fld => $val) { 
                    if($fld != 'id' && $fld != 'tbl')
                        $content .= '<th class="text-capitalize">'.  str_replace('_',' ',$fld) .'</th>';
                } 
                if($edit_mode == 1)  
                   $content .= '<th>Edit</th>';
                if($del_mode == 1) 
                   $content .= '<th>Delete</th>'; 
           $content .= '</tr>
              </thead>  
              <tbody>';
                foreach($rec_list as $k => $info) {  
                   $content .= '<tr>
                      <td>'.($k+1).'</td>';
                    foreach($rec_list[0] as $fld => $val) { 
                        if($fld != 'id') {
                             if($fld != 'tbl')
                                $content .= '<td>'. $info[$fld]  .'</td>';
                        }
                            
                    } 
                    if($edit_mode == 1)                 
                        $content .= '<td><button type="button" class="btn btn-info btn-sm btn_chld_edit" value="'. $info['id']  .'" data="'. $table  .'"><i class="fa fa-edit"></i></button></td>';    
                    if($del_mode == 1)  
                        $content .= '<td><button type="button" class="btn btn-danger btn-sm btn_chld_del" value="'. $info['id']  .'" data="'. $table  .'"><i class="fa fa-remove"></i></button></td>';    
                   $content .= '</tr>';     
                  }  
              $content .= '
              </tbody>  
            </table>';
            } else
            {
                $content = ' <table class="table table-bordered table-responsive table-striped">  ';
                $content .= '<tr><th colspan="2">'.  strtoupper(str_replace('_',' ', $table)) .'</th></tr>';
                foreach($rec_list[0] as $fld => $val) { 
                    if($fld != 'id' && $fld != 'tbl')
                    {
                        $content .= '<tr>';      
                        $content .= '<th>'. strtoupper(str_replace('_',' ',$fld)) .'</th>';
                        $content .= '<td>'.  $val.'</td>';
                        $content .= '</tr>';  
                    }
                }   
                if($edit_mode == 1)                 
                    $content .= '<tr><th>Edit</th><td><button type="button" class="btn btn-info btn-sm btn_chld_edit" value="'. $rec_list[0]['id']  .'" data="'. $table  .'"><i class="fa fa-edit"></i></button></td></tr>';    
                if($del_mode == 1)  
                    $content .= '<tr><th>Delete</th><td><button type="button" class="btn btn-danger btn-sm btn_chld_del" value="'. $rec_list[0]['id']  .'" data="'. $table  .'"><i class="fa fa-remove"></i></button></td></tr>';
                
                $content .= '</table>';              
            }
        } else {
            $content = "<strong>No Record Found</strong>";
        }
         
        if(!$flg)
            return $content;  
        else
            echo $content;    
       
    }
    
    public function delete_record()  
    {
        
        if(!$this->session->userdata('cr_logged_in'))  redirect(); 
        
        
        $table = $this->input->post('tbl') ;
        $rec_id =$this->input->post('id');
        
        if($table == 'franchise_awbill_info')
        {
             $this->db->where('franchise_awbill_id', $rec_id);
             $this->db->update('crit_franchise_awbill_info', array('status' => 'Delete'));
               
             echo 'Record Successfully deleted';  
        } 
        
        if($table == 'co_loader_info')
         {            
            $this->db->where('co_loader_id', $rec_id);
            $this->db->update('crit_co_loader_info', array('status' => 'Delete')); 
            echo 'Record Successfully deleted'; 
         }
        
         if($table == 'b2h_manifest')
         {            
            $this->db->where('booking_id', $rec_id);
            $this->db->delete('crit_b2h_manifest_info');  
            
            $this->db->where('booking_id', $rec_id);
            $this->db->update('crit_booking_info', array('status' => 'Booked'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'open_manifest')
         {            
            $this->db->where('manifest_id', $rec_id);
            $this->db->delete('crit_manifest_info');  
            
            //$this->db->where('awbno', $rec_id);
           // $this->db->update('crit_booking_info', array('status' => 'Booked'));   
            echo 'Record Successfully deleted'; 
         } 
         
         
         if($table == 'country')
         {            
            $this->db->where('country_id', $rec_id);
            $this->db->update('crit_country_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'state')
         {            
            $this->db->where('state_id', $rec_id);
            $this->db->update('crit_states_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'service_info')
         {            
            $this->db->where('service_id', $rec_id);
            $this->db->update('crit_service_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'international')
         {            
            $this->db->where('international_rate_id', $rec_id);
            $this->db->update('crit_international_rate', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'package_type')
         {            
            $this->db->where('package_type_id', $rec_id);
            $this->db->update('crit_package_type', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'package_weight')
         {            
            $this->db->where('package_weight_id', $rec_id);
            $this->db->update('crit_package_weight', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'stationery_item_info')
         {            
            $this->db->where('stationery_item_id', $rec_id);
            $this->db->update('crit_stationery_item_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'franchise_enquiry')
         {            
            $this->db->where('franchise_enquiry_id', $rec_id);
            $this->db->delete('rh_franchise_enquiry_info');   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'pay_method')
         {            
            $this->db->where('pay_method_id', $rec_id);
            $this->db->update('crit_pay_method_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'service_provider')
         {            
            $this->db->where('service_provider_id', $rec_id);
            $this->db->update('rh_service_provider_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'pick-pack')
         {            
            $this->db->where('pick_pack_id', $rec_id);
            $this->db->update('crit_pick_pack_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         if($table == 'carrier')
         {            
            $this->db->where('carrier_id', $rec_id);
            $this->db->update('crit_carrier_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         if($table == 'tracking_status')
         {            
            $this->db->where('tracking_status_id', $rec_id);
            $this->db->update('crit_tracking_status_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }  
         if($table == 'awb_tracking_info')
         {            
            $this->db->where('awb_tracking_id', $rec_id);
            $this->db->delete('crit_awb_tracking_info')  ;
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'booking')
         {            
            $this->db->where('booking_id', $rec_id);
            $this->db->update('crit_booking_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'servicable_pincode')
         {            
            $this->db->where('pincode_id', $rec_id);
            $this->db->update('crit_servicable_pincode_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'crit_customer_invoice_info')
         {            
            $this->db->where('customer_invoice_id', $rec_id);
            $this->db->update('crit_customer_invoice_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }   
           
         if($table == 'franchise_info')
         {            
            $this->db->where('franchise_id', $rec_id);
            $this->db->update('crit_franchise_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }     
          
         if($table == 'agent_info')
         {            
            $this->db->where('agent_id', $rec_id);
            $this->db->update('crit_agent_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }   
         
         if($table == 'city_info')
         {            
            $this->db->where('city_id', $rec_id);
            $this->db->update('crit_city_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'customer_info')
         {            
            $this->db->where('customer_id', $rec_id);
            $this->db->update('crit_customer_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         } 
         if($table == 'customer_type_info')
         {            
            $this->db->where('customer_type_id', $rec_id);
            $this->db->update('crit_customer_type_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         if($table == 'hub_branch_info')
         {            
            $this->db->where('hub_branch_id', $rec_id);
            $this->db->update('crit_hub_branch_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'customer_domestic_rate_info_v2')
         {            
            $this->db->where('customer_domestic_rate_id', $rec_id);
            $this->db->update('crit_customer_domestic_rate_info_v2', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'booking_doc_upload_info')
         {            
            $this->db->where('booking_doc_upload_id', $rec_id);
            $this->db->update('crit_booking_doc_upload_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'doc_upload_type_info')
         {            
            $this->db->where('doc_upload_type_id', $rec_id);
            $this->db->update('crit_doc_upload_type_info', array('status' => 'Delete'));   
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'ts_invoice_info')
         {            
            $this->db->where('invoice_no', $rec_id);
            $this->db->delete('crit_ts_invoice_info')  ;
            echo 'Record Successfully deleted'; 
         } 
         
         if($table == 'franchise_doc_upload_info')
         {            
            $this->db->where('franchise_doc_upload_id', $rec_id);
            $this->db->update('crit_franchise_doc_upload_info', array('status' => 'Delete')); 
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'staff_doc_upload_info')
         {            
            $this->db->where('staff_doc_upload_id', $rec_id);
            $this->db->update('crit_staff_doc_upload_info', array('status' => 'Delete')); 
            echo 'Record Successfully deleted'; 
         }
         
         if($table == 'fr_stationery_invoice_info')
         {            
            $this->db->where('fr_stationery_invoice_id', $rec_id);
            $this->db->update('crit_fr_stationery_invoice_info', array('status' => 'Delete')); 
            echo 'Record Successfully deleted'; 
         }
         
         
         
            
         
         
    } 
    
    
    
}
