<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer / PHPUnit Constraint XmlMatchesXsd.
 *
 * (c) SpacePossum
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$header = <<<'EOF'
    This file is part of PHP CS Fixer / PHPUnit Constraint XmlMatchesXsd.

    (c) SpacePossum
        Dariusz Rumiński <dariusz.ruminski@gmail.com>

    This source file is subject to the MIT license that is bundled
    with this source code in the file LICENSE.
    EOF;

$finder = Finder::create()
    ->exclude('tests/Fixtures')
    ->in(__DIR__)
    ->append([__FILE__])
;

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@auto' => true,
        '@auto:risky' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        'header_comment' => ['header' => $header],
    ])
    ->setFinder($finder)
;
