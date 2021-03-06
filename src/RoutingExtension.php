<?php declare(strict_types=1);

namespace Tolkam\Routing\Twig;

use Tolkam\Routing\RouterAdapterInterface;
use Twig\Extension\AbstractExtension;
use Twig\Node\Node;
use Twig\TwigFunction;

class RoutingExtension extends AbstractExtension
{
    /**
     * @param RouterAdapterInterface $adapter
     */
    public function __construct(private readonly RouterAdapterInterface $adapter)
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'routing';
    }

    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'route',
                [$this, 'getRouteUrl'],
                ['is_safe_callback' => [$this, 'getSafeContexts']]
            ),
        ];
    }

    /**
     * Generates url string from route name
     *
     * @param string $routeName
     * @param array  $params
     * @param bool   $raw
     *
     * @return string
     */
    public function getRouteUrl(string $routeName, array $params = [], bool $raw = false): string
    {
        return $this->adapter->generate($routeName, $params, ['raw' => $raw]);
    }

    /**
     * Returns safe contexts depending on raw flag
     *
     * @param Node $argsNode
     *
     * @return array
     */
    public function getSafeContexts(Node $argsNode): array
    {
        $isRaw = $argsNode->hasNode('2')
            ? $argsNode->getNode('2')->getAttribute('value')
            : true;

        return $isRaw ? [] : ['html'];
    }
}
