<?php

namespace Jmf\VisitorIpResolution;

use Jmf\VisitorIpResolution\Exception\VisitorIpResolutionException;
use PHPUnit\Framework\TestCase;

class VisitorIpV4ResolverTest extends TestCase
{
    private VisitorIpV4Resolver $resolver;

    protected function setUp(): void
    {
        $this->resolver = new VisitorIpV4Resolver();
    }

    public function testResolveWithUnresolvableIpWillThrowException(): void
    {
        $serverValues = [];

        $this->expectException(VisitorIpResolutionException::class);
        $this->expectExceptionMessage('Failed resolving visitor IP address.');

        $this->resolver->resolve($serverValues);
    }

    public function testResolveWithInvalidIpFormatWillThrowException(): void
    {
        $serverValues = [
            'REMOTE_ADDR' => '1.2.3.foo',
        ];

        $this->expectException(VisitorIpResolutionException::class);
        $this->expectExceptionMessage('Invalid IP format.');

        $this->resolver->resolve($serverValues);
    }

    public function testResolveWithValidIp(): void
    {
        $ip = '1.2.3.4';

        $serverValues = [
            'REMOTE_ADDR' => $ip,
        ];

        $result = $this->resolver->resolve($serverValues);

        $this->assertSame($ip, $result);
    }
}
