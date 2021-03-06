<?php

namespace thot;

use
	thot\exceptions
;

class calendar implements \iterator
{
	protected $start = null;
	protected $stop = null;
	protected $intervals = array();
	protected $key = 0;
	protected $current = null;

	public function __construct(\dateTime $start, \dateTime $stop)
	{
		if ($start > $stop)
		{
			throw new exceptions\invalidArgument('Start must be less than stop');
		}

		$this->start = $start;
		$this->stop = $stop->modify('tomorrow -1 minutes');

		$this->rewind();
	}

	public function getStart()
	{
		return $this->start;
	}

	public function getStop()
	{
		return $this->stop;
	}

	public function rewind()
	{
		$this->key = 0;
		$this->current = clone $this->start;

		return $this;
	}

	public function valid()
	{
		return ($this->current <= $this->stop);
	}

	public function next()
	{
		if ($this->valid() === true)
		{
			$this->key++;
			$this->current->modify('tomorrow');
		}

		return $this;
	}

	public function key()
	{
		return ($this->valid() === false ? null : $this->key);
	}

	public function current()
	{
		return ($this->valid() === false ? null : clone $this->current->modify('midnight'));
	}

	public function getIntervals(\dateTime $dateTime)
	{
		$intervals = array();

		$key = static::getKeyFromDateTime($dateTime);

		if (isset($this->intervals[$key]) === true)
		{
			foreach ($this->intervals[$key] as $interval)
			{
				$intervals[] = clone $interval;
			}
		}

		return $intervals;
	}

	public function getIntervalsSince(\dateTime $dateTime)
	{
		$intervals = $this->getIntervals($dateTime);

		if (sizeof($intervals) > 0)
		{
			$time = time::getFromDateTime($dateTime);

			foreach ($intervals as $key => $interval)
			{
				if ($interval->containsDateTime($dateTime) === false)
				{
					unset($intervals[$key]);
				}
				else
				{
					$interval->setStart(time::getFromDateTime($dateTime));

					break;
				}
			}
		}

		return $intervals;
	}

	public function getIntervalAtDateTime(\dateTime $dateTime)
	{
		foreach ($this->getIntervals($dateTime) as $interval)
		{
			if ($interval->containsDateTime($dateTime) === true)
			{
				return $interval;
			}
		}

		return null;
	}

	public function addInterval(\dateTime $dateTime, interval $interval)
	{
		$key = static::getKeyFromDateTime($dateTime);

		if (isset($this->intervals[$key]) === false)
		{
			$this->intervals[$key] = array();
		}

		$this->intervals[$key] = $interval->addTo($this->intervals[$key]);

		return $this;
	}

	public function addIntervals(\dateTime $dateTime, array $intervals)
	{
		foreach ($intervals as $interval)
		{
			$this->addInterval($dateTime, $interval);
		}

		return $this;
	}

	public function isAvailable(\dateTime $dateTime)
	{
		$key = static::getKeyFromDateTime($dateTime);

		if (isset($this->intervals[$key]) === true)
		{
			foreach ($this->intervals[$key] as $interval)
			{
				if ($interval->containsDateTime($dateTime) === true)
				{
					return true;
				}
			}
		}

		return false;
	}

	public function moveTo(\dateTime $dateTime)
	{
		$dateTime = clone $dateTime;

		if ($dateTime->modify('midnight') >= $this->start && $dateTime <= $this->stop)
		{
			$this->rewind();

			while ($this->valid() === true && $this->current() != $dateTime)
			{
				$this->next();
			}
		}
		return ($this->current() == $dateTime);
	}

	public function getFirstOpenDateTime(\dateTime $dateTimeStart = null)
	{
        if($dateTimeStart !== null)
            $dateTimeStart->setTime(0, 0, 0);

		foreach ($this as $dateTime)
		{
            if($dateTimeStart && $dateTimeStart > $dateTime ) {
                continue;
            }

			$key = static::getKeyFromDateTime($dateTime);

			if (isset($this->intervals[$key]) === true)
			{
				$start = $this->intervals[$key][0]->getStart();

				$dateTime->setTime($start->getHour(), $start->getMinute());

				return $dateTime;
			}
		}

		return null;
	}

	protected static function getKeyFromDateTime(\dateTime $dateTime)
	{
		$dateTime = clone $dateTime;

		return $dateTime->modify('midnight')->format('U');
	}

    public function segmentizeDate(\DateTime $dateTime = null, $divisor = 30)
    {
        $date = clone $dateTime;

        $hours = array();

        if ($date === null)
        {
            $date = new \DateTime();
        }
        $intervals = $this->getIntervals($date->setTime(0, 0, 0));

        foreach($intervals as $interval) {

            if ($interval !== null)
            {
                $hours[] = $interval->segmentize($divisor);
            }
        }
        return $hours;
    }

    public function getClosedDays()
    {
        $closedDays = array();

        foreach ($this as $dateTime)
        {
            if (null !== $dateTime && !count($this->getintervals($dateTime)))
            {
                $closedDays[] = $dateTime;
            }
        }
        return $closedDays;
    }
}
