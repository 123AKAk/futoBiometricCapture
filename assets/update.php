<?php require "db.php"; ?>
<?php

session_start();

// Get type from header
$type = $_GET['type'];
$urlId = $_GET["id"];
if(isset($_GET['img']))
$urlImage = $_GET['img'];

if ($conn)
{
    if (isset($_POST["update"])) 
    {
        switch ($type) {
            case "biodata":

                // Update DataBase
                $studImage = test_input($_FILES["studImage"]["name"]);
                $studentname = test_input($_POST["studentname"]);
                $matricno = $_POST["matricno"];
                $department = test_input($_POST["department"]);
                $faculty = test_input($_POST["faculty"]);

                // Upload Image
                if ($_FILES["studImage"]['error'] == 0) {
                    $picuploadmsg = uploadImage("studImage", "images/");
                    if($picuploadmsg != 11)
                    {
                        $_SESSION["adminerra"] = $picuploadmsg;
                        echo $picuploadmsg;
                        header("Location: ../update_post.php?id=$urlId");
                    }
                } else {
                    $studImage = $urlImage;
                }

                try {
                    $sql = "UPDATE biodata SET `studImage`=?, `studentname`= ?, `matricno`= ?, `department`=?, `faculty`= ? WHERE `id` = ?";

                    $stmt = $conn->prepare($sql);

                    $stmt->execute([$studImage, $studentname, $matricno, $department, $faculty, $urlId]);

                    
                    $_SESSION["adminsuc"] = "Student Data Updated successfully";
                    header("Location: ../students.php", true, 301);
                    exit;
                } catch (PDOException $e) {
                    
                    $_SESSION["adminerra"] = $e->getMessage();
                    header("Location: ../update_student.php?id=$urlId");
                }

                break;
            
            case "editprofile":

                    // Update DataBase
                    $username = test_input($_POST["username"]);
                    $email = $_POST["email"];
                    $password = test_input($_POST["password"]);
                    $confrimpassword = test_input($_POST["confrimpassword"]);

                    if($confrimpassword == $password)
                    {
                        //hash password
                        $hashpassword = password_hash($password, PASSWORD_DEFAULT);

                        try {
                            if(empty($password))
                            {
                                $stmt = $conn->prepare("UPDATE admin SET `username`=?, `email`= ? WHERE `id` = ?");
                                $stmt->execute([$username, $email, $urlId]);
                            }
                            else
                            {
                                $stmt = $conn->prepare("UPDATE admin SET `username`=?, `email`= ?, `password`= ? WHERE `id` = ?");
                                $stmt->execute([$username, $email, $hashpassword, $urlId]);
                            }
                            
                            $_SESSION["adminsuc"] = "Adminstrator Data Updated successfully";
                            header("Location: ../profile.php?id=$urlId", true, 301);
                            exit;
                        }
                        catch (PDOException $e)
                        {
                            $_SESSION["adminerra"] = $e->getMessage();
                            header("Location: ../profile.php?id=$urlId");
                        }
                    }
                    else
                    {
                        $_SESSION["adminerra"] = "Password are not the same";
                        header("Location: ../profile.php?id=$urlId");
                    }

                    break;

            default:
                break;
        }
    }
} else {
    echo 'Error: ' . $e->getMessage();
}

// function uploadImage($name, $dest){
//     // Upload Image
//     $fileName = $_FILES[$name]['name'];
//     $fileTmpName = $_FILES[$name]['tmp_name'];
//     $fileError = $_FILES[$name]['error'];

//     if($fileError === 0){
//         $fileDestination = $dest.$fileName;
//         move_uploaded_file($fileTmpName, $fileDestination);
//         echo "Image Upload Successful";
//     }else {
//         echo "Image Upload Error";
//     }
// }

function uploadImage($name, $dest)
{

    $target_dir = $dest;
    $target_file = $target_dir . basename($_FILES[$name]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$name]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES[$name]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES[$name]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
