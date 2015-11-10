<?php

namespace ViliamHusar\C4ml\Model;

class Container implements ElementInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var Usage[]
     */
    protected $usages;

    public function __construct($id, $name, $description, $type = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->usages = [];
    }

    public function uses(Usage $usage)
    {
        $this->usages[] = $usage;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUsages()
    {
        return $this->usages;
    }

    public function getType()
    {
        return $this->type;
    }

}