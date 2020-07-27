<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="timers")
 */
class Timer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="json_array")
     */
    private $items;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $common_time;

    /**
     * Timer constructor.
     * @param $name
     * @param User $user
     * @param $items
     * @param $type
     * @param $common_time
     */
    public function __construct($name, User $user, $items, $type, $common_time)
    {
        $this->name = $name;
        $this->user = $user;
        $this->items = $items;
        $this->type = $type;
        $this->common_time = $common_time;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return integer
     */
    public function getCommonTime()
    {
        return $this->common_time;
    }

    /**
     * @param $common_time
     * @return $this
     */
    public function setCommonTime($common_time)
    {
        $this->common_time = $common_time;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
