<?php include 'src/partials/header.php'; ?>

<form action="qr-input.php" method="post" enctype="multipart/form-data">
    <input type="file" name="qrFile"/><br/>
    <input type="submit" value="send"/>
</form>

<?php include 'src/partials/footer.php'; ?>

