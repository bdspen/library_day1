<?php

  class Book
  {
    private $title;
    private $author;
    private $id;

    function __construct($title, $author, $id)
    {
      $this->title = $title;
      $this->author = $author;
      $this->id = $id;
    }

    function setTitle($new_title)
    {
      $this->title = $new_title;
    }

    function getTitle()
    {
      return $this->title;
    }

    function setAuthor($new_author)
    {
      $this->author = $new_author;
    }

    function getAuthor()
    {
      return $this->author;
    }

    function getId()
    {
      return $this->id;
    }

  
  }
