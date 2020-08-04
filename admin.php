<?php

session_start();

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
    
} else { 
    header('Location: index.php');
    exit();
}

$users = $con->query('SELECT * FROM users ORDER BY id DESC LIMIT 0,10');
$events = $con->query('SELECT * FROM events ORDER BY id_event DESC LIMIT 0,10');
$comments = $con->query('SELECT * FROM comments ORDER BY comment_id DESC LIMIT 0,10');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <title>Administration</title>
   <link rel="stylesheet" href="layout/css/style.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <h2 class="text-center" style="padding-top: 50px; font-size:50px;">Administration</h2>
<br><br><br>
   <ul class="list-group" style="width:60%;margin:0 auto;">
      <h5 style="margin-left:15px; font-weight: bold;">Lastest Users</h5><br>
      <?php while($u = $users->fetch()) { ?>
      <li class="list-group-item d-flex justify-content-left align-items-center"><span class="style=font-weight:bold;color:black !important;">User ID : <?= $u['id'] ?></span> <span class="ml-4"></span> <span>Pseudo :<?= ' ' . $u['nickname'] ?></span><?php if($u['user_confirm'] == 0) { ?>  <span class="ml-auto"> <a class="btn btn-primary mr-3" href="admin.php?user_confirm=<?= $u['id'] ?>">Accept</a><?php } else { ?> <a class="btn btn-primary disabled ml-auto mr-3" href="">Allowed</a><?php } ?> <a class="btn btn-danger" href="admin.php?user_delete=<?= $u['id'] ?>">Delete</a></span></li>
      <?php } ?>
   </ul>
   <br><br><br>
   <ul class="list-group" style="width:60%;margin:0 auto;">
      <h5 style="margin-left:15px; font-weight: bold;">Latest Events</h5><br>
      <?php while($e = $events->fetch()) { ?>
      <li class="list-group-item d-flex justify-content-left align-items-center"><span>Event ID : <?= $e['id_event'] ?> </span><span class="ml-4"></span> <span>Title :<?= ' ' . $e['title'] ?></span><?php if($e['event_confirm'] == 0) { ?> <span class="ml-auto"> <a class="btn btn-primary mr-3" href="admin.php?event_confirm=<?= $e['id_event'] ?>">Accept</a><?php } else { ?> <a class="btn btn-primary disabled ml-auto mr-3" href="">Allowed</a><?php } ?> <a class="btn btn-danger" href="admin.php?event_delete=<?= $e['id_event'] ?>">Delete</a></span></li>
      <?php } ?>
   </ul>s
   <br><br><br>
   <ul class="list-group" style="width:60%;margin:0 auto;">
      <h5 style="margin-left:15px; font-weight: bold;">Latest Comments</h5><br>
      <?php while($c = $comments->fetch()) { ?>
      <li class="list-group-item d-flex justify-content-left align-items-center"><span>Comment ID : <?= $c['comment_id'] ?></span> <span class="ml-4"></span> <span>Comment :<?= ' ' . substr($c['comment'], 0, 30) ?><?php if (strlen($c['comment'])> 30) {echo '...';} ?></span><?php if($c['comment_confirm'] == 0) { ?> <span class="ml-auto"> <a class="btn btn-primary mr-3" href="admin.php?comment_confirm=<?= $c['comment_id'] ?>">Accept</a><?php } else { ?> <a class="btn btn-primary disabled ml-auto mr-3" href="">Allowed</a><?php } ?>  <a  class="btn btn-danger"href="admin.php?comment_delete=<?= $c['comment_id'] ?>">Delete</a></span></li>
      <?php } ?>
   </ul>
   

</body>
</html>