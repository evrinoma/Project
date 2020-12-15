<?php

namespace Evrinoma\ProjectBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use JMS\Serializer\Annotation\Type;

/**
 * Project
 * @ORM\MappedSuperclass
 */
abstract class AbstractBaseProject
{
    use IdTrait, ActiveTrait, CreateUpdateAtTrait;

//region SECTION: Fields
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=0, nullable=true)
     */
    private $description;

    /**
     * @Type("DateTime<'d-m-Y'>")
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="date", nullable=false)
     */
    private $dateStart;

    /**
     * @Type("DateTime<'d-m-Y'>")
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_finish", type="date", nullable=true)
     */
    private $dateFinish;

//endregion Fields

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFinish(): ?\DateTime
    {
        return $this->dateFinish;
    }
//endregion Getters/Setters
}
