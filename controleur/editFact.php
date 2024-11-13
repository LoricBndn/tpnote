<?php

$op 	= (isset($_GET['op']) ? $_GET['op'] : null);
$ajout 	= ($op == 'a');
$modif 	= ($op == 'm');
$suppr 	= ($op == 's');
$num 	= (isset($_GET['num']) ? $_GET['num'] : null);
$editNum= $ajout;


// accès à la page uniquement si un numéro de facture et statut opération sont passés en paramètre
if ( ($num != null && $ajout) || (($num == null) && $modif || $suppr) ) {
	header("location: factures.php");
} 

// étages valides
$forfait = ['EXPRES'=>'livraison express (dans la journée)','H24'=>'h24 (livraison sous 4 heures, 24h/24h)','OFFERT'=>'livraison offerte','RAPIDE'=>'livraison rapide', 'STD'=>'livraison standard', 'STDP'=>' 	livraison standard plus'];

require_once('../modele/factureDAO.class.php');
$factureDAO = new FactureDAO();

// gestion des zones non modifiables en mode "modif"
$valeurs['num'] = null;

if ($modif)	{
	$valeurs['num'] = $num;
	$uneFacture = $factureDAO->getByNum($valeurs['num']);
}
if ($editNum) {
	$valeurs['num'] = (isset($_POST['num']) ? trim($_POST['num']) : $valeurs['num']);
}


$titre = (($ajout) ? 'Nouvelle Facture' : (($modif) ? "Facture - édition des informations" : null));

$erreurs = ['num'=>"", 'libelle'=>'', 'forfait'=>""];
$valeurs['libelle'] = (isset($_POST['libelle'])?trim($_POST['libelle']):null);
$valeurs['forfait'] = (isset($_POST['forfait'])?trim($_POST['forfait']):null);

$retour = false;
	
if (isset($_POST['valider'])) {
	if (!isset($valeurs['num']) or strlen($valeurs['num'])==0) 	{ $erreurs['num']	= 'Saisie obligatoire du numéro';	}
	else if ($editNum and $salleDAO->existe($valeurs['num'])) 	{ $erreurs['num'] 	= 'Numéro de facture déjà existant';	}
	if (!isset($valeurs['forfait']) or strlen($valeurs['forfait'])==0 or !in_array($valeurs['forfait'],$forfait,true)) { 
		$erreurs['forfait'] = 'Forfait non valide.'; 
	}


 	$nbErreurs = 0;
 	foreach ($erreurs as $erreur){
 		if ($erreur != "") $nbErreurs++;
 	}
 	if ($nbErreurs == 0){
		$uneFacture = new Facture($valeurs['num'],$valeurs['libelle'], $valeurs['forfait']);
		$retour = true;
		if ($ajout)	{
			$factureDAO->insert($uneFacture);
		}	
		else {			
			$factureDAO->update($uneFacture);
		}
	}
}
else if (isset($_POST['annuler']))	{
	$retour = true;
}
else if ($suppr) {
// suppression
    echo "<br />à supprimer $num <br />";
	$factureDAO->delete($num);
	$retour = true;
}
else if ($modif)	{
	$uneFacture = $factureDAO->getByNum($num);
	$valeurs['num']		= $uneFacture->getNumFact();		
	$valeurs['forfait'] = $uneFacture->getForfait();		
}


if ($retour)
{
	header("location: factures.php");
}	

require_once("../vue/editFact.view.php");
?>