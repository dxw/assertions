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
        $h->assertHTMLEquals('a', 'b');

        $this->assertEquals([
            "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p>a</p></body></html>\n",
            "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><p>b</p></body></html>\n",
        ], $h->args);
    }

    public function testSimpleHtml()
    {
        $h = new HTMLClass();
        $h->assertHTMLEquals('<a href="aaa">bbb</a>', '<a href ="aaa"  >bbb</a >');

        $this->assertEquals([
            "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><a href=\"aaa\">bbb</a></body></html>\n",
            "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><a href=\"aaa\">bbb</a></body></html>\n",
        ], $h->args);
    }

    public function testDoNotIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEquals("<a href='aaa'>\nbbb   <br>\t</a>", '<a href="aaa">bbb<br></a>');

        $this->assertEquals([
            "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><a href=\"aaa\">\nbbb   <br></a></body></html>\n",
            "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n<html><body><a href=\"aaa\">bbb<br></a></body></html>\n",
        ], $h->args);
    }

    public function testIgnoreWhitespace()
    {
        $h = new HTMLClass();
        $h->assertHTMLEquals("<a href='aaa'>\nbbb   <br>\t</a>", '<a href="aaa">bbb<br></a>', true);

        $this->assertEquals([
            '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"><html><body><a href="aaa">bbb<br></a></body></html>',
            '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"><html><body><a href="aaa">bbb<br></a></body></html>',
        ], $h->args);
    }
}
