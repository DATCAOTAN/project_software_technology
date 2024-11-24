<?php
    class NhanVienModel extends Database
    {
        // Lấy toàn bộ nhân viên
        public function getAll()
        {
            $sql = "SELECT * FROM `nhan_vien`";
            $result = $this->con->query($sql);
    
            if (!$result) {
                die("Query failed: " . $this->con->error);
            }
    
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
    
            return $users;
        }

        public function getUserById($id)
        {
            $sql = "SELECT nv.*,tk.ten_tai_khoan FROM `nhan_vien` nv INNER JOIN `tai_khoan` tk ON nv.tai_khoan_id=tk.id WHERE nv.id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if (!$result) {
                die("Query failed: " . $this->con->error);
            }

            $user = $result->fetch_assoc();
            return $user;
        }

        public function getAccountIDNotUse()
        {
            $sql = "SELECT * FROM `tai_khoan` WHERE `id` NOT IN (SELECT `tai_khoan_id` FROM `nhan_vien`)";
            $result = $this->con->query($sql);
    
            if (!$result) {
                die("Query failed: " . $this->con->error);
            }
    
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
    
            return $users;
        }
    
        // Thêm nhân viên
        public function addEmployee( $name, $phone, $email, $taikhoanId)
        {
            $sql = "INSERT INTO `nhan_vien`(`ten`, `so_dien_thoai`, `email`, `tai_khoan_id`) VALUES (?, ?, ?, ?)";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ssss", $name, $phone, $email, $taikhoanId);
    
            if ($stmt->execute()) {
                return true;
            } else {
                die("Insert failed: " . $this->con->error);
            }
        }
    
        // Sửa thông tin nhân viên
        public function updateEmployee( $name,$sdt, $email,$taikhoanId, $id)
        {
            $sql = "UPDATE `nhan_vien` SET `ten`=?,`so_dien_thoai`=?,`email`=?,`tai_khoan_id`=? WHERE `id` = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("ssssi", $name, $sdt, $email, $taikhoanId, $id);
    
            if ($stmt->execute()) {
                return true;
            } else {
                die("Update failed: " . $this->con->error);
            }
        }
    
        // Xóa nhân viên
        public function deleteEmployee($id)
        {
            $sql = "DELETE FROM `nhan_vien` WHERE `id` = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $id);
    
            if ($stmt->execute()) {
                return true;
            } else {
                die("Delete failed: " . $this->con->error);
            }
        }
    }
    
?>