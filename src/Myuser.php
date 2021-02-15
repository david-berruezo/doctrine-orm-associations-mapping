<?php

/**
 * OneToMany Unidirectional with Join Table
 * Many User to Many PhoneNumbers
 *
 */

namespace src;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinColumns;
use Doctrine\ORM\Mapping\JoinColumn;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 */
class Myuser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToMany(targetEntity="Phonenumber")
     * @ORM\JoinTable(name="users_phonenumbers",
     *     joinColumns={@JoinColumn(name="user_id",referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="phonenumber_id", referencedColumnName="id" , unique= true)}
     * )
     */
    private $phonenumbers;


    public function __construct()
    {
        $this->phonenumbers = new ArrayCollection();
    }

}
