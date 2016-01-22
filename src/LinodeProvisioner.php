<?php

namespace Linkorb\Provisioner;

use Hampel\Linode\Commands\AvailCommand;
use Linkorb\Provisioner\LinodeCommands\LinodeCommand;
use Symfony\Component\HttpFoundation\ParameterBag;
use Hampel\Linode\Linode;

class LinodeProvisioner extends Provisioner
{
    private $linode;
    private $statuses = [-1 => 'Being Created', 0 => 'Brand New', 1 => 'Running', 2 => 'Powered Off'];

    public function __construct($accessToken)
    {
        parent::__construct($accessToken);
        $this->linode = Linode::make($this->accessToken);
    }

    public function create(ParameterBag $parameters)
    {
        $options = [];
        try {
            $command = new LinodeCommand('create');
            $options['planid'] = $parameters->get('planid');
            $options['datacenterid'] = $parameters->get('datacenterid');
            $parameters->get('paymentterm') ? $options['paymentterm'] = $parameters->get('paymentterm') : null;

            $command->setOptions($options);
            return $this->linode->execute($command);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function boot(ParameterBag $parameters)
    {
        try {
            return $this->linode->execute(new LinodeCommand('boot', [
                'linodeid' => $parameters->get('id')
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function provisioner_list(ParameterBag $parameters = null)
    {
        $args = $list = [];
        try {
            if ($parameters && $parameters->get('id'))
            {
                $args = ['planid' => $parameters->get('id')];
            }
            $response = $this->linode->execute(new LinodeCommand('list', $args));
            foreach ($response as $item) {
                $list[] = [
                    'id' => $item['LINODEID'],
                    'status' => $item['STATUS'],
                    'text_status' => $this->statuses[$item['STATUS']],
                    'label' => $item['LABEL']
                ];
            }
            return $list;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function shutdown(ParameterBag $parameters)
    {
        try {
            return $this->linode->execute(new LinodeCommand('shutdown', [
                'linodeid' => $parameters->get('id')
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function reboot(ParameterBag $parameters)
    {
        try {
            return $this->linode->execute(new LinodeCommand('reboot', [
                'linodeid' => $parameters->get('id')
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function provisioner_clone(ParameterBag $parameters)
    {
        $options = [];
        try {
            $command = new LinodeCommand('clone');
            $options['linodeid'] = $parameters->get('id');
            $options['planid'] = $parameters->get('planid');
            $options['datacenterid'] = $parameters->get('datacenterid');
            $parameters->get('paymentterm') ? $options['paymentterm'] = $parameters->get('paymentterm') : null;

            $command->setOptions($options);
            return $this->linode->execute($command);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete(ParameterBag $parameters)
    {
        try {
            return $this->linode->execute(new LinodeCommand('delete', [
                'linodeid' => $parameters->get('id')
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function resize(ParameterBag $parameters)
    {
        try {
            return $this->linode->execute(new LinodeCommand('resize', [
                'linodeid' => $parameters->get('id'), 'planid' => $parameters->get('plainid')
            ]));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(ParameterBag $parameters)
    {
        try {
            $command = new LinodeCommand('update');
            $options = ['linodeid' => $parameters->get('id')];
            foreach ($command->getAllowedParameters() as $parameter)
            {
                $parameters->get($parameter) ? $options[$parameter] = $parameters->get($parameter) : null;
            }
            $command->setOptions($options);
            return $this->linode->execute($command);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAvailablePlans(ParameterBag $parameters = null)
    {
        $args = $list = [];
        try {
            if ($parameters && $parameters->get('planid'))
            {
                 $args = ['planid' => $parameters->get('planid')];
            }
            $response = $this->linode->execute(new AvailCommand('linodeplans', $args));
            foreach ($response as $item) {
                $list[] = [
                    'id' => $item['PLANID'],
                    'price' => $item['PRICE'],
                    'label' => $item['LABEL']
                ];
            }
            return $list;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getAvailableDatacenters(ParameterBag $parameters = null)
    {
        $args = $list = [];
        try {
            if ($parameters && $parameters->get('datacenterid'))
            {
                $args = ['datacenterid' => $parameters->get('datacenterid')];
            }
            $response = $this->linode->execute(new AvailCommand('datacenters', $args));
            foreach ($response as $item) {
                $list[] = [
                    'id' => $item['DATACENTERID'],
                    'location' => $item['LOCATION'],
                    'abbr' => $item['ABBR'],
                    'label' => $item['LOCATION'].' '.$item['ABBR']
                ];
            }
            return $list;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
