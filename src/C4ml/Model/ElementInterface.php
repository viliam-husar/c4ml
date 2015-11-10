<?php

namespace ViliamHusar\C4ml\Model;


interface ElementInterface
{
    function getId();

    function uses(Usage $usage);
}