<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;

class Tickets extends ResourceObject
{
    /**
     * @Embed(rel="tickets", src="app://self/tickets")
     */
    public function onGet() : ResourceObject
    {
        return $this;
    }
}
