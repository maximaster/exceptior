# maximaster/exceptior

Functions collection to ease exception handling.

```bash
composer require maximaster/exceptior
```

## CASE #1: convert throwing void function into boolean

```php
use Maximaster\Exceptior\Ex;

$noOpeation = function(): void {};
$wouldThrow = fn () => throw new Exception('hello');

Ex::boolize($noOpeation); // === true
Ex::boolize($wouldThrow); // === false
```

## CASE #2: convert throwing function with return into returning value of your choice

```php
use Maximaster\Exceptior\Ex;

$giveString = fn () => 'hello'
$wouldThrow = fn () => throw new Exception('no hello');

Ex::suppressInto($giveString, 'fail'); // === 'hello'
Ex::suppressInto($wouldThrow, 'fail'); // === 'fail'
```

## CASE #3: convert exception into another exception

```php
use Maximaster\Exceptior\Ex;

$giveString = fn () => 'hello'
$wouldThrow = fn () => throw new Exception('no hello');
$converter = fn (Throwable $thrown) => new RuntimeException($thrown->getMessage());

Ex::convert($giveString, $converter); // === 'hello'
Ex::convert($wouldThrow, $converter); // throws RuntimeException
```

## CASE #4: normalize thrown exception to value provided by callable

```php
use Maximaster\Exceptior\Ex;

$giveString = fn () => 'hello'
$wouldThrow = fn () => throw new Exception('no hello');
$normaizeToMessage = fn (Throwable $throwable) => $throwable->getMessage();

Ex::normalize($giveString, $normaizeToMessage); // === 'hello'
Ex::normalize($wouldThrow, $normaizeToMessage); // === 'no hello'
```

## Development

Fork &rarr; Fix &rarr; `composer check` &rarr; PR.
