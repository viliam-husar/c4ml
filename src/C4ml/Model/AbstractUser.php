<?php
/**
 * Created by PhpStorm.
 * User: viliam.husar
 * Date: 08/11/15
 * Time: 19:20
 */

namespace ViliamHusar\C4ml\Model;


class AbstractUser implements ElementInterface
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
     * @var Usage[]
     */
    protected $usages;

    public function __construct($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
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
}