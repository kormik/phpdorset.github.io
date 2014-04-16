<?php

namespace PhpDorset\Eventbrite;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/**
 * Class EventbriteService
 * @package PhpDorset\Eventbrite
 */
class EventbriteService
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $oauth;

    /**
     * @param Client $client
     * @param $oauth
     */
    public function __construct(Client $client, $oauth)
    {
        $this->oauth = $oauth;
        $this->client = $client;
    }

    /**
     * @return array|null
     */
    public function getEvents()
    {
        $request = $this->client->createRequest('GET', 'https://www.eventbriteapi.com/v3/users/me/owned_events/');
        $request->setHeader('Authorization', 'Bearer ' . $this->oauth);

        $response = $this->client->send($request);

        $events = $response->json();

        if (isset($events['events']) && is_array($events['events'])) {
            $events = array_map(
                function ($event) {
                    return new EventDecorator($event);
                },
                $events['events']
            );


            return $events;
        }

        return null;


    }
}

