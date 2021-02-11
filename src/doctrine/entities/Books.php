<?php

namespace Doctrine\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="books",indexes={@ORM\Index(name="title_index_fulltext", columns={"title"})})
 *
 */
class Books implements \JsonSerializable
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $subject_id;

    /**
     * @ORM\ManytoOne(targetEntity="Doctrine\Entities\Subject",cascade={"persist"})
     * @ORM\JoinColumn(name="subject_id", referencedColumnName="id")
     */
    protected $subject;


    /** @ORM\Column(type="string") */
    protected $language;

    /** @ORM\Column(type="string") */
    protected $title;
	
	/** @ORM\Column(type="string") */
	protected $url;
	
	/** @ORM\Column(type="integer") */
	protected $word_count;
	
	/** @ORM\Column(type="boolean") */
	protected $is_original;
	
	/** @ORM\Column(type="string",nullable=true) */
	protected $based_on;
	
	function __construct()
	{
		$this->subject = new ArrayCollection();
	}
   
    public function get_id()
    {
        return $this->id;
    }

    
    public function set_id($id)
    {
        $this->id = $id;
    }

   
    public function get_subject_id()
    {
        return $this->subject_id;
    }

   
    public function set_subject_id($subject_id)
    {
        $this->subject_id = $subject_id;
    }

    public function get_subject()
    {
        return $this->subject;
    }

    public function set_subject($subject)
    {
        if (!is_null($subject)) {
            $this->subject_id = $subject->get_id();
        }
        $this->subject = $subject;
    }
	
	public function get_title()
	{
		return $this->title;
	}
	
	public function set_title($title)
	{
		$this->title = $title;
	}
	
	public function get_url()
	{
		return $this->url;
	}
	
	public function set_url($url)
	{
		$this->title = $url;
	}
	
	public function get_language()
	{
		return $this->language;
	}
	
	public function set_language($language)
	{
		$this->language = $language;
	}
	
	public function get_word_count()
	{
		return $this->word_count;
	}
	
	public function set_word_count($word_count)
	{
		$this->word_count = $word_count;
	}
	
	public function get_is_original()
	{
		return $this->is_original;
	}
	
	public function set_is_original($is_original)
	{
		$this->is_original = $is_original;
	}
	
	public function get_based_on()
	{
		return $this->based_on;
	}
	
	public function set_based_on($based_on)
	{
		$this->based_on = $based_on;
	}
	
    public function jsonSerialize()
    {
        return (!is_null($this->get_based_on()) || !empty(trim($this->get_based_on())) ) ? [
        	 "id" => $this->get_id()
            , "subject" => $this->get_subject()
            , "title" => $this->get_title()
            , "url" => $this->get_url()
            , "language" => $this->get_language()
	        , "word_count" => $this->get_word_count()
	        , "is_original" => $this->get_is_original()
	        , "based_on" =>  $this->get_based_on()
         
        ] :
	        [
		        "id" => $this->get_id()
		        , "subject" => $this->get_subject()
		        , "title" => $this->get_title()
		        , "url" => $this->get_url()
		        , "language" => $this->get_language()
		        , "word_count" => $this->get_word_count()
		        , "is_original" => $this->get_is_original()
	        ]
	    ;
    }
}