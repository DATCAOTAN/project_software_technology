<link rel="stylesheet" href="./public/css/account.css">
<style>
        * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    #Container {
        margin: 20px 30px;
        background-color: #F7F9FB;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background-color: #007bff;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #header h3 {
        margin: 0;
    }

    #header #add {
        background-color: #0063cc;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    #header #add:hover {
        background-color: #004085;
    }

    #searchbar {
        display: flex;
        padding: 20px;
        background-color: #E1E4F1;
        border-bottom: 1px solid #ccc;
    }

    #searchbar select,
    #searchbar input[type="text"] {
        margin-right: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        font-size: 16px;
        color: #333;
        outline: none;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    #searchbar input[type="text"] {
        flex-grow: 1;
    }

    #searchbar select:focus,
    #searchbar input[type="text"]:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    #accountcontainer {
        padding: 20px;
    }

    #accountcontainer table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    #accountcontainer th,
    #accountcontainer td {
        border: 1px solid #ccc;
        padding: 12px;
        text-align: left;
    }

    #accountcontainer th {
        background-color: #f2f2f2;
    }

    #accountcontainer tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    #accountcontainer tbody tr:hover {
        background-color: #e1e4f1;
    }

    #accountcontainer .fas {
        font-size: 18px;
        margin-right: 10px;
        color: #4aa0fc;
        cursor: pointer;
        transition: color 0.3s;
    }

    #accountcontainer .fas:hover {
        color: #007bff;
    }

    .pagination {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .pagination button {
        padding: 8px 12px;
        margin: 0 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f0f0f0;
        cursor: pointer;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .pagination button:hover {
        background-color: #e1e4f1;
        border-color: #007bff;
    }

    /* CSS cho popup và nội dung */
    .popup-account{
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .popup-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 10px;
    }

    /* Close button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* CSS cho form */
    #addAccountForm {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        flex-direction: row-reverse; /* Đảo chiều sắp xếp của các phần tử con */
    }

    .form-group {
        display: flex;
        flex-direction: column;
        flex: 1 1 45%; /* Flex basis is 45% for two columns layout */
        margin: 10px;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-group input,
    .form-group select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #profile_preview {
        /* display: none; */
        width: 100px;
        height: 100px;
        margin-top: 10px;
        align-self: center; /* Đặt lại align-self cho hình ảnh */
    }

    /* CSS cho nút submit */
    button[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        margin-top: 20px;
        align-self: center; /* Center align the button */
    }
    #remove_image_button {
    margin-top: 10px;
    background-color: #ff0000; /* Màu nền */
    color: #ffffff; /* Màu chữ */
    border: none; /* Không có viền */
    padding: 10px 20px; /* Kích thước padding */
    cursor: pointer; /* Con trỏ chuột thành hình bàn tay khi di chuột qua */
    border-radius: 5px; /* Đường cong viền */
    }

    #remove_image_button:hover {
    background-color: #cc0000; /* Màu nền khi di chuột qua */
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
<div id="Container">
    <div id="header">
        <h3>Quản lý tài khoản</h3>
        <button id="add">Thêm tài khoản</button>
    </div>
    <div id="searchbar">
        <select name="privilege" id="privilege">
            <option value="All">Tất cả nhóm quyền</option>
            <?php foreach ($privilege as $priv) : ?>
                <option value="<?php echo htmlspecialchars($priv["ten"]); ?>"><?php echo htmlspecialchars($priv["ten"]); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" placeholder="Tìm kiếm tài khoản" id="searchAccount" name="searchAccount">
    </div>
    <div id="accountcontainer">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên tài khoản</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Ngày sinh</th>
                    <th>Nhóm quyền</th>
                    <th>Giới tính</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($account as $acc) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($acc["id"]); ?></td>
                        <td><?php echo htmlspecialchars($acc["ten_dang_nhap"]); ?></td>
                        <td><?php echo htmlspecialchars($acc["ten_nguoi_dung"]); ?></td>
                        <td><?php echo htmlspecialchars($acc["email"]); ?></td>
                        <td><?php echo htmlspecialchars($acc["ngay_sinh"]); ?></td>
                        <td><?php echo htmlspecialchars($acc["ten"]); ?></td>
                        <td><?php echo htmlspecialchars($acc["gioi_tinh"]); ?></td>
                        <td>
                            <a href="#" id="<?php echo $acc['id']; ?>sua" class="edit"><i class="fas fa-edit"></i></a>
                            <a href="#" id="<?php echo $acc['id']; ?>xoa" class="delete"><i class="fas fa-trash-alt"></i></a>
                        </td>
                        <!-- Thêm các cột khác tùy vào dữ liệu bạn có -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="popupForm" class="popup-account">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Form tài khoản</h2>
            <form id="addAccountForm" enctype="multipart/form-data"> <!-- Đảm bảo bạn có thuộc tính enctype -->
                <div class="form-group">
                    <label for="username">Tên tài khoản:</label>
                    <input type="text" id="username" name="username" required>
                    <div id="messageus"></div>
                </div>
                <div class="form-group">
                    <label for="text">Mật khẩu:</label>
                    <input type="text" id="password" name="password" required> <!-- Sửa lại id và name -->
                </div>
                <div class="form-group">
                    <label for="fullname">Tên người dùng:</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <div id="messageem"></div>
                </div>
                <div class="form-group">
                    <label for="birthdate">Ngày sinh:</label>
                    <input type="date" id="birthdate" name="birthdate" required>
                </div>
                <div class="form-group">
                    <label for="privilege">Nhóm quyền:</label>
                    <select class="privilege" name="privilege">
                        <?php foreach ($privilege as $priv) : ?>
                            <option value="<?php echo htmlspecialchars($priv["ten"]); ?>"><?php echo htmlspecialchars($priv["ten"]); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính:</label>
                    <select id="gender" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="profile_picture">Chọn hình ảnh:</label>
                    <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                    <img id="profile_preview" src="#" alt="Hình ảnh của bạn" style="display: none; width: 100px; height: 100px; margin-top: 10px;"/>
                    <button type="button" id="remove_image_button">Xóa ảnh</button>
                </div>
                <button type="submit">Xác nhận</button>
            </form>
        </div>
    </div>
