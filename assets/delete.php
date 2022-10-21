    <?php require "db.php"; ?>
    <?php
    session_start();
    // Get id & type from header
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($conn) {
        switch ($type) {
            case "biodata":
                delete($conn, $type, $id, "students.php");
                break;
            default:
                break;
        }
    } else {
        echo 'Error: ' . $e->getMessage();
    }


    function delete($conn, $table, $id, $goto)
    {
        try {
            // sql to delete a record
            $sql = "DELETE FROM $table WHERE id = $id";
            // use exec() because no results are returned
            $conn->exec($sql);
            //echo "$table Deleted Successfully";
            $_SESSION["adminsuc"] = "Student Deleted Successfully";
        } catch (PDOException $e) {
            //echo $sql . "<br>" . $e->getMessage();
            $_SESSION["adminerra"] = $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
        header("Location: ../$goto", true, 301);
        exit;
    }

    ?>