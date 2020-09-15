<?php


namespace Evrinoma\ProjectBundle;


use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Evrinoma\ProjectBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\ProjectBundle\DependencyInjection\EvrinomaProjectExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaProjectBundle extends Bundle
{
//region SECTION: Public
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()));
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaProjectExtension();
        }

        return $this->extension;
    }
//endregion Getters/Setters
}