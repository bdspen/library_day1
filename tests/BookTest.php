<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

  require_once "src/Book.php";

  $server = 'mysql:host=localhost;dbname=library_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class BookTest extends PHPUnit_Framework_TestCase

  {
      // protected function tearDown()
      // {
      //     Task::deleteAll();
      //     Category::deleteAll();
      // }

      function test_getTitle()
      {
        //Arrange
        $title = "Fun with pillows";
        $author = "Cringleberry Jones";
        $id = 1;
        $test_book = new Book ($title, $author, $id);

        //Act
        $result = $test_book->getTitle();


        //Assert
        $this->assertEquals ( $title, $result);

      }

      function test_setTitle()
      {
        //Arrange
        $title = "Uncle Ben's puzzle basement";
        $author = "Dr. H.L. Big-Boi";
        $id = 1;
        $test_book = new Book ($title, $author, $id);

        //Act
        $test_book->setTitle("Welcome to Puzzle Heaven");
        $result = $test_book->getTitle();

        //Assert
        $this->assertEquals($result, "Welcome to Puzzle Heaven");
      }

      function test_getId()
      {
        //Arrange
        $id = 1;
        $title = "Aunt Jehmaima: A century of syrups";
        $author = "A.J.";
        $test_book = new Book ($title, $author, $id);

        //Act
        $result = $test_book->getId();

        //Assert
        $this->assertEquals(1, $result); 

      }

    }




      ?>
