<?php

namespace ViliamHusar\C4ml\Model;


class InternalSystem extends AbstractSystem
{
    /**
     * @var Container[]
     */
    protected $containers;

    public function __construct($id, $name, $description)
    {
        parent::__construct($id, $name, $description);

        $this->containers = [];
    }

    public function addContainer(Container $container)
    {
        $this->containers[] = $container;
    }

    public function getContainers()
    {
        return $this->containers;
    }
}