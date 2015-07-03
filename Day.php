<?php
class Day{
    public $count;
    public $time;
    public $text;

    public function __construct($time,$text){
        $this->count = 0;
        $this->time = $time;
        $this->text = $text;
    }

    public function incrementCount(){
        $this->count++;
    }

    public function decrementCount(){
        $this->count--;
    }

    public function inRange($sec,$tomorrow){
        return $sec >= $this->time && $sec < $tomorrow;
    }
}

class Period {

    public $days;
    public $series;

    public function __construct($days){
        $this->series = array();
        $this->days = array();

        foreach($days as $day){
            $time = $day->sec;
            $text = date('l',$day->sec);
            $day = new Day($time,$text);
            array_push($this->days,$day);
        }

        usort($this->days,array('Period','cmp'));
    }
    public function cmp($a,$b){
        if ($a->time == $b->time) {
            return 0;
        }
        return ($a->time < $b->time) ? -1 : 1;
    }

    public function countDays($categories = null){
        foreach ($this->days as $day){
            foreach (array_reverse(array_column($categories,'date'),true) as $k => $v){
                if($day->time > $v){
                    $categories[$k]['count']++;
                    break;
                }
            }
        }
        return $categories;
    }

}

