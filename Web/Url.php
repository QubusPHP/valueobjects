<?php

/**
 * Qubus\ValueObjects
 *
 * @link       https://github.com/QubusPHP/valueobjects
 * @copyright  2020 Joshua Parker
 * @license    https://opensource.org/licenses/mit-license.php MIT License
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace Qubus\ValueObjects\Web;

use Qubus\ValueObjects\StringLiteral\StringLiteral;
use Qubus\ValueObjects\Util;
use Qubus\ValueObjects\ValueObject;
use Qubus\ValueObjects\Web\Domain;
use Qubus\ValueObjects\Web\UrlFragmentIdentifier;
use Qubus\ValueObjects\Web\NullPortNumber;
use Qubus\ValueObjects\Web\Path;
use Qubus\ValueObjects\Web\PortNumber;
use Qubus\ValueObjects\Web\UrlQueryString;
use Qubus\ValueObjects\Web\SchemeName;
use Qubus\ValueObjects\Web\UrlPortNumber;

use function func_get_arg;
use function parse_url;
use function sprintf;
use function strval;

use const PHP_URL_FRAGMENT;
use const PHP_URL_HOST;
use const PHP_URL_PASS;
use const PHP_URL_PATH;
use const PHP_URL_PORT;
use const PHP_URL_QUERY;
use const PHP_URL_SCHEME;
use const PHP_URL_USER;

class Url implements ValueObject
{
    protected SchemeName $scheme;

    protected StringLiteral $user;

    protected StringLiteral $password;

    protected Domain $domain;

    protected Path $path;

    protected PortNumber $port;

    protected UrlQueryString $queryString;

    protected UrlFragmentIdentifier $fragmentIdentifier;

    /**
     * Returns a new Url object.
     */
    public function __construct(
        SchemeName $scheme,
        StringLiteral $user,
        StringLiteral $password,
        Domain $domain,
        PortNumber $port,
        Path $path,
        UrlQueryString $query,
        UrlFragmentIdentifier $fragment
    ) {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->domain = $domain;
        $this->path = $path;
        $this->port = $port;
        $this->queryString = $query;
        $this->fragmentIdentifier = $fragment;
    }

    /**
     * Returns a string representation of the url.
     */
    public function __toString(): string
    {
        $userPass = '';
        if (false === $this->getUser()->isEmpty()) {
            $userPass = sprintf('%s@', $this->getUser());
            if (false === $this->getPassword()->isEmpty()) {
                $userPass = sprintf('%s:%s@', $this->getUser(), $this->getPassword());
            }
        }
        $port = '';
        if (false === NullPortNumber::create()->equals($this->getPort())) {
            $port = sprintf(':%d', $this->getPort()->toNative());
        }

        return sprintf(
            '%s://%s%s%s%s%s%s',
            $this->getScheme(),
            $userPass,
            $this->getDomain(),
            $port,
            $this->getPath(),
            $this->getQueryString(),
            $this->getFragmentIdentifier()
        );
    }

    /**
     * Returns a new Url object from a native url string.
     *
     * @param ...string $url
     * @return Url|ValueObject
     */
    public static function fromNative(): ValueObject
    {
        $urlString = strval(func_get_arg(0));

        $user = parse_url($urlString, PHP_URL_USER);
        $pass = parse_url($urlString, PHP_URL_PASS);
        $host = parse_url($urlString, PHP_URL_HOST);
        $queryString = parse_url($urlString, PHP_URL_QUERY);
        $fragmentId = parse_url($urlString, PHP_URL_FRAGMENT);
        $port = parse_url($urlString, PHP_URL_PORT);

        $scheme = new SchemeName(parse_url($urlString, PHP_URL_SCHEME));
        $user = $user ? new StringLiteral($user) : new StringLiteral('');
        $pass = $pass ? new StringLiteral($pass) : new StringLiteral('');
        $domain = Domain::specifyType($host);
        $path = parse_url($urlString, PHP_URL_PATH);
        if (null === $path) {
            $path = '';
        }
        $path = new Path($path);
        $portNumber = $port ? new UrlPortNumber($port) : new NullPortNumber();
        $query = $queryString ? new UrlQueryString(sprintf('?%s', $queryString)) : new NullQueryString();
        $fragment = $fragmentId ? new UrlFragmentIdentifier(sprintf('#%s', $fragmentId)) : new NullFragmentIdentifier();

        return new static($scheme, $user, $pass, $domain, $portNumber, $path, $query, $fragment);
    }

    /**
     * Tells whether two Url are equals by comparing their components.
     *
     * @param Url|ValueObject $url
     */
    public function equals(ValueObject $url): bool
    {
        if (false === Util::classEquals($this, $url)) {
            return false;
        }

        return $this->getScheme()->equals($url->getScheme()) &&
        $this->getUser()->equals($url->getUser()) &&
        $this->getPassword()->equals($url->getPassword()) &&
        $this->getDomain()->equals($url->getDomain()) &&
        $this->getPath()->equals($url->getPath()) &&
        $this->getPort()->equals($url->getPort()) &&
        $this->getQueryString()->equals($url->getQueryString()) &&
        $this->getFragmentIdentifier()->equals($url->getFragmentIdentifier());
    }

    /**
     * Returns the domain of the Url.
     *
     * @return Hostname|IPAddress
     */
    public function getDomain(): Domain
    {
        return clone $this->domain;
    }

    /**
     * Returns the fragment identifier of the Url.
     */
    public function getFragmentIdentifier(): UrlFragmentIdentifier
    {
        return clone $this->fragmentIdentifier;
    }

    /**
     * Returns the password part of the Url.
     */
    public function getPassword(): StringLiteral
    {
        return clone $this->password;
    }

    /**
     * Returns the path of the Url.
     */
    public function getPath(): Path
    {
        return clone $this->path;
    }

    /**
     * Returns the port of the Url.
     */
    public function getPort(): PortNumber
    {
        return clone $this->port;
    }

    /**
     * Returns the query string of the Url.
     */
    public function getQueryString(): UrlQueryString
    {
        return clone $this->queryString;
    }

    /**
     * Returns the scheme of the Url.
     */
    public function getScheme(): SchemeName
    {
        return clone $this->scheme;
    }

    /**
     * Returns the user part of the Url.
     */
    public function getUser(): StringLiteral
    {
        return clone $this->user;
    }
}
