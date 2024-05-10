Visitor IP resolution
=====================

Allows resolving current visitor IP address.

## Usage

```
use Jmf\VisitorIpResolution\VisitorIpV4Resolver;

$resolver = new VisitorIpV4Resolver();

echo $resolver->resolve();
```

Will output something like:

```
123.45.6.7
```
