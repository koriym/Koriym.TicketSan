<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Package\Annotation\ReturnCreatedResource;
use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\RepositoryModule\Annotation\Purge;
use BEAR\RepositoryModule\Annotation\Refresh;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Koriym\Now\NowInterface;
use Ramsey\Uuid\Uuid;
use Ray\AuraSqlModule\Annotation\Transactional;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Di\Di\Named;
use Ray\Query\Annotation\AliasQuery;

/**
 * @Cacheable
 */
class Ticket extends ResourceObject
{
    /**
     * @var callable
     */
    private $createTicket;

    /**
     * @var NowInterface
     */
    private $now;

    /**
     * @Named("createTicket=ticket_insert")
     */
    public function __construct(callable $createTicket, NowInterface $now)
    {
        $this->createTicket = $createTicket;
        $this->now = $now;
    }

    /**
     * @JsonSchema(key="ticket", schema="ticket.json")
     * @AliasQuery("ticket_item_by_id", type="row")
     */
    public function onGet(string $id) : ResourceObject
    {
    }

    /**
     * @ReturnCreatedResource
     * @Transactional
     * @Purge(uri="app://self/tickets")
     * @Purge(uri="page://self/tickets")
     */
    public function onPost(
        string $title,
        string $description = '',
        string $assignee = ''
    ) : ResourceObject {
        $id = Uuid::uuid4()->toString();
        ($this->createTicket)([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'assignee' => $assignee,
            'status' => '',
            'created' => (string) $this->now,
            'updated' => (string) $this->now,
        ]);
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = "/ticket?id={$id}";

        return $this;
    }
}
