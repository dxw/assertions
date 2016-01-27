<?php

namespace Dxw\Assertions;

trait HTML
{
    public function assertHTMLEquals($expected, $actual, $ignoreWhitespace = false)
    {
        $input = [$expected, $actual];
        $output = [];

        foreach ($input as $val) {
            $h = new \DOMDocument();
            $h->loadHTML($val);
            $out = $h->saveHTML();
            if ($ignoreWhitespace) {
                $out = preg_replace('/>\s+/m', '>', $out);
                $out = preg_replace('/\s+</m', '<', $out);
            }
            $output[] = $out;
        }

        $this->assertEquals($output[0], $output[1]);
    }
}
