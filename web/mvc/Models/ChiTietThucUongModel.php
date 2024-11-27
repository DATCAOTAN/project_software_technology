<?php
class ChiTietThucUongModel extends Database
{
    public function getAll() {
        $sql = "SELECT * FROM chi_tiet_thuc_uong";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Kiểm tra xem có kết quả trả về không
        if ($result->num_rows > 0) {
            $CTthucUongs = [];
            while ($row = $result->fetch_assoc()) {
                $CTthucUong = [];
                $CTthucUong["Thuc_uong_ID"] = $row["Thuc_uong_ID"];
                $CTthucUong["Size"] = $row["Size"];
                $CTthucUong["Gia_tien"] = $row["Gia_tien"];
                $CTthucUong["Trang_thai_ban"] = $row["Trang_thai_ban"];
                $CTthucUongs[] = $CTthucUong;
            }
            return $CTthucUongs;
        } else {
            return [];
        }
    }
 
}
    
    
    
    
    


?>