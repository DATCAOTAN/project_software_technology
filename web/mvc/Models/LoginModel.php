<?php
    class LoginModel extends Database{
        public function getUser($userName, $matKhau){
            $sql = "select id,ten_tai_khoan,mat_khau from tai_khoan where ten_tai_khoan=? and mat_khau=?;";
            $stmt = $this->con->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ss", $userName,$matKhau);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return $user;
                } else {
                    return [];
                }
            } else {
                echo "Failed to prepare the SQL statement.";
                exit();
            }
        }
    }
?>