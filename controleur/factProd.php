<?php
$num = (isset($_GET['num']) ? $_GET['num'] : null);

// accès à la page uniquement si un numéro de facture est passé en paramètre
if ($num == null) {
	header("location: factures.php");
} 

require_once('../modele/factureDAO.class.php');
$factureDAO = new FactureDAO();
$uneFacture = $factureDAO->getByNum($num);

// liste des produits de la facture
require_once('../modele/prodByFactDAO.class.php');
$prodByFactDAO = new ProdByFactDAO();
$lesProdsByFact = $prodByFactDAO->getByNumFact($num);
$lignes	= [];
foreach($lesProdsByFact as $unProdByFact)
{	
    $unProd = $unProdByFact->getProduit();
    $ch = '';
    $ch .= '<td>' . $unProd->getCode() .'</td>';
    $ch .= '<td>' . $unProd->getLib() .'</td>';
    $ch .= '<td>' . $unProd->getType() .'</td>';
    $ch .= '<td>' . $unProd->getOrigine() .'</td>';
    $ch .= '<td>' . $unProd->getConditionnement() .'</td>';
    $ch .= '<td>' . $unProd->getTarifHt() .'</td>';
	$ch .= '<td>' . $unProdByFact->getQteProd() .'</td>';
    $ch .= '<td>' . $unProdByFact->getMontantProduit($num) .'</td>';

	$ch .='<td><a href="editFactProd.php?op=m&num=' .urlencode($num) .'&id=' .urlencode($unProd->getCode()) .'" ><img src="../vue/style/modification.png"></a></td>';
    $ch .= '<td><a href="editFactProd.php?op=s&num=' .urlencode($num) .'&id=' .urlencode($unProd->getCode()) .'" ><img src="../vue/style/corbeille.png"></a></td>';
 
	$lignes[] = "<tr>$ch</tr>";
}

require_once('../vue/factProd.view.php');