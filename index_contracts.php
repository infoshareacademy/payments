<?php

require_once 'src/functions/layout.php';
require_once 'src/partials/contractsMainPage.php';
echo layout('', contractsMainPage());
?>
<script>
$(document).ready(function () {
    $(".active li").removeClass("active");
    $('#contracts').addClass('active');
});
</script>