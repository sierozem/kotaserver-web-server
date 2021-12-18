<?php declare(strict_types=1);

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PHP80Migration:risky' => true,
        'concat_space' => [
            'spacing' => 'one',
        ],
        'blank_line_after_opening_tag' => false,
        'blank_line_before_statement' => false,
        'linebreak_after_opening_tag' => false,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
        'php_unit_method_casing' => false,
        'php_unit_test_class_requires_covers' => false,
    ]);
