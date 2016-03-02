<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";
    require_once "src/Department.php";

    $server = 'mysql:host=localhost;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
            Department::deleteAll();
        }

        function test_allGetters()
        {
            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $department_id = 1;
            $id = 1;

            $test_student = new Student($name, $enrollment_date, $department_id, $id);

            $result1 = $test_student->getName();
            $result2 = $test_student->getEnrollmentDate();
            $result3 = $test_student->getId();
            $result4 = $test_student->getDepartmentId();

            $this->assertEquals($name, $result1);
            $this->assertEquals($enrollment_date, $result2);
            $this->assertEquals($id, is_numeric($result3));
            $this->assertEquals($department_id, $result4);
        }

        function test_save()
        {

            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $name = "Thelma English";
            $id = null;
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $result = Student::getAll();

            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $name = "Thelma English";
            $id = null;
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $name2 = "Poppy Fredrick";
            $enrollment_date2 = "2016-03-14";
            $test_student2 = new Student($name2, $enrollment_date2, $department_id, $id);
            $test_student2->save();

            $result = Student::getAll();

            $this->assertEquals([$test_student, $test_student2] , $result);
        }

        function test_deleteAll()
        {
            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $name = "Thelma English";
            $id = null;
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $name2 = "Poppy Fredrick";
            $enrollment_date2 = "2016-03-14";
            $test_student2 = new Student($name2, $enrollment_date2, $department_id, $id);
            $test_student2->save();

            Student::deleteAll();
            $result = Student::getAll();

            $this->assertEquals([] , $result);
        }

        function test_find()
        {
            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $name = "Thelma English";
            $id = null;
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $result = Student::find($test_student->getId());

            $this->assertEquals($test_student, $result);
        }

        function test_update()
        {

            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $name = "Thelma English";
            $id = null;
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $new_name = "Bob Saget";

            $test_student->update($new_name);

            $this->assertEquals($new_name, $test_student->getName());
        }

        function test_deleteOne()
        {
            $department_name = "Science";
            $id = null;
            $test_department = new Department($department_name, $id);
            $test_department->save();

            $name = "Thelma English";
            $id = null;
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $name2 = "Poppy Fredrick";
            $enrollment_date2 = "2016-03-14";
            $test_student2 = new Student($name2, $enrollment_date2, $department_id, $id);
            $test_student2->save();

            $test_student->delete();
            $result = Student::getAll();

            $this->assertEquals([$test_student2], $result);
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

            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $test_student->addCourse($test_course);

            $this->assertEquals($test_student->getCourses(), [$test_course]);
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

            $name = "Thelma English";
            $enrollment_date = "2016-03-13";
            $department_id = $test_department->getId();
            $test_student = new Student($name, $enrollment_date, $department_id, $id);
            $test_student->save();

            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
        }


    }
?>
