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

class ControllerShippingDpdfrpredict extends Controller { 
	private $error = array();
	
	public function index() {  
		$this->load->language('shipping/dpdfrpredict');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				 
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('dpdfrpredict', $this->request->post);	
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
			'href'      => $this->url->link('shipping/dpdfrpredict', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('shipping/dpdfrpredict', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'); 

		$this->load->model('localisation/geo_zone');
		$geo_zones = $this->model_localisation_geo_zone->getGeoZones();
		
		foreach ($geo_zones as $geo_zone) {
			if (isset($this->request->post['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_rate']))
				$data['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->request->post['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_rate'];
			else
				$data['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_rate'] = $this->config->get('dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_rate');		

			if (isset($this->request->post['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_status']))
				$data['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_status'] = $this->request->post['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_status'];
			else
				$data['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_status'] = $this->config->get('dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_status');				

			if (isset($this->request->post['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_franco']))
				$data['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_franco'] = $this->request->post['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_franco'];
			else
				$data['dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_franco'] = $this->config->get('dpdfrpredict_' . $geo_zone['geo_zone_id'] . '_franco');	
		}
		
		$data['geo_zones'] = $geo_zones;

		if (isset($this->request->post['dpdfrpredict_tax_class_id']))
			$data['dpdfrpredict_tax_class_id'] = $this->request->post['dpdfrpredict_tax_class_id'];
		else
			$data['dpdfrpredict_tax_class_id'] = $this->config->get('dpdfrpredict_tax_class_id');
		
		$this->load->model('localisation/tax_class');
		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		if (isset($this->request->post['dpdfrpredict_status']))
			$data['dpdfrpredict_status'] = $this->request->post['dpdfrpredict_status'];
		else
			$data['dpdfrpredict_status'] = $this->config->get('dpdfrpredict_status');
		
		if (isset($this->request->post['dpdfrpredict_mypudo']))
			$data['dpdfrpredict_mypudo'] = $this->request->post['dpdfrpredict_mypudo'];
		else
			$data['dpdfrpredict_mypudo'] = $this->config->get('dpdfrpredict_mypudo');
		
		if (isset($this->request->post['dpdfrpredict_agence']))
			$data['dpdfrpredict_agence'] = $this->request->post['dpdfrpredict_agence'];
		else
			$data['dpdfrpredict_agence'] = $this->config->get('dpdfrpredict_agence');
		
		if (isset($this->request->post['dpdfrpredict_cargo']))
			$data['dpdfrpredict_cargo'] = $this->request->post['dpdfrpredict_cargo'];
		else
			$data['dpdfrpredict_cargo'] = $this->config->get('dpdfrpredict_cargo');
		
		if (isset($this->request->post['dpdfrpredict_advalorem']))
			$data['dpdfrpredict_advalorem'] = $this->request->post['dpdfrpredict_advalorem'];
		else
			$data['dpdfrpredict_advalorem'] = $this->config->get('dpdfrpredict_advalorem');
		
		if (isset($this->request->post['dpdfrpredict_suppiles']))
			$data['dpdfrpredict_suppiles'] = $this->request->post['dpdfrpredict_suppiles'];
		else
			$data['dpdfrpredict_suppiles'] = $this->config->get('dpdfrpredict_suppiles');
		
		if (isset($this->request->post['dpdfrpredict_suppmontagne']))
			$data['dpdfrpredict_suppmontagne'] = $this->request->post['dpdfrpredict_suppmontagne'];
		else
			$data['dpdfrpredict_suppmontagne'] = $this->config->get('dpdfrpredict_suppmontagne');
		
		if (isset($this->request->post['dpdfrpredict_sort_order']))
			$data['dpdfrpredict_sort_order'] = $this->request->post['dpdfrpredict_sort_order'];
		else
			$data['dpdfrpredict_sort_order'] = $this->config->get('dpdfrpredict_sort_order');	

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('shipping/dpdfrpredict.tpl', $data));
	}
		
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/dpdfrpredict'))
			$this->error['warning'] = $this->language->get('error_permission');
		
		if (!$this->error)
			return true;
		else
			return false;	
	}
}
?>