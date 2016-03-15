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
        $h->assertHTMLEqualsStrictWhitespace('a', 'b');

        $this->assertEquals([
            '<div>a</div>',
            '<div>b</div>',
        ], $h->args);
    }

    public function testSimpleHtml()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace('<a href="aaa">bbb</a>', '<a href ="aaa"  >bbb</a >');

        $this->assertEquals([
            '<div><a href="aaa">bbb</a></div>',
            '<div><a href="aaa">bbb</a></div>',
        ], $h->args);
    }

    public function testDoNotIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace("<a href='aaa'>\nbbb   <br>\t</a>", '<a href="aaa">bbb<br></a>');

        $this->assertEquals([
            "<div><a href=\"aaa\">\nbbb   <br>\t</a></div>",
            '<div><a href="aaa">bbb<br></a></div>',
        ], $h->args);
    }

    public function testIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEquals("<a href='aaa'>\nbbb   <br>\t</a>", '<a href="aaa">bbb<br></a>');

        $this->assertEquals([
            '<div><a href="aaa">bbb<br></a></div>',
            '<div><a href="aaa">bbb<br></a></div>',
        ], $h->args);
    }

    public function testNewerElements()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace('<article></article>', '<article></article>');
    }
}
