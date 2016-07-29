<?php


class compare {
    
    var $tabId;
    var $reserved;
    var $a;
    var $r;
    
    var $s;
    var $tabUsed;
    
    function __construct($a, $r) {
       $this->a = $a;
        $this->r = $r;
        $this->s = 0;
    }
    

    
    function compare(){}

    function settabId($i, $value){
        $this->tabId[$i] = $value;
    }
    
    function setReserved($i, $value){
        $this->reserved[$i] = $value;
    }
    
    function getReserved($i){
        return $this->reserved[$i];
    }
    
    function compareValues(){
        for($i=0; $i<$this->a; $i++){
            for($j=0; $j<$this->r; $j++){
                if($this->tabId[$i]!=$this->reserved[$j]){
                    $this->tabUsed[$this->s] = $this->tabId[$i];

                    $this->s++;
                }
            }
        }
    }
    
    function getS(){
        return $this->s;
    }
    
}
  ?>