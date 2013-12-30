<?php

namespace Agister\Core\Entity;

use DateTime;

class Timeline
{

    /**
     * @var Task[]
     */
    protected $tasks;

    /**
     * @var DateTime
     */
    protected $dateFrom;

    /**
     * @var DateTime
     */
    protected $dateTo;

    /**
     * @param  \DateTime $dateFrom
     * @return self
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param  \DateTime $dateTo
     * @return self
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param  \Agister\Core\Entity\Task[] $tasks
     * @return self
     */
    public function setTasks($tasks)
    {
        $this->tasks = $tasks;

        return $this;
    }

    /**
     * @return \Agister\Core\Entity\Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->dateTo->getTimestamp() - $this->dateFrom->getTimestamp();
    }
}
