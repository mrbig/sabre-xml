<?php

declare(strict_types=1);

namespace Sabre\Xml;

use PHPUnit\Framework\TestCase;

/**
 * Test for the ContextStackTrait.
 *
 * @copyright Copyright (C) 2009-2015 fruux GmbH (https://fruux.com/).
 * @author Evert Pot (http://evertpot.com/)
 * @license http://sabre.io/license/ Modified BSD License
 */
class ContextStackTest extends TestCase
{
    private ContextStack $stack;

    public function setUp(): void
    {
        $this->stack = new ContextStack();
    }

    public function testPushAndPull(): void
    {
        $this->stack->contextUri = '/foo/bar';
        $this->stack->elementMap['{DAV:}foo'] = 'Bar';
        $this->stack->namespaceMap['DAV:'] = 'd';

        $this->stack->pushContext();

        $this->assertEquals('/foo/bar', $this->stack->contextUri);
        $this->assertEquals('Bar', $this->stack->elementMap['{DAV:}foo']);
        $this->assertEquals('d', $this->stack->namespaceMap['DAV:']);

        $this->stack->contextUri = '/gir/zim';
        $this->stack->elementMap['{DAV:}foo'] = 'newBar';
        $this->stack->namespaceMap['DAV:'] = 'dd';

        $this->stack->popContext();

        $this->assertEquals('/foo/bar', $this->stack->contextUri);
        $this->assertEquals('Bar', $this->stack->elementMap['{DAV:}foo']);
        $this->assertEquals('d', $this->stack->namespaceMap['DAV:']);
    }
}
