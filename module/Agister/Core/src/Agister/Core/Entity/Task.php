<?php

namespace Agister\Core\Entity;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 *
 * @ORM\Entity
 * @ORM\Table(name="task")
 */
class Task
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string",length=128)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $startsAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $finishesFrom;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $finishesTo;
}