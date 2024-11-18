<?php
class HomeModel extends Database{
    public function getthongtintaikhoan($id){
        $sql = "SELECT ten,email,ngay_sinh,gioi_tinh,hinh from thong_tin_tai_khoan where id_taikhoan=?;";
        $stmt = $this->con->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id);
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
    public function getTinhNangByQuyen($idUser) {
        // Chuẩn bị câu truy vấn SQL với tham số đầu vào
        $sql = "SELECT tn.ten
                FROM phan_quyen AS pq
                JOIN quyen AS q ON pq.ID_Quyen = q.ID
                JOIN tinh_nang AS tn ON tn.ID = pq.ID_TinhNang
                JOIN chuc_nang AS cn ON cn.ID = pq.ID_chucNang
                JOIN tai_khoan AS tk ON q.ID = tk.ID_Quyen
                WHERE tk.ID = ? AND cn.ten = 'view';";
    
        // Chuẩn bị câu truy vấn
        $stmt = $this->con->prepare($sql);
    
        // Kiểm tra câu truy vấn đã chuẩn bị được không
        if ($stmt) {
            // Gán giá trị cho tham số và thực thi câu truy vấn
            $stmt->bind_param("s", $idUser);
            $stmt->execute();
    
            // Lấy kết quả trả về
            $result = $stmt->get_result();
    
            // Kiểm tra và xử lý kết quả
            if ($result->num_rows > 0) {
                $tinhNangArray = [];
                while ($row = $result->fetch_assoc()) {
                    $tinhNangArray[] = $row['ten'];
                }
                return $tinhNangArray; // Trả về mảng các tên tính năng
            } else {
                return []; // Trả về mảng rỗng nếu không tìm thấy kết quả
            }
        } else {
            echo "Failed to prepare the SQL statement.";
            return false;
        }
    } 
}
?>