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
            "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\"><div>a</div></html>\n",
            "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\"><div>b</div></html>\n",
        ], $h->args);
    }

    public function testSimpleHtml()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace('<a href="aaa">bbb</a>', '<a href ="aaa"  >bbb</a >');

        $this->assertEquals([
            "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\"><div><a href=\"aaa\">bbb</a></div></html>\n",
            "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\"><div><a href=\"aaa\">bbb</a></div></html>\n",
        ], $h->args);
    }

    public function testDoNotIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace("<a href='aaa'>\nbbb   <br>\t</a>", '<a href="aaa">bbb<br></a>');

        $this->assertEquals([
            "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\"><div><a href=\"aaa\">\nbbb   <br></br>\t</a></div></html>\n",
            "<!DOCTYPE html>\n<html xmlns=\"http://www.w3.org/1999/xhtml\"><div><a href=\"aaa\">bbb<br></br></a></div></html>\n",
        ], $h->args);
    }

    public function testIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEquals("<a href='aaa'>\nbbb   <br>\t</a>", '<a href="aaa">bbb<br></a>');

        $this->assertEquals([
            '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml"><div><a href="aaa">bbb<br></br></a></div></html>',
            '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml"><div><a href="aaa">bbb<br></br></a></div></html>',
        ], $h->args);
    }

    public function testNewerElements()
    {
        $h = new HTMLClass();
        $h->assertHTMLEqualsStrictWhitespace('<article></article>', '<article></article>');
    }
}
