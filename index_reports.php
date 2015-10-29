<?php
require_once 'src/functions/layout.php';
require_once 'src/partials/sqlReports.php';
require_once 'src/partials/sqlReportForm.php';

echo layout('', sqlReports());

