<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;

class Ticket extends ResourceObject
{
    /**
     * @Embed(rel="ticket", src="app://self/ticket{?id}")
     */
    public function onGet(int $id) : ResourceObject
    {
        return $this;
    }
}
