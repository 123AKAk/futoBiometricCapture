<?php

    require "db.php"; 
    require 'sharedComponents.php';
    $components = new SharedComponents();
    
    if($_POST["namespace"] == "info")
    {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $userid = $_POST["userid"];
        try
        {
            $sql = "UPDATE `users` SET `username`= ?, `email`= ? WHERE `id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username, $email, $components->unprotect($userid)]);

            echo json_encode(['response' => true, 'message' => 'Account Info Updated']);
        }
        catch (PDOException $e)
        {
            echo json_encode(['response' => false, 'message' => $e->getMessage()]);
        }
    }
    else if($_POST["namespace"] == "passinfo")
    {
        $password = $_POST["password"];
        $oldpassword = $_POST["oldpassword"];
        $userid = $_POST["userid"];

        try
        {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$components->unprotect($userid)]);
            $check = $stmt->fetch();
            
            if(password_verify($oldpassword, $check["password"]))
            {
                $sql = "UPDATE `users` SET `password`= ? WHERE `id` = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$password, $components->unprotect($userid)]);
    
                echo json_encode(['response' => true, 'message' => 'Account Password Updated']);
            }
            else
            {
                echo json_encode(['response' => false, 'message' => "Your Current Password is Incorrect"]);
            }
        }
        catch (PDOException $e)
        {
            echo json_encode(['response' => false, 'message' => $e->getMessage()]);
        }
    }
    else
    {
        echo "<script>window.location.replace('404.php?err=Sorry, Invalid Request');</script>";
    }
               