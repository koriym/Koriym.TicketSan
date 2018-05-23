<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Ray\Query\Annotation\AliasQuery;

/**
 * @Cacheable
 */
class Tickets extends ResourceObject
{
    /**
     * @JsonSchema(schema="tickets.json")
     * @AliasQuery("ticket_list")
     */
    public function onGet() : ResourceObject
    {
        return $this;
    }
}
