<?php

require_once __DIR__.'/../vendor/autoload.php';

use Hampel\Linode\Linode;
use Linkorb\Provisioner\LinodeCommands\LinodeCommand;
use Hampel\Linode\Commands\AvailCommand;
use Hampel\Linode\Commands\LinodeJobCommand;

$api_key = '';
$linode = Linode::make($api_key);

//print_r($linode->execute(new AvailCommand('distributions', [
//]))); exit();

//$response = $linode->execute(new LinodeCommand('list', [
//]));
//print_r($response);

//$linodeId = $response[0]['LINODEID'];

/*$response = $linode->execute(new LinodeCommand('shutdown', [
    'linodeid' => $linodeId
]));*/

/*$response = $linode->execute(new LinodeCommand('list', [
    'linodeid' => $linodeId
]));*/
//print_r($response); exit();



/*$response = $linode->execute(new LinodeCommand('boot', [
    'linodeid' => $linodeId
]));*/

/*$response = $linode->execute(new LinodeCommand('update', [
    'linodeid' => $linodeId, 'Label' => 'v03akd'
]));*/

/*$response = $linode->execute(new LinodeJobCommand('list', [
    'linodeid' => $linodeId
]));*/

$provisioner = \Linkorb\Provisioner\ProvisionerFactory::create('linode', $api_key);
//$params = new \Symfony\Component\HttpFoundation\ParameterBag();
//$params->add(['id' => $linodeId, 'label' => 'v03adk']);
//$response = $provisioner->update($params);
//print_r($response);

//$params->add(['planid' => 12]);
//print_r($provisioner->getAvailablePlans($params));

//print_r($provisioner->provisioner_list());

print_r($provisioner->getAvailableDatacenters());

