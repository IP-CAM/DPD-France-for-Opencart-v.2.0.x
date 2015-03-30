<?php
/**
 * DPD France v5.1.0 shipping module for OpenCart 2.0
 *
 * @category   DPDFrance
 * @package    DPDFrance_Shipping
 * @author     DPD S.A.S. <ensavoirplus.ecommerce@dpd.fr>
 * @copyright  2015 DPD S.A.S., société par actions simplifiée, au capital de 18.500.000 euros, dont le siège social est situé 27 Rue du Colonel Pierre Avia - 75015 PARIS, immatriculée au registre du commerce et des sociétés de Paris sous le numéro 444 420 830 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class ModelShippingDpdfrclassic extends Model {

	public function getOrderShippingCost($shipping_cost,$address){
		if ($address['iso_code_2'] == 'FR' || $address['iso_code_2'] == 'FX') {
			$iles = array('17111','17123','17190','17310','17370','17410','17480','17550','17580','17590','17630','17650','17670','17740','17840','17880','17940','22870','29242','29253','29259','29980','29990','56360','56590','56780','56840','85350');
			$montagne = array('04120','04130','04140','04160','04170','04200','04240','04260','04300','04310','04330','04360','04370','04400','04510','04530','04600','04700','04850','05100','05110','05120','05130','05150','05160','05170','05200','05220','05240','05250','05260','05290','05300','05310','05320','05330','05340','05350','05400','05460','05470','05500','05560','05600','05700','05800','06140','06380','06390','06410','06420','06430','06450','06470','06530','06540','06620','06710','06750','06910','09110','09140','09300','09460','25120','25140','25240','25370','25450','25500','25650','30570','31110','38112','38114','38142','38190','38250','38350','38380','38410','38580','38660','38700','38750','38860','38880','39220','39310','39400','63113','63210','63240','63610','63660','63690','63840','63850','64440','64490','64560','64570','65110','65120','65170','65200','65240','65400','65510','65710','66210','66760','66800','68140','68610','68650','73110','73120','73130','73140','73150','73160','73170','73190','73210','73220','73230','73250','73260','73270','73300','73320','73340','73350','73390','73400','73440','73450','73460','73470','73500','73530','73550','73590','73600','73620','73630','73640','73710','73720','73870','74110','74120','74170','74220','74230','74260','74310','74340','74350','74360','74390','74400','74420','74430','74440','74450','74470','74480','74660','74740','74920','83111','83440','83530','83560','83630','83690','83830','83840','84390','88310','88340','88370','88400','90200');

			$postcode = $address['postcode'];

			if (substr($postcode,0,2)== '20'){
				$shipping_cost += (float)$this->config->get('dpdfrclassic_suppiles');
				if ((float)$this->config->get('dpdfrclassic_suppiles') < 0)
					return false;
			}
			if (in_array($postcode, $iles)){
				$shipping_cost += (float)$this->config->get('dpdfrclassic_suppiles');
				if ((float)$this->config->get('dpdfrclassic_suppiles') < 0)
					return false;
			}
			if (in_array($postcode, $montagne)){
				$shipping_cost += (float)$this->config->get('dpdfrclassic_suppmontagne');
				if ((float)$this->config->get('dpdfrclassic_suppmontagne') < 0)
					return false;
			}
		}
		return $shipping_cost;
	}
		
  	public function getQuote($address) {
		$this->language->load('shipping/dpdfrclassic');

		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
	
		foreach ($query->rows as $result) {
			if ($this->config->get('dpdfrclassic_' . $result['geo_zone_id'] . '_status')) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$result['geo_zone_id'] . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
			
				if ($query->num_rows)
					$status = true;
				else
					$status = false;
			} else
				$status = false;
		
			if ($status) {
				$cost = '';
				$weight = $this->cart->getWeight();
				$amount = $this->cart->getTotal();
				$rates = explode(',', $this->config->get('dpdfrclassic_' . $result['geo_zone_id'] . '_rate'));
				$franco = $this->config->get('dpdfrclassic_' . $result['geo_zone_id'] . '_franco');
				foreach ($rates as $rate) {
					$data = explode(':', $rate);
				
					if ($data[0] >= $weight) {
						if (isset($data[1])){
							if ((!empty($franco)) && ($amount >= $franco))
								$data[1] = 0;
							$cost = self::getOrderShippingCost($data[1],$address);
						}
						break;
					}
				}
				
				if ((string)$cost != '') { 
					if ($address['iso_code_2'] == 'FR' OR $address['iso_code_2'] == 'FX') {
						$quote_data['dpdfrclassic_' . $result['geo_zone_id']] = array(
							'code'         => 'dpdfrclassic.dpdfrclassic_' . $result['geo_zone_id'],
							'title'        => $this->language->get('text_classicblock'),
							'cost'         => $cost,
							'tax_class_id' => $this->config->get('dpdfrclassic_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('dpdfrclassic_tax_class_id'), $this->config->get('config_tax')))
						);
					}else{
						$quote_data['dpdfrclassic_' . $result['geo_zone_id']] = array(
							'code'         => 'dpdfrclassic.dpdfrclassic_' . $result['geo_zone_id'],
							'title'        => $this->language->get('text_dpdblock').' ('.$address['country'].')',
							'cost'         => $cost,
							'tax_class_id' => $this->config->get('dpdfrclassic_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('dpdfrclassic_tax_class_id'), $this->config->get('config_tax')))
						);
					}
				}
			}
		}
		$method_data = array();
	
		if ($quote_data) {
			if ($address['iso_code_2'] == 'FR' OR $address['iso_code_2'] == 'FX') {
				$method_data = array(
					'code'       => 'dpdfrclassic',
					'title'      => '<img src="image/data/dpdfrance/front/classic/carrier_logo.jpg"/> '.$this->language->get('text_subtitlefr'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('dpdfrclassic_sort_order'),
					'error'      => false
				);
			}else{
				$method_data = array(
					'code'       => 'dpdfrclassic',
					'title'      => '<img src="image/data/dpdfrance/front/world/carrier_logo.jpg"/> '.$this->language->get('text_subtitledpd'),
					'quote'      => $quote_data,
					'sort_order' => $this->config->get('dpdfrclassic_sort_order'),
					'error'      => false
				);
			}
		}
	
		return $method_data;
  	}
}
?>