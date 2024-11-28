<?php
class FeedbackModel extends Database
{
    // Lấy tất cả phản hồi
    public function getAllFeedback()
    {
        $sql = "SELECT * FROM phan_hoi ORDER BY ngay_gio DESC";
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
        // Chuẩn bị câu lệnh SQL
        $query = "INSERT INTO phan_hoi (ten_khach_hang, hoa_don_id, so_sao, noi_dung)
                  VALUES (?, ?, ?, ?)";
        
        // Chuẩn bị và thực thi câu lệnh SQL
        $stmt = mysqli_prepare($this->con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "siis", $ten_khach_hang, $hoa_don_id, $so_sao, $noi_dung);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            return $result; // Trả về kết quả
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
