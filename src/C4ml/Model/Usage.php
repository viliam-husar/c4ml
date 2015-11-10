<?php

namespace ViliamHusar\C4ml\Model;


class Usage
{
    /**
     * Target element to use.
     *
     * @var ElementInterface
     */
    protected $target;

    /**
     * Reason why target is used.
     *
     * @var string
     */
    protected $for;

    protected $type;

    public function __construct(ElementInterface $target, $for, $type = null)
    {
        $this->target = $target;
        $this->for = $for;
        $this->type = $type;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getFor()
    {
        return $this->for;
    }
}