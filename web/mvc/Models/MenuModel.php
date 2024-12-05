<?php 
    require_once __DIR__ . '/../DTO/DrinkDTO.php';
    require_once __DIR__ . '/../DTO/PaymentMethodDTO.php';
    class MenuModel extends Database {

        public function getTotalDrinks(): int {
            $sql = "SELECT COUNT(*) AS total FROM Thuc_uong WHERE Trang_thai = '0'";
            $stmt = $this->con->prepare($sql);
            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                return (int) $row['total'];
            }
            throw new Exception("Failed to prepare statement.");
        }

        public function getAllDrinksWithDetails(int $page = 1, int $itemsPerPage = 6): array {
            // Lấy toàn bộ danh sách đồ uống
            $allDrinks = $this->getAllDrinks(); // Không phân trang ở đây
        
            // Mảng để lưu đồ uống hợp lệ
            $validDrinks = [];
        
            foreach ($allDrinks as $drink) {
                // Lấy chi tiết của đồ uống
                $details = $this->getDrinkDetails($drink->getId());
        
                // Chỉ thêm đồ uống nếu có chi tiết
                if (!empty($details)) {
                    foreach ($details as $detail) {
                        $drink->addDetail(
                            $detail['size'],
                            $detail['price'],
                            $detail['status']
                        );
                    }
                    $validDrinks[] = $drink; // Thêm đồ uống vào danh sách hợp lệ
                }
            }
        
            // Phân trang danh sách hợp lệ
            $totalDrinks = count($validDrinks);
            $offset = ($page - 1) * $itemsPerPage;
            $pagedDrinks = array_slice($validDrinks, $offset, $itemsPerPage);
        
            return $pagedDrinks;
        }

        public function getDrinkDetails(int $drinkId): array {
            $sql = "
                SELECT 
                    Size AS size, 
                    Gia_tien AS price, 
                    Trang_thai_ban AS status
                FROM Chi_tiet_thuc_uong
                WHERE Thuc_uong_ID = ? and Trang_thai_ban='Dang ban'
            ";
        
            $stmt = $this->con->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("i", $drinkId);
                $stmt->execute();
                $result = $stmt->get_result();
        
                $details = [];
                while ($row = $result->fetch_assoc()) {
                    $details[] = [
                        'size' => $row['size'],
                        'price' => (float) $row['price'],
                        'status' => $row['status']
                    ];
                }
        
                return $details;
            }
        
            throw new Exception("Failed to prepare statement.");
        }
        
        public function getAllDrinks(): array {
        
            $sql = "
                SELECT 
                    tu.ID AS drink_id, 
                    tu.Ten_thuc_uong AS name, 
                    tu.Mo_ta AS description, 
                    tu.image_URL AS image_url
                FROM Thuc_uong tu
                WHERE Trang_thai = '0'
            ";
        
            $stmt = $this->con->prepare($sql);
            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();
        
                $drinks = [];
                while ($row = $result->fetch_assoc()) {
                    $drink = new DrinkDTO(
                        $row['drink_id'],
                        $row['name'],
                        $row['description'],
                        $row['image_url']
                    );
                    $drinks[] = $drink;
                }
                return $drinks; // Trả về mảng các đối tượng DrinkDTO
            }
        
            throw new Exception("Failed to prepare statement.");
        }       

        public function getAllPaymentMethods(): array {
            $sql = "
                SELECT 
                    pt.id AS method_id, 
                    pt.ten AS method_name,
                    cpt.id AS detail_id, 
                    cpt.ten AS detail_name,
                    cpt.fee AS detail_fee
                FROM phuong_thuc_thanh_toan pt
                LEFT JOIN chi_tiet_phuong_thuc_thanh_toan cpt 
                ON pt.id = cpt.phuong_thuc_thanh_toan_id
            ";
        
            $stmt = $this->con->prepare($sql);
            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();
                $paymentMethods = [];
        
                // Xử lý dữ liệu
                while ($row = $result->fetch_assoc()) {
                    $methodId = (int)$row['method_id'];
                    $methodName = $row['method_name'];
                    $detailName = $row['detail_name'] ?? null;
                    $detailFee = $row['detail_fee'] ?? null;
        
                    // Kiểm tra xem phương thức đã tồn tại trong danh sách chưa
                    if (!isset($paymentMethods[$methodId])) {
                        $paymentMethods[$methodId] = new PaymentMethodDTO($methodId, $methodName);
                    }
        
                    // Nếu có chi tiết thì thêm vào
                    if ($detailName !== null && $detailFee !== null) {
                        $paymentMethods[$methodId]->addDetail($detailName, (float)$detailFee);
                    }
                }
        
                return array_values($paymentMethods); // Trả về danh sách DTO
            }
        
            throw new Exception("Failed to prepare statement.");
        }        

        public function createUser(){
            $ten_khach_hang = "Ẩn danh";
            $so_dien_thoai = null;
            $email = null;

            $sql = "INSERT INTO khach_hang (ten_khach_hang, so_dien_thoai, email) VALUES (?, ?, ?)";
            
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("sss", $ten_khach_hang, $so_dien_thoai, $email);
            $stmt->execute();

            $newCustomerId = $stmt->insert_id; // Lấy ID vừa tạo
            $stmt->close();
        
            return $newCustomerId;
        }
        
        public function createInvoice(int $khachHangId, int $tongTien, int $phuongThucThanhToanId, array $chiTietThucUong) {
            // Bắt đầu giao dịch
            $this->con->begin_transaction();
            
            try {
                // Tạo bản ghi hóa đơn mới
                $sql = "
                    INSERT INTO hoa_don (khach_hang_id, nhan_vien_id, ngay_gio, tong_tien, trang_thai, trang_thai_thanh_toan, phuong_thuc_thanh_toan_id)
                    VALUES (?, null, NOW(), ?, 'Dang lam', TRUE, ?)
                ";
                $stmt = $this->con->prepare($sql);
                $stmt->bind_param("idi", $khachHangId, $tongTien, $phuongThucThanhToanId);
                $stmt->execute();
    
                // Lấy ID của hóa đơn vừa tạo
                $hoaDonId = $stmt->insert_id;
    
                // Thêm chi tiết thức uống vào bảng chi_tiet_hoa_don
                $sqlDetail = "
                    INSERT INTO chi_tiet_hoa_don (hoa_don_id, thuc_uong_id, size, so_luong)
                    VALUES (?, ?, ?, ?)
                ";
                $stmtDetail = $this->con->prepare($sqlDetail);
                // Thêm từng chi tiết thức uống vào hóa đơn
                foreach ($chiTietThucUong as $chiTiet) {
                    $stmtDetail->bind_param("iiss", $hoaDonId, $chiTiet['id'], $chiTiet['size'], $chiTiet['quantity']);
                    $stmtDetail->execute();
                }
    
                // Cam kết giao dịch
                $this->con->commit();
    
                // Đóng statement
                $stmt->close();
                $stmtDetail->close();
                
                return $hoaDonId; // Trả về ID của hóa đơn vừa tạo
            } catch (Exception $e) {
                // Rollback nếu có lỗi
                $this->con->rollback();
                throw $e;  // Ném lại lỗi để có thể xử lý ở tầng cao hơn
            }
        }
        public function getInvoicesByCustomerId(int $customerId) {
            // SQL để lấy tất cả các hóa đơn của khách hàng
            $sql = "
                SELECT h.id AS hoa_don_id, 
                    h.ngay_gio, 
                    h.tong_tien, 
                    h.trang_thai, 
                    h.phuong_thuc_thanh_toan_id, 
                    ct.thuc_uong_id, 
                    ct.size, 
                    ct.so_luong, 
                    tu.Ten_thuc_uong
                FROM hoa_don h
                LEFT JOIN chi_tiet_hoa_don ct ON h.id = ct.hoa_don_id
                LEFT JOIN thuc_uong tu ON ct.thuc_uong_id = tu.id
                WHERE h.khach_hang_id = ?
                ORDER BY hoa_don_id DESC;
            ";
            
            // Chuẩn bị và thực thi câu lệnh
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $customerId);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $invoices = [];
            
            while ($row = $result->fetch_assoc()) {
                // Chúng ta có thể lưu thông tin vào mảng hoặc trả về dưới dạng đối tượng tùy thuộc vào nhu cầu
                $invoices[] = $row;
            }
            
            $stmt->close();
            return $invoices;
        }
    }
?>