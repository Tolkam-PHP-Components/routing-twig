<?php declare(strict_types=1);

namespace Tolkam\Routing\Twig;

use Tolkam\Routing\RouterContainer;
use Twig\Extension\AbstractExtension;
use Twig\Node\Node;
use Twig\TwigFunction;

class RoutingExtension extends AbstractExtension
{
    /**
     * @var RouterContainer
     */
    protected RouterContainer $routerContainer;
    
    /**
     * @param RouterContainer $routerContainer
     */
    public function __construct(RouterContainer $routerContainer)
    {
        $this->routerContainer = $routerContainer;
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
     * @return false|string
     */
    public function getRouteUrl(string $routeName, array $params = [], bool $raw = false)
    {
        $method = $raw ? 'generateRaw' : 'generate';
        
        return $this->routerContainer->getGenerator()->$method($routeName, $params);
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
