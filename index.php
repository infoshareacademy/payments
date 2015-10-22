<?php include 'src/partials/header.php'; ?>


<?php require_once 'src/partials/invoiceForm.php';
    echo invoiceForm();
?>

<?php require_once 'src/partials/invoiceList.php';
    echo invoiceList();
?>

<?php include 'src/partials/footer.php'; ?>

