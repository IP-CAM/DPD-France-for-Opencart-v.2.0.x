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

class ModelShippingDpdfrpredict extends Model {    
	public function formatGsm($input_tel) {
		$gsm_dest = str_replace(array(' ', '.', '-', ',', ';', '/', '\\', '(', ')'),'',$input_tel);
		$gsm_dest = str_replace('+33','0',$gsm_dest);
		if (substr($gsm_dest, 0, 2) == 33){ // Chrome autofill fix
			$gsm_dest = substr_replace($gsm_dest, '0', 0, 2);
		}
		return $gsm_dest;
	}
	
	public function getOrderShippingCost($shipping_cost,$address){
		if ($address['iso_code_2'] == 'FR' || $address['iso_code_2'] == 'FX') {
			$iles = array('17111','17123','17190','17310','17370','17410','17480','17550','17580','17590','17630','17650','17670','17740','17840','17880','17940','22870','29242','29253','29259','29980','29990','56360','56590','56780','56840','85350');
			$montagne = array('04120','04130','04140','04160','04170','04200','04240','04260','04300','04310','04330','04360','04370','04400','04510','04530','04600','04700','04850','05100','05110','05120','05130','05150','05160','05170','05200','05220','05240','05250','05260','05290','05300','05310','05320','05330','05340','05350','05400','05460','05470','05500','05560','05600','05700','05800','06140','06380','06390','06410','06420','06430','06450','06470','06530','06540','06620','06710','06750','06910','09110','09140','09300','09460','25120','25140','25240','25370','25450','25500','25650','30570','31110','38112','38114','38142','38190','38250','38350','38380','38410','38580','38660','38700','38750','38860','38880','39220','39310','39400','63113','63210','63240','63610','63660','63690','63840','63850','64440','64490','64560','64570','65110','65120','65170','65200','65240','65400','65510','65710','66210','66760','66800','68140','68610','68650','73110','73120','73130','73140','73150','73160','73170','73190','73210','73220','73230','73250','73260','73270','73300','73320','73340','73350','73390','73400','73440','73450','73460','73470','73500','73530','73550','73590','73600','73620','73630','73640','73710','73720','73870','74110','74120','74170','74220','74230','74260','74310','74340','74350','74360','74390','74400','74420','74430','74440','74450','74470','74480','74660','74740','74920','83111','83440','83530','83560','83630','83690','83830','83840','84390','88310','88340','88370','88400','90200');

			$postcode = $address['postcode'];

			if (substr($postcode,0,2)== '20'){
				$shipping_cost += (float)$this->config->get('dpdfrpredict_suppiles');
				if ((float)$this->config->get('dpdfrpredict_suppiles') < 0)
					return false;
			}
			if (in_array($postcode, $iles)){
				$shipping_cost += (float)$this->config->get('dpdfrpredict_suppiles');
				if ((float)$this->config->get('dpdfrpredict_suppiles') < 0)
					return false;
			}
			if (in_array($postcode, $montagne)){
				$shipping_cost += (float)$this->config->get('dpdfrpredict_suppmontagne');
				if ((float)$this->config->get('dpdfrpredict_suppmontagne') < 0)
					return false;
			}
		}
		return $shipping_cost;
	}
	
  	public function getQuote($address) {
		$this->language->load('shipping/dpdfrpredict');
		
		$quote_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");
	
		foreach ($query->rows as $result) {
			if ($this->config->get('dpdfrpredict_' . $result['geo_zone_id'] . '_status')) {
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
				$rates = explode(',', $this->config->get('dpdfrpredict_' . $result['geo_zone_id'] . '_rate'));
				$franco = $this->config->get('dpdfrpredict_' . $result['geo_zone_id'] . '_franco');
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


				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"./image/data/dpdfrance/css/front/dpdfrance.css\" />
					<script language='JavaScript'>
						function in_array(search, array){
							for (i = 0; i < array.length; i++){
								if(array[i] == search ){
									return false;
								}
							}
							return true;
						}
						
						function SetCookie(cookieName,cookieValue,nDays) {
							var today = new Date();
							var expire = new Date();
							if (nDays==null || nDays==0) nDays=1;
								expire.setTime(today.getTime() + 3600000*24*nDays);
								document.cookie = cookieName+'='+escape(cookieValue)
										 + ';expires='+expire.toGMTString();
						}

						function valideGsm(frm){
							var regex = new RegExp(/^((\+33|0)[67])(?:[ _.-]?(\d{2})){4}$/);
							var gsmDest = document.getElementById('dpdfrpredict_gsm_dest').value.replace(/\D/g,'');
							var numbers = gsmDest.substr(-8);
							var pattern = new Array('00000000','11111111','22222222','33333333','44444444','55555555','66666666','77777777','88888888','99999999','12345678','23456789','98765432');
												
							if (regex.test(gsmDest) && in_array(numbers, pattern)){
								SetCookie('dpdfrpredict_gsm',gsmDest,7);
								$('input:radio[value*=dpdfrpredict]').click();
								document.getElementById('dpdfrance_predict_error').style.display = 'none';
								$('#dpdfrpredict_gsm_submit').css('background-color','#34a900');
								$('#dpdfrpredict_gsm_submit').val('✓');
								return true;
							}else{
								document.getElementById('dpdfrance_predict_error').style.display = 'block';
								$('#dpdfrpredict_gsm_submit').css('background-color','#424143');
								$('#dpdfrpredict_gsm_submit').val('>');
								return false;
							}
						}
						</script>";
						
				if ((string)$cost != '') {
					if ($address['iso_code_2'] == 'FR' OR $address['iso_code_2'] == 'FX') {
					
						$dpdfrpredict_gsm = (isset($_COOKIE['dpdfrpredict_gsm']) ? self::formatGsm($_COOKIE['dpdfrpredict_gsm']) : null);
						
						$quote_data['dpdfrpredict_' . $result['geo_zone_id']] = array(
							'code'         => 'dpdfrpredict.dpdfrpredict_' . $result['geo_zone_id'],
							'title'        => $this->language->get('text_predictblock')."
															<form id='dpdfrpredict_gsm_form'>
																<input size='10' type='text' id='dpdfrpredict_gsm_dest' value=".$dpdfrpredict_gsm."><input id='dpdfrpredict_gsm_submit' type='button' value='>' onClick='valideGsm(this.form)'>
															</form></div>",
							'cost'         => $cost,
							'tax_class_id' => $this->config->get('dpdfrpredict_tax_class_id'),
							'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('dpdfrpredict_tax_class_id'), $this->config->get('config_tax')))
						);	
					}
				}
			}
		}
		$method_data = array();
	
		if ($quote_data) {
      		$method_data = array(
        		'code'       => 'dpdfrpredict',
        		'title'      => '<img src="image/data/dpdfrance/front/predict/carrier_logo.jpg"/> '.$this->language->get('text_subtitle'),
        		'quote'      => $quote_data,
				'sort_order' => $this->config->get('dpdfrpredict_sort_order'),
        		'error'      => false
      		);
		}
	
		return $method_data;
  	}
}
?>