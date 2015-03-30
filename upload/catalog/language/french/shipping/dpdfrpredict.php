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
$_['text_title']	= 'Livraison à domicile Predict sur rendez-vous';
$_['text_subtitle']	= 'Livraison à domicile Predict sur rendez-vous</strong><br/><br/>Livraison 24-48h à domicile dans le créneau horaire qui vous convient le mieux (parmi des choix proposés par DPD)';
$_['text_weight']	= 'Poids :'; 
$_['text_predictblock']	= '
	<div class="dpdfrance_header">Livraison à domicile Predict sur rendez-vous</div>
	<div class="module" id="predict">
		<div id="div_dpdfrance_predict_logo"></div>
			<div class="copy"> 
				<p></p><h2>Avec Predict, bénéficiez des avantages suivants</h2><p></p>
				<ul>
					<li><b>Livraison de votre colis dans un créneau de 3h (choix par SMS ou par notre portail web)</b></li>
					<li><b>Suivi complet et détaillé de votre livraison</b></li>
					<li><b>En cas d’absence, vous reprogrammez une livraison où et quand vous le souhaitez</b></li>
				</ul>
				<p></p><h2>Comment ça fonctionne ?</h2><p></p>
				<ul>
					<li>Une fois votre commande préparée, nous vous envoyons un SMS avec plusieurs choix de dates et créneaux horaires de livraison</li>
					<li>Vous sélectionnez la date et le créneau de 3h qui vous conviennent le mieux en répondant directement par SMS (prix d’un SMS standard) ou vous connectant sur l’Espace Destinataire disponible sur <a target="_blank" href="http://www.dpd.fr/destinataires">dpd.fr</a></li>
					<li>Le jour de la livraison, vous recevez un SMS vous rappelant le créneau horaire</li>
				</ul>
			</div>
		<br/>
		<div id="div_dpdfrance_dpd_logo"></div>
	</div>
	<div id="dpdfrance_predict_error" class="warnmsg" style="display:none;">Le numéro de mobile renseigné semble incorrect. Merci de préciser un numéro de mobile français, commençant par 06 ou 07, sur 10 chiffres consécutifs.</div>
	<div id="div_dpdfrance_predict_gsm">Bénéficiez dès maintenant des avantages de la livraison Predict en renseignant votre n° de mobile ici et cliquez sur l\'icône pour confirmer';
$_['text_error']	= 'Votre livraison Predict par DPD: Afin de vous livrer dans les meilleures conditions, merci de renseigner un numero de portable francais correct avant de valider votre mode de livraison (commencant par 06 ou 07, sur 10 chiffres)'; 
?>