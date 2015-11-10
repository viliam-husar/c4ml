<?php

namespace ViliamHusar\C4ml\Model;


class ExternalSystem extends AbstractSystem implements ElementInterface
{
    /**
     * @var Usage[]
     */
    protected $usages;

    public function __construct($id, $name, $description)
    {
        parent::__construct($id, $name, $description);

        $this->usages = [];
    }

    public function uses(Usage $usage)
    {
        $this->usages[] = $usage;
    }

    public function getUsages()
    {
        return $this->usages;
    }

}