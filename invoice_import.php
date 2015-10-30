<?php
require_once 'src/functions/layout.php';
require_once 'src/partials/invoiceImport.php';

echo layout('', invoiceImport());

?>

<script>
    $(document).ready(function () {
        $(".active li").removeClass("active");
        $('#import').addClass('active');
    });
</script>
