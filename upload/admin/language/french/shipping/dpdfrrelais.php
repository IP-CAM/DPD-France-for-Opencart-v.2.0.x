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
$_['heading_title']		= 'Livraison DPD Relais';

// Text
$_['text_shipping']		= 'Livraison';
$_['text_edit']			= 'Configuration du module Livraison DPD Relais';
$_['text_success']		= 'Félicitations, vous avez modifié la <b>Livraison DPD Relais</b> avec succès !';
$_['text_activate']		= 'Activer / Désactiver ce module';
$_['text_delivery']		= 'Activer / Désactiver la livraison sur cette zone';
$_['text_agence']		= '(Sur 3 chiffres, ex: 013)';
$_['text_cargo']		= '(Sur 4 ou 5 chiffres, sans code agence, ni zéros devant, tirets...)';
$_['text_advalorem']	= 'Désactivé : Assurance des colis à 23€ / kg transporté (cdt. LOTI). <br/>Activé : Assurance à hauteur de la valeur marchande, implique un coût additionnel : cf. vos conditions tarifaires.';
$_['text_suppiles']		= '€ (-1 pour désactiver la livraison sur ces zones)';
$_['text_suppmontagne']	= '€ (-1 pour désactiver la livraison sur ces zones)';
$_['text_sort_order']	= 'Modifie le classement des transporteurs par ordre croissant';
$_['text_franco']		= 'Laissez ce champ vide si vous ne souhaitez pas établir de franco de port.<br/>Les suppléments de zones Montagne et Iles du littoral seront tout de même ajoutés.';
$_['text_mypudo']		= 'Attention! Réglage sensible. Aucun espace ne doit être saisi';

// Entry
$_['entry_rate']		= 'Gestion frais de port : <br/>Saisir sous la forme<br/>Poids:Prix, Poids:Prix, etc ... <br/>Exemple : 0.5:5.95,1:6.30,2:6.95,5:7.95';
$_['entry_tax_class']	= 'Classe de Taxe :';
$_['entry_geo_zone']	= 'Zone géographique :';
$_['entry_status']		= 'État du module :';
$_['entry_franco']		= 'Offrir les frais de port à partir d\'un panier supérieur ou égal à ce montant:';
$_['entry_delivery']	= 'État de cette zone de livraison:';
$_['entry_agence']		= 'Code agence DPD :';
$_['entry_cargo']		= 'N° de contrat DPD Relais :';
$_['entry_advalorem']	= 'Assurance complémentaire Ad Valorem :';
$_['entry_sort_order']	= 'Classement :';
$_['entry_suppiles']	= 'Supplément Iles du littoral et Corse :';
$_['entry_suppmontagne']= 'Supplément Zones de montagne :';
$_['entry_mypudo']		= 'URL MyPudo :';

// Error
$_['error_permission']	= 'Attention, vous n\'avez pas la permission de modifier la <b>Livraison DPD Relais</b> !';
?>