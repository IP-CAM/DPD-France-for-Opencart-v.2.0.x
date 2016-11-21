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

// Heading
$_['heading_title']              = 'Livraison DPD CLASSIC, Europe & Intercontinental';

// Text
$_['text_shipping']              = 'Livraison';
$_['text_edit']                  = 'Configuration du module Livraison DPD CLASSIC';
$_['text_success']               = 'Félicitations, vous avez modifié la <b>Livraison DPD CLASSIC</b> avec succès !';
$_['text_activate']              = 'Activer / Désactiver ce module';
$_['text_delivery']              = 'Activer / Désactiver la livraison sur cette zone';
$_['text_agence']                = '(Sur 3 chiffres, ex: 013)';
$_['text_cargo']                 = '(Sur 4 ou 5 chiffres, sans code agence, ni zéros devant, tirets...)';
$_['text_advalorem']             = 'Désactivé : Assurance des colis à 23€ / kg transporté (cdt. LOTI). <br/>Activé : Assurance à hauteur de la valeur marchande, implique un coût additionnel : cf. vos conditions tarifaires.';
$_['text_retour']                = 'Voir documentation';
$_['text_retour_off']            = 'Aucun retour';
$_['text_retour_ondemand']       = 'A la demande';
$_['text_retour_prepared']       = 'Preparée';
$_['text_suppiles']              = '€ (-1 pour désactiver la livraison sur ces zones)';
$_['text_suppmontagne']          = '€ (-1 pour désactiver la livraison sur ces zones)';
$_['text_sort_order']            = 'Modifie le classement des transporteurs par ordre croissant';
$_['text_franco']                = 'Laissez ce champ vide si vous ne souhaitez pas établir de franco de port.<br/>Les suppléments de zones Montagne et Iles du littoral seront tout de même ajoutés.';

// Entry
$_['entry_rate']                 = 'Gestion frais de port<br/>Saisir sous la forme<br/>Poids:Prix, Poids:Prix, etc ... <br/>Exemple : 0.5:5.95,1:6.30,2:6.95,5:7.95';
$_['entry_tax_class']            = 'Classe de Taxe';
$_['entry_geo_zone']             = 'Zone géographique';
$_['entry_status']               = 'État du module';
$_['entry_franco']               = 'Offrir les frais de port à partir d\'un panier supérieur ou égal à ce montant:';
$_['entry_delivery']             = 'État de cette zone de livraison:';
$_['entry_agence']               = 'Code agence DPD';
$_['entry_cargo']                = 'N° de contrat DPD CLASSIC';
$_['entry_advalorem']            = 'Assurance complémentaire Ad Valorem';
$_['entry_retour']               = 'Option DPD Retour';
$_['entry_sort_order']           = 'Classement';
$_['entry_suppiles']             = 'Supplément Iles du littoral et Corse';
$_['entry_suppmontagne']         = 'Supplément Zones de montagne';

// Error
$_['error_permission']           = 'Attention, vous n\'avez pas la permission de modifier la <b>Livraison DPD CLASSIC</b> !';
?>