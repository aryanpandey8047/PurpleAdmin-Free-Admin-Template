<?php

class User
{
    private $dbHost = 'localhost'; 
    private $dbUser = 'root';      
    private $dbPass = '';          
    private $dbName = 'erp_us'; 

    // Method to connect to the database
    private function connect()
    {
        $connection = mysqli_connect($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $connection;
    }

    // Method to fetch user details by ID
    public function getUserDetails($userId)
    {
        $connection = $this->connect();

        $userId = mysqli_real_escape_string($connection, $userId);
        $query = "SELECT * FROM user WHERE md5(id) = '$userId'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result); 
            
            if ($userData) {
                $profileQuery = "SELECT * FROM user_profile WHERE md5(uid) = '$userId' AND is_deleted = 0";
                $profileResult = mysqli_query($connection, $profileQuery);

                if ($profileResult && mysqli_num_rows($profileResult) > 0) {
                    $profileData = mysqli_fetch_assoc($profileResult);
                    mysqli_free_result($profileResult);

                    // Add profile_img_path to the return array, or null if no profile data
                    $userProfile = isset($profileData) ? $profileData['profile_img_path'] : null;

                    $this->disconnect($connection);
                    return ['full_name' => $userData['fname'] . ' ' . $userData['lname'], 'email' => $userData['email'], 'phone_number' => $userData['phone_number'], 'profile_image_path' => $userProfile];
                } else {
                    $this->disconnect($connection);
                    return ['full_name' => $userData['fname'] . ' ' . $userData['lname'], 'email' => $userData['email'], 'phone_number' => $userData['phone_number'], 'profile_image_path' => null];
                }
            } else {
                $this->disconnect($connection);
                return ['full_name' => '', 'email' => '', 'phone_number' => '', 'profile_image_path' => null];
            }
        } else {
            echo "Error executing query: " . mysqli_error($connection);
            $this->disconnect($connection);
        }
    }

    public function getIdfromHash($hash)
    {
        $connection = $this->connect();

        $hash = mysqli_real_escape_string($connection, $hash);
        $query = "SELECT id FROM user WHERE md5(id) = '$hash'";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result); 
            
            if ($userData) {
                $this->disconnect($connection);
                return ['id' => $userData['id']];
            } else {
                $this->disconnect($connection);
                return ['id' => ''];
            }
        } else {
            echo "Error executing query: " . mysqli_error($connection);
            $this->disconnect($connection);
        }
    }

    // Method to fetch user details by email
    public function getUserDetailsEmail($email)
    {
        $connection = $this->connect();

        $email = mysqli_real_escape_string($connection, $email);

        $query = "SELECT id, fname, lname FROM user WHERE email = '$email'";  
        $result = mysqli_query($connection, $query);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result); 
            
            if ($userData) {
                $this->disconnect($connection);
                return ['full_name' => $userData['fname'] . ' ' . $userData['lname'], 'id' => $userData['id']];
            } else {
                $this->disconnect($connection);
                return ['full_name' => '', 'id' => null];
            }
        } else {
            echo "Error executing query: " . mysqli_error($connection);
            $this->disconnect($connection);
        }
    }

    // Method to fetch user details by fname and lname
    public function getUserDetailsbyName($fname, $lname)
    {
        $connection = $this->connect();

        $fname = mysqli_real_escape_string($connection, $fname);

        if (!empty($lname)) {
            $lname = mysqli_real_escape_string($connection, $lname);
            // Query for both fname and lname
            $query = "SELECT id, fname, lname FROM user WHERE fname = '$fname' AND lname = '$lname'";
        } else {
            // Query for either fname or lname
            $query = "SELECT id, fname, lname FROM user WHERE fname like '%$fname%' OR lname like '%$fname%'";
        }

        $result = mysqli_query($connection, $query);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result); 
            
            if ($userData) {
                $this->disconnect($connection);
                return ['full_name' => $userData['fname'] . ' ' . $userData['lname'], 'id' => $userData['id']];
            } else {
                $this->disconnect($connection);
                return ['full_name' => '', 'id' => null];
            }
        } else {
            echo "Error executing query: " . mysqli_error($connection);
            $this->disconnect($connection);
        }
    }

    public function tokengetUserId($token)
    {
        $connection = $this->connect();

        $email = mysqli_real_escape_string($connection, $token);
        $query = "SELECT user_id FROM user_token WHERE user_token='$token' AND is_deleted=0";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result); 
            
            if ($userData) {
                $this->disconnect($connection);
                return $userData['user_id'];
            } else {
                $this->disconnect($connection);
                return null;
            }
        } else {
            $this->disconnect($connection);
            return null;
        }
    }

    public function getUserId($email, $encrypted_password)
    {
        $connection = $this->connect();

        $email = mysqli_real_escape_string($connection, $email);
        $query = "SELECT id FROM user WHERE email='$email' AND md5(pword)='$encrypted_password' AND is_deleted=0";
        $result = mysqli_query($connection, $query);

        if ($result) {
            $userData = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result); 
            
            if ($userData) {
                $this->disconnect($connection);
                return $userData['id'];
            } else {
                $this->disconnect($connection);
                return null;
            }
        } else {
            $this->disconnect($connection);
            return null;
        }
    }

    // Method to disconnect from the database
    private function disconnect($connection)
    {
        if ($connection) {
            mysqli_close($connection);
        }
    }
}

?>