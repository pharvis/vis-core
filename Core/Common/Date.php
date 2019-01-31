<?php

namespace Core\Common;

class Date extends \DateTime{
    
    public function addSeconds(int $seconds) : Date{
        $this->modify($seconds.' second');
        return $this;
    }
    
    public function addMinutes(int $minutes) : Date{
        $this->modify($minutes.' minute');
        return $this;
    }
    
    public function addHours(int $hours) : Date{
        $this->modify($hours.' hour');
        return $this;
    }

    public function addDays(int $days) : Date{
        $this->modify($days.' day');
        return $this;
    }
    
    public function addMonths(int $months) : Date{
        $this->modify($months.' month');
        return $this;
    }
    
    public function addYears(int $years) : Date{
        $this->modify($years.' year');
        return $this;
    }
    
    public function compare(Date $date) : int{
        if($this->getTimestamp() < $date->getTimestamp()){
            return -1;
        }elseif($this->getTimestamp() == $date->getTimestamp()){
            return 0;
        }
        return 1;
    }
    
    public function equals(Date $date) : bool{
        return $this->getTimestamp() == $date->getTimestamp() ? true : false;
    }
    
    public function getDaysInMonth() : int{
        return $this->format('t');
    }
    
    public function getIsLeapYear() : bool{
        return $this->format('L');
    }
    
    public function toString(string $format = 'Y-m-d H:i:s') : string{
        return $this->format($format);
    }

    public function __toString() : string{
        return $this->toString();
    }
    
    public static function now() : Date{
        return new Date();
    }
    
    public static function parse($dateTime) : Date{
        return new Date($dateTime);
    }
}