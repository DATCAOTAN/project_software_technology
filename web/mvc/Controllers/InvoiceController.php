<?php
class InvoiceController extends Controller {
    private $invoiceModel;

    public function __construct()
    {
        $this->invoiceModel = $this->model("InvoiceModel");
    }
        // Lấy danh sách hóa đơn "Dang lam" và "Da xong"
        public function getHoaDons() {
            $dangLam = $this->invoiceModel->getHoaDonsByStatus("Dang lam");
            $daXong = $this->invoiceModel->getHoaDonsByStatus("Da xong");
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'dangLam' => $dangLam, 'daXong' => $daXong]);
            exit();
        }
    
        // Cập nhật trạng thái đơn hàng
        public function updateStatus() {
            if (isset($_POST['hoa_don_id']) && isset($_POST['new_status'])) {
                $hoaDonId = $_POST['hoa_don_id'];
                $newStatus = $_POST['new_status'];
                $updated = $this->invoiceModel->updateHoaDonStatus($hoaDonId, $newStatus);
                header('Content-Type: application/json');

                if ($updated) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật thành công.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể cập nhật trạng thái.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
            }
        }
    
        // Lấy chi tiết hóa đơn
        public function getInvoiceDetails($hoaDonId) {
            $details = $this->invoiceModel->getInvoiceDetailsByHoaDonId($hoaDonId);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $details
            ]);
        }

        public function hideOrder() {
            if (isset($_POST['hoaDonId'])) {
                $hoaDonId = $_POST['hoaDonId'];
                $result = $this->invoiceModel->updateOrderStatus($hoaDonId, 'An');
        
                header('Content-Type: application/json');
                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Đơn hàng đã được ẩn.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể ẩn đơn hàng.']);
                }
            }
        }

        public function completeOrder($hoaDonId) {
            $id_nhanvien = $_POST['id_nhanvien'];
            $result = $this->invoiceModel->updateOrderStatus($hoaDonId, "Da xong", $id_nhanvien);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
        }


        public function index()
        {     
            // Gọi view và truyền dữ liệu
            $this->view("master_layout", [
                'page' => 'invoice',
                'pageTitle' => 'Coffee shop'
            ]);
        }
    }
?>