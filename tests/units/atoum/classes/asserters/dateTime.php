<?php

namespace mageekguy\atoum\asserters;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\exceptions
;

class dateTime extends asserters\object
{
	public function setWith($value, $checkType = true)
	{
		parent::setWith($value, false);

		if ($checkType === true)
		{
			if (self::isDateTime($this->value) === false)
			{
				$this->fail(sprintf($this->getLocale()->_('%s is not an instance of \\dateTime'), $this));
			}
			else
			{
				$this->pass();
			}
		}

		return $this;
	}

	public function hasTimezone(\dateTimezone $timezone, $failMessage = null)
	{
		if ($this->valueIsSet()->value->getTimezone()->getName() == $timezone->getName())
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Timezone is %s instead of %s'), $this->value->getTimezone()->getName(), $timezone->getName()));
		}

		return $this;
	}

	public function hasYear($year, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('Y') === sprintf('%04d', $year))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Year is %04d instead of %s'), $year, $this->value->format('Y')));
		}

		return $this;
	}

	public function isInYear()
	{
		die('The method ' . __METHOD__ . ' is deprecated, please use ' . __CLASS__ . '::hasYear instead');
	}

	public function hasMonth($month, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('m') === sprintf('%02d', $month))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Month is %02d instead of %s'), $month, $this->value->format('m')));
		}

		return $this;
	}

	public function isInMonth()
	{
		die('The method ' . __METHOD__ . ' is deprecated, please use ' . __CLASS__ . '::hasMonth instead');
	}

	public function hasDay($day, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('d') === sprintf('%02d', $day))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Day is %02d instead of %s'), $day, $this->value->format('d')));
		}

		return $this;
	}

	public function isInDay()
	{
		die('The method ' . __METHOD__ . ' is deprecated, please use ' . __CLASS__ . '::hasDay instead');
	}

	public function hasDate($year, $month, $day, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('Y-m-d') === sprintf('%04d-%02d-%02d', $year, $month, $day))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Date is %s instead of %s'), sprintf('%04d-%02d-%02d', $year, $month, $day), $this->value->format('Y-m-d')));
		}

		return $this;
	}

	public function hasHours($hours, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('H') === sprintf('%02d', $hours))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Hours are %02d instead of %s'), $hours, $this->value->format('H')));
		}

		return $this;
	}

	public function hasMinutes($minutes, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('i') === sprintf('%02d', $minutes))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Minutes are %02d instead of %s'), $minutes, $this->value->format('i')));
		}

		return $this;
	}

	public function hasSeconds($seconds, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('s') === sprintf('%02d', $seconds))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Seconds are %02d instead of %s'), $seconds, $this->value->format('s')));
		}

		return $this;
	}

	public function hasTime($hours, $minutes, $seconds, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('H:i:s') === sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Time is %s instead of %s'), sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds), $this->value->format('H:i:s')));
		}

		return $this;
	}

	public function hasDateAndTime($year, $month, $day, $hours, $minutes, $seconds, $failMessage = null)
	{
		if ($this->valueIsSet()->value->format('Y-m-d H:i:s') === sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hours, $minutes, $seconds))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage !== null ? $failMessage : sprintf($this->getLocale()->_('Datetime is %s instead of %s'), sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hours, $minutes, $seconds), $this->value->format('Y-m-d H:i:s')));
		}

		return $this;
	}

	protected function valueIsSet($message = 'Instance of \dateTime is undefined')
	{
		if (self::isDateTime(parent::valueIsSet($message)->value) === false)
		{
			throw new exceptions\logic($message);
		}

		return $this;
	}

	protected static function check($value, $method)
	{
		if (self::isDateTime($value) === false)
		{
			throw new exceptions\logic('Argument of ' . $method . '() must be an instance of \\dateTime');
		}
	}

	protected static function isDateTime($value)
	{
		return ($value instanceof \dateTime);
	}
}
