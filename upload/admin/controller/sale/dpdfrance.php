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

class ControllerSaleDpdfrance extends Controller {
	private $error = array();

  	public function index()
	{
		$this->load->language('sale/dpdfrance');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/dpdfrance');
    	$this->getList();
  	}
	
  	public function dpdfranceexport() 
	{
		$this->load->language('sale/dpdfrance');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/dpdfrance');

    	if (isset($this->request->post['selected']))
		{
			$record = new DPDStation();
			foreach ($this->request->post['selected'] as $order_id) {
				
				$order_info = $this->model_sale_dpdfrance->getOrder($order_id);
				
				$this->load->model('localisation/country');
				$country_info = $this->model_localisation_country->getCountry($order_info['shipping_country_id']);
				
				$isops = array("DE", "AD", "AT", "BE", "BA", "BG", "HR", "DK", "ES", "EE", "FI", "FR", "FX", "GB", "GR", "GG", "HU", "IM", "IE", "IT", "JE", "LV", "LI", "LT", "LU", "NO", "NL", "PL", "PT", "CZ", "RO", "RS", "SK", "SI", "SE", "CH");
				$isoep = array("D", "AND", "A", "B", "BA", "BG", "CRO", "DK", "E", "EST", "SF", "F", "F", "GB", "GR", "GG", "H", "IM", "IRL", "I", "JE", "LET", "LIE", "LIT", "L", "N", "NL", "PL", "P", "CZ", "RO", "RS", "SK", "SLO", "S", "CH");
				
				if(in_array($country_info['iso_code_2'], $isops)) // Si le code ISO est européen, on le convertit au format Station DPD
					$code_iso = str_replace($isops, $isoep, $country_info['iso_code_2']);
				else
					$code_iso = str_replace($country_info['iso_code_2'], "INT", $country_info['iso_code_2']); // Si le code ISO n'est pas européen, on le passe en "INT" (intercontinental)
				
				if (strpos($order_info['shipping_code'], 'dpdfrrelais') !== false){
					$service = 'Relais';
					$compte_chargeur = $this->config->get('dpdfrrelais_cargo');
					$gsmDest = DPDStation::formatGSM($order_info['telephone'],$code_iso);
					$order_amount = ($this->config->get('dpdfrrelais_advalorem') == 1 ? str_pad(number_format($order_info['total'], 2, '.', ''), 9, '0', STR_PAD_LEFT) : '');
				}else if (strpos($order_info['shipping_code'], 'dpdfrpredict') !== false){
					$service = 'Predict';
					$compte_chargeur = $this->config->get('dpdfrpredict_cargo');
					$gsmDest = DPDStation::formatGSM(substr($order_info['shipping_method'],-11,10),$code_iso);
					$order_amount = ($this->config->get('dpdfrpredict_advalorem') == 1 ? str_pad(number_format($order_info['total'], 2, '.', ''), 9, '0', STR_PAD_LEFT) : '');
				}else{
					$service = 'Classic';
					$compte_chargeur = $this->config->get('dpdfrclassic_cargo');
					$gsmDest = DPDStation::formatGSM($order_info['telephone'],$code_iso);
					$order_amount = ($this->config->get('dpdfrclassic_advalorem') == 1 ? str_pad(number_format($order_info['total'], 2, '.', ''), 9, '0', STR_PAD_LEFT) : '');
				}

				$record->add($order_id, 0, 35);																		//	Référence client N°1 - Id Commande 
				// $record->add(str_pad(intval($weight), 8, '0', STR_PAD_LEFT), 37, 8); 							//	Poids du colis sur 8 caractères
				if($service !== 'Relais')
					$record->add($order_info['shipping_firstname'].' '.$order_info['shipping_lastname'], 60, 70);  	//	Prénom + Nom du destinataire (sauf Relais)
				else{
					$record->add($order_info['shipping_lastname'], 60, 35);    										//	Nom de famille du destinataire
					$record->add($order_info['shipping_firstname'], 95, 35);   										//	Prénom du destinataire
				}
				$record->add($order_info['shipping_company'], 130, 35);    											//	Complément d’adresse 2
				$record->add($order_info['shipping_address_2'], 165, 35);    										//	Complément d’adresse 3
				$record->add($order_info['shipping_postcode'], 270, 10);    										//	Code postal
				$record->add($order_info['shipping_city'], 280, 35);     											//	Ville
				$record->add($order_info['shipping_address_1'], 325, 35);    										//	Rue
				$record->add($code_iso, 370, 3);          															//	Code Pays destinataire
				$record->add($order_info['telephone'], 373, 30);        											//	Téléphone Destinataire
				// $record->add($order_info['store_name'], 418, 35);        										//	Nom expéditeur
				// $record->add($address2_exp, 453, 35);       														//	Complément d’adresse 1
				// $record->add($cp_exp, 628, 10);         															//	Code postal
				// $record->add($ville_exp, 638, 35);        														//	Ville
				// $record->add($address_exp, 683, 35);       														//	Rue
				// $record->add('F', 728, 3);       																//	Code Pays
				// $record->add($tel_exp, 731, 30);        															//	Tél. Expéditeur
				$record->add(date("d/m/Y"), 901, 10);  																//	Date d'expédition théorique
				$record->add(str_pad($compte_chargeur, 8, '0', STR_PAD_LEFT), 911, 8); 								//	N° de compte chargeur DPD France
				$record->add('', 919, 35);     																		//	Code à barres
				$record->add($order_id, 954, 35);        															//	N° de commande - Id Order
				$record->add($order_amount, 1018, 9); 																//  Montant valeur colis
				$record->add($order_id, 1035, 35);       															//	Référence client N°2
				// $record->add($email_exp, 1116, 80);        														//	E-mail expéditeur
				// $record->add($gsm_exp, 1196, 35);        														//	GSM expéditeur
				$record->add($order_info['email'], 1231, 80);      													//	E-mail destinataire
				$record->add($gsmDest, 1311, 35);   																//	GSM destinataire
				$record->add('', 1346, 96);         																//	Filler
				if($service == 'Relais')
					$record->add(substr($order_info['shipping_code'],-6), 1442, 8);    								//	Identifiant relais
				if($service == 'Predict' && preg_match('/^(0)[67][0-9]{8}$/', $gsmDest))
					$record->add("+", 1568, 1);																		//	Flag Predict
				$record->add($order_info['shipping_lastname'], 1569, 35);    										//	Nom de famille du destinataire
				$record->add_line();	
			}
			$record->display();
			
			$this->session->data['success'] = $this->language->get('text_success');


			$url = '';
			if (isset($this->request->get['filter_order_id']))
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];			
			if (isset($this->request->get['filter_customer']))
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));												
			if (isset($this->request->get['filter_address']))
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			if (isset($this->request->get['filter_order_status_id']))
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			if (isset($this->request->get['filter_total']))
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			if (isset($this->request->get['filter_shipping_code']))
				$url .= '&filter_shipping_code=' . $this->request->get['filter_shipping_code'];
			if (isset($this->request->get['filter_date_added']))
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			if (isset($this->request->get['filter_date_modified']))
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];									
			if (isset($this->request->get['sort']))
				$url .= '&sort=' . $this->request->get['sort'];
			if (isset($this->request->get['order']))
				$url .= '&order=' . $this->request->get['order'];
			if (isset($this->request->get['page']))
				$url .= '&page=' . $this->request->get['page'];
			$this->response->redirect($this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}
    	$this->getList();
  	}
	
	public function dpdfrancetracking() 
	{
		$this->load->language('sale/dpdfrance');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/dpdfrance');


    	if (isset($this->request->post['selected'])) 
		{
			foreach ($this->request->post['selected'] as $order_id) 
			{
				$order_info = $this->model_sale_dpdfrance->getOrder($order_id);
				if (strpos($order_info['shipping_code'], 'dpdfrrelais') !== false){
					$service = 'Relais';
					$agence = $this->config->get('dpdfrrelais_agence');
					$compte_chargeur = $this->config->get('dpdfrrelais_cargo');
				}else if (strpos($order_info['shipping_code'], 'dpdfrpredict') !== false){
					$service = 'Predict';
					$agence = $this->config->get('dpdfrpredict_agence');
					$compte_chargeur = $this->config->get('dpdfrpredict_cargo');
				}else{
					$service = 'Classic';
					$agence = $this->config->get('dpdfrclassic_agence');
					$compte_chargeur = $this->config->get('dpdfrclassic_cargo');
				}
				$data = array(	'notify' => 1, 
								'order_status_id' => '15', 
								'comment' => 'Cher client, vous pouvez suivre l\'acheminement de votre colis par DPD en cliquant sur le lien ci-contre : http://www.dpd.fr/tracer_'.$order_id.'_'.$agence.$compte_chargeur
								);
				$this->model_sale_dpdfrance->addOrderHistory($order_id, $data);	
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_order_id']))
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			if (isset($this->request->get['filter_customer']))
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			if (isset($this->request->get['filter_address']))
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));			
			if (isset($this->request->get['filter_order_status_id']))
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			if (isset($this->request->get['filter_total']))
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			if (isset($this->request->get['filter_shipping_code']))
				$url .= '&filter_shipping_code=' . $this->request->get['filter_shipping_code'];
			if (isset($this->request->get['filter_date_added']))
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			if (isset($this->request->get['filter_date_modified']))
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			if (isset($this->request->get['sort']))
				$url .= '&sort=' . $this->request->get['sort'];
			if (isset($this->request->get['order']))
				$url .= '&order=' . $this->request->get['order'];
			if (isset($this->request->get['page']))
				$url .= '&page=' . $this->request->get['page'];
			$this->response->redirect($this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}
	
	public function dpdfrancelivre() 
	{
		$this->load->language('sale/dpdfrance');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('sale/dpdfrance');

    	if (isset($this->request->post['selected'])) 
		{
			foreach ($this->request->post['selected'] as $order_id)
			{
			$data = array('notify' => 0, 'order_status_id' => '3', 'comment' => '');
			$this->model_sale_dpdfrance->addOrderHistory($order_id, $data);
			}
			$this->session->data['success'] = $this->language->get('text_success');
			$url = '';
			if (isset($this->request->get['filter_order_id']))
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			if (isset($this->request->get['filter_customer']))
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			if (isset($this->request->get['filter_address']))
				$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
			if (isset($this->request->get['filter_order_status_id']))
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			if (isset($this->request->get['filter_total']))
				$url .= '&filter_total=' . $this->request->get['filter_total'];		
			if (isset($this->request->get['filter_date_added']))
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			if (isset($this->request->get['filter_shipping_code']))
				$url .= '&filter_shipping_code=' . $this->request->get['filter_shipping_code'];
			if (isset($this->request->get['filter_date_modified']))
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			if (isset($this->request->get['sort']))
				$url .= '&sort=' . $this->request->get['sort'];
			if (isset($this->request->get['order']))
				$url .= '&order=' . $this->request->get['order'];
			if (isset($this->request->get['page']))
				$url .= '&page=' . $this->request->get['page'];
			$this->response->redirect($this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}
	
  	protected function getList()
	{
		if (isset($this->request->get['filter_order_id']))
			$filter_order_id = $this->request->get['filter_order_id'];
		else
			$filter_order_id = null;

		if (isset($this->request->get['filter_customer']))
			$filter_customer = $this->request->get['filter_customer'];
		else
			$filter_customer = null;

		if (isset($this->request->get['filter_address']))
			$filter_address = $this->request->get['filter_address'];
		else
			$filter_address = null;

		if (isset($this->request->get['filter_order_status_id']))
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		else
			$filter_order_status_id = null;
		
		if (isset($this->request->get['filter_total']))
			$filter_total = $this->request->get['filter_total'];
		else
			$filter_total = null;
			
		if (isset($this->request->get['filter_shipping_code']))
			$filter_shipping_code = $this->request->get['filter_shipping_code'];
		else
			$filter_shipping_code = null;
		
		if (isset($this->request->get['filter_date_added']))
			$filter_date_added = $this->request->get['filter_date_added'];
		else
			$filter_date_added = null;
		
		if (isset($this->request->get['filter_date_modified']))
			$filter_date_modified = $this->request->get['filter_date_modified'];
		else
			$filter_date_modified = null;

		if (isset($this->request->get['sort']))
			$sort = $this->request->get['sort'];
		else
			$sort = 'o.order_id';

		if (isset($this->request->get['order']))
			$order = $this->request->get['order'];
		else
			$order = 'DESC';
		
		if (isset($this->request->get['page']))
			$page = $this->request->get['page'];
		else
			$page = 1;
				
		$url = '';

		if (isset($this->request->get['filter_order_id']))
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		if (isset($this->request->get['filter_customer']))
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));	
		if (isset($this->request->get['filter_address']))
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_order_status_id']))
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		if (isset($this->request->get['filter_total']))
			$url .= '&filter_total=' . $this->request->get['filter_total'];	
		if (isset($this->request->get['filter_date_added']))
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		if (isset($this->request->get['filter_shipping_code']))
			$url .= '&filter_shipping_code=' . $this->request->get['filter_shipping_code'];
		if (isset($this->request->get['filter_date_modified']))
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		if (isset($this->request->get['sort']))
			$url .= '&sort=' . $this->request->get['sort'];
		if (isset($this->request->get['order']))
			$url .= '&order=' . $this->request->get['order'];
		if (isset($this->request->get['page']))
			$url .= '&page=' . $this->request->get['page'];
  
		$data['breadcrumbs'] = array();
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);

		$data['dpdfranceexport'] = $this->url->link('sale/dpdfrance/dpdfranceexport', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['dpdfrancetracking'] = $this->url->link('sale/dpdfrance/dpdfrancetracking', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['dpdfrancelivre'] = $this->url->link('sale/dpdfrance/dpdfrancelivre', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['orders'] = array();

		$filter_data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_customer'	     => $filter_customer,
			'filter_address'	     => $filter_address,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_total'           => $filter_total,
			'filter_shipping_code'   => $filter_shipping_code,
			'filter_date_added'      => $filter_date_added,
			'filter_date_modified'   => $filter_date_modified,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$order_total = $this->model_sale_dpdfrance->getTotalOrders($filter_data);
		$results = $this->model_sale_dpdfrance->getOrders($filter_data);

    	foreach ($results as $result) 
		{
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['shipping_country_id'] . "'");

			if ($country_query->num_rows)
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
			else
				$shipping_iso_code_2 = '';
			
			$action = array();
				if (strpos($result['shipping_code'], 'dpdfrrelais') !== false){
					$service = 'Relais';
					$icon = '<span style="font-size:0px;">Relais</span><img src="../image/data/dpdfrance/admin/service_relais.png" alt="Relais" title="Relais"/>';
					$address = $result['relais_address'];
					$link = '<a href="http://www.dpd.fr/tracer_'.$result['order_id'].'_'.$this->config->get('dpdfrrelais_agence').$this->config->get('dpdfrrelais_cargo').'" target="_blank"><img src="../image/data/dpdfrance/admin/tracking.png"/></a>';
				}else if (strpos($result['shipping_code'], 'dpdfrpredict') !== false){
					$service = 'Predict';
					$icon = '<span style="font-size:0px;">Predict</span><img src="../image/data/dpdfrance/admin/service_predict.png" alt="Predict" title="Predict"/>';
					$address = $result['address'];
					$link = '<a href="http://www.dpd.fr/tracer_'.$result['order_id'].'_'.$this->config->get('dpdfrpredict_agence').$this->config->get('dpdfrpredict_cargo').'" target="_blank"><img src="../image/data/dpdfrance/admin/tracking.png"/></a>';
				}else{
					if ($shipping_iso_code_2 == 'FR'){
						$service = 'Classic';
						$icon = '<span style="font-size:0px;">Classic</span><img src="../image/data/dpdfrance/admin/service_dom.png" alt="Classic" title="Classic"/>';
						$address = $result['address'];
						$link = '<a href="http://www.dpd.fr/tracer_'.$result['order_id'].'_'.$this->config->get('dpdfrclassic_agence').$this->config->get('dpdfrclassic_cargo').'" target="_blank"><img src="../image/data/dpdfrance/admin/tracking.png"/></a>';
					}else{
						$service = 'Classic';
						$icon = '<span style="font-size:0px;">Classic</span><img src="../image/data/dpdfrance/admin/service_world.png" alt="Intercontinental" title="Intercontinental"/>';
						$address = $result['address'];
						$link = '<a href="http://www.dpd.fr/tracer_'.$result['order_id'].'_'.$this->config->get('dpdfrclassic_agence').$this->config->get('dpdfrclassic_cargo').'" target="_blank"><img src="../image/data/dpdfrance/admin/tracking.png"/></a>';
					}
				}
			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'address'     	=> $address,
				'status'        => $result['status'],
				'shipping_code' => $icon,
				'parcel_trace'  => $link,
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_export'] = $this->language->get('text_export');
		$data['text_trackings'] = $this->language->get('text_trackings');
		$data['text_livre'] = $this->language->get('text_livre');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_missing'] = $this->language->get('text_missing');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_news'] = $this->language->get('text_news');
		$data['text_search_filter'] = $this->language->get('text_search_filter');

		$data['column_order_id'] = $this->language->get('column_order_id');
    	$data['column_customer'] = $this->language->get('column_customer');
    	$data['column_address'] = $this->language->get('column_address');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_shipping_code'] = $this->language->get('column_shipping_code');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_date_modified'] = $this->language->get('column_date_modified');
		$data['column_parcel_trace'] = $this->language->get('column_parcel_trace');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_invoice'] = $this->language->get('button_invoice');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];
		
		if (isset($this->error['warning']))
			$data['error_warning'] = $this->error['warning'];
		else
			$data['error_warning'] = '';

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else
			$data['success'] = '';

		$url = '';

		if (isset($this->request->get['filter_order_id']))
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		if (isset($this->request->get['filter_customer']))
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));							
		if (isset($this->request->get['filter_address']))
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_order_status_id']))
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		if (isset($this->request->get['filter_total']))
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		if (isset($this->request->get['filter_shipping_code']))
			$url .= '&filter_shipping_code=' . $this->request->get['filter_shipping_code'];
		if (isset($this->request->get['filter_date_added']))
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		if (isset($this->request->get['filter_date_modified']))
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		
		if ($order == 'ASC')
			$url .= '&order=DESC';
		else
			$url .= '&order=ASC';

		if (isset($this->request->get['page']))
			$url .= '&page=' . $this->request->get['page'];

		$data['sort_order'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$data['sort_customer'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$data['sort_address'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=address' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$data['sort_shipping_code'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=shipping_code' . $url, 'SSL');
		$data['sort_total'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$data['sort_date_modified'] = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';
		if (isset($this->request->get['filter_order_id']))
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		if (isset($this->request->get['filter_customer']))
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_address']))
			$url .= '&filter_address=' . urlencode(html_entity_decode($this->request->get['filter_address'], ENT_QUOTES, 'UTF-8'));
		if (isset($this->request->get['filter_order_status_id']))
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		if (isset($this->request->get['filter_total']))
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		if (isset($this->request->get['filter_shipping_code']))
			$url .= '&filter_shipping_code=' . $this->request->get['filter_shipping_code'];
		if (isset($this->request->get['filter_date_added']))
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		if (isset($this->request->get['filter_date_modified']))
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		if (isset($this->request->get['sort']))
			$url .= '&sort=' . $this->request->get['sort'];
		if (isset($this->request->get['order']))
			$url .= '&order=' . $this->request->get['order'];
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/dpdfrance', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_address'] = $filter_address;
		$data['filter_order_status_id'] = $filter_order_status_id;
		$data['filter_total'] = $filter_total;
		$data['filter_shipping_code'] = $filter_shipping_code;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$this->load->model('localisation/order_status');

    	$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
	
		// Flux RSS
		$rss = @simplexml_load_string(file_get_contents('http://www.dpd.fr/extensions/rss/flux_info_dpdfr.xml'));
		if (!empty($rss->channel->item))
		{
			$data['rss'] = '<fieldset><legend><a href="javascript:void(0)" onclick="$(&quot;#zonemarquee&quot;).toggle(&quot;fast&quot;, function() {var text = $(&quot;#showhide&quot;).text();$(&quot;#showhide&quot;).text(text == &quot;+&quot; ? &quot;-&quot; : &quot;+&quot;);});"><img src="../image/data/dpdfrance/admin/rss_icon.png" />'.$data['text_news'].'<div id="showhide">-</div></a></legend><div id="zonemarquee"><div id="marquee" class="marquee">';
			foreach ($rss->channel->item as $item)
				$data['rss'] .= '<strong>'.$item->category.' > '.$item->title.' : </strong> '.$item->description.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$data['rss'] .= '</div></div></fieldset><br/>';
		}
		// Fin RSS
	
		$this->response->setOutput($this->load->view('sale/dpdfrance.tpl', $data));
  	}
}

