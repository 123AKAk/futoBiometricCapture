<?php 
    require "db.php"; 
    require 'sharedComponents.php';
    $components = new SharedComponents();
?>
<?php
session_start();
// Get type from header
$type = $_GET['type'];

if ($conn) {

    if (isset($_POST["submit"])) {

        switch ($type) {
            case "biodata":

                $_SESSION["studentname"] = $_POST["studentname"];
                $_SESSION["matricno"] = $_POST["matricno"];
                $_SESSION["department"] = $_POST["department"];
                $_SESSION["faculty"] = $_POST["faculty"];

                $astmt = $conn->prepare("SELECT * FROM biodata WHERE matricno = ?");
                $astmt->execute([$_POST["matricno"]]);
                // Attempt to execute the prepared statement
                if ($astmt->execute()) 
                {
                    // Check if matricno exists
                    if ($astmt->rowCount() != 1) 
                    {
                        if ($row = $astmt->fetch())
                        {
                            $_SESSION["adminerra"] = "There is already a user with that matric No.";
                            header("Location: ../add_student.php", true, 301);
                        }
                        else
                        {
                            // Upload Image
                            $picuploadmsg = uploadImage("studImage", "images/");

                            if($picuploadmsg == 11)
                            {
                                // PREPARE DATA TO INSERT INTO DB
                                $data = array(
                                    "studImage" => test_input($_FILES["studImage"]["name"]),
                                    "studentname" => test_input($_POST["studentname"]),
                                    "matricno" => test_input($_POST["matricno"]),
                                    "department" => test_input($_POST["department"]),
                                    "faculty" => test_input($_POST["faculty"])
                                );
            
                                // Call insert function
                                $resultmsg = insertToDB($conn, $type, $data);
                                if($resultmsg != 0)
                                {
                                    $_SESSION["adminsuc"] = "Student Data Added Successfully";
                                    $_SESSION["studentname"] = $_SESSION["matricno"] = $_SESSION["department"] = $_SESSION["faculty"] = "";
                                    header("Location: ../add_student.php", true, 301);
                                    exit;
                                }
                                else
                                {
                                    echo $_SESSION["studentname"];
            
                                    $_SESSION["adminerra"] = $resultmsg;
                                    header("Location: ../add_student.php", true, 301);
                                }
                            }
                            else
                            {
                                $_SESSION["adminerra"] = $picuploadmsg;
                                header("Location: ../add_student.php", true, 301);
                            }
                        }
                    }
                    else
                    {
                        $_SESSION["adminerra"] = "There is a user with that Matric No.";
                        header("Location: ../add_student.php", true, 301);
                    }
                }
                else
                {
                    $_SESSION["adminerra"] = "Error processing Matric No.";
                    header("Location: ../add_student.php", true, 301);
                }

                // Go to show.php
                break;

            default:
                echo "ERROR: Incorrect Case";
                break;
        }
    }
} else {
    echo 'Error: ' . $e->getMessage();
}

function insertToDB($conn, $table, $data)
{
    try {
        // Get keys string from data array
        $columns = implodeArray(array_keys($data));

        // Get values string from data array with prefix (:) added
        $prefixed_array = preg_filter('/^/', ':', array_keys($data));
        $values = implodeArray($prefixed_array);

        // prepare sql and bind parameters
        $sql = "INSERT INTO $table ($columns) VALUES ($values); SELECT LAST_INSERT_ID();";
        $stmt = $conn->prepare($sql);

        // insert row
        $stmt->execute($data);
        
        //echo "New records created successfully";
        return $conn->lastInsertId();
    } catch (PDOException $error) {
        //echo $error;
        return $error;
    }
}

function implodeArray($array)
{
    return implode(", ", $array);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


function uploadImage($name, $dest)
{
    $target_dir = $dest;
    $target_file = $target_dir . basename($_FILES[$name]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    // $check = getimagesize($_FILES[$name]["tmp_name"]);
    // if ($check == false) {
    //     //echo "File is an image - " . $check["mime"] . ".";
    //     //return "File is an image - " . $check["mime"] . ".";
    //     return "File is not an image.";
    //     $uploadOk = 0;
    // }
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
        return "Sorry, file already exists.";
    }
    // Check file size
    if ($_FILES[$name]["size"] > 500000) {
        $uploadOk = 0;
        return "Sorry, your file is too large.";
    }
    // Allow certain file formats
    if ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
        return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //echo "Sorry, your file was not uploaded.";
        return "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
            //echo "The file " . basename($_FILES[$name]["name"]) . " has been uploaded.";
            return 11;
        } else {
            //echo "Sorry, there was an error uploading your file.";
            return "Sorry, there was an error uploading your file.";
        }
    }
}

?>