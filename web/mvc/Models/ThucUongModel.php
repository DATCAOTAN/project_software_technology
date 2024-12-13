<?php
class ThucUongModel extends Database
{
    public function getAll() {
        $sql = "SELECT * FROM thuc_uong where Trang_thai=False";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Kiểm tra xem có kết quả trả về không
        if ($result->num_rows > 0) {
            $thucUongs = [];
            while ($row = $result->fetch_assoc()) {
                $thucUong = [];
                $thucUong["ID"] = $row["ID"];
                $thucUong["Ten_thuc_uong"] = $row["Ten_thuc_uong"];
                $thucUong["Mo_ta"] = $row["Mo_ta"];
                $thucUong["image_URL"] = $row["image_URL"];
                $thucUongs[] = $thucUong;
            }
            return $thucUongs;
        } else {
            return [];
        }
    }

    public function get_chitiet($id) {
        $id=(int)$id;
        $sql = "SELECT cttu.*, tu.mo_ta,tu.ten_thuc_uong FROM thuc_uong tu JOIN chi_tiet_thuc_uong cttu where tu.ID=cttu.thuc_uong_id and tu.ID=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Kiểm tra xem có kết quả trả về không
        if ($result->num_rows > 0) {
            $thucUongs = [];
            while ($row = $result->fetch_assoc()) {
                $thucUong = [];
                $thucUong["mo_ta"]=$row["mo_ta"];
                $thucUong["ten_thuc_uong"]=$row["ten_thuc_uong"];
                $thucUong["Size"] = $row["Size"];
                $thucUong["Gia_tien"] = $row["Gia_tien"];
                $thucUong["Trang_thai_ban"] = $row["Trang_thai_ban"];
                $thucUongs[] = $thucUong;
            }
            return $thucUongs;
        } else {
            return [];
        }
    }

    public function add($thucuong) {
        // Bắt đầu transa
            $sql = "INSERT INTO Thuc_uong (Ten_thuc_uong, Mo_ta, Trang_thai, image_URL) VALUES (?, ?, ?, ?)";
            $stmt = $this->con->prepare($sql);
            $Trang_thai = 0;
            $stmt->bind_param("ssis", $thucuong['Ten_thuc_uong'], $thucuong['Mo_ta'], $Trang_thai, $thucuong['image_URL']);
            $stmt->execute();
    
            // Lấy ID của thức uống mới thêm
            $new_id = $this->con->insert_id;
    
            // Tạo tên file hình ảnh và cập nhật
            $image_URL = "image" . $new_id . ".jpg";
            $stmt2 = $this->con->prepare("UPDATE Thuc_uong SET image_URL = ? WHERE ID = ?");
            $stmt2->bind_param("si", $image_URL, $new_id);
            $stmt2->execute();
    
            // Thêm chi tiết vào bảng Chi_tiet_thuc_uong
            $sql2 = "INSERT INTO Chi_tiet_thuc_uong (Thuc_uong_ID, Size, Gia_tien, Trang_thai_ban) VALUES (?, ?, ?, ?)";
            $stmt3 = $this->con->prepare($sql2);
    
            // Danh sách size
            $sizes = ['S', 'M', 'L'];
            foreach ($sizes as $size) {
                $gia_tien = $thucuong['Gia_tien_' . $size];
                $trang_thai_ban = $thucuong['Trang_thai_ban_' . $size];
                $stmt3->bind_param("isds", $new_id, $size, $gia_tien, $trang_thai_ban);
                $stmt3->execute();
            }
    
            // Commit transaction nếu mọi thứ thành công
            $this->con->commit();
    
            return $new_id;
    }
    

    
    public function delete($ID) {
        $ID = (int)$ID; // Chuyển ID thành kiểu số nguyên để đảm bảo an toàn
        // $imagePath = 'public/images/thuc_uong/' . 'image'.$ID.'.jpg';
        // if (file_exists($imagePath)) {
        //     unlink($imagePath); // Xóa file ảnh từ thư mục
        // }
        // // Xóa chi tiết thức uống liên quan trong bảng Chi_tiet_thuc_uong
        // $sql_chitiet = "DELETE FROM Chi_tiet_thuc_uong WHERE Thuc_uong_ID = ?";
        // $stmt_chitiet = $this->con->prepare($sql_chitiet);
        // $stmt_chitiet->bind_param("i", $ID);
        // $stmt_chitiet->execute();
    
        // // Xóa thức uống trong bảng Thuc_uong
        // $sql_thucuong = "UPDATE Thuc_uong SET Ten_thuc_uong = ?, Mo_ta = ? WHERE ID = ?";
        // $stmt_thucuong = $this->con->prepare($sql_thucuong);
        // $stmt_thucuong->bind_param("i", $ID);
        // $stmt_thucuong->execute();

        $sql_thucuong = "UPDATE Thuc_uong SET Trang_thai=True WHERE ID = ?";
        $stmt_thucuong = $this->con->prepare($sql_thucuong);
        $stmt_thucuong->bind_param("i", $ID);
        $stmt_thucuong->execute();
    
    
        // Kiểm tra kết quả
        if ($stmt_thucuong->affected_rows > 0) {
            return true; // Xóa thành công
        } else {
            return false; // Xóa thất bại hoặc ID không tồn tại
        }
    }

