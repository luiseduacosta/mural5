<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\HostHeaderMiddleware;
use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\InternalErrorException;
use Cake\TestSuite\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HostHeaderMiddlewareTest extends TestCase
{
    protected HostHeaderMiddleware $middleware;

    protected function createMockRequest(string $host): ServerRequestInterface
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $uri = $this->createMock(\Psr\Http\Message\UriInterface::class);
        $uri->method('getHost')->willReturn($host);
        $request->method('getUri')->willReturn($uri);
        return $request;
    }

    protected function createMockHandler(): RequestHandlerInterface
    {
        $response = $this->createMock(ResponseInterface::class);
        $handler = $this->createMock(RequestHandlerInterface::class);
        $handler->method('handle')->willReturn($response);
        return $handler;
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->middleware = new HostHeaderMiddleware();
    }

    public function testSkipsInDebugMode(): void
    {
        Configure::write('debug', true);
        $request = $this->createMockRequest('example.com');
        $handler = $this->createMockHandler();
        $result = $this->middleware->process($request, $handler);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testThrowsInternalErrorWhenFullBaseUrlNotConfigured(): void
    {
        Configure::write('debug', false);
        Configure::delete('App.fullBaseUrl');
        $request = $this->createMockRequest('example.com');
        $handler = $this->createMockHandler();
        $this->expectException(InternalErrorException::class);
        $this->middleware->process($request, $handler);
    }

    public function testAllowsValidHost(): void
    {
        Configure::write('debug', false);
        Configure::write('App.fullBaseUrl', 'https://valid.example.com');
        $request = $this->createMockRequest('valid.example.com');
        $handler = $this->createMockHandler();
        $result = $this->middleware->process($request, $handler);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testAllowsValidHostCaseInsensitive(): void
    {
        Configure::write('debug', false);
        Configure::write('App.fullBaseUrl', 'https://VALID.EXAMPLE.COM');
        $request = $this->createMockRequest('valid.example.com');
        $handler = $this->createMockHandler();
        $result = $this->middleware->process($request, $handler);
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }

    public function testThrowsBadRequestForInvalidHost(): void
    {
        Configure::write('debug', false);
        Configure::write('App.fullBaseUrl', 'https://valid.example.com');
        $request = $this->createMockRequest('evil.example.com');
        $handler = $this->createMockHandler();
        $this->expectException(BadRequestException::class);
        $this->middleware->process($request, $handler);
    }
}
