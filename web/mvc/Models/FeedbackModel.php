<?php
class FeedbackModel extends Database
{
    // Lấy tất cả phản hồi
    public function getAllFeedback()
    {
        $sql = "
                SELECT 
                    phan_hoi.id, 
                    khach_hang.ten_khach_hang, 
                    phan_hoi.hoa_don_id, 
                    phan_hoi.so_sao, 
                    phan_hoi.noi_dung, 
                    phan_hoi.ngay_gio
                FROM 
                    phan_hoi
                INNER JOIN 
                    hoa_don ON phan_hoi.hoa_don_id = hoa_don.id
                INNER JOIN 
                    khach_hang ON hoa_don.khach_hang_id = khach_hang.id
                ORDER BY 
                    phan_hoi.ngay_gio DESC";
        $result = $this->con->query($sql);
        $feedbackList = [];
        while ($row = $result->fetch_assoc()) {
            $feedbackList[] = $row;
        }
        return $feedbackList;
    }

    // Lấy tổng số phản hồi
    public function getTotalFeedback()
    {
        $sql = "SELECT COUNT(*) AS total_feedback FROM phan_hoi";
        $result = $this->con->query($sql);
        return $result->fetch_assoc()['total_feedback'];
    }

    // Lấy thống kê tổng quan về phản hồi
    public function getFeedbackSummary()
    {
        $sql = "SELECT 
                    COUNT(*) AS total_feedback,
                    ROUND(AVG(so_sao), 1) AS average_rating, 
                    SUM(CASE WHEN so_sao >= 4 THEN 1 ELSE 0 END) AS positive_feedback,
                    SUM(CASE WHEN so_sao < 4 THEN 1 ELSE 0 END) AS negative_feedback 
                FROM phan_hoi";
        $result = $this->con->query($sql);
        return $result->fetch_assoc();
    }


    //Thêm phản hồi vào cơ sở dữ liệu.
    public function addFeedback($ten_khach_hang, $hoa_don_id, $so_sao, $noi_dung) {
        // Kiểm tra xem phản hồi cho hóa đơn đã tồn tại hay chưa
        $checkQuery = "SELECT id FROM phan_hoi WHERE hoa_don_id = ?";
        $stmt = $this->con->prepare($checkQuery);
        $stmt->bind_param("i", $hoa_don_id);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            // Đã có phản hồi cho hóa đơn, không thêm phản hồi mới
            $stmt->close();
            return false; // Trả về false để báo lỗi hoặc ngăn thêm phản hồi
        }
        $stmt->close();
    
        // Kiểm tra nếu tên khách hàng không rỗng thì cập nhật
        if (!empty($ten_khach_hang)) {
            $updateQuery = "UPDATE khach_hang 
                            SET ten_khach_hang = ? 
                            WHERE id = (
                                SELECT khach_hang_id FROM hoa_don WHERE id = ?
                            )";
            $stmt = $this->con->prepare($updateQuery);
            if ($stmt) {
                $stmt->bind_param("si", $ten_khach_hang, $hoa_don_id);
                $stmt->execute();
                $stmt->close();
            }
        }
    
        // Thêm phản hồi mới vào bảng phan_hoi
        $insertQuery = "INSERT INTO phan_hoi (hoa_don_id, so_sao, noi_dung) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($insertQuery);
        if ($stmt) {
            $stmt->bind_param("iis", $hoa_don_id, $so_sao, $noi_dung);
            $result = $stmt->execute();
            $stmt->close();
            return $result; // Trả về kết quả thêm phản hồi
        }
        return false;
    }
    

    public function isHoaDonExists($hoaDonId) {
        // Tạo và chuẩn bị câu truy vấn
        $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM phan_hoi WHERE hoa_don_id = ?");
        $stmt->bind_param("i", $hoaDonId);
        
        // Thực thi truy vấn và lấy kết quả
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
    
        // Đóng statement và trả về kết quả
        $stmt->close();
        return $result['count'] > 0;
    }
}
?>
