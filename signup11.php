    <?php
    require_once 'database_connection.php';
    
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Handle file upload
        $target_dir = "profile_images/";
        $target_file = $target_dir . basename($_FILES["profile-photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["profile-photo"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "<script>alert('File is not an image.');
                window.location.href = 'signup.php';
                </script>";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<script>alert('Sorry, file already exists.');
            window.location.href = 'signup.php';
            </script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile-photo"]["size"] > 500000) {
            echo "<script>alert('Sorry, your file is too large.');
            window.location.href = 'signup.php';
            </script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
            window.location.href = 'signup.php';
            </script>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<script>alert('Sorry, your file was not uploaded.');
            window.location.href = 'signup.php';
            </script>";        
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["profile-photo"]["tmp_name"], $target_file)) {
                // echo "The file " . basename($_FILES["profile-photo"]["name"]) . " has been uploaded.";

                // Insert user into the database
                $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, username, password, profile_photo_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $fullname, $email, $phone, $username, $password, $target_file);

                if ($stmt->execute()) {
                    echo "<script>alert('Registered successfully!');
                    window.location.href = 'login.php';
                    </script>";;
                } else {
                    echo "<script>alert('Please try again');
                    window.location.href = 'signup.php';
                    </script>";
                }

                $stmt->close();
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');
                window.location.href = 'signup.php';
                </script>";            
            }
        }
    }

    $conn->close();
    ?>
