<?php

use PHPUnit\Framework\TestCase;

require_once ("src/Game.php");

final class GameTest extends TestCase
{
    public function testAdd(){
        $game = new Game;
        $game->GameOfLife1D(10, 10);
    }
}