</div>

</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
            $('#add').hide();
            $('.edit').hide();
            $('.delete').hide();
            const userdata = JSON.parse(localStorage.getItem("userData"));
            userID = userdata.userId;
            $.ajax({
                url: './AccountController/getChucnang/' + userID,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    response.forEach(function(privilege) {
                        if (privilege.cn === 'Add') {
                            $('#add').show();
                        }
                        if (privilege.cn === 'Edit') {
                            $('.edit').show();
                        }
                        if (privilege.cn === 'Remove') {
                            $('.delete').show();
                        }
                    });
                },
                error: function() {
                    console.error(error);
                }
            });   
        $('#remove_image_button').click(function() {
            // Hiển thị hộp thoại xác nhận với thông báo
            var confirmed = confirm("Bạn có chắc chắn muốn xóa ảnh?");
            // Nếu người dùng xác nhận, thêm một trường ẩn vào form để đánh dấu việc xóa ảnh
            if (confirmed) {
                $('#profile_preview').hide(); // Ẩn thẻ img
                $('<input>').attr({
                    type: 'hidden',
                    name: 'remove_image',
                    value: 'true'
                }).appendTo('#addAccountForm');
            }
        });
        var fileName=null;
        $('#profile_picture').change(function(event) {
            var preview = $('#profile_preview');
            var file = event.target.files[0];

            if (file) {
                preview.attr('src', URL.createObjectURL(file));
                preview.css('display', 'block');
            } else {
                preview.attr('src', '');
                preview.css('display', 'none');
            }
        });

        // Close popup
        $('.close').click(function() {
            $('#popupForm').css('display', 'none');
        });

        // Show popup
        $('#add').click(function() {
            $('#popupForm').css('display', 'block');
            $('#username').focus();
            $('#username').val("");
            $('#password').val("");
            $('#fullname').val("");
            $('#email').val("");
            $('#birthdate').val("");
            $('.privilege').val("");
            $('#gender').val("");
            $('#addAccountForm').off('submit').submit(function(event) {
                event.preventDefault();
                // Tạo một đối tượng FormData từ form HTML
                var formData = new FormData(this);
                var url = 'index.php?url=AccountController/addData';
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // for (var pair of formData.entries()) {
                        //     console.log(pair[0]+ ': ' + pair[1]);
                        // }
                        console.log(response);
                        if(response){
                            alert("Thêm thành công");
                            $('#popupForm').css('display', 'none');
                            // location.reload();
                        } else {
                            alert("Thêm thất bại");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi khi gửi yêu cầu AJAX:", error);
                    }
                });
            });
        });   

        $("#add").click(function() {
            $("#popupForm").fadeIn();
        });

        // Đóng pop-up khi nhấn vào nút "x"
        $(".close").click(function() {
            $("#popupForm").fadeOut();
        });

        // Đóng pop-up khi nhấn ra ngoài vùng pop-up
        $(window).click(function(event) {
            if ($(event.target).is("#popupForm")) {
                $("#popupForm").fadeOut();
            }
        });

        $('#username').keyup(function(e){
            var un=$(this).val();
            $.post("./AccountController/checkten/"+un,function(data){
                if(data==true)
                    $('#messageus').html("Tên đăng nhập đã tồn tại");
                else
                    $('#messageus').html("");
            });
        });

        $('#email').keyup(function(e){
            var em=$(this).val();
            $.post("./AccountController/checkemail/"+em,function(data){
                if(data==true)
                    $('#messageem').html("Email đã tồn tại");
                else
                    $('#messageem').html("");
            });
        });

        $(document).ready(function() {
            // Gán sự kiện cho nút sửa
            $('#accountcontainer a[id$="sua"]').click(function(event) {
                event.preventDefault();
                var accountId = $(this).attr('id').replace('sua', ''); // Lấy ID tài khoản
                console.log('Sửa tài khoản có ID:', accountId);
                // Thực hiện các hành động cần thiết khi nhấn nút sửa
                $.ajax({
                    url: './AccountController/showData/' +accountId,
                    type: 'POST',
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            // Gán dữ liệu vào form
                            $('#username').val(response.Ten_dang_nhap);
                            $('#password').val(response.mat_khau);
                            $('#fullname').val(response.tennguoidung);
                            $('#email').val(response.email);
                            $('#birthdate').val(response.ngay_sinh);
                            $('.privilege').val(response.tenquyen);
                            $('#gender').val(response.gioi_tinh);
                            if (response.hinh) {
                                console.log(response.hinh);
                                $('#profile_preview').attr('src', "./"+response.hinh).show();
                            } else {
                                $('#profile_preview').hide();
                            }
                            $('#popupForm').css('display', 'block');
                        }
                    },
                    error: function() {
                        alert('Lỗi khi lấy dữ liệu tài khoản.');
                    }
                });
                $('#addAccountForm').off('submit').submit(function(event){
                    event.preventDefault();
                    var formData = new FormData(this);
                    var url = 'index.php?url=AccountController/updateData/'+accountId;
                    for (var pair of formData.entries()) {
                                console.log(pair[0]+ ': ' + pair[1]);
                            }
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            if(response){
                                alert("Sửa thành công");
                                $('#popupForm').css('display', 'none');
                                // location.reload();
                            } else {
                                alert("Sửa thất bại");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Lỗi khi gửi yêu cầu AJAX:", error);
                        }
                    });
                });
            });

            // Gán sự kiện cho nút xóa
            $('#accountcontainer a[id$="xoa"]').click(function(event) {
                event.preventDefault();
                var accountId = $(this).attr('id').replace('xoa', ''); // Lấy ID tài khoản
                console.log('Xóa tài khoản có ID:', accountId);
                $.ajax({
                        type: 'POST',
                        url: 'index.php?url=AccountController/deleteData/' +accountId,
                        success: function(response) {
                            if(response){
                                alert("Xóa thành công");
                                location.reload();
                            }
                            else{
                                alert("Xóa thất bại, Tài khoản đang được sử dụng");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Lỗi khi gửi yêu cầu AJAX:", error);
                        }
                });
            });
        });

        $('#privilege').change(function() {
            searchAccounts();
        });
        let searchTimeout;
        $('#searchAccount').keyup(function() {
            const inputVal = $(this).val();

            clearTimeout(searchTimeout); // Clear any existing timeout to reset the delay

            if (inputVal === '') {
                // If the input is empty, call searchAccounts immediately
                searchAccounts();
            } else {
                // Otherwise, set a timeout to call searchAccounts after 500 milliseconds
                searchTimeout = setTimeout(function() {
                    searchAccounts();
                }, 500); // 500 milliseconds delay
            }
        });
        function searchAccounts() {
            var searchTerm = $('#searchAccount').val();
            var selectedPrivilege = $('#privilege').val();
            if (selectedPrivilege === "All") {
                window.location.reload();
                return;
            }
            console.log(selectedPrivilege);
            console.log( searchTerm);
            var page = 1; // Default page is 1
            var limit = 2; // Number of results per page

            $.ajax({
                type: 'POST',
                url: 'index.php?url=AccountController/search/' + selectedPrivilege +"/"+searchTerm +"/" + page + "/" + limit,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var results = response.results;
                    var totalPages = response.totalPages;

                    // Build HTML for the table based on search results
                    var tableHtml = '<table><thead><tr><th>ID</th><th>Tên tài khoản</th><th>Tên người dùng</th><th>Email</th><th>Ngày sinh</th><th>Nhóm quyền</th><th>Giới tính</th><th>Chức năng</th></tr></thead><tbody>';
                    results.forEach(function(acc) {
                        tableHtml += '<tr>';
                        tableHtml += '<td>' + acc.id + '</td>';
                        tableHtml += '<td>' + acc.ten_dang_nhap + '</td>';
                        tableHtml += '<td>' + acc.ten_nguoi_dung + '</td>';
                        tableHtml += '<td>' + acc.email + '</td>';
                        tableHtml += '<td>' + acc.ngay_sinh + '</td>';
                        tableHtml += '<td>' + acc.ten + '</td>';
                        tableHtml += '<td>' + acc.gioi_tinh + '</td>';
                        tableHtml += '<td>';
                        tableHtml += '<a href="#"><i class="fas fa-edit"></i></a>'; // Edit icon
                        tableHtml += '<a href="#"><i class="fas fa-trash-alt"></i></a>'; // Delete icon
                        tableHtml += '</td>';
                        tableHtml += '</tr>';
                    });
                    tableHtml += '</tbody></table>';

                    // Update the content of #accountcontainer with the new table
                    $('#accountcontainer').html(tableHtml);

                    // Build and append pagination buttons
                    var paginationHtml = '<div class="pagination">';
                    for (var i = 1; i <= totalPages; i++) {
                        paginationHtml += '<button class="page-btn" data-page="' + i + '">' + i + '</button>';
                    }
                    paginationHtml += '</div>';
                    $('#accountcontainer').append(paginationHtml); // Append pagination

                    // Add event listeners to pagination buttons
                    $('.page-btn').click(function() {
                        var page = $(this).data('page');
                        searchAccountsByPage(page);
                    });
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                }
            });
        }

        // Function to handle pagination
        function searchAccountsByPage(page) {
            var searchTerm = $('#searchAccount').val();
            var selectedPrivilege = $('#privilege').val();
            var limit = 2;
            if (selectedPrivilege === "All") {
                selectedPrivilege = 'temp';
            }
            $.ajax({
                type: 'POST',
                url: 'index.php?url=AccountController/search/' + selectedPrivilege +"/"+searchTerm +"/" + page + "/" + limit,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var results = response.results;

                    var tableHtml = '<table><thead><tr><th>ID</th><th>Tên tài khoản</th><th>Tên người dùng</th><th>Email</th><th>Ngày sinh</th><th>Nhóm quyền</th><th>Giới tính</th><th>Chức năng</th></tr></thead><tbody>';
                    results.forEach(function(acc) {
                        tableHtml += '<tr>';
                        tableHtml += '<td>' + acc.id + '</td>';
                        tableHtml += '<td>' + acc.ten_dang_nhap + '</td>';
                        tableHtml += '<td>' + acc.ten_nguoi_dung + '</td>';
                        tableHtml += '<td>' + acc.email + '</td>';
                        tableHtml += '<td>' + acc.ngay_sinh + '</td>';
                        tableHtml += '<td>' + acc.ten + '</td>';
                        tableHtml += '<td>' + acc.gioi_tinh + '</td>';
                        tableHtml += '<td>';
                        tableHtml += '<a href="#"><i class="fas fa-edit"></i></a>'; // Edit icon
                        tableHtml += '<a href="#"><i class="fas fa-trash-alt"></i></a>'; // Delete icon
                        tableHtml += '</td>';
                        tableHtml += '</tr>';
                    });
                    tableHtml += '</tbody></table>';
                    $('#accountcontainer').html(tableHtml);

                    // Rebuild and append pagination buttons
                    var paginationHtml = '<div class="pagination">';
                    for (var i = 1; i <= response.totalPages; i++) {
                        paginationHtml += '<button class="page-btn" data-page="' + i + '">' + i + '</button>';
                    }
                    paginationHtml += '</div>';
                    $('#accountcontainer').append(paginationHtml); // Append pagination

                    // Add event listeners to pagination buttons again
                    $('.page-btn').click(function() {
                        var page = $(this).data('page');
                        searchAccountsByPage(page);
                    });
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                }
            });
        }

    </script>
</div>