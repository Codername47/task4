<?php

namespace src;

class Game
{
    private $options;
    private $optionsForMenu;
    private $computerMove;
    private $baseRuleForShift;
    private $rules;
    
    public function __construct($moves)
    {
        $this->options = $moves;
        $this->generateBaseLineForAllExodus();
        $this->calculateRulesForAllExodus();
        $this->generateComputerMove();
        $this->generateOptions();
    }
    public function __get($name)
    {
        if(isset($this->$name)){
            return $this->$name;
        } else return null;
    }
    
    private function generateOptions()
    {
        $this->optionsForMenu = array_flip($this->options);
        $this->optionsForMenu = array_map(function($n){ return (string)($n+1); }, $this->optionsForMenu);
        $this->optionsForMenu = $this->optionsForMenu + ['Help' => '?', 'Exit' => '0'];
    }
    private function generateBaseLineForAllExodus()
    {
        end($this->options);
        $lastKey = key($this->options);
        $centerKey = intdiv($lastKey, 2);
        $this->baseRuleForShift = array_merge(array_fill(0, $centerKey, 0), (array)1, array_fill(0, $centerKey, 2));
        while($this->baseRuleForShift[0] != 1)
            $this->shiftRule();
    }
    
    private function generateComputerMove()
    {
        $this->computerMove = random_int(1, count($this->options));
    }
    
    private function calculateRulesForAllExodus()
    {
        for($i = 0; $i < count($this->options); $i++){
           $this->rules[$i] = $this->baseRuleForShift; 
           $this->shiftRule();
        }
    }
    
    private function shiftRule()
    {
        $item = array_pop($this->baseRuleForShift);
        array_unshift ($this->baseRuleForShift, $item);
    }
    
    public function calculateExodus($playerMove)
    {
        return $this->rules[$this->computerMove-1][$playerMove-1];
    }
}