<?php

    class Department
    {
        private $department_name;
        private $id;

        function __construct($department_name, $id = null)
        {
            $this->department_name = $department_name;
            $this->id = $id;
        }

        function setDepartmentName($new_department_name)
        {
            $this->department_name = $new_department_name;
        }

        function getDepartmentName()
        {
            return $this->department_name;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO departments (department_name) VALUES ('{$this->getDepartmentName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_departments = $GLOBALS['DB']->query("SELECT * FROM departments");
            $departments = array();
            foreach($returned_departments as $department){
                $department_name = $department['department_name'];
                $id = $department['id'];
                $new_department = new Department($department_name, $id);
                array_push( $departments, $new_department);
            }
            return $departments;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments");
        }

        static function find($id)
        {
            $all_departments = Department::getAll();
            $found_department = null;
            foreach($all_departments as $department) {
                $department_id = $department->getId();
                if ($department_id == $id) {
                    $found_department = $department;
                }
            }
            return $found_department;
        }

        function update($new_department_name)
        {
            $GLOBALS['DB']->exec("UPDATE departments SET department_name = '{$new_department_name}' WHERE id={$this->getId()};");
            $this->setDepartmentName($new_department_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM departments WHERE id = {$this->getId()};");
        }

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT students.* FROM students WHERE department_id = {$this->getId()};");
            $all_students = $query->fetchAll(PDO::FETCH_ASSOC);
            $students = array();
            foreach($all_students as $student) {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO departments_courses (department_id, courses_id) VALUES ({$this->getId()}, {$course->getId()}) ;");
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT courses.* FROM departments JOIN departments_courses ON (departments.id = departments_courses.department_id) JOIN courses ON (departments_courses.courses_id = courses.id) WHERE departments.id = {$this->getId()}; ");
            $returned_courses = $query->fetchAll(PDO::FETCH_ASSOC);
            $courses = array();
            foreach($returned_courses as $course){
                $course_name = $course['course_name'];
                $id = $course['id'];
                $new_course = new Course($course_name, $id);
                array_push( $courses, $new_course);
            }
            return $courses;
        }

    }




 ?>
