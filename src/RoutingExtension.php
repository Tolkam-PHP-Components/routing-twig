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
    protected $routerContainer;
    
    /**
     * @param RouterContainer $routerContainer
     */
    public function __construct(RouterContainer $routerContainer)
    {
        $this->routerContainer = $routerContainer;
    }
    
    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'routing';
    }
    
    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('route', [$this, 'getRouteUrl'], ['is_safe_callback' => [$this, 'getSafeContexts']]),
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
    public function getSafeContexts(Node $argsNode)
    {
        $isRaw = $argsNode->hasNode(2) ? $argsNode->getNode(2)->getAttribute('value') : true;
        return $isRaw ? [] : ['html'];
    }
}
