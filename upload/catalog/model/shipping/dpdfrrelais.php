<?php
/**
 * DPD France v5.2.0 shipping module for OpenCart 2.0
 *
 * @category   DPDFrance
 * @package    DPDFrance_Shipping
 * @author     DPD France S.A.S. <support.ecommerce@dpd.fr>
 * @copyright  2016 DPD France S.A.S., société par actions simplifiée, au capital de 18.500.000 euros, dont le siège social est situé 9 Rue Maurice Mallet - 92130 ISSY LES MOULINEAUX, immatriculée au registre du commerce et des sociétés de Paris sous le numéro 444 420 830
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class ModelShippingDpdfrrelais extends Model {
    function stripaccents($str){
        $str = preg_replace('/[\x{00C0}\x{00C1}\x{00C2}\x{00C3}\x{00C4}\x{00C5}]/u','A', $str);
        $str = preg_replace('/[\x{0105}\x{0104}\x{00E0}\x{00E1}\x{00E2}\x{00E3}\x{00E4}\x{00E5}]/u','a', $str);
        $str = preg_replace('/[\x{00C7}\x{0106}\x{0108}\x{010A}\x{010C}]/u','C', $str);
        $str = preg_replace('/[\x{00E7}\x{0107}\x{0109}\x{010B}\x{010D}}]/u','c', $str);
        $str = preg_replace('/[\x{010E}\x{0110}]/u','D', $str);
        $str = preg_replace('/[\x{010F}\x{0111}]/u','d', $str);
        $str = preg_replace('/[\x{00C8}\x{00C9}\x{00CA}\x{00CB}\x{0112}\x{0114}\x{0116}\x{0118}\x{011A}]/u','E', $str);
        $str = preg_replace('/[\x{00E8}\x{00E9}\x{00EA}\x{00EB}\x{0113}\x{0115}\x{0117}\x{0119}\x{011B}]/u','e', $str);
        $str = preg_replace('/[\x{00CC}\x{00CD}\x{00CE}\x{00CF}\x{0128}\x{012A}\x{012C}\x{012E}\x{0130}]/u','I', $str);
        $str = preg_replace('/[\x{00EC}\x{00ED}\x{00EE}\x{00EF}\x{0129}\x{012B}\x{012D}\x{012F}\x{0131}]/u','i', $str);
        $str = preg_replace('/[\x{0142}\x{0141}\x{013E}\x{013A}]/u','l', $str);
        $str = preg_replace('/[\x{00F1}\x{0148}]/u','n', $str);
        $str = preg_replace('/[\x{00D2}\x{00D3}\x{00D4}\x{00D5}\x{00D6}\x{00D8}]/u','O', $str);
        $str = preg_replace('/[\x{00F2}\x{00F3}\x{00F4}\x{00F5}\x{00F6}\x{00F8}]/u','o', $str);
        $str = preg_replace('/[\x{0159}\x{0155}]/u','r', $str);
        $str = preg_replace('/[\x{015B}\x{015A}\x{0161}]/u','s', $str);
        $str = preg_replace('/[\x{00DF}]/u','ss', $str);
        $str = preg_replace('/[\x{0165}]/u','t', $str);
        $str = preg_replace('/[\x{00D9}\x{00DA}\x{00DB}\x{00DC}\x{016E}\x{0170}\x{0172}]/u','U', $str);
        $str = preg_replace('/[\x{00F9}\x{00FA}\x{00FB}\x{00FC}\x{016F}\x{0171}\x{0173}]/u','u', $str);
        $str = preg_replace('/[\x{00FD}\x{00FF}]/u','y', $str);
        $str = preg_replace('/[\x{017C}\x{017A}\x{017B}\x{0179}\x{017E}]/u','z', $str);
        $str = preg_replace('/[\x{00C6}]/u','AE', $str);
        $str = preg_replace('/[\x{00E6}]/u','ae', $str);
        $str = preg_replace('/[\x{0152}]/u','OE', $str);
        $str = preg_replace('/[\x{0153}]/u','oe', $str);
        $str = preg_replace('/[\x{0022}\x{0025}\x{0026}\x{0027}\x{00A1}\x{00A2}\x{00A3}\x{00A4}\x{00A5}\x{00A6}\x{00A7}\x{00A8}\x{00AA}\x{00AB}\x{00AC}\x{00AD}\x{00AE}\x{00AF}\x{00B0}\x{00B1}\x{00B2}\x{00B3}\x{00B4}\x{00B5}\x{00B6}\x{00B7}\x{00B8}\x{00BA}\x{00BB}\x{00BC}\x{00BD}\x{00BE}\x{00BF}]/u',' ', $str);
        $str = strtoupper($str);
        return $str;
    }

    public function getOrderShippingCost($shipping_cost, $address, $postcode){
        if ($address['iso_code_2'] == 'FR' || $address['iso_code_2'] == 'FX') {
            $iles = array('17111','17123','17190','17310','17370','17410','17480','17550','17580','17590','17630','17650','17670','17740','17840','17880','17940','22870','29242','29253','29259','29980','29990','56360','56590','56780','56840','85350');
            $montagne = array('04120','04130','04140','04160','04170','04200','04240','04260','04300','04310','04330','04360','04370','04400','04510','04530','04600','04700','04850','05100','05110','05120','05130','05150','05160','05170','05200','05220','05240','05250','05260','05290','05300','05310','05320','05330','05340','05350','05400','05460','05470','05500','05560','05600','05700','05800','06140','06380','06390','06410','06420','06430','06450','06470','06530','06540','06620','06710','06750','06910','09110','09140','09300','09460','25120','25140','25240','25370','25450','25500','25650','30570','31110','38112','38114','38142','38190','38250','38350','38380','38410','38580','38660','38700','38750','38860','38880','39220','39310','39400','63113','63210','63240','63610','63660','63690','63840','63850','64440','64490','64560','64570','65110','65120','65170','65200','65240','65400','65510','65710','66210','66760','66800','68140','68610','68650','73110','73120','73130','73140','73150','73160','73170','73190','73210','73220','73230','73250','73260','73270','73300','73320','73340','73350','73390','73400','73440','73450','73460','73470','73500','73530','73550','73590','73600','73620','73630','73640','73710','73720','73870','74110','74120','74170','74220','74230','74260','74310','74340','74350','74360','74390','74400','74420','74430','74440','74450','74470','74480','74660','74740','74920','83111','83440','83530','83560','83630','83690','83830','83840','84390','88310','88340','88370','88400','90200');

            // $postcode = $address['postcode']; // DPD Relais : postcode is given in params to appply overcost on each relaypoint

            if (substr($postcode,0,2)== '20'){
                $shipping_cost += (float)$this->config->get('dpdfrrelais_suppiles');
                if ((float)$this->config->get('dpdfrrelais_suppiles') < 0)
                    return false;
            }
            if (in_array($postcode, $iles)){
                $shipping_cost += (float)$this->config->get('dpdfrrelais_suppiles');
                if ((float)$this->config->get('dpdfrrelais_suppiles') < 0)
                    return false;
            }
            if (in_array($postcode, $montagne)){
                $shipping_cost += (float)$this->config->get('dpdfrrelais_suppmontagne');
                if ((float)$this->config->get('dpdfrrelais_suppmontagne') < 0)
                    return false;
            }
        }
        return $shipping_cost;
    }

    public function getQuote($address) {
        $this->language->load('shipping/dpdfrrelais');

        $quote_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "geo_zone ORDER BY name");

        foreach ($query->rows as $result) {
            if ($this->config->get('dpdfrrelais_' . $result['geo_zone_id'] . '_status')) {
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
                $rates = explode(',', $this->config->get('dpdfrrelais_' . $result['geo_zone_id'] . '_rate'));
                $franco = $this->config->get('dpdfrrelais_' . $result['geo_zone_id'] . '_franco');
                foreach ($rates as $rate) {
                    $data = explode(':', $rate);

                    if ($data[0] >= $weight) {
                        if (isset($data[1]))
                            $cost = $data[1];
                        break;
                    }
                }
                if ((!empty($franco)) && ($amount >= $franco))
                    $cost = 0;

                if ((string)$cost != '') {
                    $variables = array('carrier'=>'EXA',
                                'key'=> 'deecd7bc81b71fcc0e292b53e826c48f',
                                'address'=> self::stripaccents($address['address_1']),
                                'zipCode'=> $address['postcode'],
                                'city'=> self::stripaccents($address['city']),
                                'countrycode'=>'FR',
                                'requestID'=>'1234',
                                'request_id'=>'1234',
                                'date_from'=>date('d/m/Y'),
                                'max_pudo_number'=>'',
                                'max_distance_search'=>'',
                                'weight'=>'',
                                'category'=>'',
                                'holiday_tolerant'=>'');
                    try {
                        ini_set("default_socket_timeout", 5);
                        $serviceurl = $this->config->get('dpdfrrelais_mypudo');
                        $soappudo = new SoapClient($serviceurl,array('connection_timeout' => 5,'cache_wsdl' => WSDL_CACHE_NONE, 'exceptions' => true));

                        $pointsRelais = $soappudo->getPudoList($variables)->GetPudoListResult->any;// récupère la liste des points relais
                        $xml = new SimpleXMLElement($pointsRelais);
                        $quality = $xml["quality"];
                        $relais_items = $xml->PUDO_ITEMS;
                        if($quality!=0){
                            $cpt=0;
                            foreach($relais_items->PUDO_ITEM as $pointRelais){
                                $link = 'http://www.dpd.fr/dpdrelais/id_'.$pointRelais->PUDO_ID.'';
                                $delivery_cost = self::getOrderShippingCost($cost, $address, $pointRelais->ZIPCODE);
                                if (!$delivery_cost)
                                    continue;
                                $quote_data['dpdfrrelais_' . $pointRelais->PUDO_ID] = array(
                                    'code'          => 'dpdfrrelais.dpdfrrelais_' . $pointRelais->PUDO_ID,
                                    'title'         => "<div class=\"lignepr\"><b>".self::stripaccents($pointRelais->NAME) . ' (' . $pointRelais->PUDO_ID . ') ' . "</b><br/>".self::stripaccents($pointRelais->ADDRESS1) ." <br/>".$pointRelais->ZIPCODE." ".self::stripaccents($pointRelais->CITY)." <a href=\"javascript:void(0);\" target=\"_blank\" onclick=\"window.open(&quot;".$link."&quot;,&quot;Votre relais Pickup&quot;,&quot;menubar=no, status=no, scrollbars=no, location=no, toolbar=no, width=1024, height=640&quot;);return false;\">          (".number_format($pointRelais->DISTANCE/1000,2)."km - ".$this->language->get('text_details').")</a></div>",
                                    'cost'          => $delivery_cost,
                                    'tax_class_id'  => $this->config->get('dpdfrrelais_tax_class_id'),
                                    'text'          => $this->currency->format($this->tax->calculate($delivery_cost, $this->config->get('dpdfrrelais_tax_class_id'), $this->config->get('config_tax')))
                                );
                            $cpt++;
                            if($cpt==5)
                                break;
                            }
                        }
                    }catch (Exception $e){
                        // Ne pas afficher de méthode de livraison si le WS ne répond pas de liste correcte de PR
                    }
                }
            }
        }
        $method_data = array();

        if ($quote_data) {
            $method_data = array(
                'code'       => 'dpdfrrelais',
                'title'      => '<img src="image/data/dpdfrance/front/relais/carrier_logo.jpg"/> '.$this->language->get('text_subtitle').'<div class="dpdfrance_header">'.$this->language->get('text_header').'</div>',
                'quote'      => $quote_data,
                'sort_order' => $this->config->get('dpdfrrelais_sort_order'),
                'error'      => false
            );
        }

        return $method_data;
    }
}
?>