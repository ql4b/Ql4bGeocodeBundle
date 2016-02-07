<?php
namespace Ql4b\Bundle\GeocodeBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;


class Ql4bGeocodeExtension extends Extension {
    
	public function load(array $configs, ContainerBuilder $container){
		
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('geocode.client.endpoint', $config['endpoint']);
        $container->setParameter('geocode.client.key', $config['key']);
        $container->setParameter('geocode.client.language', $config['language']);
		
	}
}