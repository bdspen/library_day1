<?php

//all methods and tests passing

  class Patron
  {
    private $name;
    private $id;

    function __construct($name, $id)
    {
      $this->name = $name;
      $this->id = $id;
    }

    function setPatronName($new_patron_name)
    {
      $this->name = $new_patron_name;
    }

    function getPatronName()
    {
      return $this->name;
    }

    function getId()
    {
      return $this->id;
    }

    function save()
    {
      $GLOBALS['DB']->exec("INSERT INTO patrons (names)
      VALUES ('{$this->getPatronName()}')");
      $this->id = $GLOBALS['DB']->lastInsertId();
    }

    static function deleteAll()
    {
      $GLOBALS['DB']->exec("DELETE FROM patrons;");
    }

    static function getAll()
    {
      $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
      $patrons = array();

      foreach($returned_patrons as $patron) {
        $name = $patron['names'];
        $id = $patron['id'];

        $new_patron = new Patron ($name, $id);
        array_push($patrons, $new_patron);
      }
      return $patrons;

    }

    static function find($search_id)
    {
      $found_patron = null;
      $patrons = Patron::getAll();
      foreach($patrons as $patron) {
        $patron_id = $patron->getId();
        if ($patron_id == $search_id) {
          $found_patron = $patron;
        }
      }

      return $found_patron;
    }

    function updatePatronName($new_name)
    {
      $GLOBALS['DB']->exec("UPDATE patrons SET names = '{$new_name}' WHERE id = {$this->getId()};");
      $this->setPatronName($new_name);
    }

    function deletePatron()
    {
      $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
    }
  }
?>
