<?php

namespace Linkorb\Provisioner;

class ProvisionerFactory
{
    /**
     * @param $type
     * @param $accessToken
     * @return \Linkorb\Provisioner\ProvisionerInterface
     * @throws \Exception
     */
    public static function create($type, $accessToken)
    {
        try {
            $namePart = implode(array_map('ucfirst', explode('_', $type)));
            $className = 'Linkorb\Provisioner\\'.$namePart.'Provisioner';
            return new $className($accessToken);
        }
        catch (\Exception $e) {
            throw new \Exception(sprintf(
                "Class for '%s' not found",
                $type
            ));
        }
    }
}
