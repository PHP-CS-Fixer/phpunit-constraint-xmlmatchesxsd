<?php

$header = <<<'EOF'
This file is part of PHP CS Fixer / PHPUnit Constraint XmlMatchesXsd.

(c) SpacePossum
    Dariusz Rumiński <dariusz.ruminski@gmail.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->exclude('tests/Fixtures')
    ->in(__DIR__)
;

return (new PhpCsFixer\Config)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer'               => true,
        '@PhpCsFixer:risky'         => true,
        '@PHPUnit60Migration:risky' => true,
        'header_comment'            => ['header' => $header],
    ])
    ->setFinder($finder)
;
