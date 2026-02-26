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

namespace PhpCsFixer\PhpunitConstraintXmlMatchesXsd\Tests\Constraint;

use PhpCsFixer\PhpunitConstraintXmlMatchesXsd\Constraint\XmlMatchesXsd;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \PhpCsFixer\PhpunitConstraintXmlMatchesXsd\Constraint\XmlMatchesXsd
 */
final class XmlMatchesXsdTest extends TestCase
{
    public function testAssertXMLMatchesXSD(): void
    {
        $constraint = new XmlMatchesXsd($this->getXSD());
        $sampleFile = $this->getAssetsDir().'xliff_sample.xml';
        $content = @file_get_contents($sampleFile);

        if (false === $content) {
            $error = error_get_last();

            throw new \RuntimeException(\sprintf(
                'Failed to read content of the sample file "%s".%s',
                $content,
                $error ? ' '.$error['message'] : ''
            ));
        }

        $constraint->evaluate($content); // should not throw an exception
        self::assertTrue($constraint->evaluate($content, '', true));
    }

    public function testXMLValidConstraintBasics(): void
    {
        $constraint = new XmlMatchesXsd('');
        self::assertSame(1, $constraint->count());
        self::assertSame('matches XSD', $constraint->toString());
    }

    public function testXMLValidConstraintFalse(): void
    {
        $this->expectException(
            'PHPUnit\Framework\ExpectationFailedException'
        );
        $this->expectExceptionMessageRegex(
            '#^Failed asserting that boolean\# matches XSD\.$#'
        );

        $constraint = new XmlMatchesXsd($this->getXSD());
        $constraint->evaluate(false);
    }

    public function testXMLValidConstraintInt(): void
    {
        $this->expectException(
            'PHPUnit\Framework\ExpectationFailedException'
        );
        $this->expectExceptionMessageRegex(
            '#^Failed asserting that integer\#1 matches XSD\.$#'
        );

        $constraint = new XmlMatchesXsd($this->getXSD());
        $constraint->evaluate(1);
    }

    public function testXMLValidConstraintInvalidXML(): void
    {
        $this->expectException(
            'PHPUnit\Framework\ExpectationFailedException'
        );
        $this->expectExceptionMessageRegex(
            '#^Failed asserting that <a></b> matches XSD.[\n]\[error \d{1,}\](?s).*\.$#'
        );

        $constraint = new XmlMatchesXsd($this->getXSD());
        $constraint->evaluate('<a></b>');
    }

    public function testXMLValidConstraintNotMatchingXML(): void
    {
        $this->expectException(
            'PHPUnit\Framework\ExpectationFailedException'
        );
        $this->expectExceptionMessageRegex(
            '#^Failed asserting that <a></a> matches XSD.[\n]\[error \d{1,}\](?s).*\.$#'
        );

        $constraint = new XmlMatchesXsd($this->getXSD());
        $constraint->evaluate('<a></a>');
    }

    public function testXMLValidConstraintNull(): void
    {
        $this->expectException(
            'PHPUnit\Framework\ExpectationFailedException'
        );
        $this->expectExceptionMessageRegex(
            '#^Failed asserting that null matches XSD\.$#'
        );

        $constraint = new XmlMatchesXsd($this->getXSD());
        $constraint->evaluate(null);
    }

    public function testXMLValidConstraintObject(): void
    {
        $this->expectException(
            'PHPUnit\Framework\ExpectationFailedException'
        );
        $this->expectExceptionMessageRegex(
            '#^Failed asserting that stdClass\# matches XSD\.$#'
        );

        $constraint = new XmlMatchesXsd($this->getXSD());
        $constraint->evaluate(new \stdClass());
    }

    /**
     * @return string
     */
    private function getXSD()
    {
        return file_get_contents($this->getAssetsDir().'xliff-core-1.2-strict.xsd');
    }

    /**
     * @return string
     */
    private function getAssetsDir()
    {
        return __DIR__.'/../Fixtures/XmlMatchesXsdTest/';
    }

    /**
     * @param string $pattern
     */
    private function expectExceptionMessageRegex($pattern): void
    {
        if (method_exists($this, 'expectExceptionMessageRegExp')) {
            $this->expectExceptionMessageMatches($pattern);
        } elseif (method_exists($this, 'expectExceptionMessageMatches')) {
            $this->expectExceptionMessageMatches($pattern);
        } elseif (method_exists($this, 'expectDeprecationMessageMatches')) {
            $this->expectDeprecationMessageMatches($pattern);
        } else {
            throw new \RuntimeException('Unknown how to match against exception message.');
        }
    }
}
