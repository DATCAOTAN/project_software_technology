<?php
    class NhanVienModel extends Database
    {
        // Lấy toàn bộ nhân viên
        public function getAll()
        {
            $sql = "SELECT * FROM `nhan_vien` where Trang_thai=False";
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
            $sql = "SELECT * FROM `tai_khoan` WHERE `id` NOT IN (SELECT `tai_khoan_id` FROM `nhan_vien`) and id!=1";
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
            // Chuyển ID thành kiểu số nguyên để đảm bảo an toàn
            $id = (int)$id;
        
            // Chuẩn bị truy vấn UPDATE để xóa mềm (đặt trạng thái là 1)
            $sql = "UPDATE `nhan_vien` SET Trang_thai = 1 WHERE `id` = ?";
            $stmt = $this->con->prepare($sql);
        
            // Kiểm tra lỗi trong quá trình prepare
            if (!$stmt) {
                die("Lỗi chuẩn bị truy vấn: " . $this->con->error);
            }
        
            // Gán giá trị tham số và thực thi câu lệnh
            $stmt->bind_param("i", $id);
        
            if ($stmt->execute()) {
                // Kiểm tra số hàng bị ảnh hưởng
                if ($stmt->affected_rows > 0) {
                    echo "Xóa nhân viên thành công!";
                    return true;
                } else {
                    // Không tìm thấy nhân viên với ID này
                    echo "Không tìm thấy nhân viên với ID: " . $id;
                    return false;
                }
            } else {
                // Xử lý lỗi trong quá trình thực thi
                echo "Lỗi xóa nhân viên: " . $stmt->error;
                return false;
            }
        }
        
    }
        
    
?>