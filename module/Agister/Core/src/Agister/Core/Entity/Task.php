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
     * @ORM\Column(type="text",nullable=true)
     */
    protected $details;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $startsAt;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $hoursMin;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $hoursMax;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $completed = false;

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
        $this->hoursMin = 1;
        $this->hoursMax = 1;
    }

    /**
     * @param  string $details
     * @return self
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param  int  $hoursMax
     * @return self
     */
    public function setHoursMax($hoursMax)
    {
        $this->hoursMax = $hoursMax;

        return $this;
    }

    /**
     * @return int
     */
    public function getHoursMax()
    {
        return $this->hoursMax;
    }

    /**
     * @param  int  $hoursMin
     * @return self
     */
    public function setHoursMin($hoursMin)
    {
        $this->hoursMin = $hoursMin;

        return $this;
    }

    /**
     * @return int
     */
    public function getHoursMin()
    {
        return $this->hoursMin;
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
     * @param  boolean $completed
     * @return self
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCompleted()
    {
        return $this->completed;
    }

}
