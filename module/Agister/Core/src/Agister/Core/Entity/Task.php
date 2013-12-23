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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $description
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
     * @param \DateTime $finishesFrom
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
     * @param \DateTime $finishesTo
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
     * @param \DateTime $startsAt
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
     * @param string $title
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

}