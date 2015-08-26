<?php

  class Author
  {
    private $name;

    private $id;

    function __construct($name, $id)
    {
      $this->name = $name;
      $this->id = $id;
    }

    function setAuthorName($new_name)
    {
      $this->name = $new_name;
    }

    function getAuthorName()
    {
      return $this->name;
    }

    function getId()
    {
      return $this->id;
    }

    //Save method
    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO authors (names)
      VALUES ('{$this->getname()}');");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM authors;");
    }

    static function getAll()
    {
      $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
      $authors = array();

      foreach($returned_authors as $author) {
        $name = $author['name'];
        $id = $author['id'];

        $new_author = new Author ($name, $id);
        array_push($authors, $new_author);
      }
      return $authors;

    }

    static function find($search_id)
    {
      $found_author = null;
      $authors = Author::getAll();
      foreach($authors as $author) {
        $author_id = $author->getId();
        if ($author_id == $search_id) {
          $found_author = $author;
        }
      }

      return $found_author;
    }

    function updateAuthorName($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setAuthorName($new_name);
    }

    function deleteAuthor()
    {
      $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
    }
}
?>
