<?php

class HTMLClass
{
    use \Dxw\Assertions\HTML;

    public function assertEquals()
    {
        $this->args = func_get_args();
    }
}

class HTMLTest extends PHPUnit_Framework_TestCase
{
    public function testPlainText()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace(
            'a',
            'b'
        );

        $this->assertEquals([
            'a',
            'b',
        ], $h->args);
    }

    public function testSimpleHtml()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace(
            '<a href="aaa">bbb</a>',
            '<a href ="aaa"  >bbb</a >'
        );

        $this->assertEquals([
            '<a href="aaa">bbb</a>',
            '<a href="aaa">bbb</a>',
        ], $h->args);
    }

    public function testDoNotIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace(
            "<a href='aaa'>\nbbb   <br>\t</a>",
            '<a href="aaa">bbb<br></a>'
        );

        $this->assertEquals([
            "<a href=\"aaa\">\nbbb   <br>\t</a>",
            '<a href="aaa">bbb<br></a>',
        ], $h->args);
    }

    public function testIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEquals(
            "<a href='aaa'>\nbbb   <br>\t</a>",
            '<a href="aaa">bbb<br></a>'
        );

        $this->assertEquals([
            '<a href="aaa">bbb<br></a>',
            '<a href="aaa">bbb<br></a>',
        ], $h->args);
    }

    public function testNewerElements()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace(
            '<article></article>',
            '<article></article>'
        );

        $this->assertEquals([
            '<article></article>',
            '<article></article>',
        ], $h->args);
    }
}
