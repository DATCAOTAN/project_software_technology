<head>
    <style>
        label{
            margin-bottom: 0;
        }
.rating-stars {
    margin-left: 10px;
    cursor: pointer;
    font-size: 24px; /* Kích thước sao */
    color: #000000; /* Màu sao đầy */
}

.rating-stars .star {
    color: #000000; /* Màu sao mặc định (rỗng) */
}

.rating-stars .star.hovered {
    color: #000000; /* Màu sao khi hover */
}

.rating-stars .star.selected {
    color: #000000; /* Màu sao khi được chọn */
}

    </style>
</head>

<div class="container mt-4">
    <h2 class="mb-4">Customer Feedback</h2>

    <!-- Form viết phản hồi -->
    <form id="feedback-form" class="mb-4" style="border:solid 1px #d5d5d5; padding: 10px">

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <!-- Nhập tên -->
                <label for="tenKhachHang" class="form-label me-2">Tên:</label>
                <input type="text" id="tenKhachHang" class="form-control me-3" style="width: 200px; margin-left: 10px" placeholder="Nhập tên">
            </div>
            <!-- Input Hóa đơn ID -->
            <div class="d-flex align-items-center">
                <label for="hoaDonId" class="form-label me-2">Hóa đơn ID:</label>
                <input type="text" id="hoaDonId" class="form-control" style="width: 150px; margin-left: 10px" placeholder="Nhập ID" required>
            </div>

            <!-- Rating -->
            <div class="d-flex align-items-center">
                <label for="ratingStars" class="form-label me-2">Rating:</label>
                <div id="ratingStars" class="rating-stars d-flex">
                    <span data-value="1" class="star">☆</span>
                    <span data-value="2" class="star">☆</span>
                    <span data-value="3" class="star">☆</span>
                    <span data-value="4" class="star">☆</span>
                    <span data-value="5" class="star">☆</span>
                </div>
                <input type="hidden" id="soSao" value="5"> <!-- Giá trị sao mặc định -->
            </div>
        </div>
        <div class="mb-3">
            <label for="noiDung" class="form-label">Feedback</label>
            <textarea class="form-control" id="noiDung" rows="3" placeholder="Write your feedback..."></textarea>
        </div>
        <div style="display: flex; justify-content: flex-end;">
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </div>
    </form>

    <div class="row">
        <!-- Cột danh sách phản hồi -->
        <div class="col-lg-8">
            <div id="feedback-list" class="list-group">
                <!-- Danh sách phản hồi sẽ được cập nhật thông qua AJAX -->
            </div>

            <!-- Phần phân trang -->
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination justify-content-center" id="pagination">
                    <!-- Các trang sẽ được cập nhật thông qua AJAX -->
                </ul>
            </nav>
        </div>

        <!-- Cột thống kê -->
        <div class="col-lg-4">
            <div class="card" style="margin-top: 0;">
                <div class="card-header text-center bg-primary text-white">Feedback Summary</div>
                <div class="card-body">
                    <p class="mb-2"><strong>Total Feedback:</strong> <span id="totalFeedback">0</span></p>
                    <p class="mb-2">
                        <strong>Average Rating:</strong>
                        <span id="averageStars">☆☆☆☆☆</span> 
                        <small>(<span id="averageRating">0.0</span> / 5)</small>
                    </p>
                    <p class="mb-2"><strong>Positive Feedback:</strong> <span id="positiveFeedback">0</span></p>
                    <p class="mb-2"><strong>Negative Feedback:</strong> <span id="negativeFeedback">0</span></p>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    
    
    let currentRating = 5; // Số sao mặc định

    // Hover để thay đổi trạng thái sao
    $('#ratingStars .star').hover(
        function () {
            const hoverValue = $(this).data('value');
            highlightStars(hoverValue, false);
        },
        function () {
            highlightStars(currentRating, true);
        }
    );

    // Click để chọn số sao
    $('#ratingStars .star').click(function () {
        currentRating = $(this).data('value');
        $('#soSao').val(currentRating); // Gán giá trị vào input ẩn
        highlightStars(currentRating, true);
    });

    // Hàm làm nổi bật sao
    function highlightStars(value, isSelected) {
        $('#ratingStars .star').each(function () {
            const starValue = $(this).data('value');
            if (starValue <= value) {
                $(this).text('★'); // Sao đầy
                if (isSelected) $(this).addClass('selected');
            } else {
                $(this).text('☆'); // Sao rỗng
                if (isSelected) $(this).removeClass('selected');
            }
        });
    }

    // Thiết lập mặc định là 5 sao
    highlightStars(currentRating, true);

    // Sự kiện khi nhấn nút Submit
    $("#feedback-form").on( "submit", function( event ) {
        event.preventDefault();
        const tenKhachHang = $('#tenKhachHang').val().trim();
        const hoaDonId = $('#hoaDonId').val().trim();
        const soSao = $('#soSao').val();
        const feedbackContent = $('#noiDung').val().trim(); // Nội dung phản hồi (nếu có)

        // Gửi dữ liệu qua AJAX
        $.ajax({
            type: 'POST',
            url: 'index.php?url=FeedbackController/addFeedback',
            data: {
                ten_khach_hang: tenKhachHang,
                hoa_don_id: hoaDonId,
                so_sao: soSao,
                noi_dung: feedbackContent
            },
            success: function (response) {
                console.log(response.success)
                if (response.success) {
                    alert("Phản hồi đã được gửi thành công!");
                    // Xóa dữ liệu trên form
                    $('#tenKhachHang').val('');
                    $('#hoaDonId').val('');
                    $('#soSao').val('5');
                    currentRating = 5;
                    $('#noiDung').val('');
                    highlightStars(5, true); // Reset về 5 sao
                    loadFeedback(1); // Tải lại danh sách phản hồi
                } else {
                    console.log(response.message)
                    alert("Đã xảy ra lỗi: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi gửi phản hồi:", error);
                alert("Không thể gửi phản hồi. Vui lòng thử lại sau.");
            }
        });
    });

    // Hàm gọi AJAX để tải dữ liệu phản hồi và cập nhật giao diện
    function loadFeedback(page = 1) {
        $.ajax({
            type: 'POST',
            url: "index.php?url=FeedbackController/showFeedback",
            data: { page: page },  // Gửi trang hiện tại
            success: function(response) {
                if (response) {
                    // Cập nhật danh sách phản hồi
                    updateFeedbackList(response.feedbackList);

                    // Cập nhật phân trang
                    updatePagination(response.totalPages, page);

                    // Cập nhật thống kê phản hồi
                    updateFeedbackSummary(response.feedbackSummary);
                }
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi gửi yêu cầu AJAX:", error);
            }
        });
    }

    // Cập nhật danh sách phản hồi trong DOM
    function updateFeedbackList(feedbacks) {
        $('#feedback-list').empty();  // Xóa danh sách cũ
        feedbacks.forEach(function(feedback) {
            const stars = '★'.repeat(feedback.so_sao) + '☆'.repeat(5 - feedback.so_sao);
            const item = `
                <div class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-1">${feedback.ten_khach_hang}</h5>
                        <small class="text-muted">${feedback.ngay_gio}</small>
                    </div>
                    <p class="mb-1">${feedback.noi_dung}</p>
                    <small>${stars}</small>
                </div>`;
            $('#feedback-list').append(item);  // Thêm phản hồi mới vào danh sách
        });
    }

    // Cập nhật phân trang
    function updatePagination(totalPages, currentPage) {
        const pagination = $('#pagination');
        pagination.empty();  // Xóa phân trang cũ
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
            pagination.append(pageItem);
        }
    }

    // Cập nhật thống kê phản hồi
    function updateFeedbackSummary(summary) {
        // Cập nhật tổng số phản hồi
        $('#totalFeedback').text(summary.total_feedback);

        // Cập nhật xếp hạng trung bình
        const averageRating = summary.average_rating;
        $('#averageRating').text(averageRating);

        // Cập nhật hiển thị ngôi sao cho xếp hạng trung bình
        const fullStars = Math.floor(summary.average_rating); // Số ngôi sao đầy
        const emptyStars = 5 - fullStars; // Ngôi sao rỗng còn lại

        let starsHTML = '★'.repeat(fullStars); // Ngôi sao đầy
        starsHTML += '☆'.repeat(emptyStars); // Ngôi sao rỗng

        $('#averageStars').html(starsHTML);

        // Cập nhật phản hồi tích cực
        $('#positiveFeedback').text(summary.positive_feedback);

        // Cập nhật phản hồi tiêu cực
        $('#negativeFeedback').text(summary.negative_feedback);
    }


    // Khi người dùng nhấn vào một trang trong phân trang
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        loadFeedback(page);
    });

    // Tải phản hồi cho trang đầu tiên khi tải trang
    loadFeedback(1);
});
</script>