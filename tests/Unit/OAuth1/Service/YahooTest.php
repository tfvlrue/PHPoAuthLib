<?php

namespace OAuthTest\Unit\OAuth1\Service;

use OAuth\OAuth1\Service\Yahoo;
use PHPUnit\Framework\TestCase;

class YahooTest extends TestCase
{
    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     */
    public function testConstructCorrectInterfaceWithoutCustomUri()
    {
        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface'),
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertInstanceOf('\\OAuth\\OAuth1\\Service\\ServiceInterface', $service);
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     */
    public function testConstructCorrectInstanceWithoutCustomUri()
    {
        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface'),
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertInstanceOf('\\OAuth\\OAuth1\\Service\\AbstractService', $service);
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     */
    public function testConstructCorrectInstanceWithCustomUri()
    {
        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface'),
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Uri\\UriInterface')
        );

        $this->assertInstanceOf('\\OAuth\\OAuth1\\Service\\AbstractService', $service);
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     */
    public function testGetRequestTokenEndpoint()
    {
        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface'),
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertSame(
            'https://api.login.yahoo.com/oauth/v2/get_request_token',
            $service->getRequestTokenEndpoint()->getAbsoluteUri()
        );
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getAuthorizationEndpoint
     */
    public function testGetAuthorizationEndpoint()
    {
        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface'),
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertSame(
            'https://api.login.yahoo.com/oauth/v2/request_auth',
            $service->getAuthorizationEndpoint()->getAbsoluteUri()
        );
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getAccessTokenEndpoint
     */
    public function testGetAccessTokenEndpoint()
    {
        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface'),
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertSame(
            'https://api.login.yahoo.com/oauth/v2/get_token',
            $service->getAccessTokenEndpoint()->getAbsoluteUri()
        );
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseRequestTokenResponse
     */
    public function testParseRequestTokenResponseThrowsExceptionOnNulledResponse()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue(null));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->expectException('\\OAuth\\Common\\Http\\Exception\\TokenResponseException');

        $service->requestRequestToken();
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseRequestTokenResponse
     */
    public function testParseRequestTokenResponseThrowsExceptionOnResponseNotAnArray()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue('notanarray'));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->expectException('\\OAuth\\Common\\Http\\Exception\\TokenResponseException');

        $service->requestRequestToken();
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseRequestTokenResponse
     */
    public function testParseRequestTokenResponseThrowsExceptionOnResponseCallbackNotSet()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue('foo=bar'));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->expectException('\\OAuth\\Common\\Http\\Exception\\TokenResponseException');

        $service->requestRequestToken();
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseRequestTokenResponse
     */
    public function testParseRequestTokenResponseThrowsExceptionOnResponseCallbackNotTrue()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue(
            'oauth_callback_confirmed=false'
        ));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->expectException('\\OAuth\\Common\\Http\\Exception\\TokenResponseException');

        $service->requestRequestToken();
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseRequestTokenResponse
     * @covers OAuth\OAuth1\Service\Yahoo::parseAccessTokenResponse
     */
    public function testParseRequestTokenResponseValid()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue(
            'oauth_callback_confirmed=true&oauth_token=foo&oauth_token_secret=bar'
        ));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface'),
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertInstanceOf('\\OAuth\\OAuth1\\Token\\StdOAuth1Token', $service->requestRequestToken());
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseAccessTokenResponse
     */
    public function testParseAccessTokenResponseThrowsExceptionOnError()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue('error=bar'));

        $token = $this->createMock('\\OAuth\\OAuth1\\Token\\TokenInterface');

        $storage = $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface');
        $storage->expects($this->any())->method('retrieveAccessToken')->will($this->returnValue($token));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $storage,
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->expectException('\\OAuth\\Common\\Http\\Exception\\TokenResponseException');

        $service->requestAccessToken('foo', 'bar', $token);
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::__construct
     * @covers OAuth\OAuth1\Service\Yahoo::getRequestTokenEndpoint
     * @covers OAuth\OAuth1\Service\Yahoo::parseAccessTokenResponse
     */
    public function testParseAccessTokenResponseValid()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue(
            'oauth_token=foo&oauth_token_secret=bar'
        ));

        $token = $this->createMock('\\OAuth\\OAuth1\\Token\\TokenInterface');

        $storage = $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface');
        $storage->expects($this->any())->method('retrieveAccessToken')->will($this->returnValue($token));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $storage,
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface')
        );

        $this->assertInstanceOf('\\OAuth\\OAuth1\\Token\\StdOAuth1Token', $service->requestAccessToken('foo', 'bar', $token));
    }

    /**
     * @covers OAuth\OAuth1\Service\Yahoo::request
     */
    public function testRequest()
    {
        $client = $this->createMock('\\OAuth\\Common\\Http\\Client\\ClientInterface');
        $client->expects($this->once())->method('retrieveResponse')->will($this->returnValue('response!'));

        $token = $this->createMock('\\OAuth\\OAuth1\\Token\\TokenInterface');

        $storage = $this->createMock('\\OAuth\\Common\\Storage\\TokenStorageInterface');
        $storage->expects($this->any())->method('retrieveAccessToken')->will($this->returnValue($token));

        $service = new Yahoo(
            $this->createMock('\\OAuth\\Common\\Consumer\\CredentialsInterface'),
            $client,
            $storage,
            $this->createMock('\\OAuth\\OAuth1\\Signature\\SignatureInterface'),
            $this->createMock('\\OAuth\\Common\\Http\\Uri\\UriInterface')
        );

        $this->assertSame('response!', $service->request('/my/awesome/path'));
    }
}
