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

class ControllerShippingDpdfrrelais extends Controller { 
	private $error = array();
	
	public function index() {  
		$this->load->language('shipping/dpdfrrelais');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dpdfrrelais', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_none'] = $this->language->get('text_none');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_activate'] = $this->language->get('text_activate');
		$data['text_delivery'] = $this->language->get('text_delivery');
		$data['text_agence'] = $this->language->get('text_agence');
		$data['text_cargo'] = $this->language->get('text_cargo');
		$data['text_advalorem'] = $this->language->get('text_advalorem');
		$data['text_suppiles'] = $this->language->get('text_suppiles');
		$data['text_suppmontagne'] = $this->language->get('text_suppmontagne');
		$data['text_sort_order'] = $this->language->get('text_sort_order');
		$data['text_franco'] = $this->language->get('text_franco');
		$data['text_mypudo'] = $this->language->get('text_mypudo');
		
		$data['entry_rate'] = $this->language->get('entry_rate');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_franco'] = $this->language->get('entry_franco');
		$data['entry_activate'] = $this->language->get('entry_activate');
		$data['entry_delivery'] = $this->language->get('entry_delivery');
		$data['entry_agence'] = $this->language->get('entry_agence');
		$data['entry_cargo'] = $this->language->get('entry_cargo');
		$data['entry_advalorem'] = $this->language->get('entry_advalorem');
		$data['entry_suppiles'] = $this->language->get('entry_suppiles');
		$data['entry_suppmontagne'] = $this->language->get('entry_suppmontagne');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_mypudo'] = $this->language->get('entry_mypudo');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning']))
			$data['error_warning'] = $this->error['warning'];
		else
			$data['error_warning'] = '';

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/dpdfrrelais', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('shipping/dpdfrrelais', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'); 

		$this->load->model('localisation/geo_zone');
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_rate']))
				$data['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_rate'];
			else
				$data['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_rate');

			if (isset($this->request->post['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_status']))
				$data['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_status'];
			else
				$data['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_status');

			if (isset($this->request->post['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_franco']))
				$data['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_franco'] = $this->request->post['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_franco'];
			else
				$data['dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_franco'] = $this->config->get('dpdfrrelais_' . $geo_zone['geo_zone_id'] . '_franco');
		}
		
		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['dpdfrrelais_tax_class_id']))
			$data['dpdfrrelais_tax_class_id'] = $this->request->post['dpdfrrelais_tax_class_id'];
		else
			$data['dpdfrrelais_tax_class_id'] = $this->config->get('dpdfrrelais_tax_class_id');
		
		$this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['dpdfrrelais_status']))
			$data['dpdfrrelais_status'] = $this->request->post['dpdfrrelais_status'];
		else
			$data['dpdfrrelais_status'] = $this->config->get('dpdfrrelais_status');
		
		if (isset($this->request->post['dpdfrrelais_mypudo']))
			$data['dpdfrrelais_mypudo'] = $this->request->post['dpdfrrelais_mypudo'];
		else
			$data['dpdfrrelais_mypudo'] = $this->config->get('dpdfrrelais_mypudo');
		
		if (isset($this->request->post['dpdfrrelais_agence']))
			$data['dpdfrrelais_agence'] = $this->request->post['dpdfrrelais_agence'];
		else
			$data['dpdfrrelais_agence'] = $this->config->get('dpdfrrelais_agence');
		
		if (isset($this->request->post['dpdfrrelais_cargo']))
			$data['dpdfrrelais_cargo'] = $this->request->post['dpdfrrelais_cargo'];
		else
			$data['dpdfrrelais_cargo'] = $this->config->get('dpdfrrelais_cargo');
		
		if (isset($this->request->post['dpdfrrelais_advalorem']))
			$data['dpdfrrelais_advalorem'] = $this->request->post['dpdfrrelais_advalorem'];
		else
			$data['dpdfrrelais_advalorem'] = $this->config->get('dpdfrrelais_advalorem');
			
		if (isset($this->request->post['dpdfrrelais_suppiles']))
			$data['dpdfrrelais_suppiles'] = $this->request->post['dpdfrrelais_suppiles'];
		else
			$data['dpdfrrelais_suppiles'] = $this->config->get('dpdfrrelais_suppiles');
		
		if (isset($this->request->post['dpdfrrelais_suppmontagne']))
			$data['dpdfrrelais_suppmontagne'] = $this->request->post['dpdfrrelais_suppmontagne'];
		else
			$data['dpdfrrelais_suppmontagne'] = $this->config->get('dpdfrrelais_suppmontagne');
		
		if (isset($this->request->post['dpdfrrelais_sort_order']))
			$data['dpdfrrelais_sort_order'] = $this->request->post['dpdfrrelais_sort_order'];
		else
			$data['dpdfrrelais_sort_order'] = $this->config->get('dpdfrrelais_sort_order');	

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/dpdfrrelais.tpl', $data));
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/dpdfrrelais'))
			$this->error['warning'] = $this->language->get('error_permission');
		
		if (!$this->error)
			return true;
		else
			return false;	
	}
}
?>