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

// Text
$_['text_title']	= 'Predict delivery by DPD';
$_['text_subtitle']	= 'Predict delivery by DPD</strong><br/><br/>24-48h delivery within a precise time window';
$_['text_weight']	= 'Weight :';  
$_['text_predictblock']	= '
	<div class="dpdfrance_header">Your order will be delivered by DPD with Predict service</div>
	<div class="module" id="predict">
		<div id="div_dpdfrance_predict_logo"></div>
		<div class="copy"> 
			<p></p><h2>Predict offers you the following benefits :</h2><p></p>
			<ul>
				<li><b>A parcel delivery in a 3-hour time window (choice is made by SMS or through our website)</b></li>
				<li><b>A complete and detailed tracking of your delivery</b></li>
				<li><b>In case of absence, you can schedule a new delivery when and where you it suits you best</b></li>
			</ul>
			<br>
			<p></p><h2>How does it work?</h2><p></p>
			<ul>
				<li>Once your order is ready for shipment, you will receive an SMS proposing various days and time windows for your delivery.</li>
				<li>You choose the moment which suits you best for the delivery by replying to the SMS (no extra cost) or through our website <a target="_blank" href="http://www.dpd.fr/destinataires">dpd.fr</a></li>
				<li>On the day of delivery, a text message will remind you the selected time window.</li>
			</ul>
		</div>
		<br/>
		<div id="div_dpdfrance_dpd_logo"></div>
	</div> 
	<div id="dpdfrance_predict_error" class="warnmsg" style="display:none;">It seems that the GSM number you provided is incorrect. Please provide a french GSM number, starting with 06 or 07, on 10 consecutive digits.</div>
	<div id="div_dpdfrance_predict_gsm">Get all the advantages of DPD\'s Predict service by providing a french GSM number here and click on the icon to confirm';
$_['text_error']	= 'Your Predict delivery by DPD: It seems that the GSM number you provided is incorrect. Please provide a french GSM number, starting with 06 or 07, on 10 consecutive digits.'; 
?>