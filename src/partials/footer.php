</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$content = ob_get_contents();
$length = strlen($content);
header('Content-Length: ' . $length);
ob_flush();
?>