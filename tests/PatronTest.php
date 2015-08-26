<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

  require_once "src/Patron.php";

  $server = 'mysql:host=localhost;dbname=library_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class PatronTest extends PHPUnit_Framework_TestCase

  {
      protected function tearDown()
      {
          Patron::deleteAll();
          Book::deleteAll();
      }

      function test_getname()
      {
        //Arrange
        $name = "Ryan Seacrest";
        $id = 1;
        $test_patron = new Patron ($name, $id);

        //Act
        $result = $test_patron->getPatronName();


        //Assert
        $this->assertEquals($name, $result);

      }

      function test_setPatornName()
      {
        //Arrange
        $name = "Ryan Seacrest";
        $id = 1;
        $test_patron = new Patron ($name, $id);

        //Act
        $test_patron->setPatronName("George W. Bush");
        $result = $test_patron->getPatronName();

        //Assert
        $this->assertEquals($result, "George W. Bush");
      }

      function test_getId()
      {
        //Arrange
        $id = 1;
        $name = "Aunt Jehmaima";
        $test_patron = new Patron ($name, $id);

        //Act
        $result = $test_patron->getId();

        //Assert
        $this->assertEquals(1, $result);

      }

      function test_save()
      {
        //Arrange
        $name = "Donald Trump";
        $id = 1;
        $test_patron = new Patron($name, $id);

        //Act
        $test_patron->save();

        //Assert
        $result = Patron::getAll();

        $this->assertEquals($result[0], $test_patron);
      }

      function test_getAll()
      {
        //arrange
        $name = "Grimey Harry";
        $id = 1;
        $test_patron1 = new Patron($name, $id);
        $test_patron1->save();

        $name2 = "Grimey Harry Jr.";
        $id2 = 2;
        $test_patron2 = new patron($name2, $id2);
        $test_patron2->save();

        //act
        $result = Patron::getAll();

        //assert
        $this->assertEquals([$test_patron1, $test_patron2], $result);

      }

      function test_deleteAll()
      {
        $name = "Arnold Schwarzenegger";
        $id = 1;
        $test_patron1 = new Patron($name, $id);
        $test_patron1->save();

        $name2 = "Sylvester Stallone";
        $id2 = 2;
        $test_patron2 = new Patron($name2, $id2);
        $test_patron2->save();

        Patron::deleteAll();

        $result = Patron::getAll();
        $this->assertEquals([], $result);
      }

      function test_find()
      {
        $name = "Steve Brule";
        $id = 1;
        $test_patron1 = new Patron ($name, $id);
        $test_patron1->save();

        $name2 = "Tim Heidecker";
        $id2 = 2;
        $test_patron2 = new Patron ($name2, $id2);
        $test_patron2->save();

        $result = Patron::find($test_patron2->getId());

        $this->assertEquals($test_patron2, $result);
      }

    function testUpdatePatronName()
    {
      $name = "Satan";
      $id = 1;
      $test_patron = new Patron($name, $id);
      $test_patron->save();

      $new_name = "Jesus";

      $test_patron->updatePatronName($new_name);

      $this->assertEquals("Jesus", $test_patron->getPatronName());
    }


    function testDeletePatron()
    {
      $name = "Hulk Hogan";
      $id = 1;
      $test_patron = new Patron($name, $id);
      $test_patron->save();

      $name2 = "Kool-aid Man and Randal Savage";
      $id2 = 2;
      $test_patron2 = new Patron($name2, $id2);
      $test_patron2->save();

      $test_patron->deletePatron();

      $this->assertEquals([$test_patron2], Patron::getAll());

    }
  }



?>
