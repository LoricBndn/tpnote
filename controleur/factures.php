<?php
require_once('../modele/factureDAO.class.php');
$factureDAO = new FactureDAO();

$lesFactures = $factureDAO->getAll();
$lignes	= [];

foreach($lesFactures as $uneFacture) {
	$ch = '';

	$ch .= '<td><a href="factProd.php?num=' . urlencode($uneFacture->getNumFact()) . '"><img src="../vue/style/visu.png"></a></td>';

	$ch .= '<td>' . $uneFacture->getNumFact() . '</td>';
	$ch .= '<td>' . $uneFacture->getDateFact() . '</td>';
	$ch .= '<td>' . $uneFacture->getClient()->getId() . '</td>';
    $ch .= '<td>' . $uneFacture->getClient()->getNom() . '</td>';
    $ch .= '<td>' . $factureDAO->getMontantTotalSansRemise($uneFacture->getNumFact()) . '</td>';
    $ch .= '<td>' . $factureDAO->getMontantTotalAvecRemise($uneFacture->getNumFact()) . '</td>';
	$ch .= '<td>' . $uneFacture->getForfait()->getLib() . '</td>';
	
	$ch .= '<td><a href="editFact.php?op=m&num=' . urlencode($uneFacture->getNumFact()) . '"><img src="../vue/style/modification.png"></a></td>';
	$ch .= '<td><a href="editFact.php?op=s&num=' . urlencode($uneFacture->getNumFact()) . '" ><img src="../vue/style/corbeille.png"></a></td>';

	$lignes[] = "<tr>$ch</tr>";
}
unset($lesFactures);
echo $lignes;
require_once('../vue/factures.view.php');
