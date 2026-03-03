<?php 
    session_start();
    $username = $email = $password = NULL;
    function handle_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function get_users_count($__users_data_path) {
        $user_count = 0;
        $lines = file($__users_data_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if($lines) {
            $lastline = end($lines);
            $parts = explode(",", $lastline);
            $user_count = (int)$parts[0] + 1;
        } else {
            $user_count = 1;
        }
        
        return $user_count;
    }

    function check_existed_user($__users_data_path, $__username, $__email) {
        $users_data = fopen($__users_data_path, "r");
        while(($data = fgetcsv($users_data)) !== FALSE) {
            $existing_username = $data[1];
            $existing_email = $data[2];

            if($existing_username === $__username || $existing_email === $__email) {
                fclose($users_data);
                return TRUE;
            }
        }
        fclose($users_data);
        return FALSE;
    }

    if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
        $username = handle_input($_POST["username"]);
        $email = handle_input($_POST["email"]);
        $password = password_hash(handle_input($_POST["password"]), PASSWORD_DEFAULT);

        $users_data_path = "../data/users.csv";
        $user_id = get_users_count($users_data_path);
        if(check_existed_user($users_data_path, $username, $email) == TRUE) {
            $_SESSION["error"] = "Use a different username or email";
            header("Location: ./login.php");
            exit();
        }
        
        $users_data = fopen($users_data_path, "a+");
        if(filesize($users_data_path) > 0)
            fputs($users_data, "\n$user_id,$username,$email,$password");
        else
            fputs($users_data, "$user_id,$username,$email,$password");
        fclose($users_data);
    }

    header("Location: ./login.php");
    exit();
?>