<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        function test_allGetters()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = 1;

            $test_student = new Student($name, $enrollment_date, $id);

            $result1 = $test_student->getName();
            $result2 = $test_student->getEnrollmentDate();
            $result3 = $test_student->getId();

            $this->assertEquals($name, $result1);
            $this->assertEquals($enrollment_date, $result2);
            $this->assertEquals($id, is_numeric($result3));
        }

    }
?>
