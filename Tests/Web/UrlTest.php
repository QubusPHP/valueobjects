<?php

declare(strict_types=1);

namespace Qubus\Tests\ValueObjects\Web;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\ValueObject;
use Qubus\ValueObjects\Web\Hostname;
use Qubus\ValueObjects\Web\NullPortNumber;
use Qubus\ValueObjects\Web\Path;
use Qubus\ValueObjects\Web\SchemeName;
use Qubus\ValueObjects\Web\Url;
use Qubus\ValueObjects\Web\UrlFragmentIdentifier;
use Qubus\ValueObjects\Web\UrlPortNumber;
use Qubus\ValueObjects\Web\UrlQueryString;

class UrlTest extends TestCase
{
    /** @var Url */
    protected $url;

    public function setup(): void
    {
        $this->url = new Url(
            new SchemeName('http'),
            new StringLiteral('user'),
            new StringLiteral('pass'),
            new Hostname('foo.com'),
            new UrlPortNumber(80),
            new Path('/bar'),
            new UrlQueryString('?querystring'),
            new UrlFragmentIdentifier('#fragmentidentifier')
        );
    }

    public function testFromNative()
    {
        $nativeUrlString = 'http://user:pass@foo.com:80/bar?querystring#fragmentidentifier';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        Assert::assertTrue($this->url->equals($fromNativeUrl));

        $nativeUrlString = 'http://www.test.com';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        Assert::assertSame($nativeUrlString, $fromNativeUrl->__toString());

        $nativeUrlString = 'http://www.test.com/bar';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        Assert::assertSame($nativeUrlString, $fromNativeUrl->__toString());

        $nativeUrlString = 'http://www.test.com/?querystring';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        Assert::assertSame($nativeUrlString, $fromNativeUrl->__toString());

        $nativeUrlString = 'http://www.test.com/#fragmentidentifier';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        Assert::assertSame($nativeUrlString, $fromNativeUrl->__toString());
    }

    public function testSameValueAs()
    {
        $url2 = new Url(
            new SchemeName('http'),
            new StringLiteral('user'),
            new StringLiteral('pass'),
            new Hostname('foo.com'),
            new UrlPortNumber(80),
            new Path('/bar'),
            new UrlQueryString('?querystring'),
            new UrlFragmentIdentifier('#fragmentidentifier')
        );

        $url3 = new Url(
            new SchemeName('git+ssh'),
            new StringLiteral(''),
            new StringLiteral(''),
            new Hostname('github.com'),
            new NullPortNumber(),
            new Path('/nicolopignatelli/valueobjects'),
            new UrlQueryString('?querystring'),
            new UrlFragmentIdentifier('#fragmentidentifier')
        );

        Assert::assertTrue($this->url->equals($url2));
        Assert::assertTrue($url2->equals($this->url));
        Assert::assertFalse($this->url->equals($url3));

        $mock = $this->getMockBuilder(ValueObject::class)
            ->getMock();
        Assert::assertFalse($this->url->equals($mock));
    }

    public function testGetDomain()
    {
        $domain = new Hostname('foo.com');
        Assert::assertTrue($this->url->getDomain()->equals($domain));
    }

    public function testGetFragmentIdentifier()
    {
        $fragment = new UrlFragmentIdentifier('#fragmentidentifier');
        Assert::assertTrue($this->url->getFragmentIdentifier()->equals($fragment));
    }

    public function testGetPassword()
    {
        $password = new StringLiteral('pass');
        Assert::assertTrue($this->url->getPassword()->equals($password));
    }

    public function testGetPath()
    {
        $path = new Path('/bar');
        Assert::assertTrue($this->url->getPath()->equals($path));
    }

    public function testGetPort()
    {
        $port = new UrlPortNumber(80);
        Assert::assertTrue($this->url->getPort()->equals($port));
    }

    public function testGetQueryString()
    {
        $queryString = new UrlQueryString('?querystring');
        Assert::assertTrue($this->url->getQueryString()->equals($queryString));
    }

    public function testGetScheme()
    {
        $scheme = new SchemeName('http');
        Assert::assertTrue($this->url->getScheme()->equals($scheme));
    }

    public function testGetUser()
    {
        $user = new StringLiteral('user');
        Assert::assertTrue($this->url->getUser()->equals($user));
    }

    public function testToString()
    {
        Assert::assertSame('http://user:pass@foo.com:80/bar?querystring#fragmentidentifier', $this->url->__toString());
    }

    public function testAuthlessUrlToString()
    {
        $nativeUrlString = 'http://foo.com:80/bar?querystring#fragmentidentifier';
        $authlessUrl = new Url(
            new SchemeName('http'),
            new StringLiteral(''),
            new StringLiteral(''),
            new Hostname('foo.com'),
            new UrlPortNumber(80),
            new Path('/bar'),
            new UrlQueryString('?querystring'),
            new UrlFragmentIdentifier('#fragmentidentifier')
        );
        Assert::assertSame($nativeUrlString, $authlessUrl->__toString());
        $fromNativeUrl = Url::fromNative($nativeUrlString);
        Assert::assertSame($nativeUrlString, Url::fromNative($authlessUrl)->__toString());
    }

    public function testNullPortUrlToString()
    {
        $nullPortUrl = new Url(
            new SchemeName('http'),
            new StringLiteral('user'),
            new StringLiteral(''),
            new Hostname('foo.com'),
            new NullPortNumber(),
            new Path('/bar'),
            new UrlQueryString('?querystring'),
            new UrlFragmentIdentifier('#fragmentidentifier')
        );
        Assert::assertSame('http://user@foo.com/bar?querystring#fragmentidentifier', $nullPortUrl->__toString());
    }
}
