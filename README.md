# tolkam/routing-twig

Twig integration for tolkam/routing.

## Documentation

The code is rather self-explanatory and API is intended to be as simple as possible. Please, read the sources/Docblock if you have any questions. See [Usage](#usage) for quick start.

## Usage

````php
use Aura\Router\RouterContainer;
use Tolkam\Routing\Adapter\Aura\Adapter\Aura\AuraRouterAdapter;
use Tolkam\Routing\Twig\RoutingExtension;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

$routerContainer = new RouterContainer();
$routerContainer
    ->getMap()
    ->route('my.route', '/my-route-url{/param}');

$twig = new Environment(new ArrayLoader([
    'myTemplate.twig' => 'Route "my.route" URL is "{{ route("my.route", {"param": "value"}) }}"',
]));

$twig->addExtension(new RoutingExtension(new AuraRouterAdapter($routerContainer)));

echo $twig->render('myTemplate.twig');
````

## License

Proprietary / Unlicensed 🤷
