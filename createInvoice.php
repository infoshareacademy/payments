<?php
/**
 * Created by PhpStorm.
 * User: marek
 * Date: 13.10.15
 * Time: 15:25
 */
require_once 'Model/Invoice.php';

$formData = [
    'number' => 'FV/124',
    'amount' => '23.34',
    'issueDate' => '2015-10-11',
    'maturityDate' => '2015-10-14',
    'paymentDate' => ''
];

$invoice2 = new Invoice();
$invoice2->importFromArray($formData);

print_r($invoice2);

echo $invoice2->serializeToHTML();