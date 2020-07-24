<?php
include "./includes/templates/header.php";
include "./includes/func/functions.php";
?>

<?php
if (isset($_SESSION['userid'])) {
    echo "Hello" . $_SESSION['nickname'];
}
?>

<?php
include "./includes/templates/footer.php";
?>