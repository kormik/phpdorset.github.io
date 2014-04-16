<?php

namespace PhpDorset\Eventbrite;

use GuzzleHttp\Client;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Class EventbriteProvider
 * @package PhpDorset\EventBrite
 */
class EventbriteProvider implements ServiceProviderInterface
{
    /**
     * @param Application $app
     */
    public function register(Application $app)
    {
        $app['eventbrite'] = $app->share(
            function ($app) {
                return new EventbriteService(
                    new Client,
                    $app['eventbrite.oauth']
                );
            }
        );

        $app['eventbrite.oauth'] = function () {
            return getenv('EVENTBRITE_OAUTH');
        };
    }

    /**
     * @param Application $app
     */
    public function boot(Application $app)
    {
    }
}

