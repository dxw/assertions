<?php

namespace Dxw\Assertions;

trait HTML
{
    public function assertHTMLEquals($expected, $actual)
    {
        $this->assertEquals($expected, $actual);
    }
}
