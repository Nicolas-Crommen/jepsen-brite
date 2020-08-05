<?php

session_start();

var_dump($_SESSION);

include "connect.php";

//Admin verification
if ($_SESSION['isAdmin'] == 1) 
{

    //confirm/delete users
    if(isset($_GET['user_confirm'])) {
        $user_confirm = (int) $_GET['user_confirm'];
        $req = $con->prepare('UPDATE users SET user_confirm = 1 WHERE id = ?');
        $req->execute(array($user_confirm));
    }
    if(isset($_GET['user_delete'])) {
        $user_delete = (int) $_GET['user_delete'];
        $req = $con->prepare('DELETE FROM users WHERE id = ?');
        $req->execute(array($user_delete));
    }

    //confirm/delete events
    if(isset($_GET['event_confirm'])) {
        $event_confirm = (int) $_GET['event_confirm'];
        $req = $con->prepare('UPDATE events SET event_confirm = 1 WHERE id_event = ?');
        $req->execute(array($event_confirm));
    }
    if(isset($_GET['event_delete'])) {
        $event_delete = (int) $_GET['event_delete'];
        $req = $con->prepare('DELETE FROM events WHERE id_event = ?');
        $req->execute(array($event_delete));
    }

    //confirm/delete comments
    if(isset($_GET['comment_confirm'])) {
        $comment_confirm = (int) $_GET['comment_confirm'];
        $req = $con->prepare('UPDATE comments SET comment_confirm = 1 WHERE comment_id = ?');
        $req->execute(array($comment_confirm));
    }
    if(isset($_GET['comment_delete'])) {
        $comment_delete = (int) $_GET['comment_delete'];
        $req = $con->prepare('DELETE FROM comments WHERE comment_id = ?');
        $req->execute(array($comment_delete));
    }
    
} else 
{
    exit();
}

$users = $con->query('SELECT * FROM users ORDER BY id DESC LIMIT 0,5');
$events = $con->query('SELECT * FROM events ORDER BY id_event DESC LIMIT 0,5');
$comments = $con->query('SELECT * FROM comments ORDER BY comment_id DESC LIMIT 0,5');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>Administration</title>
</head>
<body>
   <ul>
      <?php while($u = $users->fetch()) { ?>
      <li><?= $u['id'] ?> : <?= $u['nickname'] ?><?php if($u['user_confirm'] == 0) { ?> - <a href="admin.php?user_confirm=<?= $u['id'] ?>">Confirmer</a><?php } ?> - <a href="admin.php?user_delete=<?= $u['id'] ?>">Supprimer</a></li>
      <?php } ?>
   </ul>
   <br /><br />
   <ul>
      <?php while($e = $events->fetch()) { ?>
      <li><?= $e['id_event'] ?> : <?= $e['title'] ?><?php if($e['event_confirm'] == 0) { ?> - <a href="admin.php?event_confirm=<?= $e['id_event'] ?>">Confirmer</a><?php } ?> - <a href="admin.php?event_delete=<?= $e['id_event'] ?>">Supprimer</a></li>
      <?php } ?>
   </ul>
   <br /><br />
   <ul>
      <?php while($c = $comments->fetch()) { ?>
      <li><?= $c['comment_id'] ?> : <?= $c['comment'] ?><?php if($c['comment_confirm'] == 0) { ?> - <a href="admin.php?comment_confirm=<?= $c['comment_id'] ?>">Confirmer</a><?php } ?> - <a href="admin.php?comment_delete=<?= $c['comment_id'] ?>">Supprimer</a></li>
      <?php } ?>
   </ul>
   

</body>
</html>