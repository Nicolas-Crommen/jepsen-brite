<?php

session_start();

include "connect.php";

if (isset($_GET['participate_userid'])) {
    $userid = $_GET['participate_userid'];
    $eventid = $_GET['participate_eventid'];
    $insertparticipation = $con->prepare("INSERT INTO `association` (`participate_userid`, `participate_eventid`) VALUES (?, ?);");
    $insertparticipation->execute(array($userid, $eventid));

    echo '<div class="alert alert-success text-center">Your Registration has been sent</div>';
    header("refresh: 2; url = event_show.php?eventID=". $eventid ."");
}

if (isset($_GET['cancel_userid'])) {
    $userid = $_GET['cancel_userid'];
    $eventid = $_GET['cancel_eventid'];
    $cancelparticipation = $con->prepare("DELETE FROM `association` WHERE participate_userid=? AND participate_eventid=?;");
    $cancelparticipation->execute(array($userid, $eventid));

    echo '<div class="alert alert-success text-center">Your Registration has been canceled</div>';


    if ((isset($_GET['from_dashboard'])) AND $_GET['from_dashboard'] == 'yes') {
        header("refresh: 2; url = user_dashboard.php");
    } else {

        header("refresh: 2; url = event_show.php?eventID=". $eventid ."");
    }

}