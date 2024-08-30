<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

return (new Config())
    ->setRiskyAllowed(true)
    ->setFinder((new Finder())->in(['src']))
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],
        'single_blank_line_at_eof' => true,
        'no_superfluous_phpdoc_tags' => true,
        'strict_param' => true,
        'declare_strict_types' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'single_line_throw' => false,
        'yoda_style' => false,
        'phpdoc_align' => false,
        'global_namespace_import' => true,
        // psalm won't read types from generic comments.
        'phpdoc_to_comment' => false,
    ]);
