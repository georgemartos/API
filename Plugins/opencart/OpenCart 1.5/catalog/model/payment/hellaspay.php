<?php 
class ModelPaymentHellaspay extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('payment/hellaspay');
		
		if ($this->config->get('hellaspay_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('hellaspay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
			if ($this->config->get('hellaspay_total') > 0 && $this->config->get('hellaspay_total') > $total) {
			$status = FALSE;
			} elseif (!$this->config->get('hellaspay_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
      	} else {
			$status = FALSE;
		}
		
		$method_data = array();
	
		if ($status) {  
      		$method_data = array( 
        		'code'         => 'hellaspay',
        		'title'      => $this->language->get('text_title'),
				'sort_order' => $this->config->get('hellaspay_sort_order')
      		);
    	}
   
    	return $method_data;
  	}
}
?>