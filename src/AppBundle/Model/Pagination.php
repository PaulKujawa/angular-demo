<?php

namespace AppBundle\Model;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

class Pagination
{
    /**
     * @var int
     */
    public $page;

    /**
     * @var int
     */
    public $pages;
}
