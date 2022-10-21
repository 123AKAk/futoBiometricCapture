<?php
class SharedComponents
{
    //checks images and upload to server
    function processImage($email, $image)
    {
        $filename = htmlspecialchars(basename($_FILES[$image]["name"])).$email.date('d-m-y h:i:s');
        $target_dir = "../datauploads/";
        $target_file = $target_dir.basename($_FILES[$image]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                        
        // Check file size
        if($_FILES[$image]["size"] > 500000)
        {
            $imageProcessingMsg = ['response' => false, 'message' => 'Sorry, your file is too large' ];
            return $imageProcessingMsg;
        }
        // Allow certain file formats
        else if($imageFileType != "jpg" && $imageFileType != "pdf" && $imageFileType != "doc"
        && $imageFileType != "pdf" )
        {
            $imageProcessingMsg = ['response' => false, 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed'];
            return $imageProcessingMsg;
        }
        //upload file
        move_uploaded_file($_FILES[$image]["tmp_name"], $target_file);

        $imageProcessingMsg = ['response' => true, 'message' => $filename];
        return $imageProcessingMsg;
    }

    //encrypt the datastring
    function protect($routeValue)
    {
        // Store a string into the variable which
        // need to be Encrypted
        $data = $routeValue."";

        // Store the cipher method
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for encryption
        $encryption_iv = '1234567891011121';

        // Store the encryption key
        $encryption_key = "eyo123";

        // Use openssl_encrypt() function to encrypt the data
        $encryption = openssl_encrypt($data, $ciphering,
        $encryption_key, $options, $encryption_iv);

        return $encryption;
    }

    //decrypt the datastring
    function unprotect($encryptedValue)
    {
        $ciphering = "AES-128-CTR";

        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Non-NULL Initialization Vector for decryption
        $decryption_iv = '1234567891011121';

        // Store the decryption key
        $decryption_key = "eyo123";

        // Use openssl_decrypt() function to decrypt the data
        $decryption = openssl_decrypt ($encryptedValue, $ciphering, 
        $decryption_key, $options, $decryption_iv);

        return $decryption;
    }

    function checkuser($id, $pdo)
    {
        $sql = "SELECT * FROM admin WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            if ($stmt->execute()) {
                // Check if email exists, if yes then verify password
                if ($stmt->rowCount() == 1){
                    if ($row = $stmt->fetch()) {
                        return 2;
                    }
                    return true;
                }
            }
        }
    }

    function returnname($id, $pdo)
    {
        $sql = "SELECT * FROM admin WHERE id = :id";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            if ($stmt->execute()) {
                // Check if email exists, if yes then verify password
                if ($stmt->rowCount() == 1){
                    if ($row = $stmt->fetch()) {
                        return $row["username"];
                    }
                }
            }
        }
    }

    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function implodeArray($array){
        return implode(", ", $array);
    }
}
?>