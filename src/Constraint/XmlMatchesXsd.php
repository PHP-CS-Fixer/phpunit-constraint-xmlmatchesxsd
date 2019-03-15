<?php

/*
 * This file is part of PHP CS Fixer / PHPUnit Constraint XmlMatchesXsd.
 *
 * (c) SpacePossum
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PhpCsFixer\PhpunitConstraintXmlMatchesXsd\Constraint;

if (version_compare(\PHPUnit\Runner\Version::id(), '7.0.0') < 0) {
    class_alias(XmlMatchesXsdForV5::class, XmlMatchesXsd::class);
} elseif (version_compare(\PHPUnit\Runner\Version::id(), '8.0.0') < 0) {
    class_alias(XmlMatchesXsdForV7::class, XmlMatchesXsd::class);
} else {
    class_alias(XmlMatchesXsdForV8::class, XmlMatchesXsd::class);
}
