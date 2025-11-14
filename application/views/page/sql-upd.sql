ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION


select 
a.origin_state_code,
a.origin_city_code, 
b.dest_state_code,
b.dest_city_code,
b.dest_region,
a.origin_region,
a.origin_metro_city,
b.dest_metro_city,
c.min_weight,
c.min_charges,
c.addt_weight,
c.addt_charges 
from (select q.state_code as origin_state_code, q.branch_code as origin_city_code, q.zone as origin_region, q.metro_city as origin_metro_city  from crit_servicable_pincode_info as q where q.pincode = '600001'  and q.status = 'Active') as a  
left join (select q1.state_code as dest_state_code, q1.branch_code as dest_city_code ,q1.zone as dest_region, q1.metro_city as dest_metro_city from crit_servicable_pincode_info as q1 where q1.pincode = '641034'  and q1.status = 'Active') as b on 1=1
left join crit_domestic_rate_info as c on 
c.flg_region = (if(b.dest_region = a.origin_region,1,0)) 
and 
c.flg_state = (if(b.dest_state_code = a.origin_state_code,1,0)) 
and 
c.flg_city = (if(b.dest_city_code = a.origin_city_code,1,0)) 
and 
c.flg_metro = (if(b.dest_metro_city = 'Y',1,0)) 
c.`status` = 'Active'
where 1 and c.c_type = 'Air'


ALTER TABLE `crit_domestic_rate_info`
	ADD COLUMN `flg_region` CHAR(1) NULL DEFAULT '0' AFTER `rate_as_on`,
	ADD COLUMN `flg_metro` CHAR(1) NULL DEFAULT '0' AFTER `flg_city`;
    
    
ALTER TABLE `crit_servicable_pincode_info`
	ADD COLUMN `metro_city` VARCHAR(10) NULL DEFAULT 'N' AFTER `branch_code`;    
