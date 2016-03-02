<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Department.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class DepartmentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
            Department::deleteAll();
        }

        function test_allGetters()
        {
            $department_name = "Math";
            $id = 1;
            $test_department = new Department($department_name, $id);

            $result1 = $test_department->getDepartmentName();
            $result2 = $test_department->getId();

            $this->assertEquals($department_name, $result1);
            $this->assertEquals($id, is_numeric($result2));
        }

        function test_save()
        {
            $department_name = "Math";
            $id = null;
            $test_department = new Department($department_name, $id);

            $test_department->save();

            $result = Department::getAll();

            $this->assertEquals([$test_department], $result);

        }

        function test_getAll()
        {
            $department_name = "Math";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $department_name2 = "Science";
            $test_department2 = new Department($department_name2, $id);
            $test_department2->save();

            $result = Department::getAll();

            $this->assertEquals([$test_department, $test_department2], $result);
        }

        function test_deleteAll()
        {
            $department_name = "Math";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $department_name2 = "Science";
            $test_department2 = new Department($department_name2, $id);
            $test_department2->save();

            Department::deleteAll();

            $this->assertEquals([], Department::getAll());
        }

        function test_find()
        {
            $department_name = "Math";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $department_name2 = "Science";
            $test_department2 = new Department($department_name2, $id);
            $test_department2->save();

            $result = Department::find($test_department->getId());

            $this->assertEquals($test_department, $result);

        }

        function test_update()
        {
            $department_name = "Math";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $new_department_name = "Science";
            $test_department->update($new_department_name);

            $this->assertEquals($new_department_name, $test_department->getDepartmentName());
        }

        function test_deleteOne()
        {
            $department_name = "Math";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $department_name2 = "Science";
            $test_department2 = new Department($department_name2, $id);
            $test_department2->save();

            $test_department->delete();
            $result = Department::getAll();

            $this->assertEquals([$test_department2], $result);
        }

        function test_addCourse()
        {
            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $course_name = "Biology";
            $id = null;
            $test_course = new Course($course_name, $id);
            $test_course->save();

            $test_department->addCourse($test_course);

            $this->assertEquals($test_department->getCourses(), [$test_course]);
        }

        function test_getCourses()
        {
            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $course_name = "Biology";
            $id = null;
            $test_course = new Course($course_name, $id);
            $test_course->save();

            $course_name2 = "Economics";
            $test_course2 = new Course($course_name2, $id);
            $test_course2->save();

            $test_department->addCourse($test_course);
            $test_department->addCourse($test_course2);

            $this->assertEquals($test_department->getCourses(), [$test_course, $test_course2]);
        }




    }

?>
