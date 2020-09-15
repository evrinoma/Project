<?php

namespace Evrinoma\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\ProjectBundle\Model\AbstractBaseProject;

/**
 * Project
 *
 * @ORM\Table(name="project")
 * @ORM\Entity
 */
class BaseProject extends AbstractBaseProject
{
}
