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

class Ticket extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    /**
     * @JsonSchema(key="ticket", schema="ticket.json")
     */
    public function onGet(string $id) : ResourceObject
    {
        $ticket = $this->pdo->fetchOne($this->query['ticket_select'], ['id' => $id]);
        if (! $ticket) {
            $this->code = StatusCode::NOT_FOUND;

            return $this;
        }
        $this->body['ticket'] = $ticket;

        return $this;
    }

    /**
     * @Assisted("now")
     * @ReturnCreatedResource
     */
    public function onPost(
        string $title,
        string $description = '',
        string $assignee = '',
        NowInterface $now = null
    ) : ResourceObject {
        $value = [
            'title' => $title,
            'description' => $description,
            'assignee' => $assignee,
            'status' => '',
            'created' => (string) $now,
            'updated' => (string) $now,
        ];
        $this->pdo->perform($this->query['ticket_insert'], $value);
        $id = $this->pdo->lastInsertId();
        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = "/ticket?id={$id}";

        return $this;
    }
}
