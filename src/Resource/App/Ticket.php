<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Koriym\Now\NowInterface;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Di\Di\Named;
use Ray\Query\Annotation\AliasQuery;

class Ticket extends ResourceObject
{
    use AuraSqlInject;

    /**
     * @var callable
     */
    private $ticketInsert;

    /**
     * @var NowInterface
     */
    private $now;

    /**
     * @Named("ticketInsert=ticket_insert")
     */
    public function __construct(callable $ticketInsert, NowInterface $now)
    {
        $this->ticketInsert = $ticketInsert;
        $this->now = $now;
    }

    /**
     * @JsonSchema(key="ticket", schema="ticket.json")
     * @AliasQuery("ticket_item_by_id")
     */
    public function onGet(string $id) : ResourceObject
    {
    }

    /**
     * @ReturnCreatedResource
     */
    public function onPost(
        string $title,
        string $description = '',
        string $assignee = ''
    ) : ResourceObject {
        ($this->ticketInsert)([
            'title' => $title,
            'description' => $description,
            'assignee' => $assignee,
            'status' => '',
            'created' => (string) $this->now,
            'updated' => (string) $this->now,
        ]);
        $id = $this->pdo->lastInsertId();
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = "/ticket?id={$id}";

        return $this;
    }
}
