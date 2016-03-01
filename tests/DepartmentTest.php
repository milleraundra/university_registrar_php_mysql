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

    }

?>
