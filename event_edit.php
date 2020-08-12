<?php
include "./includes/templates/header.php";
include "connect.php";
include "./includes/func/functions.php";
?>

<?php

if (!empty($_GET) && $_GET['do'] == "edit") {

    $stmt = $con->prepare("select * from events where id_event = ?");
    $stmt->execute([$_GET["edit_id_event"]]);
    $data = $stmt->fetch();
?>


    <div class="container formCenter">
        <h2 class="text-center">Edit Event</h2>

        <div class="text-center"><a class="btn btn-info" href=?do=changeCat&idEvent=<?php echo $_GET['edit_id_event'] ?>>Change the category</a></div>

        <form class="login-page" method="POST" action=<?php echo "?do=update&id=" . $_GET['edit_id_event'] . "" ?> enctype="multipart/form-data">
            <input class="form-control" type="text" name="title" autocomplete="off" placeholder="Give your event a title" value=<?php echo $data['title']  ?> required="required" />
            <input class="form-control" type="date" name="date_debut" placeholder="yyyy-mm-jj" value=<?php echo $data["date_debut"] ?>></p>
            <textarea class="form-control" name="description" rows="8" cols="45" autocomplete="off" placeholder="Explain what will take place" required="required"><?php echo $data["description"] ?></textarea>
            <p><input class="form-control" type="text" name="address" value="<?php echo $data["address"] ?>" autocomplete="off" placeholder="Indicate here the address of your event" required="required" /></p>
            <label> In which category would you like your event to be referenced ?</label>
            <select class="form-control" name="id_category">
                <?php
                $categor = $con->prepare('select * from categor ca where ca.parent_id = (select ev.id_category from events ev where ev.id_event = ? )');
                $categor->execute([$_GET['edit_id_event']]);
                $cats = $categor->fetchAll();

                foreach ($cats as $cat) {
                    echo '<option value="' . $cat['id_category'] . '">' . $cat['name'] . '</option>';
                }
                ?>
            </select>

            <?php

            ?>          
            <h3 class="text-center">Type of your illustration :<br /></h3>
            <select name="image_type" class="form-control" required="required">
                <option value="none" disabled="disabled" selected="selected">Choose one</option>
                <option value="1">Image</option>
                <option value="2">YouTube</option>
                <option value="3">Vimeo</option>
            </select>

            <input class="form-control" type="text" name="image" autocomplete="off" placeholder="Add your illustration URL (Image, YouTube video or Vimeo video)" required="required" />
            <input class="btn btn-info btn-block" type="submit" name="submit">
        </form>

    </div>
<?php

} elseif ($_GET['do'] == "update") {






    if ($_SERVER["REQUEST_METHOD"] == "POST") {






        $newTitle = $_POST["title"];
        $newDate = $_POST["date_debut"];
        $newAdress = $_POST["address"];
        $newDesc = $_POST["description"];
        $newSubCat = $_POST["id_category"];
        $newImage = $_POST["image"];
        $newImageType = $_POST["image_type"];



        $stmt = $con->prepare("UPDATE events SET title = ? , `description` = ? , date_debut = ? , `address` = ? , `image` = ? ,`image_type` = ? , id_sub = ? WHERE id_event = ?  ");
        $stmt->execute([$newTitle, $newDesc, $newDate, $newAdress, $newImage, $newImageType, $newSubCat, $_GET['id']]);
        if ($stmt->rowCount() > 0) {

            echo "<div class='alert alert-success text-center'>Your event's information has been successfully updated</div>";
            header("refresh: 3; url = user_dashboard.php");
        }
    } else {
        echo "Pas d acces";
    }
} elseif ($_GET['do'] == "changeCat") {
    $categor = $con->prepare('SELECT * FROM categor where parent_id =?');
    $categor->execute([0]);
    $cats = $categor->fetchAll();

?>
    <div class="container headingCreate">
        <h3 class="text-center">In which category would you like your event to be referenced ?</h3>
        <hr class="custom-hr">
        <div class="row">
            <div class="btns-cat">
                <ul class='list-unstyled'>
                    <?php
                    foreach ($cats as $cat) {
                        echo '<li class="col-md-3">
                               <a class="btn" href ="?do=editMainCat&idCat=' . $cat['id_category'] . '&idEvent=' . $_GET["idEvent"] . '">' . $cat["name"] . ' </a>
                              </li>';
                    }
                    ?>
            </div>
        </div>
    </div>
<?php } elseif ($_GET['do'] == "editMainCat") {

    $stmt = $con->prepare("UPDATE events SET id_category = ?  where id_event = ?");
    $stmt->execute([$_GET['idCat'], $_GET['idEvent']]);
    header("location:event_edit.php?do=edit&edit_id_event=" . $_GET['idEvent']);
}

include "./includes/templates/footer.php";

?>