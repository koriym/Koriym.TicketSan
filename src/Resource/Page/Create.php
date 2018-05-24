<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Koriym\TicketSan\Form\TicketForm;

class Create extends ResourceObject
{
    use ResourceInject;

    /**
     * @var TicketForm
     */
    private $form;

    public function __construct(TicketForm $form)
    {
        $this->form = $form;
    }

    public function onGet() : ResourceObject
    {
        $this->body = [
            'form' => (string) $this->form
        ];

        return $this;
    }

    /**
     * @Link(rel="create", method="post", href="app://self/ticket"))
     */
    public function onPost(
        string $title,
        string $description,
        string $assignee
    ) {
        $this->resource->href('create', get_defined_vars());
        $this->code = 301;
        $this->headers = [
            'Location' => '/tickets'
        ];

        return $this;
    }
}
