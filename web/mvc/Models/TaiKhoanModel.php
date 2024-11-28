<?php
class TaiKhoanModel extends Database
{

    public function getAll()
    {
        $sql = "SELECT * FROM `tai_khoan` where id!=1";
        $result = $this->con->query($sql);

        // Kiểm tra lỗi
        if (!$result) {
            die("Query failed: " . $this->con->error);
        }

        // Chuyển kết quả thành mảng
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    // Thêm nhân viên
    public function addAccount($name, $pass)
    {
        $sql = "INSERT INTO `tai_khoan`(`ten_tai_khoan`, `mat_khau`) VALUES (?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ss", $name, $pass);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Insert failed: " . $this->con->error);
        }
    }

    // Sửa thông tin nhân viên  
    public function updateAccount($name, $pass, $id)
    {
        $sql = "UPDATE `tai_khoan` SET `ten_tai_khoan`=?,`mat_khau`=? WHERE `id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ssi", $name, $pass, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Update failed: " . $this->con->error);
        }
    }

    // Xóa nhân viên
    public function deleteAccount($id)
    {
        $sql = "DELETE FROM `tai_khoan` WHERE `id` = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Delete failed: " . $this->con->error);
        }
    }

    public function getAccountById($id)
    {
        $sql = "SELECT * FROM `tai_khoan` WHERE id=?";
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

    public function checkAccount($id)
    {
        $sql = "SELECT * FROM `nhan_vien` WHERE tai_khoan_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return true; // Tài khoản đã có nhân viên sử dụng
        } else {
            return false;
        }
    }
}