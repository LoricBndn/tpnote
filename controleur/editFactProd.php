<?php

$op 	= (isset($_GET['op'])?$_GET['op']:null);
$ajout 	= ($op == 'a');
$modif 	= ($op == 'm');
$suppr 	= ($op == 's');
$num = (isset($_GET['num'])?$_GET['num']:null);
$id = (isset($_GET['id'])?$_GET['id']:null);
$editId = $ajout;


// accès à la page uniquement si un numéro de facture et statut opération sont passés en paramètre
if ( $num==null || ($id!=null && $ajout) || (($id==null) && $modif || $suppr) ) {
	header("location: factures.php");
} 


// forfaits sélectionnables
$libelles = [];
require_once('../modele/produitDAO.class.php');
$produitDAO = new ProduitDAO();
$lesProduits = $produitDAO->getNonFacture($num);
foreach ($lesProduits as $unProd) {
	$libelles[$unProd->getCode()] = $unProd->getLib();
}


require_once('../modele/prodByFactDAO.class.php');
$prodByFactDAO = new ProdByFactDAO();

// gestion des zones non modifiables en mode "modif"
$valeurs['id'] = null;
if ($modif)	{
	$valeurs['id'] 		= $id;
	$unProdByFact 	= $prodByFactDAO->getByNumFactByCodeProd($num, $id);
	$valeurs['libelle'] = $unProdByFact[0]->getProduit()->getLib();

}
if ($editId) {
	$valeurs['id'] = (isset($_POST['id'])?trim($_POST['id']):$valeurs['id']);
}

$erreurs = ['id'=>"", 'qte'=>""];
$valeurs['qte'] = (isset($_POST['qte'])?trim($_POST['qte']):null);

$retour = false;

require_once('../modele/factureDAO.class.php');
$factureDAO = new FactureDAO();
$uneFacture = $factureDAO->getByNum($num);
$titre .= (($op=='a')?'Nouveau produit':(($op=='m')?"Edition d'une ligne":null));


if (isset($_POST['valider'])) {
	if (!isset($valeurs['id']) or strlen(trim($valeurs['id']))==0) 	{ $erreurs['id'] = "choix obligatoire d'un produit"; }
	if (!isset($valeurs['qte']) or !is_numeric($valeurs['qte']) or $valeurs['qte']<1 ) {	$erreurs['qte'] = 'la quantité doit &ecirc;tre supérieur ou égal à 0';	}

 	$nbErreurs = 0;
 	foreach ($erreurs as $erreur){
 		if ($erreur != "") $nbErreurs++;
 	}
 	if ($nbErreurs == 0){
		$unProd 		= $produitDAO->getByCode($valeurs['code']);
		$unProdByFact= new ProdByFact($num, $unProd, $valeurs['qte']);
		$retour = true;
		if ($op=="a")	{
			$prodByFactDAO->insert($unProdByFact);
		}	
		else {			
			$prodByFactDAO->update($unProdByFact);
		}
	}
}
else if (isset($_POST['annuler']))	{
	$retour = true;
}
else if ($suppr) {
// suppression
	$prodByFactDAO->deleteByNumFactByCodeProd($num,$id);
	$retour = true;
}
else if ($modif)	{
	$unProdByFact = $prodByFactDAO->getByNumFactByCodeProd($num,$id);
// affectation de la quantité, les autres valeurs ont déjà été renseignées 
// voir en début de fichier la partie gestion des zones non modifiables en mode "modif"
	$valeurs['qte']  	= $unProdByFact[0]->getQteProd();
}


if ($retour)
{
	header("location: factProd.php?num=$num");
}	

require_once("../vue/editFactProd.view.php");
?>