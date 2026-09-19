<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\MarkdownHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

class MarkdownHelperTest extends TestCase
{
    protected MarkdownHelper $helper;

    public function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->helper = new MarkdownHelper($view);
    }

    public function tearDown(): void
    {
        unset($this->helper);
        parent::tearDown();
    }

    public function testToHtmlWithText(): void
    {
        $result = $this->helper->toHtml('Hello **World**');
        $this->assertStringContainsString('<p>Hello <strong>World</strong></p>', $result);
    }

    public function testToHtmlWithNull(): void
    {
        $result = $this->helper->toHtml(null);
        $this->assertSame('', $result);
    }

    public function testToHtmlWithEmptyString(): void
    {
        $result = $this->helper->toHtml('');
        $this->assertSame('', $result);
    }

    public function testParseAlias(): void
    {
        $result = $this->helper->parse('Hello **World**');
        $this->assertStringContainsString('<p>Hello <strong>World</strong></p>', $result);
    }
}
