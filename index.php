<?php
require_once "templates/header.php";

if($_REQUEST['action'] == 'registerPlayers'){
    registerPlayers($_POST['player-x'], $_POST['player-o']);

    if (playersRegistered()) {
        header("location: play.php");
    }
}
?>
<div class="wrapper">
    <form method="post" action="index.php">
        <input type='hidden' name="action" value="registerPlayers"/>
        <div class="welcome">
            <h1>Start playing Tic Tac Toe!</h1>
            <h2>Please fill in your names</h2>
            <div class="player-name">
                <label for="player-x">First player (X)</label>
                <input type="text" id="player-x" name="player-x" required />
            </div>
            <div class="player-name">
                <label for="player-o">Second player (O)</label>
                <input type="text" id="player-o" name="player-o" required />
            </div>
            <button type="submit">Start</button>
        </div>
    </form>
</div>