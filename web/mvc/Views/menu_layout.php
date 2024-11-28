<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Menu Layout</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        <style>
            #ordersList{
                padding: 0;
                list-style: none;
                margin: 0;
            }
            .menu-item img {
                width: 100%;
                height: 150px;
                object-fit: cover;
            }
            .cart-summary, .orders-summary {
                max-height: 480px; /* Đặt chiều cao tối đa */
                overflow-y: auto; /* Hiển thị thanh cuộn dọc nếu nội dung vượt quá chiều cao */
                overflow-x: hidden; /* Ẩn thanh cuộn ngang nếu không cần thiết */
            }
            .menu-category {
                margin-bottom: 20px;
            }

            /* Đổi màu cho checkbox khi món ăn hết hàng */
            .out-of-stock {
                background-color: #f0f0f0; /* Màu nền xám nhạt */
                color: #999; /* Màu chữ xám nhạt */
            }

            .out-of-stock input[type="radio"]:disabled {
                background-color: #ddd; /* Màu nền xám khi vô hiệu hóa */
            }

            .out-of-stock label {
                color: #999; /* Màu chữ xám cho label */
                font-style: italic; /* Màu chữ nghiêng nếu món hết hàng */
            }

            /* Căn chỉnh lại các phần tử trong giỏ hàng */
            .cart-item {
                position: relative;
                margin: 10px; /* Quan trọng: giúp căn chỉnh nút "X" tuyệt đối */
            }

            .cart-item-details {
                display: flex;
                flex-direction: column;
            }

            .cart-item-name {
                font-weight: bold;
            }

            .cart-item-price {
                font-size: 0.9rem;
                color: #777;
            }

            .cart-item-actions {
                display: flex;
                align-items: center;
                justify-content: flex-end; /* Căn phải các phần tử trong phần này */
                width: 20%; /* Chiếm 40% chiều rộng */
            }

            .quantity-input {
                width: 60px;
                text-align: center;
            }

            .cart-item-actions span {
                font-weight: bold;
                font-size: 1rem;
                margin-left: 10px;
            }

            /* Nút X di chuyển lên góc phải */
            .remove-btn {
                position: absolute;
                top: -10px; /* Khoảng cách từ trên */
                right: -10px; /* Khoảng cách từ phải */
                padding: 3px 7px;
                background-color: #dc3545;
                font-size: 8px;
                border: none;
                color: white;
                cursor: pointer;
            }

            .remove-btn:hover {
                background-color: #c82333;
            }
            .centered {
                text-align: center;       /* Căn giữa ngang */
                line-height: 55px;       /* Dòng chữ nằm giữa theo chiều dọc */
                height: 60px;            /* Chiều cao của thẻ p */
                margin: 0;                /* Loại bỏ khoảng cách mặc định */
                border: 1px solid #ddd;   /* Tùy chọn để hiển thị rõ khung */
            }
            .image-container {
            display: flex;
            justify-content: center; /* Canh giữa theo chiều ngang */
            align-items: center;    /* Canh giữa theo chiều dọc */
            width: 100%;            /* Độ rộng vùng chứa */
            height: 300px;          /* Chiều cao vùng chứa (có thể thay đổi theo nhu cầu) */
            overflow: hidden;       /* Ẩn phần ảnh thừa nếu cần */
            }

            .image-container img {
            width: 100%;            /* Đảm bảo ảnh bao phủ toàn bộ chiều ngang */
            height: 100%;           /* Đảm bảo ảnh bao phủ toàn bộ chiều dọc */
            object-fit: cover;      /* Giữ tỉ lệ ảnh và cắt phần thừa nếu không khớp */
            }
            .image-container {
                display: flex;
                justify-content: center;   /* Canh giữa theo chiều ngang */
                align-items: center;      /* Canh giữa theo chiều dọc */
                width: 100%;              /* Đảm bảo ảnh chiếm toàn bộ vùng chứa */
                height: 300px;            /* Chiều cao cố định cho container */
                overflow: hidden;         /* Ẩn phần ảnh thừa */
                border-radius: 0.5rem;    /* Bo góc cho container */
            }

            .image-container img {
                width: 100%;              /* Ảnh chiếm toàn bộ chiều ngang container */
                height: 100%;             /* Ảnh chiếm toàn bộ chiều cao container */
                object-fit: cover;        /* Giữ tỉ lệ ảnh, cắt phần thừa nếu cần */
                display: block;           /* Xóa khoảng trống dưới ảnh (nếu có) */
            }
            /* Điều chỉnh layout cho các màn hình nhỏ */
            @media (max-width: 768px) {
                .cart-item {
                    flex-direction: column;
                    align-items: flex-start;
                }
                .cart-item-actions {
                    margin-top: 10px;
                }
            }

            /* Khi ở màn hình nhỏ, các cột xếp chồng lên nhau */
            @media (max-width: 768px) {
                .col-lg-6, .col-lg-3 {
                    flex: 0 0 100%; /* Chiều rộng 100% khi màn hình nhỏ */
                    max-width: 100%;
                }
            }

        </style>
    </head>
    <body>
        <div style="position: absolute; top: 6px; left: 30px; z-index: 10;">
            <button class="btn" onclick="history.back()">
                <i class="bi bi-caret-left-fill fs-1"></i>
            </button>
        </div>
        <div class="container mt-4">
            <div class="row">
                    <!-- Menu -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Menu</h2>
                    <div id="drink-container" class="row gy-4">
                        <!-- Dữ liệu sẽ được thêm vào đây bằng AJAX -->
                    </div>
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul id="pagination" class="pagination justify-content-center">
                            <!-- Các nút phân trang sẽ được thêm tại đây -->
                        </ul>
                    </nav>
                </div>

                <!-- Cart -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <h4>Giỏ hàng (0)</h4>
                    <div class="cart-summary border">
                        <p class="centered">Không có sản phẩm trong giỏ hàng</p>
                    </div>
                    <div class="mt-3">
                        <h5>Total: 0 VND</h5>
                        <button class="btn btn-danger w-100" id="paymentButton">Payment</button>
                    </div>
                </div>

                <!-- View Orders Section -->
                <div class="col-lg-3 col-md-3 col-sm-6">
                    <h4>Lịch sử mua hàng</h4>
                    <div class="orders-summary border p-3">
                        <ul id="ordersList">
                            <!-- Các hóa đơn sẽ được hiển thị tại đây -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <!-- Food Details Modal -->
    <div class="modal fade" id="foodDetailsModal" tabindex="-1" aria-labelledby="foodDetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="foodDetailsLabel">Food Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="foodDetailsImage" src="your-image-url.jpg" alt="Food Image" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <h3 id="foodDetailsName"></h3>
                            <p id="foodDetailsDescription"></p>
                            <div class="mb-3">
                                <label class="form-label">Choose Size</label>
                                <div class="d-flex flex-column gap-3" id="menuSizes">
                                    <!-- Checkbox options will be injected dynamically -->
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" id="quantity" class="form-control" min="1" value="1">
                            </div>
                            <h4 class="text-danger" id="foodDetailsPrice"></h4>
                            <button class="btn btn-success w-100" id="addToCartButton">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Modal -->
    <div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nameModalLabel">Payment Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Payment Method Dropdown -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Hình thức thanh toán</label>
                        <select class="form-select" id="paymentMethod" onchange="updateBankDropdown()">
                            <!-- Payment methods will be dynamically added here -->
                        </select>
                    </div>

                    <!-- Bank Dropdown -->
                    <div class="mb-3">
                        <label for="bankMethod" id="bankTitle"class="form-label">Phương thức thanh toán</label>
                        <select class="form-select" id="bankMethod">
                            <!-- Bank options will be dynamically added here -->
                        </select>
                    </div>

                    <!-- Total and Fees -->
                    <div id="totalPriceInfo">
                        <h5>Total: <span id="totalAmount">0</span> VND</h5>
                        <h5>Fee: <span id="feeAmount">0</span>%</h5>
                        <h4>Amount After Fee: <span id="amountAfterFee">0</span> VND</h4>
                    </div>

                    <!-- Payment Button -->
                    <div id="payButtonContainer">
                        <button class="btn btn-success w-100" id="payButton" disabled>Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Bootstrap Bundle JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const paymentMethods = <?php echo json_encode($paymentMethods); ?>;
            let cart = [];
            let totalPrice = 0;
            let amountAfterFee =0;
            let selectedPaymentMethod = null;

            // Function to populate the Payment Method dropdown
            function populatePaymentMethods() {
                const paymentMethodSelect = $('#paymentMethod');
                const bankMethodSelect = $('#bankMethod');
                paymentMethods.forEach(method => {
                    paymentMethodSelect.append(`
                        <option value="${method.id}" data-details='${JSON.stringify(method.details)}'>
                            ${method.name}
                        </option>
                    `);
                });
                // Populate bank dropdown with the first payment method by default
                updateBankDropdown();
            }

            // Function to update the Bank dropdown based on the selected Payment Method
            function updateBankDropdown() {
                const paymentMethodSelect = $('#paymentMethod');
                const selectedMethod = paymentMethods.find(method => method.id == paymentMethodSelect.val());
                const bankMethodSelect = $('#bankMethod');
                const bankMethodTitle = $('#bankTitle');
                
                // Clear previous bank options
                bankMethodSelect.empty();
                
                // If the selected method is 'Tiền mặt', hide the bank dropdown and set fee to 0
                if (selectedMethod.name === 'Tien mat') {
                    bankMethodSelect.hide();  // Hide the bank dropdown
                    bankMethodTitle.hide();
                    $('#feeAmount').text(0);  // Set fee to 0
                    $('#amountAfterFee').text($('#totalAmount').text());  // Amount after fee is the same as total
                    $('#payButton').prop('disabled', false);  // Enable the Pay button since no fee is applied
                } else {
                    bankMethodTitle.show();
                    bankMethodSelect.show();  // Show the bank dropdown
                    
                    // Add bank options for the selected payment method
                    selectedMethod.details.forEach(bank => {
                        bankMethodSelect.append(`
                            <option value="${bank.name}" data-fee="${bank.fee}">${bank.name}</option>
                        `);
                    });

                    // Update the fee information based on the selected bank
                    updateFeeInfo();
                }
            }

            // Function to update the fee information based on the selected bank
            function updateFeeInfo() {
                const totalAmount = totalPrice;
                const bankSelect = $('#bankMethod');
                const selectedBank = bankSelect.find(':selected');
                const fee = parseFloat(selectedBank.attr('data-fee'));
                
                const feeAmount = (totalAmount * fee) / 100;
                amountAfterFee = totalAmount + feeAmount;

                // Update fee and amount after fee
                $('#feeAmount').text(fee.toFixed(2));
                $('#amountAfterFee').text(amountAfterFee.toFixed(0));

                // Enable the Pay button when a valid bank is selected
                if (selectedBank.length > 0) {
                    $('#payButton').prop('disabled', false);
                } else {
                    $('#payButton').prop('disabled', true);
                }
            }

            // Handle Pay Now button click
            $('#payButton').on('click', function() {
                const paymentMethod = document.getElementById('paymentMethod').value; // Phương thức thanh toán
                const customerId = <?php echo json_encode($userID); ?>;
                const totalAmount = document.getElementById('totalAmount').innerText; // Tổng tiền

                // Cấu trúc dữ liệu gửi lên server
                const orderData = {
                    customerId: customerId,
                    paymentMethod: paymentMethod,
                    totalAmount: amountAfterFee,
                    items: cart
                };

                // Gửi AJAX đến controller để tạo hóa đơn
                fetch('./MenuController/createOrder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData) // Gửi dữ liệu dưới dạng JSON
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#totalAmount').text(0);  // Reset tổng số tiền

                        const bankSelect = $('#bankMethod').find(':selected').text();
                        const paymentMethodSelect = $('#paymentMethod');
                        const selectedMethod = paymentMethods.find(method => method.id == paymentMethodSelect.val());

                        if (selectedMethod.name === 'Tien mat') {
                            // Nếu thanh toán bằng tiền mặt
                            alert('Hãy thanh toán tại quầy khi lấy nước Mã hóa đơn bạn là: '+ data.hoaDonId);
                            clearCart();
                            $('#nameModal').modal('hide');
                            loadOrders();
                        } else {
                            // Thanh toán thành công cho các phương thức khác
                            alert("Thanh toán " + bankSelect + " Thành công, hãy lấy hóa đơn khi nhận nước ở quầy. Mã hóa đơn bạn là: "+ data.hoaDonId);
                            clearCart();
                            $('#nameModal').modal('hide');
                            loadOrders();
                        }

                        // Tự động chọn lại phương thức thanh toán đầu tiên
                        $('#paymentMethod').prop('selectedIndex', 0);  // Chọn phương thức thanh toán đầu tiên

                        // Nếu phương thức thanh toán không phải Tiền mặt, cập nhật lại dropdown ngân hàng
                        updateBankDropdown();
                    } else {
                        alert('Error creating order');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            });

            // Hàm hiển thị chi tiết món ăn
            function showFoodDetails(drink) {
                document.getElementById('foodDetailsName').textContent = drink.name;
                document.getElementById('foodDetailsDescription').textContent = drink.description || 'No description available';
                document.getElementById('foodDetailsImage').src = 'public/images/thuc_uong/'+drink.imageUrl || '';

                const menuSizesContainer = document.getElementById('menuSizes');
                menuSizesContainer.innerHTML = ''; // Xóa nội dung cũ
                let selectedPrice = 0;

                // Tạo các lựa chọn kích thước
                drink.details.forEach(detail => {
                    const price = parseFloat(detail.price);
                    const size = detail.size;
                    const itemStatus = detail.status;

                    const sizeOption = document.createElement('div');
                    sizeOption.className = 'form-check border rounded p-3 cursor-pointer'; // Thêm hover và pointer

                    // Kiểm tra trạng thái của món ăn, nếu hết hàng thì không hiển thị checkbox
                    if (itemStatus === 'Het hang') {
                        sizeOption.innerHTML = `
                            <label class="form-check-label" for="${size}">
                                <strong>${size.charAt(0).toUpperCase() + size.slice(1)}</strong> - ${price} VND (Đã hết hàng)
                            </label>
                        `;
                        sizeOption.classList.add('out-of-stock');
                    } else {
                        sizeOption.innerHTML = `
                            <input 
                                class="form-check-input" 
                                type="radio" 
                                name="menuSize" 
                                id="${size}" 
                                value="${price}">
                            <label class="form-check-label" for="${size}">
                                <strong>${size.charAt(0).toUpperCase() + size.slice(1)}</strong> - ${price} VND
                            </label>
                        `;

                        // Cho phép click toàn vùng
                        sizeOption.addEventListener('click', () => {
                            const radioInput = sizeOption.querySelector('input');
                            radioInput.checked = true; // Chọn
                            selectedPrice = parseFloat(radioInput.value);
                            const quantity = parseInt(document.getElementById('quantity').value) || 1;
                            updateTotalPrice(selectedPrice, quantity);
                        });
                    }

                    menuSizesContainer.appendChild(sizeOption);
                });

                // Hiển thị giá ban đầu
                const quantityInput = document.getElementById('quantity');
                const closeButton = document.querySelector('.btn-close');
                const addToCartButton = document.getElementById('addToCartButton');

                closeButton.onclick = () => {
                    quantityInput.value = 1;
                };

                addToCartButton.onclick = () => {
                    const selectedSize = document.querySelector('input[name="menuSize"]:checked');
                    if (!selectedSize) {
                        alert('Vui lòng chọn kích thước.');
                        return;
                    }

                    const size = selectedSize.id;
                    const price = parseFloat(selectedSize.value);
                    const quantity = parseInt(quantityInput.value) || 1;

                    addToCart(drink, size, quantity, price);
                    bootstrap.Modal.getInstance(document.getElementById('foodDetailsModal')).hide();
                    quantityInput.value =1;
                };
                
                updateTotalPrice(selectedPrice, parseInt(quantityInput.value));

                // Sự kiện thay đổi size
                document.querySelectorAll('input[name="menuSize"]').forEach(radio => {
                    radio.addEventListener('change', (e) => {
                        selectedPrice = parseFloat(e.target.value);
                        updateTotalPrice(selectedPrice, parseInt(quantityInput.value));
                    });
                });

                // Sự kiện thay đổi số lượng
                quantityInput.addEventListener('input', (e) => {
                    const quantity = parseInt(e.target.value) || 1;
                    updateTotalPrice(selectedPrice, quantity);
                });

                // Hiển thị modal
                const foodDetailsModal = new bootstrap.Modal(document.getElementById('foodDetailsModal'));
                foodDetailsModal.show();
            }

            function updateTotalPrice(pricePerItem, quantity) {
                const total = pricePerItem * quantity;
                document.getElementById('foodDetailsPrice').textContent = `Total: ${total} VND`;
            }

            $(document).ready(function() {
                let currentPage = 1;  // Trang hiện tại
                const itemsPerPage = 6; // Số mục mỗi trang

                // Hàm tải thức uống từ server
                function loadDrinks(page) {
                    $.ajax({
                        url: './MenuController/getDrinksByPage/' + page,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#drink-container').empty();  // Xóa các món uống cũ
                            if (data.length > 0) {
                                data.forEach(function(drink) {
                                    console.log(drink);
                                    $('#drink-container').append(`
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-img-top text-center pt-3">
                                                    <img src="public/images/thuc_uong/${drink.imageUrl}" alt="${drink.name}" class="img-fluid rounded" style="height: 125px; width: 150px; object-fit: cover;">
                                                </div>
                                                <div class="card-body text-center">
                                                    <h6 class="card-title mb-1">${drink.name}</h6>
                                                    <p class="text-danger fw-bold mb-2">${Math.min(...drink.details.map(d => d.price))} VND</p>
                                                    <button class="btn btn-outline-danger btn-sm" onclick='showFoodDetails(${JSON.stringify(drink)})'>
                                                        <i class="bi bi-cart"></i> View Details
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                });
                            } else {
                                $('#drink-container').append('<p class="text-center w-100">No drinks found.</p>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error loading drinks:", error);
                        }
                    });
                }

                // Hàm tạo các nút phân trang
                function createPagination(totalItems, itemsPerPage, currentPage, onPageChange) {
                    const totalPages = Math.ceil(totalItems / itemsPerPage);
                    const pagination = $('#pagination');
                    pagination.empty(); // Xóa phân trang cũ

                    // Số trang hiển thị tối đa
                    const maxVisiblePages = 5;

                    // Xác định phạm vi trang
                    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
                    let endPage = startPage + maxVisiblePages - 1;

                    if (endPage > totalPages) {
                        endPage = totalPages;
                        startPage = Math.max(1, endPage - maxVisiblePages + 1);
                    }

                    // Nút Previous
                    const prevDisabled = currentPage === 1 ? 'disabled' : '';
                    pagination.append(`
                        <li class="page-item ${prevDisabled}">
                            <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    `);

                    // Các nút trang
                    for (let i = startPage; i <= endPage; i++) {
                        const activeClass = i === currentPage ? 'active' : '';
                        pagination.append(`
                            <li class="page-item ${activeClass}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>
                        `);
                    }

                    // Nút Next
                    const nextDisabled = currentPage === totalPages ? 'disabled' : '';
                    pagination.append(`
                        <li class="page-item ${nextDisabled}">
                            <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    `);

                    // Gắn sự kiện click cho các nút phân trang
                    pagination.find('.page-link').click(function (e) {
                        e.preventDefault(); // Ngừng hành vi mặc định của liên kết

                        const selectedPage = parseInt($(this).data('page')); // Lấy trang mà người dùng chọn

                        // Kiểm tra xem trang có hợp lệ và khác với currentPage không
                        if (!isNaN(selectedPage) && selectedPage !== currentPage) {
                            currentPage = selectedPage; // Cập nhật currentPage với trang được chọn

                            // Gọi callback để tải lại dữ liệu cho trang mới
                            onPageChange(currentPage);

                            // Cập nhật lại các nút phân trang
                            createPagination(totalItems, itemsPerPage, currentPage, onPageChange);
                        }
                    });
                }

                // Lấy tổng số món để tính toán phân trang
                $.ajax({
                    url: './MenuController/getTotalDrinks',
                    type: 'GET',
                    success: function(totalItems) {
                        totalItems = parseInt(totalItems); // Đảm bảo kiểu dữ liệu là số
                        
                        // Tạo phân trang và xử lý chuyển trang
                        createPagination(totalItems, itemsPerPage, currentPage, function (page) {
                            currentPage = page; // Cập nhật trang hiện tại
                            loadDrinks(page); // Tải dữ liệu theo trang
                        });

                        // Tải dữ liệu của trang đầu tiên
                        loadDrinks(currentPage);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error getting total drinks:", error);
                    }
                });

                populatePaymentMethods();

                // Handle payment method selection
                $('#paymentMethod').change(updateBankDropdown);

                // Trigger fee update when bank selection changes
                $('#bankMethod').change(updateFeeInfo);
                
                document.getElementById('paymentButton').addEventListener('click', function (e) {
                    // Kiểm tra nếu giỏ hàng trống
                    if (cart.length === 0) {
                        alert("Hãy chọn ít nhất 1 sản phẩm trước khi thanh toán");
                        e.preventDefault(); // Ngăn không cho mở modal
                    } else {
                        // Hiển thị modal
                        $('#totalAmount').text(totalPrice);
                        const paymentModal = new bootstrap.Modal(document.getElementById('nameModal'));
                        paymentModal.show();
                    }
                });

                // Gọi hàm loadOrders khi trang tải
                loadOrders();
                setInterval(loadOrders, 60000);
            });
            
            function loadOrders() {
                $.ajax({
                    url: './MenuController/viewOrders', // URL để lấy danh sách hóa đơn
                    method: 'GET',
                    success: function (response) {
                        const ordersList = $('#ordersList');
                        ordersList.empty();
                        // Nếu response là chuỗi JSON, parse thành đối tượng
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }

                        // Kiểm tra nếu có hóa đơn
                        if (response.orders && response.orders.length > 0) {
                            // Nhóm các hóa đơn theo ID hóa đơn
                            const groupedOrders = {};
                            response.orders.forEach(order => {
                                if (!groupedOrders[order.hoa_don_id]) {
                                    groupedOrders[order.hoa_don_id] = {
                                        id:order.hoa_don_id,
                                        ngay_gio: order.ngay_gio,
                                        tong_tien: order.tong_tien,
                                        trang_thai: order.trang_thai,
                                        details: []
                                    };
                                }
                                groupedOrders[order.hoa_don_id].details.push({
                                    name: order.Ten_thuc_uong,
                                    size: order.size,
                                    quantity: order.so_luong
                                });
                            });
                          
                            // Hiển thị các hóa đơn đã nhóm
                            Object.values(groupedOrders).forEach(order => {
                                const orderDetails = order.details.map(detail => `
                                    <p>
                                        <strong>${detail.name}</strong> 
                                        (Size: ${detail.size}, số lượng: ${detail.quantity})
                                    </p>
                                `).join('');

                                ordersList.append(`
                                    <div class="order-box border p-3 mb-3 rounded shadow-sm">
                                        <p><strong>Mã hóa đơn:</strong> ${order.id}</p>
                                        <p><strong>Ngày:</strong> ${order.ngay_gio}</p>
                                        <p><strong>Tổng:</strong> ${order.tong_tien} VND</p>
                                        <p><strong>Trạng thái:</strong> 
                                            <span style="color: ${order.trang_thai === 'Da xong' ? 'green' : (order.trang_thai === 'Da dat' ? 'red' : 'inherit')}">
                                                ${order.trang_thai === 'Da dat' ? 'Đang làm' : 'Đã xong'}
                                            </span>
                                        </p>
                                        <div class="order-details">
                                            ${orderDetails}
                                        </div>
                                    </div>
                                `);
                            });
                        } else {
                            ordersList.append('<div>Bạn chưa mua gì cả.</div>');
                        }
                    },
                    error: function () {
                        $('#ordersList').html('<div class="alert alert-danger">Failed to load orders.</div>');
                    }
                });
            }

            function updateCartUI() {
                const cartSummary = document.querySelector('.cart-summary');
                const cartTitle = document.querySelector('.col-lg-3 h4');
                const totalPriceElement = document.querySelector('.col-lg-3 h5');

                totalPrice = 0;

                if (cart.length === 0) {
                    cartSummary.innerHTML = '<p class="centered">Không có sản phẩm trong giỏ hàng</p>';
                    cartTitle.textContent = 'Giỏ hàng (0)';
                    totalPriceElement.textContent = 'Total: 0 VND';
                    return;
                }

                cartSummary.innerHTML = '';
                let totalItems = 0;

                cart.forEach((item, index) => {
                    totalItems += item.quantity;
                    totalPrice += item.totalPrice;

                    cartSummary.innerHTML += `
                        <div class="cart-item d-flex justify-content-between align-items-center">
                            <div class="cart-item-details d-flex align-items-center">
                                <div class="cart-item-name">
                                    <strong>${item.name}</strong> (${item.size})
                                </div>
                                <div class="cart-item-price ml-3">
                                    <small>${item.quantity} x ${item.price} VND</small>
                                </div>
                            </div>
                            <div class="cart-item-actions d-flex align-items-center">
                                <input 
                                    type="number" 
                                    class="form-control quantity-input" 
                                    value="${item.quantity}" 
                                    min="1" 
                                    data-index="${index}" 
                                    onchange="updateItemQuantity(event)">
                            </div>
                                    <span class="text-danger ml-2">${item.totalPrice} VND</span>
                            <button 
                                class="btn btn-sm btn-danger remove-btn" 
                                onclick="removeItemFromCart(${index})">X</button>
                        </div>
                    `;
                });

                cartTitle.textContent = `Giỏ hàng (${totalItems})`;
                totalPriceElement.textContent = `Total: ${totalPrice} VND`;
            }

            function removeItemFromCart(index) {
                // Xóa món đồ khỏi giỏ hàng theo index
                cart.splice(index, 1);
                updateCartUI(); // Cập nhật lại giao diện giỏ hàng
            }
            
            function updateItemQuantity(event) {
                const index = event.target.getAttribute('data-index'); // Lấy index của món đồ
                const newQuantity = parseInt(event.target.value); // Lấy số lượng mới

                if (newQuantity < 1) {
                    alert('Số lượng phải lớn hơn 0.');
                    return;
                }

                // Cập nhật lại số lượng và giá trị tổng
                cart[index].quantity = newQuantity;
                cart[index].totalPrice = cart[index].price * newQuantity;

                updateCartUI(); // Cập nhật lại giao diện giỏ hàng
            }


            function addToCart(drink, size, quantity, price) {
                // Tìm sản phẩm trong giỏ hàng
                const existingItem = cart.find(item => item.id === drink.id && item.size === size);

                if (existingItem) {
                    // Nếu sản phẩm đã có, tăng số lượng
                    existingItem.quantity += quantity;
                    existingItem.totalPrice = existingItem.quantity * existingItem.price;
                } else {
                    // Nếu sản phẩm chưa có, thêm mới
                    cart.push({
                        id: drink.id,
                        name: drink.name,
                        size: size,
                        quantity: quantity,
                        price: price,
                        totalPrice: quantity * price
                    });
                }

                // Lưu giỏ hàng vào localStorage
                saveCartToLocalStorage();

                // Cập nhật giỏ hàng
                updateCartUI();
                
                // Cập nhập giá sau thuế
                updateFeeInfo();
            }

            function saveCartToLocalStorage() {
                localStorage.setItem('cart', JSON.stringify(cart));
            }

            function loadCartFromLocalStorage() {
                const savedCart = localStorage.getItem('cart');
                if (savedCart) {
                    cart = JSON.parse(savedCart);
                    updateCartUI();
                }
            }

            // Gọi hàm này khi trang tải
            document.addEventListener('DOMContentLoaded', () => {
                loadCartFromLocalStorage();
            });

            function clearCart() {
                cart = [];
                localStorage.removeItem('cart'); // Xóa giỏ hàng khỏi localStorage
                updateCartUI();
            }
        </script>
    </body>
</html>