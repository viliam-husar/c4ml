<?php

namespace ViliamHusar\C4ml\Model;


class Model
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var InternalSystem[]
     */
    protected $internalSystems;

    /**
     * @var ExternalSystem[]
     */
    protected $externalSystems;

    /**
     * @var InternalUser[]
     */
    protected $internalUsers;

    /**
     * @var ExternalUser[]
     */
    protected $externalUsers;

    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->internalSystems = [];
        $this->externalSystems = [];
        $this->internalUsers = [];
        $this->externalUsers = [];
    }

    public function addInternalSystem(InternalSystem $internalSystem)
    {
        $this->internalSystems[] = $internalSystem;
    }

    public function addExternalSystem(ExternalSystem $externalSystem)
    {
        $this->externalSystems[] = $externalSystem;
    }

    public function addInternalUser(InternalUser $internalUser)
    {
        $this->internalUsers[] = $internalUser;
    }

    public function addExternalUser(ExternalUser $externalUser)
    {
        $this->externalUsers[] = $externalUser;
    }

    public function getInternalSystems()
    {
        return $this->internalSystems;
    }

    public function getExternalSystems()
    {
        return $this->externalSystems;
    }

    public function getExternalUsers()
    {
        return $this->externalUsers;
    }

    public function getInternalUsers()
    {
        return $this->internalUsers;
    }

}