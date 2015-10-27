<?php
require_once 'src/functions/layout.php';
require_once 'src/partials/invoiceForm.php';
require_once 'src/partials/invoiceList.php';

echo layout('', invoiceForm() . invoiceList());



