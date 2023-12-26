<?php 
    class user {
        private $db;
        private $userId;

        private $username;
        private $password;
        private $email;
        private $role;

        public function __construct(PDO $db) {
            $this->db = $db;
        }
        public function getUserId() {
            return $this->userId;
        }

        public function setUserId($userId) {
            $this->userId = $userId;
        }
        public function getUsername() {
            return $this->username;
        }

        public function setUsername($username) {
            $this->username = $username;
        }

        public function getPassword() {
            return $this->password;
        }

        public function setPassword($password) {
            $this->password = $password;
        }

        public function getEmail() {
            return $this->email;
        }

        public function setEmail($email) {
            $this->email = $email;
        }
        public function getRole() {
            return $this->role;
        }

        public function setRole($role) {
            $this->role = $role;
        }
        public function saveUserPro() {
            try {
                $sql= " UPDATE user
                        SET username = :username,
                            email = :email
                        WHERE userId = :userId;";
                    
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':username', $this->username);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':userId', $this->userId);
    
                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function getUserById($id) {
            $stmt = $this->db->prepare("SELECT * FROM user WHERE userId = :userId");
            $stmt->bindParam(':userId', $id);
            $stmt->execute();
            $result = $stmt->fetch();

            return $result;
        }
        public function checkUser($username, $password){
            try {
                $stmt = $this->db->prepare("SELECT * FROM user WHERE username = :username AND password = :password");
                $stmt->bindValue(':username', $username);
                $stmt->bindValue(':password', $password);
                $stmt->execute();
                
                $rowCount = $stmt->rowCount();
            
                if ($rowCount > 0) {
                    $result = $stmt->fetch();
                    $role = $result['role'];
                    return $role;
                } else {
                    return $role = 3;
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
        public function isUsernameTaken($username)
        {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM user WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        }
        public function isEmailTaken($email)
        {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        }

        public function insertUser($username, $password, $email)
        {
            try {
                $stmt = $this->db->prepare("INSERT INTO user (username, password, email, role) VALUES (?, ?, ?, 0)");

                $stmt->bindParam(1, $username, PDO::PARAM_STR);
                $stmt->bindParam(2, $password, PDO::PARAM_STR);
                $stmt->bindParam(3, $email, PDO::PARAM_STR);

                $stmt->execute();

                return true;
            } catch (PDOException $e) {
                return false;
            }
        }
        public function getUserIdFromData($username)
        {
            $stmt = $this->db->prepare("SELECT userId FROM user WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();
            $userId = $result['userId'];

            return $userId;
        }
        public function getAllUserAd(){
            try {
                $sql = "SELECT * FROM user";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                
                $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
                return $userData;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function deleteUser($userId) {
            try {
                $sql = "DELETE FROM user WHERE userId = :userId";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
        
                $rowCount = $stmt->rowCount();
        
                return $rowCount > 0;
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function setRoleToDB() {
            try {
                $sql= " UPDATE user
                        SET role = :role
                        WHERE userId = :userId;";
                    
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':role', $this->role);
                $stmt->bindParam(':userId', $this->userId);
    
                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function countAllUsers() {
            try {
                $sql = "SELECT COUNT(*) as count FROM user";
                $stmt = $this->db->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['count'];
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function getEmailById($userId)
        {
            try {
                $sql = "SELECT email FROM user WHERE userId = :userId";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    return $result['email'];
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function isPasswordCorrect($password, $userId)
        {
            try {

                $sql = "SELECT password FROM user WHERE userId = :userId";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();
        
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result) {
                    $passwordFromDatabase = $result['password'];
                    
                    return $password === $passwordFromDatabase;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function changePassword($newPassword)
        {
            try {
                $sql = "UPDATE user SET password = :password WHERE userId = :userId";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
                $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    return true; 
                } else {
                    return false; 
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        public function updatePass($email, $newPass)
        {
            try {
                $sql = "UPDATE user SET password = :password WHERE email = :email";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':password', $newPass, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
        
                if ($stmt->rowCount() > 0) {
                    return true; 
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
        }
        

    }
?>