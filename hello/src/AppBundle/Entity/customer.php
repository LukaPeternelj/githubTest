<?php
/**
 * Created by PhpStorm.
 * User: lpeternelj
 * Date: 24. 11. 2017
 * Time: 11:25
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customer")
 */
class Customer
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $davcna;

    /**
     * @ORM\Column(type="text")
     */
    private $naslov;
}