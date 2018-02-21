<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public $code = 301;

    public $headers = [
        'Location' => '/tickets'
    ];

    public function onGet() : ResourceObject
    {
        return $this;
    }
}
