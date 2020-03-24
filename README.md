# control-structures.php

## `Loop::while()`

```php
<?php

use zonuexe\Loop;

$i = 0;

Loop::while(
    function () use (&$i) { return $i < 10; },
    function () use (&$i) { var_dump($i++); }
);
```

## `Loop::do_while()`

```php
<?php

use zonuexe\Loop;

$i = 0;

Loop::do_while(
    function () use (&$i) { var_dump($i++); },  // dumps "int(0)"
    function () use (&$i) { return $i < 0; }
);
```

## `Loop::until()`

```php
<?php

use zonuexe\Loop;

$i = 0;

Loop::until(
    function () use (&$i) { return $i === 10; },
    function () use (&$i) { var_dump($i++); }
);
```

## `Loop::do()`

```php
<?php

use zonuexe\Loop;

$i = 0;

Loop::do(
    function () use (&$i) { var_dump($i++); },
    ['while' => function () use (&$i) { return $i < 0; }]
);
```

```php
<?php

use zonuexe\Loop;

$i = 0;

Loop::do(
    function () use (&$i) { var_dump($i++); },
    ['until' => function () use (&$i) { return $i === 10; }]
);
```

## `Loop::for()`

```php
<?php

use zonuexe\Loop;

$i = 0;

Loop::for(
    function () use (&$i) { $i = 0; },
    function () use (&$i) { return $i < 10; },
    function () use (&$i) { $i++; },
    function () use (&$i) { var_dump($i); }
);
```

## `Loop::foreach()`

```php
<?php

use zonuexe\Loop;

Loop::foreach(range(1, 10), fn($k, $v) => print $v . PHP_EOL);
```
