<?php
session_start();
error_reporting(E_ALL);

function registerPlayers($playerX="", $playerO="") {
    $_SESSION['PLAYER_X_NAME'] = $playerX;
    $_SESSION['PLAYER_O_NAME'] = $playerO;
    setTurn();
    resetBoard();
    resetWins();
}

function setTurn($turn='x') {
    $_SESSION['TURN'] = $turn;
}

function resetBoard() {
    resetPlaysCount();
    for ( $i = 1; $i <= 9; $i++ ) {
        unset($_SESSION['CELL_' . $i]);
    }
}

function resetPlaysCount() {
    $_SESSION['PLAYS'] = 0;
}

function resetWins() {
    $_SESSION['PLAYER_X_WINS'] = 0;
    $_SESSION['PLAYER_O_WINS'] = 0;
    $_SESSION['ROUND'] = 0;
}

function playersRegistered() {
    if(isset($_SESSION['PLAYER_X_NAME']) && isset($_SESSION['PLAYER_O_NAME'])){
       return true;
    }else{
        return false;
    }
}

function playsCount() {
    return $_SESSION['PLAYS'] ? $_SESSION['PLAYS'] : 0;
}

function addPlaysCount() {
    if (! $_SESSION['PLAYS']) {
        $_SESSION['PLAYS'] = 0;
    }

    $_SESSION['PLAYS']++;
}

function playerName($player='x') {
    return $_SESSION['PLAYER_' . strtoupper($player) . '_NAME'];

}

function getTurn() {
    return $_SESSION['TURN'] ? $_SESSION['TURN'] : 'x';
}

function markWin($player='x') {
    $_SESSION['PLAYER_' . strtoupper($player) . '_WINS']++;
    $_SESSION['ROUND']++;
}

function switchTurn() {
    switch (getTurn()) {
        case 'x':
            setTurn('o');
            break;
        default:
            setTurn('x');
            break;
    }
}

function currentPlayer() {
    return playerName(getTurn());
}

function play($cell='') {
    if (getCell($cell)) {
        return false;
    }

    $_SESSION['CELL_' . $cell] = getTurn();
    addPlaysCount();
    $win = playerPlayWin($cell);

    if (! $win) {
        switchTurn();
    }
    else {
        markWin(getTurn());
        //resetBoard();
    }

    return $win;
}

function getCell($cell='') {
    return $_SESSION['CELL_' . $cell];
}

function playerPlayWin($cell=1) {
    if (playsCount() < 3) {
        return false;
    }

    $column = $cell % 3;
    if (! $column) {
        $column = 3;
    }

    $row = ceil($cell / 3);
    /* print_r($_SESSION);
    echo $row; */

    $player = getTurn();

    return isVerticalWin($column, $player) || isHorizontalWin($row*3, $player) || isDiagonalWin($player);
}

function isVerticalWin($column=1, $turn='x') {
    return getCell($column) == $turn &&
        getCell($column + 3) == $turn &&
        getCell($column + 6) == $turn;
}

function isHorizontalWin($row=1, $turn='x') {
    return getCell($row) == $turn &&
        getCell($row - 1) == $turn &&
        getCell($row - 2) == $turn;
}

function isDiagonalWin($turn='x') {
    if(getCell(1) == $turn && getCell(9) == $turn){
        $win = true;
    }

    if (! $win) {
        if(getCell(3) == $turn && getCell(7) == $turn){
            $win = true;
        }
    }

    if ($win && getCell(5) == $turn){
        return true;
    }else{
        return false;
    }
}

function score($player='x') {
    $score = $_SESSION['PLAYER_' . strtoupper($player) . '_WINS'];
    return $score ? $score : 0;
}
