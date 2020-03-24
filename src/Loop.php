<?php

namespace zonuexe;

use ArrayIterator;
use Closure;
use Generator;
use function is_array;

final class Loop
{
    public static function _for(Closure $init, Closure $cont, Closure $each): Generator
    {
        $init();
        $iter = Loop::_while($cont);

        begin:

        if ($iter->valid()) {
            yield;
            $each();
            $iter->next();

            goto begin;
        }
    }

    public static function _foreach(iterable $iter): Generator
    {
        if (is_array($iter)) {
            $iter = new ArrayIterator($iter);
        }

        begin:

        if ($iter->valid()) {
            yield $iter->key() => $iter->current();
            $iter->next();

            goto begin;
        }
    }

    public static function _while(Closure $cond): Generator
    {
        begin:

        if ($cond()) {
            yield;

            goto begin;
        }
    }

    public static function for(Closure $init, Closure $cont, Closure $each, Closure $body): void
    {
        Loop::foreach(Loop::_for($init, $cont, $each), $body);
    }

    public static function foreach(iterable $iter, Closure $body): void
    {
        $loop = Loop::_foreach($iter);

        begin:

        if ($loop->valid()) {
            $body($loop->key(), $loop->current());
            $loop->next();

            goto begin;
        }
    }

    public static function while(Closure $cond, Closure $body): void
    {
        Loop::foreach(Loop::_while($cond), $body);
    }

    /**
     * @param array{while?:Closure}|array{until?:Closure} $cond
     */
    public static function do(Closure $body, array $cond): void
    {
        if (isset($cond['until'])) {
            $test = fn () => !$cond['until']();
        } else {
            $tets = $cond['while'] ?? fn () => false;
        }

        $body();
        Loop::while($test, $body);
    }

    public static function do_while(Closure $body, Closure $cond): void
    {
        $body();
        Loop::while($cond, $body);
    }

    public static function until(Closure $cond, Closure $body): void
    {
        Loop::while(fn() => !$cond(), $body);
    }
}
