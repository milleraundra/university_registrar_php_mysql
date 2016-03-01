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

        protected function tearDown()
        {
            Student::deleteAll();
        }

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

        function test_save()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = null;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $result = Student::getAll();

            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = null;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $name2 = "Poppy Fredrick";
            $enrollment_date2 = "2016-03-14";
            $test_student2 = new Student($name2, $enrollment_date2, $id);
            $test_student2->save();

            $result = Student::getAll();

            $this->assertEquals([$test_student, $test_student2] , $result);
        }

        function test_deleteAll()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = null;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $name2 = "Poppy Fredrick";
            $enrollment_date2 = "2016-03-14";
            $test_student2 = new Student($name2, $enrollment_date2, $id);
            $test_student2->save();

            Student::deleteAll();
            $result = Student::getAll();

            $this->assertEquals([] , $result);
        }

        function test_find()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = null;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $result = Student::find($test_student->getId());

            $this->assertEquals($test_student, $result);
        }

        function test_update()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = null;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $new_name = "Bob Saget";

            $test_student->update($new_name);

            $this->assertEquals($new_name, $test_student->getName());
        }

        function test_deleteOne()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $id = null;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $name2 = "Poppy Fredrick";
            $enrollment_date2 = "2016-03-14";
            $test_student2 = new Student($name2, $enrollment_date2, $id);
            $test_student2->save();

            $test_student->delete();
            $result = Student::getAll();

            $this->assertEquals([$test_student2], $result);
        }


    }
?>
