<?php
require_once 'src/functions/layout.php';
require_once 'src/partials/sqlReports.php';

echo layout('', sqlReports());
?>
<script>
$(document).ready(function () {
    $(".active li").removeClass("active");
    $('#reports').addClass('active');
});
</script>
