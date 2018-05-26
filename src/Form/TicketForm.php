<?php
namespace Koriym\TicketSan\Form;

use Aura\Html\Helper\Tag;
use Ray\WebFormModule\AbstractForm;

class TicketForm extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->setField('title')
            ->setAttribs([
                'id' => 'title',
                'name' => 'title',
                'class' => 'form-control',
                'size' => 20
            ]);
        $this->setField('description')
            ->setAttribs([
                'id' => 'description',
                'name' => 'description',
                'class' => 'form-control',
                'size' => 40
            ]);
        $this->setField('assignee')
            ->setAttribs([
                'id' => 'assignee',
                'name' => 'assignee',
                'class' => 'form-control',
                'size' => 10
            ]);
        $this->setField('submit', 'submit')
            ->setAttribs([
                'name' => 'submit',
                'value' => '送信',
                'class' => 'btn btn-primary'
            ]);
        // form validation
        $this->filter->validate('title')->is('strlenMin', 3);
        $this->filter->useFieldMessage('title', 'Min 3 Characters required');
    }

    /**
     * @throws \Aura\Html\Exception\HelperNotFound
     * @throws \Aura\Input\Exception\NoSuchInput
     */
    public function __toString()
    {
        $form = $this->form([
            'method' => 'post',
            'action' => '/create',
        ]);
        /** @var Tag $tag */
        $tag = $this->helper->get('tag');
        $form .= $this->setTitle($tag);
        $form .= $this->setDescription($tag);
        $form .= $this->setAssignee($tag);
        $form .= $this->input('submit');
        $form .= $tag('/form');

        return $form;
    }

    /**
     * @throws \Aura\Input\Exception\NoSuchInput
     */
    private function setTitle(Tag $tag) : string
    {
        $form = $tag('div', ['class' => 'form-group']);
        $form .= $tag('label', ['for' => 'title']);
        $form .= 'Title';
        $form .= $tag('/label') . PHP_EOL;
        $form .= $this->input('title');
        $form .= $this->error('title');
        $form .= $tag('/div') . PHP_EOL;

        return $form;
    }

    /**
     * @throws \Aura\Input\Exception\NoSuchInput
     */
    private function setDescription(Tag $tag) : string
    {
        $form = $tag('div', ['class' => 'form-group']);
        $form .= $tag('label', ['for' => 'description']);
        $form .= 'Description';
        $form .= $tag('/label') . PHP_EOL;
        $form .= $this->input('description');
        $form .= $this->error('description');
        $form .= $tag('/div') . PHP_EOL;

        return $form;
    }

    /**
     * @throws \Aura\Input\Exception\NoSuchInput
     */
    private function setAssignee(Tag $tag) : string
    {
        $form = $tag('div', ['class' => 'form-group']);
        $form .= $tag('label', ['for' => 'assignee']);
        $form .= 'Assignee';
        $form .= $tag('/label') . PHP_EOL;
        $form .= $this->input('assignee');
        $form .= $this->error('assignee');
        $form .= $tag('/div') . PHP_EOL;

        return $form;
    }
}
