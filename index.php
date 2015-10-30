<?php
require_once 'src/functions/layout.php';
require_once 'src/partials/invoiceForm.php';
require_once 'src/partials/invoiceCalendar.php';

ob_start();
invoiceCalendar();
$calendar = ob_get_clean();
echo layout('', invoiceForm() . $calendar);
?>
<script>
$(document).ready(function () {
    $(".active li").removeClass("active");
    $('#overview').addClass('active');
});
</script>

