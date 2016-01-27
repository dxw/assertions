<?php

namespace Dxw\Assertions;

trait HTML
{
    public function assertHTMLEquals($expected, $actual)
    {
        $input = [$expected, $actual];
        $output = [];

        foreach ($input as $val) {
            $h = new \DOMDocument;
            $h->loadHTML($val);
            $output[] = $h->saveHTML();
        }

        $this->assertEquals($output[0], $output[1]);
    }
}
