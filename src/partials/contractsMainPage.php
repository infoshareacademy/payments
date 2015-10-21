<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 2015-10-17
 * Time: 22:28
 */

require_once __DIR__ . '/../Model/ContractClass.php';
include __DIR__ . '/contractForm.php';

//tworzenie tabelki HTML
echo '<h2>List of contracts:</h2>';
echo '<table class="table table-hover">';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Company Name</th>';
echo '<th>Contract number.</th>';
echo '<th>Edit company details</th>';
echo '<th>Delete contract record</th>';

echo '</tr>';
//Zdefiniowana w ContractClass funkcja statyczna obiektu - wy�wietla tablice z selecta all z contract
$ContractsMainPage = ContractClass::ContractTable();
//Zamienianie tablicy z ContractTable na tabelk� html
foreach ($ContractsMainPage as $item) {
    echo '<tr>';
    echo '<td>'.$item['id'].'</td>';
    echo '<td>'.$item['companyName'].'</td>';
    echo '<td>'.$item['Signature'].'</td>';
    echo '<td><a href="?edit='.$item['id'].'">edit</a></td>';
    echo '<td><form method="get"><button name="delete" type="submit" value="'.$item['id'].'">delete<div style="color:#f00;"></div></td>';

    echo '</tr>';
}
echo '</table>';
echo '<br/><br/>';

