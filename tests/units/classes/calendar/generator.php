<?php

namespace time\tests\units\calendar;

require __DIR__ . '/../../runner.php';

use
	atoum,
	time\time,
	time\interval,
	time\calendar\generator as testedClass
;

class generator extends atoum\test
{
	public function test__construct()
	{
		$this
			->if($generator = new testedClass())
			->then
				->array($generator->getOpening())->isEmpty()
				->array($generator->getClosing())->isEmpty()
		;
	}

	public function testAddOpening()
	{
		$this
			->if($generator = new testedClass())
			->then
				->object($generator->addOpening(0, $interval0 = new interval()))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array($interval0)
					)
				)
				->object($generator->addOpening(0, $otherInterval0 = new interval()))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array($interval0)
					)
				)
			->if($generator = new testedClass())
			->then
				->object($generator->addOpening(0, $interval0 = new interval(new time(8), new time(12))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array($interval0)
					)
				)
				->object($generator->addOpening(0, $otherInterval0 = new interval(new time(14), new time(18))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array($interval0, $otherInterval0)
					)
				)
				->object($generator->addOpening(0, new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18)))
					)
				)
				->object($generator->addOpening(1, $interval1 = new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18))),
						1 => array($interval1)
					)
				)
				->object($generator->addOpening(2, $interval2 = new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18))),
						1 => array($interval1),
						2 => array($interval2)
					)
				)
				->object($generator->addOpening(3, $interval3 = new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18))),
						1 => array($interval1),
						2 => array($interval2),
						3 => array($interval3)
					)
				)
				->object($generator->addOpening(4, $interval4 = new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18))),
						1 => array($interval1),
						2 => array($interval2),
						3 => array($interval3),
						4 => array($interval4)
					)
				)
				->object($generator->addOpening(5, $interval5 = new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18))),
						1 => array($interval1),
						2 => array($interval2),
						3 => array($interval3),
						4 => array($interval4),
						5 => array($interval5)
					)
				)
				->object($generator->addOpening(6, $interval6 = new interval(new time(10), new time(16))))->isIdenticalTo($generator)
				->array($generator->getOpening())->isEqualTo(array(
						0 => array(new interval(new time(8), new time(18))),
						1 => array($interval1),
						2 => array($interval2),
						3 => array($interval3),
						4 => array($interval4),
						5 => array($interval5),
						6 => array($interval6)
					)
				)
				->exception(function() use ($generator, & $day) { $generator->addOpening($day = rand(7, PHP_INT_MAX), new interval()); })
					->isInstanceOf('time\exceptions\invalidArgument')
					->hasMessage('Day \'' . $day . '\' is invalid')
		;
	}

	public function testAddClosing()
	{
		$this
			->if($generator = new testedClass())
			->then
				->object($generator->addClosing($date = new \dateTime(), $interval1 = new interval()))->isIdenticalTo($generator)
				->array($generator->getClosing())->isEqualTo(array(
						$date->modify('midnight')->format('U') => array($interval1)
					)
				)
		;
	}
}
