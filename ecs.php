<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $containerConfigurator): void {
    // A. standalone rule
    $containerConfigurator->services()
        ->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff::class)
        ->set(\PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer::class)
        ->set(\PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff::class)
        ->property('forbiddenFunctions', [
            'dd' => null,
            'var_dump' => null,
            'xdebug_break' => null,
        ])
        ->set(\PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer::class)
        ->call('configure', [[
            'elements' => ['property', 'method'],
        ]])
        ->set(\PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer::class)
        ->property('configure', [[
            'space_before_parenthesis' => true,
            'multi_line_extends_each_single_line' => true,
        ]])
        ->set(ConcatSpaceFixer::class)->call('configure', [[
            'spacing' => 'one',
        ]])
        ->set(CastSpacesFixer::class)->call('configure', [[
            'space' => 'single',
        ]])
        ->set(FullyQualifiedStrictTypesFixer::class)
        ->set(\PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer::class)
        ->call('configure', [[
            'include' => ['@internal'],
            'scope' => 'namespaced',
            'strict' => true,
        ]]);

    // B. full sets
    $containerConfigurator->import(SetList::COMMON);
    $containerConfigurator->import(SetList::CLEAN_CODE);
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::NAMESPACES);
    $containerConfigurator->import(SetList::STRICT);
    $containerConfigurator->import(SetList::CONTROL_STRUCTURES);

    $containerConfigurator->paths([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/routes',
        __DIR__ . '/resources/lang',
    ]);

    $containerConfigurator->skip([
        __DIR__ . '/vendor/*',
        __DIR__ . '/themes/*',
        __DIR__ . '/storage/*',
        __DIR__ . '/bootstrap/*',
        __DIR__ . '/.circleci',
        '*.blade.php',
        NoSuperfluousPhpdocTagsFixer::class => null,
        ValidClassNameSniff::class . '.NotCamelCaps' => [
            __DIR__ . '/App/Core/Services/CompanyInfoFetcher/Fetchers/*.php',
        ],
        RemoveUselessDefaultCommentFixer::class,
    ]);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PARALLEL, true);
};
