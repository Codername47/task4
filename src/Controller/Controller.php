<?php

namespace src;

class Controller
{
    public function __construct(){}
    public function main($args)
    {
        
        try{
            $this->isArgsValid($args);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return;
        }
        echo "";
        $this->core($args);
    }
    
    private function core($args)
    {
        $game = new Game($args);
        $keys = new HMACGen($game->computerMove);
        echo "HMAC:\n".$keys->hmac.PHP_EOL;
        $playerMove = $this->menu($game);
        $exodus = $game->calculateExodus($playerMove);
        $this->printResults($keys->key, $exodus, $game->computerMove, $playerMove, $game->optionsForMenu); 
    }
    
    private function isArgsValid($args){
        if (count($args) == 0)
            throw new \Exception("Error: Running without parameters.\n Try 'php main.php a b c'");
        elseif(count($args) == 1)
            throw new \Exception("Error: Running with 1 parameter.\n Try more than 1 params: 'php main.php a b c'");
        elseif((count($args) % 2) == 0)
            throw new \Exception("Error: Running with even count parameters.\n Try odd params: 'php main.php a b c'");
        elseif (null != array_unique(array_diff_assoc($args,array_unique($args))))
            throw new \Exception("Error: Running with duplicate parameters.\n Try avoid diplicates: 'php main.php a b c'");
    }
    
    private function menu(Game $game)
    {
        $table = new TableFormat($game->rules, $game->options);
        
        while(true){
            $this->showMenu($game->optionsForMenu);
            $playerMove = $this->readPlayerMove($game->optionsForMenu);
            switch($playerMove)
            {
                case '!': 
                    continue 2;
                case '?': 
                    $this->showTable($table);
                    continue 2;
                case '0': 
                    exit();
            }
            break;
        } 
        return $playerMove;
    }
    
    private function showTable(TableFormat $table)
    {
        echo $table->format();
    }
    
    private function readPlayerMove(array $options)
    {
        echo "Enter your move: ";
        $line = trim(fgets(STDIN));
        if(array_search($line, $options) === false)
            return '!';
        else
            return $line;
    }
    
    private function showMenu(array $menuOptions) 
    {
        foreach($menuOptions as $move => $key)
            echo $key." - ".$move.PHP_EOL;
    }
    
    private function printResults($key, $exodus, $computerMove, $playerMove, $moves)
    {
        echo 'Your move:'.array_search((string)$playerMove, $moves).PHP_EOL;
        echo 'Computer move:'.array_search((string)$computerMove, $moves).PHP_EOL;
        switch($exodus){
            case 0: echo 'You Lose!'.PHP_EOL; break;
            case 1: echo 'Draw!'.PHP_EOL; break;
            case 2: echo 'You Win!'.PHP_EOL; break;
        }
        echo "HMAC key:\n".$key;
    }
}