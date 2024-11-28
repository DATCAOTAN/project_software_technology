<?php
class BankModel extends Database
{
    // Lấy tất cả phương thức thanh toán
    public function getAll() {
        $sql = "SELECT * FROM phuong_thuc_thanh_toan";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $banks = [];
            while ($row = $result->fetch_assoc()) {
                $bank = [];
                $bank["id"] = $row["id"];
                $bank["ten"] = $row["ten"];
                $banks[] = $bank;
            }
            return $banks;
        } else {
            return [];
        }
    }

    // Lấy chi tiết phương thức thanh toán theo ID
    public function chi_tiet($id) {
        $sql = "SELECT * FROM chi_tiet_phuong_thuc_thanh_toan WHERE phuong_thuc_thanh_toan_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $detail = [];
                $detail["phuong_thuc_thanh_toan_id"] = $row["phuong_thuc_thanh_toan_id"];
                $detail["ten"] = $row["ten"];
                $detail["fee"] = $row["fee"];
                $detail["id"] = $row["id"];
                $details[] = $detail;
            }
            return $details;
        } else {
            return [];
        }
    }

    public function get_all_chi_tiet() {
        $sql = "SELECT * FROM chi_tiet_phuong_thuc_thanh_toan ";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $details = [];
            while ($row = $result->fetch_assoc()) {
                $detail = [];
                $detail["id"] = $row["id"];
                $detail["phuong_thuc_thanh_toan_id"]=$row["phuong_thuc_thanh_toan_id"];
                $detail["ten"] = $row["ten"];
                $detail["fee"] = $row["fee"];
                $details[] = $detail;
            }
            return $details;
        } else {
            return [];
        }
    }


    // Thêm chi tiết mới
    public function addDetail($data) {
        $sql = "INSERT INTO chi_tiet_phuong_thuc_thanh_toan (phuong_thuc_thanh_toan_id, ten, fee) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("isd", $data['phuong_thuc_thanh_toan_id'], $data['ten'], $data['fee']);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Chỉnh sửa chi tiết
    public function editDetail($id, $data) {
        $sql = "UPDATE chi_tiet_phuong_thuc_thanh_toan SET ten = ?, fee = ? WHERE id = ? and phuong_thuc_thanh_toan_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("sdii", $data['ten'], $data['fee'], $id,$data['phuong_thuc_thanh_toan_id']);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Xóa chi tiết theo ID
    public function deleteDetail($id,$phuong_thuc_thanh_toan_id) {
        $sql = "DELETE FROM chi_tiet_phuong_thuc_thanh_toan WHERE id = ? and phuong_thuc_thanh_toan_id=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $id,$phuong_thuc_thanh_toan_id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
