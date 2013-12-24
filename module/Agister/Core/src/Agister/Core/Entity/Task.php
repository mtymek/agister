<?php

namespace Agister\Core\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Task
 *
 * @ORM\Entity(repositoryClass="Agister\Core\Repository\Task")
 * @ORM\Table(name="task")
 */
class Task implements \JsonSerializable
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

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $active = 1;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->startsAt = new DateTime();
        $this->finishesFrom = new DateTime();
        $this->finishesTo = new DateTime();
    }

    /**
     * @param  string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param  \DateTime $finishesFrom
     * @return self
     */
    public function setFinishesFrom($finishesFrom)
    {
        $this->finishesFrom = $finishesFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFinishesFrom()
    {
        return $this->finishesFrom;
    }

    /**
     * @param  \DateTime $finishesTo
     * @return self
     */
    public function setFinishesTo($finishesTo)
    {
        $this->finishesTo = $finishesTo;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFinishesTo()
    {
        return $this->finishesTo;
    }

    /**
     * @param  \DateTime $startsAt
     * @return self
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * @param  string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  boolean $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *               which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'active' => $this->active,
            'title' => $this->title,
            'description' => $this->description,
            'startsAt' => $this->startsAt,
            'finishesFrom' => $this->finishesFrom,
            'finishesTo' => $this->finishesTo,
        );
    }
}
