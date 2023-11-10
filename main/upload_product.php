<?php require 'includes/db.php' ?>
<link rel="stylesheet" href="styles/upload/upload.css">
<script src="script.js"></script>

<!-- create GUI section to upload new product -->
<!-- use the php in current upload.php -->

<?php  

        if($_SERVER["REQUEST_METHOD"] == 'POST'){

            $user_name = $_COOKIE["CookieUname"];
            if(empty($user_name)){
                echo "no user";
            }
            $sql = "SELECT mId FROM `Member` WHERE `user_name`='$user_name'";
            $users = $db -> query($sql);
            $users = $users -> fetch();
            
            $SQL = "SELECT publicKey FROM Seller WHERE mId='$users[0]'";
            $has_publicKey = $db -> query($SQL);
            $has_publicKey = $has_publicKey -> fetch();
            if(empty($has_publicKey[0])){
                // echo "right_here";
                echo "nopublickey";
                // echo "<script>alert('wrong!!')</script>";
                // header("Location: dashboard.php?user_name=%27".$user_name."%27");
            }
            else{
                // retrive data from upload form
                echo $_FILES["get_image_path"]["error"];
                
            
                $pname = $_POST["pName"];
                $unitPrice = $_POST["unitPrice"];
                $image_path = $_FILES["get_image_path"];
                $category = $_POST["category"];
                $description = $_POST["description"];
                $pStock = $_POST["pStock"];
                $heartNum = 0;
                $hashtags = $_POST["hashtags"];

                
                // // process image path 
                $targetPath = "images/" . $_FILES["get_image_path"]["name"];
                $fileName = $_FILES["get_image_path"]["name"];
                echo $image_path["error"];
            

                // // identify user_name and insert user_id to product table
            
                // echo $_FILES["image_path"]["tmp_name"];
                echo $targetPath;
            
                // move image from temp location to designate location 
                if (move_uploaded_file($_FILES["get_image_path"]["tmp_name"], $targetPath)){
                    echo "hello";
                
                    $sql = "INSERT INTO `Product`(`pName`, `pImage`, `unitPrice`, `category`, `description`, `pStock`,`heartNum`, `mId`, `hashtag`) 
                            VALUES ('$pname','$fileName','$unitPrice','$category', '$description', '$pStock','$heartNum', '$users[0]', '$hashtags')";
                    echo $sql;
                    if($db->exec($sql)){
                        echo "<script>alert('successfully uploaded!!')</script>";
                        // header("Location: dashboard.php");
                    }
                    else{
                        echo "<script>alert('failed to upload')</script>";
                    }
                }
                else{
                    echo "failed to upload";
                } 
            }
        }
    

?>