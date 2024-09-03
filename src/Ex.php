<?php

declare(strict_types=1);

namespace Maximaster\Exceptior;

use Exception;
use Throwable;

/**
 * Exception handler helper function collection.
 *
 * @SuppressWarnings(PHPMD.ShortClassName) why:intended
 */
class Ex
{
    /**
     * Return true unless worker throws an exception.
     */
    public static function boolize(callable $worker): bool
    {
        try {
            $worker();

            return true;
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * Convert any worker throwed exception using callable converter.
     *
     * @psalm-template WorkerReturn
     * @psalm-template OutputThrowable of Throwable
     *
     * @psalm-param callable():WorkerReturn $worker
     * @psalm-param callable(Throwable):OutputThrowable $converter
     *
     * @psalm-return WorkerReturn
     *
     * // TODO @psalm-throws OutputThrowable
     *         impossible unless https://github.com/vimeo/psalm/issues/6098
     */
    public static function convert(callable $worker, callable $converter)
    {
        try {
            return $worker();
        } catch (Throwable $throwable) {
            throw $converter($throwable);
        }
    }

    /**
     * Normalize worker throwed exception into return value using callable
     * normalizer.
     *
     * @psalm-template WorkerReturn
     * @psalm-template NormalizerReturn
     *
     * @psalm-param callable():WorkerReturn $worker
     * @psalm-param callable(Throwable):NormalizerReturn $normalizer
     *
     * @psalm-return WorkerReturn|NormalizerReturn
     */
    public static function normalize(callable $worker, callable $normalizer)
    {
        try {
            return $worker();
        } catch (Throwable $throwable) {
            return $normalizer($throwable);
        }
    }

    /**
     * Suppress worker throwed exception into given static return value.
     *
     * @psalm-template WorkerReturn
     * @psalm-template SuppressType
     *
     * @psalm-param callable():WorkerReturn $worker
     * @psalm-param SuppressType $suppressValue
     *
     * @psalm-return WorkerReturn|SuppressType
     */
    public static function suppressInto(callable $worker, $suppressValue)
    {
        try {
            return $worker();
        } catch (Throwable $throwable) {
            return $suppressValue;
        }
    }

    /**
     * Suppress worker throwed exception into null.
     *
     * @psalm-template WorkerReturn
     *
     * @psalm-param callable():WorkerReturn $worker
     *
     * @psalm-return WorkerReturn|null
     */
    public static function nullize(callable $worker)
    {
        try {
            return $worker();
        } catch (Throwable $throwable) {
            return null;
        }
    }
}
