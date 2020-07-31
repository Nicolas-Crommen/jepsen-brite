<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>

</head>
<body>
<script src="https://cdn.tiny.cloud/1/rc3x3afwvdknm43392a1j88f52b56x77doamtd7xm0tgi7u5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea',  // change this value according to your HTML
        plugins: 'emoticons a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinymcespellchecker',
        toolbar: 'emoticons a11ycheck addcomment showcomments casechange checklist formatpainter pageembed permanentpen table'
    });
</script>
<script>
var simplemde = new SimpleMDE();
</script>

<?php
include "Parsedown.php";
$Parsedown = new Parsedown();
echo $Parsedown->text('Hello _Parsedown_!');
echo $Parsedown->text('Hello _Parsedown_!');
//htmlentities();
//ou
//$Parsedown->setSafeMode(true);
?>
<textarea id="test"></textarea>
</body>
