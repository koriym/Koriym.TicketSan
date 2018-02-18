<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    public function onGet() : ResourceObject
    {
        $this->code = 301;
        $this->headers['Location'] = '/tickets';

        return $this;
    }
}
