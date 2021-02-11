<?php

namespace Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="subject",indexes={@ORM\Index(name="name_index_fulltext", columns={"name"})})
 *
 */
class Subject implements \JsonSerializable
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
    protected $id;

    /**
     * @ORM\Column(type="string", columnDefinition="UNSIGED INTEGER(3) ZEROFILL")
     */
    protected $identifier;

    /** @ORM\Column(type="string") */
    protected $name;
	
	
   
    public function get_id()
    {
        return $this->id;
    }

    
    public function set_id($id)
    {
        $this->id = $id;
    }

   
    public function get_identifier()
    {
        return $this->identifier;
    }

   
    public function set_identifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function get_name()
    {
        return $this->name;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }
	
	
	
    public function jsonSerialize()
    {
        return [
             "identifier" => $this->get_identifier()
            , "name" => $this->get_name()
        ];
    }
}