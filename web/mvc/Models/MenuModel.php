<?php 
    require_once __DIR__ . '/../DTO/DrinkDTO.php';
    require_once __DIR__ . '/../DTO/PaymentMethodDTO.php';
    class MenuModel extends Database {

        public function getTotalDrinks(): int {
            $sql = "SELECT COUNT(*) AS total FROM Thuc_uong";
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
            $drinks = $this->getAllDrinks($page, $itemsPerPage);
        
            foreach ($drinks as $drink) {
                $details = $this->getDrinkDetails($drink->getId());
                foreach ($details as $detail) {
                    $drink->addDetail(
                        $detail['size'],
                        $detail['price'],
                        $detail['status']
                    );
                }
            }
        
            return $drinks;
        }

        public function getDrinkDetails(int $drinkId): array {
            $sql = "
                SELECT 
                    Size AS size, 
                    Gia_tien AS price, 
                    Trang_thai_ban AS status
                FROM Chi_tiet_thuc_uong
                WHERE Thuc_uong_ID = ?
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
        
        public function getAllDrinks(int $page = 1, int $itemsPerPage = 6): array {
            $offset = ($page - 1) * $itemsPerPage;
        
            $sql = "
                SELECT 
                    tu.ID AS drink_id, 
                    tu.Ten_thuc_uong AS name, 
                    tu.Mo_ta AS description, 
                    tu.image_URL AS image_url
                FROM Thuc_uong tu
                LIMIT ? OFFSET ?
            ";
        
            $stmt = $this->con->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("ii", $itemsPerPage, $offset);
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
    }
?>