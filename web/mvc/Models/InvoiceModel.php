<?php
class InvoiceModel extends Database{
        // Lấy danh sách hóa đơn theo trạng thái
    public function getHoaDonsByStatus($status) {
        $stmt = $this->con->prepare("SELECT id, khach_hang_id, tong_tien, trang_thai, ngay_gio FROM hoa_don WHERE trang_thai = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $hoaDons = [];
        while ($row = $result->fetch_assoc()) {
            $hoaDons[] = $row;
        }
        $stmt->close();
        return $hoaDons;
    }

    // Cập nhật trạng thái đơn hàng
    public function updateHoaDonStatus($hoaDonId, $newStatus) {
        $stmt = $this->con->prepare("UPDATE hoa_don SET trang_thai = ? WHERE id = ?");
        $stmt->bind_param("si", $newStatus, $hoaDonId);
        $stmt->execute();
        $updated = $stmt->affected_rows > 0;
        $stmt->close();
        return $updated;
    }

    // Lấy thông tin chi tiết hóa đơn
    public function getInvoiceDetailsByHoaDonId($hoaDonId) {
        $stmt = $this->con->prepare("
            SELECT tu.Ten_thuc_uong, cthd.size, cthd.so_luong
            FROM chi_tiet_hoa_don AS cthd
            JOIN Thuc_uong AS tu ON cthd.thuc_uong_id = tu.ID
            WHERE cthd.hoa_don_id = ?
        ");
        $stmt->bind_param("i", $hoaDonId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function updateOrderStatus($hoaDonId, $newStatus, $id_nhanvien) {
        $stmt = $this->con->prepare("UPDATE hoa_don SET trang_thai = ?, nhan_vien_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $newStatus, $id_nhanvien, $hoaDonId);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>