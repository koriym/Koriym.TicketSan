<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Query\Annotation\AliasQuery;

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
