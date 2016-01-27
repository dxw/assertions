# \\Dxw\\Assertions

## Installation

    composer require --dev dxw/assertions=dev-master

## Usage

    class MyTest extends PHPUnit_Framework_TestCase
    {
        use \Dxw\Assertions\HTML;

        public function testSomeHtml()
        {
            $output = '<a href="aaa">bbb</a>';

            // Assert the two documents are equivalent
            $this->assertHTMLEquals('
            <a   href="aaa"   >bbb</a>
            ', $output);

            // Ignore semantic whitespace differences
            $this->assertHTMLEquals('
            <a   href="aaa"   >
            bbb
            </a>
            ', $output, true);
        }
    }

## API

### \Dxw\Assertions\HTML

    assertHTMLEquals($expected, $actual, $ignoreWhitespace)

## Licence

[MIT](COPYING.md)
