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
    public function testBasic()
    {
        $h = new HTMLClass;
        $h->assertHTMLEquals('a', 'b');

        $this->assertEquals(['a', 'b'], $h->args);
    }
}
