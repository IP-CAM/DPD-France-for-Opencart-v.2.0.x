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

// Heading
$_['heading_title']		= 'Predict delivery by DPD';

// Text
$_['text_shipping']		= 'Shipping';
$_['text_edit']			= 'Predict by DPD configuration';
$_['text_success']		= 'Success: You have modified Predict delivery by DPD!';
$_['text_activate']		= 'Enable / Disable this module';
$_['text_delivery']		= 'Enable / Disable delivery to this zone';
$_['text_agence']		= '(3 digits, i.e.: 013)';
$_['text_cargo']		= '(4 or 5 digits, no depot code, no preceding zeros, dashes...)';
$_['text_advalorem']	= 'Disabled : Parcel insurance up to 23€ / shipped kg (cdt. LOTI). <br/>Enabled : Insurance up to the goods value, implies an additional cost : cf. your pricing conditions.';
$_['text_suppiles']		= '€ (-1 to disable delivery to these areas)';
$_['text_suppmontagne']	= '€ (-1 to disable delivery to these areas)';
$_['text_sort_order']	= 'Sort carriers in the front-office by ascending order';
$_['text_franco']		= 'This field should be empty if you don\'t want to set a free shipping rule.<br/>Mountain and Islands zones overcost still applies.';

// Entry
$_['entry_rate']		= 'Rates:<br/>To be entered in this format:<br/>Weight:Cost, Weight:Cost, etc ... <br/><br/>Example : 0.5:5.95,1:6.30,2:6.95,5:7.95';
$_['entry_tax_class']	= 'Tax Class:';
$_['entry_geo_zone']	= 'Geo Zone:';
$_['entry_status']		= 'Status:';
$_['entry_franco']		= 'Offer free shipping for carts equal or exceeding this amount:';
$_['entry_delivery']	= 'Delivery zone status:';
$_['entry_agence']		= 'DPD local depot code:';
$_['entry_cargo']		= 'Predict by DPD contract number:';
$_['entry_advalorem']	= 'Ad Valorem parcel insurance service:';
$_['entry_sort_order']	= 'Sort Order:';
$_['entry_suppiles']	= 'Coastal islands and Corsica overcost :';
$_['entry_suppmontagne']= 'Mountain areas overcost :';

// Error
$_['error_permission']	= 'Warning: You do not have permission to modify Predict delivery by DPD!';
?>