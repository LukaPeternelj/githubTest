<?php
/**
 * Created by PhpStorm.
 * User: lpeternelj
 * Date: 27. 11. 2017
 * Time: 09:42
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class FormId
{
    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


}