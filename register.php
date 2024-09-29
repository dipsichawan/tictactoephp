<?php
registerPlayers($_REQUEST['player-x'], $_REQUEST['player-o']);

if (playersRegistered()) {
    header("location: play.php");
}
