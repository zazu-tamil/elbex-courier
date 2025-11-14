<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	 
	public function index()
	{
	   if(!$this->session->userdata('cr_logged_in'))  redirect();  
       
       $data = array(); 
         
       $this->db->query("update `crit_booking_info` set awbno = trim(awbno) WHERE `awbno` like ' %'");
         
       /*if($this->session->userdata('cr_is_admin') == '111')  {
        $where .= " and a.origin_state_code = '". $this->session->userdata('cr_pstate') ."'";  
       }*/
		  
           if($this->session->userdata('cr_is_admin') == 1) { 
            $query = $this->db->query(" 
                  select 
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    where a.`status` != 'Delete' and a.booking_date = '". date('Y-m-d')."' 
                    order by a.booking_id  
            ");
            } elseif($this->session->userdata('cr_is_admin') == '111')  { 
                $query = $this->db->query(" 
                      select 
                        count(a.booking_id) as no_of_booking ,
                        sum(grand_total) as amount
                        from crit_booking_info as a 
                        left join crit_user_info as b on b.user_id = a.created_by
                        where a.`status` != 'Delete' and a.booking_date = '". date('Y-m-d')."' 
                        and a.origin_state_code = '". $this->session->userdata('cr_pstate') ."'
                        order by a.booking_id  
                ");
            } else {
                $query = $this->db->query(" 
                  select 
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    where a.`status` != 'Delete' and a.booking_date = '". date('Y-m-d')."'
                    and b.franchise_id = '". $this->session->userdata('cr_franchise_id') ."' 
                    order by a.booking_id 
                ");
            }
             
    
            foreach($query->result_array() as $row)
            {
                $data['fr_no_of_booking'] = $row['no_of_booking'];  
                $data['fr_day_amt'] = $row['amount'];  
            }
            
            if($this->session->userdata('cr_is_admin') == 1) { 
                $query = $this->db->query(" 
                      select 
                        count(a.booking_id) as no_of_booking ,
                        sum(grand_total) as amount
                        from crit_booking_info as a 
                        left join crit_user_info as b on b.user_id = a.created_by
                        where a.`status` != 'Delete' and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m')."' 
                        order by a.booking_id ;
                ");
            } elseif($this->session->userdata('cr_is_admin') == '111')  { 
                $query = $this->db->query(" 
                      select 
                        count(a.booking_id) as no_of_booking ,
                        sum(grand_total) as amount
                        from crit_booking_info as a 
                        left join crit_user_info as b on b.user_id = a.created_by
                        where a.`status` != 'Delete' and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m')."' 
                        and a.origin_state_code = '". $this->session->userdata('cr_pstate') ."'
                        order by a.booking_id ;
                ");
            } else {
                 $query = $this->db->query(" 
                      select 
                        count(a.booking_id) as no_of_booking ,
                        sum(grand_total) as amount
                        from crit_booking_info as a 
                        left join crit_user_info as b on b.user_id = a.created_by
                        where a.`status` != 'Delete' and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m')."'
                        and b.franchise_id = '". $this->session->userdata('cr_franchise_id') ."' 
                        order by a.booking_id ;
                ");   
            }
             
    
            foreach($query->result_array() as $row)
            {
                $data['fr_no_of_booking_month'] = $row['no_of_booking'];  
                $data['fr_month_amt'] = $row['amount'];
            }
            
           if($this->session->userdata('cr_is_admin') == 1) {  
            $query = $this->db->query(" 
                  select 
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    where a.`status` != 'Delete' and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m',strtotime('-1 months'))."'
                     
                    order by a.booking_id ;
            ");
            } elseif($this->session->userdata('cr_is_admin') == '111')  { 
                $query = $this->db->query(" 
                  select 
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    where a.`status` != 'Delete' and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m',strtotime('-1 months'))."'
                    and a.origin_state_code = '". $this->session->userdata('cr_pstate') ."' 
                    order by a.booking_id ;
                ");
            } else {
                 $query = $this->db->query(" 
                    select 
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    where a.`status` != 'Delete' and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m',strtotime('-1 months'))."'
                    and b.franchise_id = '". $this->session->userdata('cr_franchise_id') ."' 
                    order by a.booking_id ;
                ");
            }
             
            $data['fr_last_month_book'] = 0;
            foreach($query->result_array() as $row)
            {
                 
                $data['fr_last_month_amt'] = $row['amount'];
                $data['fr_last_month_book'] = $row['no_of_booking'];
            }
            
           
           $sql = "
                select 
                a.manifest_date,
                a.manifest_no,
                a.from_city_code,
                GROUP_CONCAT(a.awbno) as awbno,
                sum(c.no_of_pieces) as no_of_pieces,
                sum(c.weight) as weight,
                b.co_loader_name as co_loader,
                a.co_loader_awb_no,
                a.co_loader_remarks 
                from crit_manifest_info as a 
                left join crit_co_loader_info as b on b.co_loader_id = a.co_loader_id
                left join crit_booking_info as c on c.awbno = a.awbno
                where a.m_status = 'Open Manifest'
                and a.to_city_code = '". $this->session->userdata('cr_branch_code') ."'  
                and a.awbno != ''
                and a.manifest_date >= '2025-01-01'
                group by a.manifest_no 
                order by a.manifest_date asc
           ";  
           
           $query = $this->db->query($sql);
           
           $data['incoming_manifest'] = array();
           
           foreach($query->result_array() as $row)
            {                 
                $data['incoming_manifest'][] = $row;
            }   
            
            $sql = "
                select 
                c.booking_date,
                a.received_date,
                a.from_city_code,
                a.to_city_code,
                c.dest_pincode,
                a.awbno,
                c.dest_pincode,
                c.no_of_pieces,
                c.weight
                from crit_manifest_info as a 
                left join crit_co_loader_info as b on b.co_loader_id = a.co_loader_id
                left join crit_booking_info as c on c.awbno = a.awbno
                where a.m_status = 'Received Manifest'
                and c.booking_date >= '2025-01-01'
                and a.to_city_code =  '". $this->session->userdata('cr_branch_code') ."' 
                and not exists( select * from crit_drs_info as z where z.awbno = a.awbno )
                order by c.booking_date desc
            ";    
            
            $query = $this->db->query($sql);
            
            $data['drs_to_be_prepared'] = array();
           
            foreach($query->result_array() as $row)
            {                 
                $data['drs_to_be_prepared'][] = $row;
            } 
            
            $sql = "
                select 
                a.drs_date, 
                a.drs_time , 
                a.awbno, 
                c.dest_pincode,
                c.no_of_pieces,
                c.weight,
                b.first_name as delivery_by
                from crit_drs_info as a 
                left join crit_user_info as b on b.user_id = a.delivery_by
                left join crit_booking_info as c on c.awbno = a.awbno
                where a.drs_status = 'Out for Delivery'
                and a.branch_city_code =  '". $this->session->userdata('cr_branch_code') ."'   
                and c.booking_date >= '2025-01-01'
                order by a.drs_date , a.drs_time
            ";    
            
            $query = $this->db->query($sql);
            
            $data['out_for_delivery'] = array();
           
            foreach($query->result_array() as $row)
            {                 
                $data['out_for_delivery'][] = $row;
            } 
            
            
            $sql = "
                    select 
                    a.state_name,                
                    a.state_code             
                    from crit_states_info as a  
                    left join crit_franchise_info as b on b.state_code = a.state_code 
                    where a.status = 'Active' and b.status = 'Active'   
                    group by a.state_name          
                    order by a.state_name asc               
            "; 
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['state_opt'][$row['state_code']] = $row['state_name']. ' [ ' . $row['state_code'] . ' ]';     
            }
            
            
            
            if($this->input->post('srch_state') != ''){
                $data['srch_state'] = $this->input->post('srch_state'); 
            } else {
                $data['srch_state'] = "TN";
            }
            
            $sql = '
                select 
                b.franchise_type_name,
                a.contact_person,
                a.mobile,
                a.phone,
                a.email,
                a.address,
                a.branch_code,
                a.city_code         
                from  crit_franchise_info as a
                left join crit_franchise_type_info as b on b.franchise_type_id = a.franchise_type_id
                where a.status = "Active" and b.`status` = "Active"
                and a.state_code = "'. $data['srch_state'] .'"    
                order by b.franchise_type_name asc  
            
            ';
            
            $query = $this->db->query($sql);
           
            foreach ($query->result_array() as $row)
            {
                $data['franchise_info'][] = $row;     
            }
            
         //echo date('Y-m', strtotime('last month'));   
          
         if($this->session->userdata('cr_is_admin') == 1) {  
             $sql ="
                select 
                b.franchise_id,
                d.franchise_type_name,
                c.branch_code,
                e.hub_branch_name,
                count(a.booking_id) as no_of_booking ,
                sum(grand_total) as amount
                from crit_booking_info as a 
                left join crit_user_info as b on b.user_id = a.created_by
                left join crit_franchise_info as c on c.franchise_id = b.franchise_id
                left join crit_franchise_type_info as d on d.franchise_type_id = c.franchise_type_id
                left join crit_hub_branch_info as e on e.hub_branch_code = c.branch_code and e.status = 'Active' and e.type = 'Branch'
                where a.`status` != 'Delete' 
                and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m')."' 
                group by b.franchise_id 
                order by  no_of_booking desc ,d.franchise_type_name, e.hub_branch_name
            ";
            } elseif($this->session->userdata('cr_is_admin') == '111')  { 
                
                $sql ="
                    select 
                    b.franchise_id,
                    d.franchise_type_name,
                    c.branch_code,
                    e.hub_branch_name,
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    left join crit_franchise_info as c on c.franchise_id = b.franchise_id
                    left join crit_franchise_type_info as d on d.franchise_type_id = c.franchise_type_id
                    left join crit_hub_branch_info as e on e.hub_branch_code = c.branch_code and e.status = 'Active' and e.type = 'Branch'
                    where a.`status` != 'Delete' 
                    and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m')."' 
                    and a.origin_state_code = '". $this->session->userdata('cr_pstate') ."' 
                    group by b.franchise_id 
                    order by  no_of_booking desc ,d.franchise_type_name, e.hub_branch_name
                ";
                 
            } else {
                 
                 $sql ="
                    select 
                    b.franchise_id,
                    d.franchise_type_name,
                    c.branch_code,
                    e.hub_branch_name,
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    left join crit_franchise_info as c on c.franchise_id = b.franchise_id
                    left join crit_franchise_type_info as d on d.franchise_type_id = c.franchise_type_id
                    left join crit_hub_branch_info as e on e.hub_branch_code = c.branch_code and e.status = 'Active' and e.type = 'Branch'
                    where a.`status` != 'Delete' 
                    and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m')."' 
                    and b.franchise_id = '". $this->session->userdata('cr_franchise_id') ."' 
                    group by b.franchise_id 
                    order by  no_of_booking desc ,d.franchise_type_name, e.hub_branch_name
                ";
                  
            }
             
            $query = $this->db->query($sql); 
            $data['fr_booking'] = array();
            foreach($query->result_array() as $row)
            {  
                $data['fr_booking'][] = $row; 
            }   
            
            
         if($this->session->userdata('cr_is_admin') == 1) {  
             $sql ="
                select 
                b.franchise_id,
                d.franchise_type_name,
                c.branch_code,
                e.hub_branch_name,
                count(a.booking_id) as no_of_booking ,
                sum(grand_total) as amount
                from crit_booking_info as a 
                left join crit_user_info as b on b.user_id = a.created_by
                left join crit_franchise_info as c on c.franchise_id = b.franchise_id
                left join crit_franchise_type_info as d on d.franchise_type_id = c.franchise_type_id
                left join crit_hub_branch_info as e on e.hub_branch_code = c.branch_code and e.status = 'Active' and e.type = 'Branch'
                where a.`status` != 'Delete' 
                and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m', strtotime('last month')) ."' 
                group by b.franchise_id 
                order by  no_of_booking desc ,d.franchise_type_name, e.hub_branch_name
            ";
            } elseif($this->session->userdata('cr_is_admin') == '111')  { 
                
                $sql ="
                    select 
                    b.franchise_id,
                    d.franchise_type_name,
                    c.branch_code,
                    e.hub_branch_name,
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    left join crit_franchise_info as c on c.franchise_id = b.franchise_id
                    left join crit_franchise_type_info as d on d.franchise_type_id = c.franchise_type_id
                    left join crit_hub_branch_info as e on e.hub_branch_code = c.branch_code and e.status = 'Active' and e.type = 'Branch'
                    where a.`status` != 'Delete' 
                    and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m', strtotime('last month'))."' 
                    and a.origin_state_code = '". $this->session->userdata('cr_pstate') ."' 
                    group by b.franchise_id 
                    order by  no_of_booking desc ,d.franchise_type_name, e.hub_branch_name
                ";
                 
            } else {
                 
                 $sql ="
                    select 
                    b.franchise_id,
                    d.franchise_type_name,
                    c.branch_code,
                    e.hub_branch_name,
                    count(a.booking_id) as no_of_booking ,
                    sum(grand_total) as amount
                    from crit_booking_info as a 
                    left join crit_user_info as b on b.user_id = a.created_by
                    left join crit_franchise_info as c on c.franchise_id = b.franchise_id
                    left join crit_franchise_type_info as d on d.franchise_type_id = c.franchise_type_id
                    left join crit_hub_branch_info as e on e.hub_branch_code = c.branch_code and e.status = 'Active' and e.type = 'Branch'
                    where a.`status` != 'Delete' 
                    and DATE_FORMAT(a.booking_date,'%Y-%m') = '". date('Y-m', strtotime('last month'))."' 
                    and b.franchise_id = '". $this->session->userdata('cr_franchise_id') ."' 
                    group by b.franchise_id 
                    order by  no_of_booking desc ,d.franchise_type_name, e.hub_branch_name
                ";
                  
            }
             
            $query = $this->db->query($sql); 
            $data['last_month_fr_booking'] = array();
            foreach($query->result_array() as $row)
            {  
                $data['last_month_fr_booking'][] = $row; 
            } 
            
            
            
             
        $this->load->view('page/dashboard' , $data);
	}
    
    
    
    
    
}
