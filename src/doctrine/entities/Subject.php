<?php

namespace Doctrine\Entities;

use Doctrine\Common\Collections\ArrayCollection;
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
	
	
	/**
	 * @ORM\OnetoMany(targetEntity="Doctrine\Entities\Subject",cascade={"persist"})
	 * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
	 *
	 */
	/**
	 * @OneToMany(targetEntity="Emaki\doctrine\entities\emaki_tag_type_field", mappedBy="subject")
	 *
	 */
	protected $books;
	
	function __construct()
	{
		$this->books = new ArrayCollection();
	}
	
   
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
	
	
	public function get_books()
	{
		return $this->books;
	}
	
	public function get_booksToArray()
	{
		return (!is_null($this->books)) ? $this->books->toArray() : [];
	}
	
	public function set_books($books)
	{
		$this->books = $books;
	}
	
	
	
    public function jsonSerialize()
    {
        return [
             "identifier" => $this->get_identifier()
            , "name" => $this->get_name()
	        , "books" => $this->get_booksToArray()
        ];
    }
}