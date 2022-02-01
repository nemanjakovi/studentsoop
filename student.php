<?php
include_once "database.php";

class Student extends Database
{
    public $id;
    public $name;
    public $grades;
    public $school;

    // Checking if student pass
    public function hasPass($average, $school, $grades)
    {
        if ($school === "CMS") return $average >= 7;
        $gradesArray = explode(",", $grades);
        return max($gradesArray) >= 8;
    }

    // Geting avarage grade
    public function getAverage($gradesArray)
    {
        $sum = array_sum($gradesArray);
        $gradesCount = count($gradesArray);
        return  $sum / $gradesCount;
    }

    //Getting data for bouth school
    public function getData($studentsData)
    {
        if ($studentsData["school"] === "CSM" || $studentsData["school"] === "CSMB") return json_encode($studentsData);
    }

    // Query method
    public function query()
    {
        $query = "SELECT * FROM student WHERE id=? ";
        $stmt = $this->conn->prepare($query);
        $this->id = $_GET["id"];
        $stmt->bind_param("i", $this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    // fetching data from database
    public function fetch()
    {
        while ($row = $this->query()->fetch_assoc()) {
            $grades = $row["grades"];
            $gradesArray = explode(",", $grades);
            $average = $this->getAverage($gradesArray);
            $studentsData = array(
                "id"       =>    $row["id"],
                "name"     =>    $row["name"],
                "grades"   =>    $row["grades"],
                "school"   =>    $row["school"],
                "average"  =>    $average,
                "hasPass"  =>    $this->hasPass($average, $row["school"], $grades)

            );
            return $this->getData($studentsData);
        }
    }

    public function students()
    {
        return  $this->fetch();
    }
}
$student = new Student();
print_r($student->students());
