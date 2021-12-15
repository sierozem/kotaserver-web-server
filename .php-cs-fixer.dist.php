<?php declare(strict_types=1);

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer' => true,
        '@PHP80Migration:risky' => true,
        'blank_line_after_opening_tag' => false,
        'blank_line_before_statement' => false,
        'linebreak_after_opening_tag' => false,
        'multiline_whitespace_before_semicolons' => [
            'strategy' => 'no_multi_line',
        ],
    ]);
