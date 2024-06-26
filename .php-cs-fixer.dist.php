<?php
$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'generated',
        'schemas',
    ])
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP83Migration' => true,
        '@PHP80Migration:risky' => true,
        'array_indentation' => true,
        'concat_space' => ['spacing' => 'one'],
        'heredoc_indentation' => ['indentation' => 'same_as_start'],
        'native_constant_invocation' => false,
        'native_function_invocation' => false,
        'no_alternative_syntax' => ['fix_non_monolithic_code' => false],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'phpdoc_align' => ['align' => 'left'],
        'trailing_comma_in_multiline' => ['elements' => ['arguments', 'arrays', 'match', 'parameters']],
        'use_arrow_functions' => false,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false, 'always_move_variable' => false],
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
;
