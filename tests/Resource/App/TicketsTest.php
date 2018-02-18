<?php
namespace Koriym\TicketSan\Resource\App;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use PHPUnit\Framework\TestCase;

class TicketsTest extends TestCase
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = (new AppInjector('Koriym\TicketSan', 'app'))->getInstance(ResourceInterface::class);
    }

    public function testOnPost()
    {
        $params = [
            'title' => 'title1',
            'status' => 'status1',
            'description' => 'description1',
            'assignee' => 'assignee1'
        ];
        $ro = $this->resource->post->uri('app://self/ticket')($params);
        /* @var $ro \BEAR\Resource\ResourceObject */
        $this->assertSame(201, $ro->code);
        $this->assertContains('/ticket', $ro->headers['Location']);

        return $ro;
    }

    /**
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $page = $this->resource->uri('app://self' . $location)();
        /* @var $page ResourceObject */
        $this->assertSame('title1', $page->body['ticket']['title']);
        $this->assertSame('description1', $page->body['ticket']['description']);
        $this->assertSame('assignee1', $page->body['ticket']['assignee']);
    }
}
