<?php

namespace zonuexe\Loop;

use Closure;
use function array_map;
use function range;
use zonuexe\Loop;
use zonuexe\TestCase;

final class ForeachTest extends TestCase
{
    /**
     * @dataProvider foreachProvider
     */
    public function test(Closure $expected, iterable $subject, Closure $body)
    {
        Loop::foreach($subject, $body);

        $this->assertEquals(...$expected());
    }

    /**
     * @return array<array{expected:Closure, subject: iterable<mixed>, body: Closure}>
     */
    public function foreachProvider()
    {
        return [
            (function () {
                $received = [];
                return [
                    'expected' => function () use (&$received) {
                        return [
                            array_map(
                                null,
                                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                                [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                            ),
                            $received,
                        ];
                    },
                    'subject' => range(1, 10),
                    'body' => function ($k, $v) use (&$received) {
                        $received[] = [$k, $v];
                    }
                ];
            })(),
        ];
    }
}
