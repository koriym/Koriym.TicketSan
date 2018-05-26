<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;

/**
 * @Cacheable(type="view")
 */
class Tickets extends ResourceObject
{
    /**
     * @Embed(rel="tickets", src="app://self/tickets")
     */
    public function onGet() : ResourceObject
    {
        $this->body += [
            'last_update' => date('r')
        ];
        return $this;
    }
}
