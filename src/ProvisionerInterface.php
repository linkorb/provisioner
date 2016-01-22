<?php

namespace Linkorb\Provisioner;

use Symfony\Component\HttpFoundation\ParameterBag;

interface ProvisionerInterface
{
    public function create(ParameterBag $parameters);
    public function boot(ParameterBag $parameters);
    public function provisioner_list(ParameterBag $parameters = null);
    public function shutdown(ParameterBag $parameters);
    public function reboot(ParameterBag $parameters);
    public function provisioner_clone(ParameterBag $parameters);
    public function delete(ParameterBag $parameters);
    public function resize(ParameterBag $parameters);
    public function update(ParameterBag $parameters);
    public function getAvailablePlans(ParameterBag $parameters = null);
    public function getAvailableDatacenters(ParameterBag $parameters = null);
}
