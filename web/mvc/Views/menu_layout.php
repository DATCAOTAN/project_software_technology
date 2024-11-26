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
            .menu-item img {
                width: 100%;
                height: 150px;
                object-fit: cover;
            }
            .menu-category {
                margin-bottom: 20px;
            }
            .cart-summary {
                max-height: 500px;
                overflow-y: auto;
            }
        </style>
    </head>
    <body>
    
        <div class="container mt-4">
            <div class="row">
                <!-- Menu -->
                <div class="col-lg-8">
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
                <div class="col-lg-4">
                    <h4>Your Cart (0)</h4>
                    <div class="cart-summary border p-3">
                        <p>No items in cart</p>
                    </div>
                    <div class="mt-3">
                        <h5>Total: 0 VND</h5>
                        <button class="btn btn-danger w-100" id="paymentButton">Payment</button>
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
                            <img id="foodDetailsImage" src="" alt="Food Image" class="img-fluid rounded">
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
                const amountAfterFee = totalAmount + feeAmount;

                // Update fee and amount after fee
                console.log(totalAmount)
                console.log(fee)
                console.log(amountAfterFee)
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
                $('#totalAmount').text(0);
                const bankSelect = $('#bankMethod').find(':selected').text();
                const paymentMethodSelect = $('#paymentMethod');
                const selectedMethod = paymentMethods.find(method => method.id == paymentMethodSelect.val());
                if (selectedMethod.name === 'Tien mat') {
                    // If paying at counter, just close the modal
                    alert('Hãy thanh toán tại quầy khi lấy nước');
                    clearCart();
                    $('#nameModal').modal('hide');
                } else {
                    // Show total and proceed to payment for other methods
                    alert("Thanh toán "+bankSelect +" Thành công, hãy lấy hóa đơn khi nhận nước ở quầy");
                    clearCart();
                    $('#nameModal').modal('hide');
                }
            });

            // Hàm hiển thị chi tiết món ăn
            function showFoodDetails(drink) {
                document.getElementById('foodDetailsName').textContent = drink.name;
                document.getElementById('foodDetailsDescription').textContent = drink.description || 'No description available';
                document.getElementById('foodDetailsImage').src = drink.imageUrl || '';

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

                    sizeOption.innerHTML = `
                        <input 
                            class="form-check-input" 
                            type="radio" 
                            name="menuSize" 
                            id="${size}" 
                            value="${price}" 
                            ${itemStatus === 'Het hang' ? 'disabled' : ''}>
                        <label class="form-check-label" for="${size}">
                            <strong>${size.charAt(0).toUpperCase() + size.slice(1)}</strong> - ${price} VND
                        </label>
                    `;

                    // Cho phép click toàn vùng
                    sizeOption.addEventListener('click', () => {
                        const radioInput = sizeOption.querySelector('input');
                        if (!radioInput.disabled) {
                            radioInput.checked = true; // Chọn
                            selectedPrice = parseFloat(radioInput.value);
                            const quantity = parseInt(document.getElementById('quantity').value) || 1;
                            updateTotalPrice(selectedPrice, quantity);
                        }
                    });

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
                                    $('#drink-container').append(`
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-img-top text-center pt-3">
                                                    <img src="${drink.image_url}" alt="${drink.name}" class="img-fluid rounded" style="min-height: 125px; width: 150px; object-fit: cover;">
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
            });

            function updateCartUI() {
                const cartSummary = document.querySelector('.cart-summary');
                const cartTitle = document.querySelector('.col-lg-4 h4');
                const totalPriceElement = document.querySelector('.col-lg-4 h5');

                totalPrice = 0;

                if (cart.length === 0) {
                    cartSummary.innerHTML = '<p>No items in cart</p>';
                    cartTitle.textContent = 'Your Cart (0)';
                    totalPriceElement.textContent = 'Total: 0 VND';
                    return;
                }

                cartSummary.innerHTML = '';
                let totalItems = 0;

                cart.forEach(item => {
                    totalItems += item.quantity;
                    totalPrice += item.totalPrice;

                    cartSummary.innerHTML += `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <strong>${item.name}</strong> (${item.size})<br>
                                <small>${item.quantity} x ${item.price} VND</small>
                            </div>
                            <span class="text-danger">${item.totalPrice} VND</span>
                        </div>
                    `;
                });

                cartTitle.textContent = `Your Cart (${totalItems})`;
                totalPriceElement.textContent = `Total: ${totalPrice} VND`;
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

            // // Ví dụ: Thêm sự kiện khi nhấn nút Payment
            // document.querySelector('.btn-danger').addEventListener('click', () => {
            //     // Hiển thị thông báo hoặc thực hiện thanh toán
            //     alert('Thank you for your payment!');
            //     clearCart(); // Xóa giỏ hàng sau thanh toán
            // });

        </script>
    </body>
</html>