<?php

namespace Core\Common;

/**
 * A convenience class to help create and manipulate dates.
 */
class Date extends \DateTime{
    
    /**
     * Adds $seconds to the current date instance. Returns the current Date 
     * instance.
     */
    public function addSeconds(int $seconds) : Date{
        $this->modify($seconds.' second');
        return $this;
    }
    
    /**
     * Adds $minutes to the current date instance. Returns the current Date 
     * instance.
     */
    public function addMinutes(int $minutes) : Date{
        $this->modify($minutes.' minute');
        return $this;
    }
    
    /**
     * Adds $hours to the current date instance. Returns the current Date 
     * instance.
     */
    public function addHours(int $hours) : Date{
        $this->modify($hours.' hour');
        return $this;
    }

    /**
     * Adds $days to the current date instance. Returns the current Date 
     * instance.
     */
    public function addDays(int $days) : Date{
        $this->modify($days.' day');
        return $this;
    }
    
    /**
     * Adds $months to the current date instance. Returns the current Date 
     * instance.
     */
    public function addMonths(int $months) : Date{
        $this->modify($months.' month');
        return $this;
    }
    
    /**
     * Adds $years to the current date instance. Returns the current Date 
     * instance.
     */
    public function addYears(int $years) : Date{
        $this->modify($years.' year');
        return $this;
    }
    
    /**
     * Compares $date to the current Date instance. If the current Date instance
     * is less than $date then -1 is returned. If the current Date instance is 
     * equal to $date then 0 is return. If the current Date instance is more than
     * $date then 1 is returned.
     */
    public function compare(Date $date) : int{
        if($this->getTimestamp() < $date->getTimestamp()){
            return -1;
        }elseif($this->getTimestamp() == $date->getTimestamp()){
            return 0;
        }
        return 1;
    }
    
    /**
     * Gets a boolean value indicating if the current Date instance is equal
     * to $date.
     */
    public function equals(Date $date) : bool{
        return $this->getTimestamp() == $date->getTimestamp() ? true : false;
    }
    
    /**
     * Gets the number of days in the current month.
     */
    public function getDaysInMonth() : int{
        return $this->format('t');
    }
    
    /**
     * Gets a boolean value indicating if the current Date instance is a
     * leap year.
     */
    public function getIsLeapYear() : bool{
        return $this->format('L');
    }
    
    /**
     * Gets a formatted date using $format.
     */
    public function toString(string $format = 'Y-m-d H:i:s') : string{
        return $this->format($format);
    }
    
    /**
     * Gets a new Date instance that represents the current date.
     */
    public static function now() : Date{
        return new Date();
    }
    
    /**
     * Gets a new Date instance that represents the current date.
     */
    public static function parse(string $dateTime) : Date{
        return new Date($dateTime);
    }
    
    public function __toString() : string{
        return $this->toString();
    }
}