    public function edit($ID, $drinkData, $check)
{
    $ID = (int)$ID;  // Đảm bảo ID là kiểu số nguyên
    // Cập nhật thông tin cơ bản của thức uống trong bảng Thuc_uong
    $sql = "UPDATE Thuc_uong SET Ten_thuc_uong = ?, Mo_ta = ? WHERE ID = ?";
    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("ssi", $drinkData['Ten_thuc_uong'], $drinkData['Mo_ta'], $ID);
    $stmt->execute();
    // Lưu trữ tổng số dòng bị ảnh hưởng
    $affectedRows = $stmt->affected_rows;
    // Cập nhật chi tiết thức uống trong bảng Chi_tiet_thuc_uong
    $sizes = ['S', 'M', 'L'];
    foreach ($sizes as $size) {
        $sql_detail = "UPDATE Chi_tiet_thuc_uong SET Gia_tien = ?, Trang_thai_ban = ? WHERE Thuc_uong_ID = ? AND Size = ?";
        $stmt_detail = $this->con->prepare($sql_detail);
        $gia_tien = $drinkData['Gia_tien_' . $size];
        $trang_thai = $drinkData['Trang_thai_ban_' . $size];
        $stmt_detail->bind_param("dsis", $gia_tien, $trang_thai, $ID, $size);
        $stmt_detail->execute();
        // Cộng dồn số dòng bị ảnh hưởng từ mỗi lần cập nhật
        $affectedRows += $stmt_detail->affected_rows;
    }
    // Kiểm tra kết quả tổng thể và trả về trạng thái
    if ($affectedRows > 0) {
        return true;  // Có sự thay đổi
    } else {
        return false; // Không có sự thay đổi nào
    }
}

public function searchByName($keyword) {
    // Thêm ký tự % vào trước và sau từ khóa để tìm kiếm gần đúng (LIKE)
    $searchPattern = "%" . $keyword . "%";

    // Câu truy vấn SQL sử dụng LIKE để tìm kiếm tên thức uống chứa từ khóa
    $sql = "SELECT * FROM Thuc_uong WHERE Ten_thuc_uong LIKE ? AND Trang_thai = False";
    
    $stmt = $this->con->prepare($sql);
    $stmt->bind_param("s", $searchPattern);  // Gán tham số vào câu truy vấn
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra xem có kết quả trả về không
    if ($result->num_rows > 0) {
        $thucUongs = [];
        while ($row = $result->fetch_assoc()) {
            $thucUong = [];
            $thucUong["ID"] = $row["ID"];
            $thucUong["Ten_thuc_uong"] = $row["Ten_thuc_uong"];
            $thucUong["Mo_ta"] = $row["Mo_ta"];
            $thucUong["image_URL"] = $row["image_URL"];
            $thucUongs[] = $thucUong;
        }
        return $thucUongs;  // Trả về danh sách thức uống tìm được
    } else {
        return [];  // Trả về mảng rỗng nếu không có kết quả
    }
}



    
    
    
 
}
