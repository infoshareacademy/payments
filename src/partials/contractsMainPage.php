<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 2015-10-17
 * Time: 22:28
 */
require_once __DIR__ . '/../Model/ContractClass.php';
require_once __DIR__ . '/contractForm.php';

function contractsMainPage()
{
    $output = '';

    $output .= '<h1 class="page-header">Contracts</h1>';

    $output .= contractForm();


//tworzenie tabelki HTML
    $output .= '<h2>List of contracts:</h2>';
    $output .= '<table class="table table-hover">';
    $output .= '<tr>';
    $output .= '<th>ID</th>';
    $output .= '<th>Company Name</th>';
    $output .= '<th>Contract number.</th>';
    $output .= '<th>Edit company details</th>';
    $output .= '<th>Delete contract record</th>';
    $output .= '<th>View contract file</th>';
    $output .= '</tr>';
//Zdefiniowana w ContractClass funkcja statyczna obiektu - wy�wietla tablice z selecta all z contract
    $ContractsMainPage = ContractClass::ContractTable();
//Zamienianie tablicy z ContractTable na tabelk� html
    foreach ($ContractsMainPage as $item) {
        $output .= '<tr>';
        $output .= '<td>' . $item['id'] . '</td>';
        $output .= '<td>' . $item['companyName'] . '</td>';
        $output .= '<td>' . $item['Signature'] . '</td>';
        $output .= '<td><a href="?edit=' . $item['id'] . '">edit</a></td>';
        $output .= '<td><form method="get"><button class="btn btn-primary" id="btn_send" name="delete" type="submit" value="' . $item['id'] . '">delete</button><div style="color:#f00;"></div></form></td>';
        $output .= '<td><form action="uploadedFiles/'. $item['fileName'] . '" method="get"><button class="btn btn-primary" id="btn_send" type="submit">view file</button><div style="color:#f00;"></div></form></td>';
        $output .= '</tr>';
    }
    $output .= '</table>';
    $output .= '<br/><br/>';

    return $output;
}