<?php

/**
 * One to One Bidirectional
 * One Customer to One Cart
 *
 */

namespace src;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToOne;


use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 */
class Customer{

    /**
     * @var
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var
     * @ORM\OneToOne(targetEntity="Cart", mappedBy="customer")
     */
    private $cart;

}
?>