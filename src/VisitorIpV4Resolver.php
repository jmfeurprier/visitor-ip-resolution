<?php

namespace Jmf\VisitorIpResolution;

use Jmf\VisitorIpResolution\Exception\VisitorIpResolutionException;
use Override;
use Webmozart\Assert\Assert;

class VisitorIpV4Resolver implements VisitorIpResolverInterface
{
    /**
     * @var string[]
     */
    private const iterable SERVER_KEYS = [
        'REMOTE_ADDR',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
    ];

    #[Override]
    public function resolve(?array $serverValues = null): string
    {
        $serverValues = $this->getServerValues($serverValues);

        foreach (self::SERVER_KEYS as $key) {
            if (array_key_exists($key, $serverValues)) {
                $ip = $serverValues[$key];

                Assert::string($ip);

                if (false !== filter_var($ip, \FILTER_VALIDATE_IP, \FILTER_FLAG_IPV4)) {
                    return $ip;
                }

                throw new VisitorIpResolutionException('Invalid IP format.');
            }
        }

        throw new VisitorIpResolutionException(
            'Failed resolving visitor IP address. Calling retriever from command line?'
        );
    }

    /**
     * @param null|array<string, mixed> $serverValues Values from $_SERVER superglobal variable.
     *
     * @return array<string, mixed>
     */
    private function getServerValues(?array $serverValues): array
    {
        return $serverValues ?? $_SERVER;
    }
}