class DPDStation
{

    var $line;
    var $contenu_fichier;

    function __construct()
	{
        $this->line = str_pad("", 1634);
        $this->contenu_fichier = '';
    }

    function add($txt, $position, $length)
	{
        $txt = $this->stripAccents($txt);
        $this->line = substr_replace($this->line, str_pad($txt, $length), $position, $length);
    }

    function convdate($date1)
	{
        $d1 = explode("-", $date1);
        $date2 = date("d/m/Y", mktime(0, 0, 0, (int) $d1[1], (int) $d1[2], (int) $d1[0]));
        return $date2;
    }

    function add_line()
	{
        if ($this->contenu_fichier != '') {
            $this->contenu_fichier = $this->contenu_fichier . "\r\n" . $this->line;
            $this->line = '';
            $this->line = str_pad("", 1634);
        } else {
            $this->contenu_fichier.=$this->line;
            $this->line = '';
            $this->line = str_pad("", 1634);
        }
    }

    function display()
	{
        if (ob_get_contents()) ob_end_clean();
        header('Content-type: application/dat');
        header('Content-Disposition: attachment; filename="DPDFRANCE_' . date("dmY-His") . '.dat"');
        echo '$VERSION=110' . "\r\n";
        echo $this->contenu_fichier. "\r\n";
        exit;
    }
	
	public static function formatGSM($gsm_dest,$code_iso)
	{
		if ($code_iso == 'F') {
			$gsm_dest = str_replace(array(' ', '.', '-', ',', ';', '/', '\\', '(', ')'),'',$gsm_dest);
			$gsm_dest = str_replace('+33','0',$gsm_dest);
			if (substr($gsm_dest, 0, 2) == 33) // Chrome autofill fix
				$gsm_dest = substr_replace($gsm_dest, '0', 0, 2);
		}
		return $gsm_dest;
	}
	
    function stripAccents($str)
	{
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
		return $str;
	}
}
?>
