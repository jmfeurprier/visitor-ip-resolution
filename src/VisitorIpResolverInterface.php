<?php

namespace Jmf\VisitorIpResolution;

use Jmf\VisitorIpResolution\Exception\VisitorIpResolutionException;

interface VisitorIpResolverInterface
{
    /**
     * @param null|array<string, mixed> $serverValues Values from $_SERVER superglobal variable (optional).
     *
     * @throws VisitorIpResolutionException
     */
    public function resolve(?array $serverValues = null): string;
}
