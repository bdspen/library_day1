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
      protected function tearDown()
      {
          Book::deleteAll();
      }

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

      function test_save()
      {
        //Arrange
        $title = "Growing up Casalino: the Big Ben story";
        $author = "Big Ben Casalino";
        $id = 1;
        $test_book = new Book($title, $author, $id);

        //Act
        $test_book->save();

        //Assert
        $result = Book::getAll();

        $this->assertEquals($result[0], $test_book);
      }

      function test_getAll()
      {
        //arrange
        $title = "Poles, Sweat, and Chicken Strips: the definitive guide to Portland strip clubs";
        $author = "Grimey Harry";
        $id = 1;
        $test_book1 = new Book($title, $author, $id);
        $test_book1->save();

        $title2 = "My dad my hero";
        $author2 = "Grimey Harry Jr.";
        $id2 = 2;
        $test_book2 = new Book($title2, $author2, $id2);
        $test_book2->save();

        //act
        $result = Book::getAll();

        var_dump($result);

        //assert
        $this->assertEquals([$test_book1, $test_book2], $result);

      }

    }




      ?>
