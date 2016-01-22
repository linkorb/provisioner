<?php

namespace Linkorb\Provisioner;

abstract class Provisioner implements ProvisionerInterface
{
    protected $accessToken;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
