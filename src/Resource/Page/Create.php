<?php
namespace Koriym\TicketSan\Resource\Page;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Create extends ResourceObject
{
    use ResourceInject;

    /**
     * @var FormInterface
     */
    public $form;

    /**
     * @Named("form=ticket_form")
     */
    public function __construct(FormInterface $form)
    {
        $this->form = $form;
    }

    /**
     * Create ticket form page
     */
    public function onGet() : ResourceObject
    {
        $this->body['form'] = (string) $this->form;

        return $this;
    }

    /**
     * Create ticket
     *
     * @FormValidation(form="form", onFailure="onFailure")
     * @Link(rel="create", href="app://self/tickets", method="post")
     */
    public function onPost(
        string $title,
        string $description,
        string $assignee
    ) : ResourceObject {
        $this->resource->href('create', get_defined_vars());
        $this->code = StatusCode::MOVED_PERMANENTLY;
        $this->headers[ResponseHeader::LOCATION] = '/';
        $this->body['form'] = $this->form;

        return $this;
    }

    public function onFailure()
    {
        $this->code = StatusCode::BAD_REQUEST;

        return $this->onGet();
    }
}
