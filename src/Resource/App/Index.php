<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public $body = [
        'message' => 'Welcome to the Koriym.TicketSan API !',
        '_links' => [
            'self' => [
                'href' => '/',
            ],
            'curies' => [
                'href' => 'http://localhost:8081/rels/{?rel}',
                'name' => 'kt',
                'templated' => true
            ],
            'kt:ticket' => [
                'href' => '/ticket',
                'title' => 'tickets item',
                'templated' => true
            ],
            'kt:tickets' => [
                'href' => '/tickets',
                'title' => 'ticket list']
        ]
    ];

    public function onGet()
    {
        return $this;
    }
}
