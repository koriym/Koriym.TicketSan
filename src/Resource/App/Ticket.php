<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Koriym\Now\NowInterface;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Di\Di\Assisted;
use Ray\Di\Di\Named;

class Ticket extends ResourceObject
{
    use AuraSqlInject;
    
    /**
     * @var callable
     */
    private $ticketSelect;
    
    /**
     * @var callable
     */
    private $ticketInsert;
    
    /**
     * @var NowInterface
     */
    private $now;
    
    /**
     * @Named("ticketSelect=ticket_select, ticketInsert=ticket_insert")
     */
    public function __construct(callable $ticketSelect, callable $ticketInsert, NowInterface $now)
    {
        $this->ticketSelect = $ticketSelect;
        $this->ticketInsert = $ticketInsert;
        $this->now = $now;
    }
    
    /**
     * @JsonSchema(key="ticket", schema="ticket.json")
     */
    public function onGet(string $id) : ResourceObject
    {
        
        $ticket = ($this->ticketSelect)(['id' => $id])[0];
        if (! $ticket) {
            $this->code = StatusCode::NOT_FOUND;

            return $this;
        }
        $this->body['ticket'] = $ticket;

        return $this;
    }

    /**
     * @ReturnCreatedResource
     */
    public function onPost(
        string $title,
        string $description = '',
        string $assignee = '',
        NowInterface $now = null
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
