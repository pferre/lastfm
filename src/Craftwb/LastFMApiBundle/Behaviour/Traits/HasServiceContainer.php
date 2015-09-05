<?php


namespace Craftwb\LastFMApiBundle\Behaviour\Traits;

use Symfony\Component\DependencyInjection\ContainerAware;

trait HasServiceContainer
{

    /**
     * @var ContainerAware $container
     */
    protected $container;

    /**
     * @param ContainerAware $container
     * @return $this
     * @internal param $ Symfony\Component\DependencyInjection\ContainerAware
     */
    public function setContainer(ContainerAware $container)
    {
        $this->container = $container;

        return $this;
    }
}