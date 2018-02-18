<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;

class Tickets extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    /**
     * @JsonSchema(schema="tickets.json")
     */
    public function onGet() : ResourceObject
    {
        $this->body = $this->pdo->fetchAll($this->query['ticket_list']);

        return $this;
    }
}
