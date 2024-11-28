<?php
class FeedbackController extends Controller
{
    private $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = $this->model("FeedbackModel");
    }

    // Xử lý trang phản hồi và lấy dữ liệu
    public function showFeedback()
    {
        $page = $_POST['page'];

        // Lấy tất cả phản hồi
        $allFeedback = $this->feedbackModel->getAllFeedback();
        
        // Lấy tổng số phản hồi
        $totalFeedback = $this->feedbackModel->getTotalFeedback();

        // Tổng số trang
        $limit = 5;
        $totalPages = ceil($totalFeedback / $limit);
        
        // Tính offset cho phân trang
        $offset = ($page - 1) * $limit;
        
        // Cắt mảng feedback để phân trang
        $feedbackList = array_slice($allFeedback, $offset, $limit);

        // Lấy thống kê tổng quan
        $feedbackSummary = $this->feedbackModel->getFeedbackSummary();

        
        header('Content-Type: application/json');
        echo json_encode([
            'feedbackList' => $feedbackList,
            'totalPages' => $totalPages,
            'feedbackSummary' => $feedbackSummary
        ]);
        exit;
    }

    public function addFeedback() {
        // Lấy dữ liệu từ yêu cầu POST
        $ten_khach_hang = $_POST['ten_khach_hang'];
        $hoa_don_id = $_POST['hoa_don_id'];
        $so_sao = $_POST['so_sao'];  // Mặc định là 5 sao
        $noi_dung = $_POST['noi_dung'];  // Nội dung có thể trống

        if (!$ten_khach_hang) {
            $ten_khach_hang = 'An danh';
        }

        if (!$noi_dung) {
            $noi_dung = 'Khong co noi dung';
        }

        header('Content-Type: application/json');

        if ($this->feedbackModel->isHoaDonExists($hoa_don_id)) {
            echo json_encode(['success' => false, 'message' => 'Hóa đơn này đã được phản hồi.']);
            exit();
        }

        // Thêm phản hồi vào cơ sở dữ liệu
        $result = $this->feedbackModel->addFeedback($ten_khach_hang, $hoa_don_id, $so_sao, $noi_dung);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Phản hồi đã được gửi thành công.']);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Có lỗi khi thêm phản hồi.']);
            exit();
        }
    }

    public function index()
    {     
        // Gọi view và truyền dữ liệu
        $this->view("master_layout", [
            'page' => 'feedback',
            'pageTitle' => 'Coffee shop',
        ]);
    }
}
?>
