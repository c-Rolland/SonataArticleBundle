<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\ArticleBundle\Tests\Twig;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sonata\ArticleBundle\Helper\FragmentHelper;
use Sonata\ArticleBundle\Model\ArticleInterface;
use Sonata\ArticleBundle\Model\FragmentInterface;
use Sonata\ArticleBundle\Twig\FragmentExtension;

/**
 * @author Sylvain Rascar <rascar.sylvain@gmail.com>
 */
class FragmentExtensionTest extends TestCase
{
    /**
     * @var FragmentHelper
     */
    protected $fragmentHelper;

    /**
     * @var FragmentExtension
     */
    protected $fragmentExtension;

    protected function setUp(): void
    {
        $this->fragmentHelper = $this->getMockBuilder(FragmentHelper::class)
            ->disableOriginalConstructor()
            ->setMethods(['render'])
            ->getMock();

        $this->fragmentExtension = new FragmentExtension($this->fragmentHelper);
    }

    public function testRenderFragment(): void
    {
        // We render one fragment
        $fragment = $this->getFragmentMock([
            'title' => 'foo',
            'body' => 'bar',
        ]);

        $this->fragmentHelper->expects($this->once())
            ->method('render')
            ->willReturnCallback([$this, 'renderFragment']);

        $this->assertSame(
            '<h1>foo</h1><p>bar</p>',
            $this->fragmentExtension->renderFragment($fragment)
        );
    }

    public function testRenderArticleFragment(): void
    {
        $fragments = [];

        // We render 3 fragments with one disabled
        for ($i = 0; $i < 3; ++$i) {
            $fragments[] = $this->getFragmentMock(
                [
                    'title' => 'foo'.$i,
                    'body' => 'bar'.$i,
                ],
                !($i % 2)
            );
        }

        $article = $this->createMock(ArticleInterface::class);
        $article->expects($this->any())
            ->method('getFragments')
            ->willReturn($fragments);

        // we expect only two calls
        $this->fragmentHelper->expects($this->at(0))
            ->method('render')
            ->willReturnCallback([$this, 'renderFragment']);
        $this->fragmentHelper->expects($this->at(1))
            ->method('render')
            ->willReturnCallback([$this, 'renderFragment']);

        $this->assertSame(
            '<h1>foo0</h1><p>bar0</p><h1>foo2</h1><p>bar2</p>',
            $this->fragmentExtension->renderArticleFragments($article)
        );
    }

    public function renderFragment(FragmentInterface $fragment)
    {
        $fields = $fragment->getFields();

        return sprintf('<h1>%s</h1><p>%s</p>', $fields['title'], $fields['body']);
    }

    protected function getFragmentMock(array $settings, bool $enabled = true): MockObject
    {
        $fragment = $this->createMock(FragmentInterface::class);
        $fragment->expects($this->any())
            ->method('getFields')
            ->willReturn($settings);
        $fragment->expects($this->any())
            ->method('getEnabled')
            ->willReturn($enabled);

        return $fragment;
    }
}
