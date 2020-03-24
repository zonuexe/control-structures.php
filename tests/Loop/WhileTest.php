<?php

namespace zonuexe\Loop;

use Closure;
use zonuexe\Loop;
use zonuexe\TestCase;

final class WhileTest extends TestCase
{
    /**
     * @dataProvider whileProvider
     */
    public function test(Closure $expected, Closure $cond, Closure $body)
    {
        Loop::while($cond, $body);

        $this->assertEquals(...$expected());
    }

    /**
     * @return array<array{expected: Closure, cond: Closure, body: Closure}>
     */
    public function whileProvider()
    {
        return [
            (function () {
                $i = 0;
                $sum = 0;
                return [
                    'expected' => function () use (&$i, &$sum) { return [
                        ['i' => 11, 'sum' => 55],
                        compact('i', 'sum'),
                    ]; },
                    'cond' => function () use (&$i) { return $i++ < 10; },
                    'body' => function () use (&$i, &$sum) { $sum += $i; },
                ];
            })(),
        ];
    }
}
