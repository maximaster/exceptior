<?php

declare(strict_types=1);

use Maximaster\Exceptior\Ex;

$returnTrue = static fn (): bool => true;
$returnSuccess = static fn (): string => 'success';
$throwFailure = static fn () => throw new Exception('failure');
$throwOops = static fn () => throw new Exception('oops');

describe(Ex::class, function () use ($returnTrue, $returnSuccess, $throwFailure, $throwOops): void {
    it('should boolize failure worker to false', function () use ($throwFailure): void {
        expect(Ex::boolize($throwFailure))->toBe(false);
    });

    it('should boolize success worker to true', function () use ($returnTrue): void {
        expect(Ex::boolize($returnTrue))->toBe(true);
    });

    it('should convert failure to oops', function () use ($throwFailure, $throwOops): void {
        expect(static fn () => Ex::convert($throwFailure, $throwOops))
            ->toThrow('oops');
    });

    it('should not convert success', function () use ($returnTrue, $throwOops): void {
        expect(static fn () => Ex::convert($returnTrue, $throwOops))
            ->not->toThrow();
    });

    it('should return success on convert', function () use ($returnTrue, $throwOops): void {
        expect(Ex::convert($returnTrue, $throwOops))->toBeTruthy();
    });

    it ('should normalize failure to its message', function () use ($throwFailure): void {
        expect(Ex::normalize($throwFailure, static fn (Throwable $throwable) => $throwable->getMessage()))
            ->toBe('failure');
    });

    it ('should not normalize return', function () use ($returnSuccess): void {
        expect(Ex::normalize($returnSuccess, static fn (Throwable $throwable) => $throwable->getMessage()))
            ->toBe('success');
    });

    it ('should suppress failure into null', function () use ($throwFailure): void {
        expect(Ex::suppressInto($throwFailure, null))->toBe(null);
    });

    it ('should not suppress success into null', function () use ($returnSuccess): void {
        expect(Ex::suppressInto($returnSuccess, null))->toBe('success');
    });

    it('should nullize oops', function () use ($throwOops): void {
        expect(Ex::nullize($throwOops))->toBeNull();
    });

    it('should not nullize true', function () use ($returnTrue): void {
        expect(Ex::nullize($returnTrue))->toBe(true);
    });
});
