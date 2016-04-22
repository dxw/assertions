<?php

namespace Dxw\Assertions;

trait HTML
{
    private function prettyPrint($html)
    {
        // Pretty print

        libxml_use_internal_errors(true);
        $out = (new \Wa72\HtmlPrettymin\PrettyMin())
        ->load($html)
        ->indent()
        ->saveHtml();
        libxml_clear_errors();

        // Strip front boilerplate

        $out = preg_replace('_^<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">'."\n".'_', '', $out);
        $out = preg_replace("_^<html>\n_", '', $out);
        $out = preg_replace("_^\t<body>\n_", '', $out);
        $out = preg_replace("_^\t\t<div>_", '', $out);
        $out = preg_replace("_^\n_", '', $out);

        // Strip end boilerplate

        $out = preg_replace("_</html>\n\$_", '', $out);
        $out = preg_replace("_\t</body>\n\$_", '', $out);
        $out = preg_replace("_\t\t</div>\n\$_", '', $out);
        $out = preg_replace("_\n\$_", '', $out);

        // Strip extra tabs

        $out = preg_replace("_^\t\t\t_m", '', $out);

        return $out;
    }

    private function _assertHTMLEquals($expected, $actual, $ignoreWhitespace = false)
    {
        $input = [$expected, $actual];
        $output = [];

        foreach ($input as $val) {
            $html5 = new \Masterminds\HTML5();
            $dom = $html5->loadHTMLFragment('<div>'.$val.'</div>');
            $out = $html5->saveHTML($dom);
            if ($ignoreWhitespace) {
                $out = preg_replace('/>\s+/m', '>', $out);
                $out = preg_replace('/\s+</m', '<', $out);
                $out = $this->prettyPrint($out);
            }
            $out = preg_replace('_^<div>_', '', $out);
            $out = preg_replace('_</div>$_', '', $out);
            $output[] = $out;
        }

        $this->assertEquals($output[0], $output[1]);
    }

    public function assertHTMLEqualsStrictWhitespace($expected, $actual)
    {
        return $this->_assertHTMLEquals($expected, $actual, false);
    }

    public function assertHTMLEquals($expected, $actual)
    {
        return $this->_assertHTMLEquals($expected, $actual, true);
    }
}
