<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 16.10.15
 * Time: 14:27
 */
//
//class PaymentReport
//{
//    private $pdo;
//
//
//    public function getReport(){
//        $this->pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
//        $stmt = $this->pdo->query('SELECT invoices.Signature, invoices.Amount, invoices.Maturity_date, invoices.Payment_date, contract.companyName FROM invoices, contract WHERE invoices.id_contract = contract.id ORDER BY Maturity_date DESC ;');
//        if ($stmt->rowCount() > 0) {
//        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
////        var_dump($result);
//        } else {
//            throw new Exception('There is no available data');
//        }
//
//    }
//}
//
//$paymentReport = new PaymentReport();
//$paymentReport->getReport();


?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Company Name</th>
            <th>To Pay</th>
            <th>Maturity date</th>
            <th>Payment date</th>
            <th>Invoice Signature</th>
        </tr>
        </thead>
        <tbody>
        <tr>

  <?php
$pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
$PaymentReport = $pdo->query('SELECT invoices.Signature, invoices.Amount, invoices.Maturity_date, invoices.Payment_date, contract.companyName FROM invoices, contract WHERE invoices.id_contract = contract.id ORDER BY Maturity_date DESC ;');
$PaymentReport = $PaymentReport->fetchAll(pdo::FETCH_ASSOC);
foreach ($PaymentReport as $result){
    echo "<tr>" .
        "<td>". $result["companyName"]."</td>" .
        "<td>". $result["Amount"] ."</td>" .
        "<td>". $result["Maturity_date"] ."</td>" .
        "<td>". $result["Payment_date"] ."</td>" .
        "<td>". $result["Signature"] ."</td>".
        "</tr>";

}

?>

  <?php
  $pdo = new PDO('mysql:dbname=infoshareaca_7;host=test.payments.infoshareaca.nazwa.pl', 'infoshareaca_7', 'F0r3v3r!');
  $PaymentReport = $pdo->query('SELECT invoices.Signature, invoices.Amount, invoices.Maturity_date, invoices.Payment_date, contract.companyName FROM invoices, contract WHERE invoices.id_contract = contract.id ORDER BY Maturity_date DESC ;');
  $PaymentReport = $PaymentReport->fetchAll(pdo::FETCH_ASSOC);
  foreach ($PaymentReport as $result){
      echo "<tr>" .
          "<td>". $result["companyName"]."</td>" .
          "<td>". $result["Amount"] ."</td>" .
          "<td>". $result["Maturity_date"] ."</td>" .
          "<td>". $result["Payment_date"] ."</td>" .
          "<td>". $result["Signature"] ."</td>".
          "</tr>";

  }

  ?>
