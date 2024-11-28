<div class="container my-4">
    <h2 class="text-center">Danh sách đơn hàng</h2>

    <!-- "Dang lam" section -->
    <div>
        <h4 class="text-danger">Đơn đang làm</h4>
        <div id="dang_lam_list" class="list-group"></div>
    </div>

    <!-- "Da xong" section -->
    <div class="mt-4">
        <h4 class="text-success">Đơn đã xong</h4>
        <div id="da_xong_list" class="list-group"></div>

        <!-- Phân trang -->
        <nav aria-label="Page navigation" class="mt-3">
            <ul class="pagination justify-content-center" id="pagination">
            </ul>
        </nav>
    </div>
</div>

<!-- Modal hiển thị chi tiết hóa đơn -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> <!-- Đặt modal giữa màn hình -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Chi tiết hóa đơn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên thức uống</th>
                            <th>Kích cỡ</th>
                            <th>Số lượng</th>
                        </tr>
                    </thead>
                    <tbody id="hoaDonDetailsBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let currentPage = 1;
    const itemsPerPage = 5;
    const id_nhanvien = <?php echo json_encode($_SESSION['user']['userID']); ?>;

    // Gọi AJAX để tải dữ liệu
    function loadHoaDons() {
        $.ajax({
            url: 'index.php?url=InvoiceController/getHoaDons',
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    renderDangLam(response.dangLam);
                    renderDaXong(response.daXong, currentPage);
                } else {
                    console.log(response)
                    alert(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function () {
                console.error("Không thể tải dữ liệu.");
            }
        });
    }

    function renderDangLam(hoaDons) {
        const list = $('#dang_lam_list');
        list.empty();

        hoaDons.forEach(hd => {
            const item = `
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-id="${hd.id}">
                    Hóa đơn #${hd.id} - ${hd.tong_tien} VNĐ
                    <div>
                        <button class="btn btn-success btn-sm mark-complete" data-id="${hd.id}">Hoàn thành</button>
                        <button class="btn btn-sm btn-danger hide-order" data-id="${hd.id}">Xóa</button>
                    </div>
                </a>`;
            list.append(item);
        });

        // Thêm sự kiện cho click vào hóa đơn để hiện chi tiết
        list.find('a').on('click', function (e) {
            const hoaDonId = $(this).data('id');
            showDetails(hoaDonId);  // Gọi hàm hiển thị chi tiết
        });

        // Ngăn click vào nút Hoàn thành và Xóa không kích hoạt hiển thị chi tiết
        list.find('.mark-complete').on('click', function (e) {
            e.stopPropagation(); // Chặn sự kiện click lan tỏa
            const hoaDonId = $(this).data('id');
            markAsCompleted(hoaDonId);
        });

        list.find('.hide-order').on('click', function (e) {
            e.stopPropagation();
            const hoaDonId = $(this).data('id');
            hideOrder(hoaDonId);
        });
    }

    function renderDaXong(hoaDons, page) {
        const list = $('#da_xong_list');
        list.empty();

        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const items = hoaDons.slice(start, end);

        items.forEach(hd => {
            const item = `
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-id="${hd.id}">
                    Hóa đơn #${hd.id} - ${hd.tong_tien} VNĐ
                    <div>
                        <button class="btn btn-sm btn-danger hide-order" data-id="${hd.id}">Xóa</button>
                    </div>
                </a>`;
            list.append(item);
        });

        // Thêm sự kiện cho click vào hóa đơn để hiện chi tiết
        list.find('a').on('click', function (e) {
            const hoaDonId = $(this).data('id');
            showDetails(hoaDonId);  // Gọi hàm hiển thị chi tiết
        });

        list.find('.hide-order').on('click', function (e) {
            e.stopPropagation(); // Chặn sự kiện click lan tỏa
            const hoaDonId = $(this).data('id');
            hideOrder(hoaDonId);
        });

        renderPagination(hoaDons.length, page);
    }

    // Đánh dấu đơn hàng là "Hoàn thành"
    function markAsCompleted(hoaDonId) {
        $.ajax({
            url: `index.php?url=InvoiceController/completeOrder/${hoaDonId}/${id_nhanvien}`,
            method: 'POST',
            success: function (response) {
                if (response.success) {
                    alert('Đơn hàng đã được hoàn thành.');
                    loadHoaDons(); // Cập nhật lại danh sách đơn hàng
                } else {
                    alert('Có lỗi xảy ra khi cập nhật trạng thái.');
                }
            },
            error: function () {
                alert('Lỗi kết nối. Vui lòng thử lại.');
            }
        });
    }

    function renderPagination(totalItems, currentPage) {
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        const pagination = $('#pagination');
        pagination.empty();

        for (let i = 1; i <= totalPages; i++) {
            const activeClass = i === currentPage ? 'active' : '';
            const pageItem = `
                <li class="page-item ${activeClass}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>`;
            pagination.append(pageItem);
        }
    }

    function changePage(page) {
        currentPage = page;
        loadHoaDons();
    }

    function showDetails(hoaDonId) {
        $.ajax({
            url: `index.php?url=InvoiceController/getInvoiceDetails/${hoaDonId}`,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    const details = response.data;
                    const tbody = $('#hoaDonDetailsBody');
                    tbody.empty();

                    details.forEach(detail => {
                        const row = `
                            <tr>
                                <td>${detail.Ten_thuc_uong}</td>
                                <td>${detail.size}</td>
                                <td>${detail.so_luong}</td>
                            </tr>`;
                        tbody.append(row);
                    });

                    $('#detailModal').modal('show');
                } else {
                    alert('Không thể tải chi tiết hóa đơn.');
                }
            },
            error: function () {
                console.error('Lỗi khi tải chi tiết hóa đơn.');
            }
        });
    }

    function hideOrder(hoaDonId) {
        $.ajax({
            url: 'index.php?url=InvoiceController/hideOrder/',
            method: 'POST',
            data: { hoaDonId: hoaDonId },
            success: function (response) {
                if (response.success) {
                    alert('Đơn hàng đã được ẩn.');
                    loadHoaDons(); // Cập nhật lại danh sách
                } else {
                    alert(response.message || 'Có lỗi xảy ra!aaaaa');
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi gửi yêu cầu AJAX:", error);
            }
        });
    }

    // Tải dữ liệu ban đầu
    $(document).ready(function () {
        loadHoaDons();
        setInterval(loadHoaDons, 5000);
    });

</script>