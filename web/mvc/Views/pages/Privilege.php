<style>
    #container-privilege {
        width: 100%;
        min-height: 80vh;
        background-color: #E0E0E0;
        display: flex;
        flex-direction: column;
    }

    #head-privilege {
        width: 100%;
        background-color: #007BFF;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        display: flex;
        align-items: center;
    }

    #head-privilege .btn {
        background-color: #136bc4;
        color: white;
        margin: 10px;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-right: 10px;
    }

    #head-privilege .btn:hover {
        background-color: #004085;
    }

    #content-wrapper {
        display: flex;
        flex: 1;
    }

    #leftmenu-privilege {
        width: 200px;
        min-height: 75vh;
        background-color: #f0f0f0;
        display: flex;
        flex-direction: column;
    }

    .menu-item {
        padding: 10px;
        color: #333;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 0.3s;
        display: flex;
        justify-content: center;
    }

    .menu-item.active {
        background-color: #ddd;
    }

    .menu-item:hover {
        background-color: #ddd;
    }

    #content-privilege {
        flex: 1;
        background-color: white;
    }

    #privilege-table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
    }

    #privilege-table th,
    #privilege-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #privilege-table th {
        background-color: #f2f2f2;
    }
    #confirm-row {
        text-align: right;
    }

    #confirm-row .btn {
        background-color: #007BFF;
        color: white;
        margin: 10px;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
    }
    #confirm-row .btn:hover {
        background-color:  #3162B9;
    }
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Màu nền với độ trong suốt */
        z-index: 99; /* Đặt z-index cao hơn so với popup form */
        display: none; /* Ẩn mặc định */
    }
    #popup-form {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        z-index: 100;
        text-align: right;
    }

    #popup-form input[type="text"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #popup-form button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin: 10px;
    }

    #popup-form #cancel-btn {
        background-color: #ccc;
        color: black;
    }

    #popup-form #confirm-btn {
        background-color: #007BFF;
        color: white;
    }

</style>
    <div id="container-privilege">
        <div id="head-privilege">
            <button class="btn" id="add-btn">Thêm</button>
            <button class="btn" id="edit-btn">Sửa</button>
            <button class="btn" id="delete-btn">Xóa</button>
        </div>
        <div id="content-wrapper">
            <div id="leftmenu-privilege">
                <?php foreach ($quyen as $item): ?>
                    <a href="#" class="menu-item" id="<?= $item['ten'] ?>"><?= $item['ten'] ?></a>
                <?php endforeach; ?>
            </div>
            <div id="content-privilege">
            <table id="privilege-table" style="display: none;">
                <thead>
                    <tr>
                        <th>Tính năng</th>
                        <th>Xem</th>
                        <th>Thêm</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td id="privilege_management">Phân quyền</td>
                        <td><input type="checkbox" id="privilege_management_view"></td>
                        <td><input type="checkbox" id="privilege_management_add"></td>
                        <td><input type="checkbox" id="privilege_management_edit"></td>
                        <td><input type="checkbox" id="privilege_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="account_management">Tài khoản</td>
                        <td><input type="checkbox" id="account_management_view"></td>
                        <td><input type="checkbox" id="account_management_add"></td>
                        <td><input type="checkbox" id="account_management_edit"></td>
                        <td><input type="checkbox" id="account_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="question_management">Câu hỏi</td>
                        <td><input type="checkbox" id="question_management_view"></td>
                        <td><input type="checkbox" id="question_management_add"></td>
                        <td><input type="checkbox" id="question_management_edit"></td>
                        <td><input type="checkbox" id="question_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="exam_management">Đề thi</td>
                        <td><input type="checkbox" id="exam_management_view"></td>
                        <td><input type="checkbox" id="exam_management_add"></td>
                        <td></td>
                        <td><input type="checkbox" id="exam_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="classes_management">Lớp học</td>
                        <td><input type="checkbox" id="classes_management_view"></td>
                        <td><input type="checkbox" id="classes_management_add"></td>
                        <td><input type="checkbox" id="classes_management_edit"></td>
                        <td><input type="checkbox" id="classes_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="classes">Tham gia lớp học</td>
                        <td><input type="checkbox" id="classes_view"></td>
                        <td><input type="checkbox" id="classes_add"></td>
                        <td></td>
                        <td><input type="checkbox" id="classes_remove"></td>
                    </tr>
                    <tr>
                        <td id="examination_schedule_management">Thông báo</td>
                        <td><input type="checkbox" id="examination_schedule_management_view"></td>
                        <td><input type="checkbox" id="examination_schedule_management_add"></td>
                        <td><input type="checkbox" id="examination_schedule_management_edit"></td>
                        <td><input type="checkbox" id="examination_schedule_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="student_management">Học viên</td>
                        <td><input type="checkbox" id="student_management_view"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td id="lecturers_management">Giảng viên</td>
                        <td><input type="checkbox" id="lecturers_management_view"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td id="subject_management">Môn học</td>
                        <td><input type="checkbox" id="subject_management_view"></td>
                        <td><input type="checkbox" id="subject_management_add"></td>
                        <td><input type="checkbox" id="subject_management_edit"></td>
                        <td><input type="checkbox" id="subject_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="chapter_management">Chương</td>
                        <td><input type="checkbox" id="chapter_management_view"></td>
                        <td><input type="checkbox" id="chapter_management_add"></td>
                        <td><input type="checkbox" id="chapter_management_edit"></td>
                        <td><input type="checkbox" id="chapter_management_remove"></td>
                    </tr>
                    <tr>
                        <td id="statistics_of_students_average_by_month_and_year">Thống kê</td>
                        <td><input type="checkbox" id="statistics_of_students_average_by_month_and_year_view"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <!-- <tr>
                        <td id="statistics2">Thống kê 2</td>
                        <td><input type="checkbox" id="statistics2_view"></td>
                        <td><input type="checkbox" id="statistics2_add"></td>
                        <td><input type="checkbox" id="statistics2_edit"></td>
                        <td><input type="checkbox" id="statistics2_remove"></td>
                    </tr> -->
                    <tr>
                        <td colspan="5" id="confirm-row" style="text-align: right;">
                            <button class="btn">Xác nhận</button>
                        </td>
                    </tr>
                    <!-- Thêm các hàng dữ liệu khác tại đây nếu cần -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="overlay"></div>
    <div id="popup-form" style="display: none;">
        <form id="quyen-form">
            <input type="text" id="ten-quyen-input" placeholder="Nhập tên quyền">
            <button id="cancel-btn">Hủy</button>
            <button type="submit" id="confirm-btn">Xác nhận</button>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-btn').hide();
            $('#edit-btn').hide();
            $('#delete-btn').hide();
            const userdata = JSON.parse(localStorage.getItem("userData"));
            userID = userdata.userId;
            $.ajax({
                url: './PrivilegeController/getchucnang/' + userID,
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    response.forEach(function(privilege) {
                        if (privilege.cn === 'Add') {
                            $('#add-btn').show();
                        }
                        if (privilege.cn === 'Edit') {
                            $('#edit-btn').show();
                        }
                        if (privilege.cn === 'Remove') {
                            $('#delete-btn').show();
                        }
                    });
                },
                error: function() {
                    console.error(error);
                }
            });    

            let initialPrivileges = {};

            function showPopup() {
                $("#popup-form").show();
                $(".overlay").show();
            }

            function hidePopup() {
                $("#popup-form").hide();
                $(".overlay").hide();
            }
            $("#delete-btn").click(function(){
                let activeMenuItem = $(".menu-item.active");
                if (activeMenuItem.length > 0) {
                    let currentName = activeMenuItem.text();
                    console.log("currentName"+currentName);
                        $.ajax({
                            url: './PrivilegeController/deleteQuyen/'+currentName,
                            method: 'POST',
                            success: function(response) {
                                if (response) {
                                    alert('xóa thành công');
                                    location.reload();
                                }
                            },
                            error: function() {
                                alert('xóa thất bại');
                                console.error(error);
                            }
                        });
                } else {
                    alert('Vui lòng chọn một quyền để xóa.');
                }
            });
            $("#edit-btn").click(function() {
                let activeMenuItem = $(".menu-item.active");
                if (activeMenuItem.length > 0) {
                    let roleName = activeMenuItem.attr("id");
                    let currentName = activeMenuItem.text();

                    // Hiển thị popup form để sửa tên
                    $("#ten-quyen-input").val(currentName);
                    showPopup();

                    $("#confirm-btn").off().on("click", function(event) {
                        event.preventDefault();
                        let newName = $("#ten-quyen-input").val();

                        // Gửi yêu cầu cập nhật tên quyền
                        $.ajax({
                            url: './PrivilegeController/updateQuyen/' + newName +'/'+ currentName,
                            method: 'POST',
                            success: function(response) {
                                if (response) {
                                    alert('sửa thành công');
                                    location.reload();
                                }
                            },
                            error: function() {
                                alert('sửa thất bại');
                                console.error(error);
                            }
                        });

                            // Đóng popup form sau khi xác nhận
                            hidePopup();
                        });
                } else {
                    alert('Vui lòng chọn một quyền để sửa.');
                }
            });

            function addMenuItem(tenQuyen) {
                var newMenuItem = $('<a>', {
                    href: '#',
                    class: 'menu-item',
                    id: tenQuyen,
                    text: tenQuyen
                });

                $('#leftmenu-privilege').append(newMenuItem);

                setMenuItemClickEvent(newMenuItem);
            }

            function setMenuItemClickEvent(menuItem) {
                menuItem.click(function() {
                    let roleName = $(this).attr('id');
                    $('#privilege-table').show();

                    $.ajax({
                        url: './PrivilegeController/showPhanquyen/' + roleName,
                        method: 'POST',
                        success: function(response) {
                            let privileges = response;
                            $('input[type="checkbox"]').prop('checked', false);

                            initialPrivileges = {};

                            privileges.forEach(function(privilege) {
                                let module = privilege.tn.toLowerCase().replace(/ /g, '_');
                                let action = privilege.cn.toLowerCase();
                                let checkboxId = `${module}_${action}`;
                                $(`#${checkboxId}`).prop('checked', true);

                                if (!initialPrivileges[module]) {
                                    initialPrivileges[module] = {};
                                }
                                initialPrivileges[module][action] = true;
                            });

                            console.log('Initial Privileges:', initialPrivileges);
                        },
                        error: function() {
                            alert('Error fetching privileges');
                        }
                    });
                });
            }

            $(".menu-item").each(function() {
                setMenuItemClickEvent($(this));
            });

            $("#add-btn").click(function() {
                showPopup();
                $("#ten-quyen-input").val("");
                $("#confirm-btn").off().on("click", function(event) {
                    event.preventDefault();
                    var tenQuyen = $("#ten-quyen-input").val();
                    $.ajax({
                        url: './PrivilegeController/insertQuyen/' + tenQuyen,
                        method: 'POST',
                        success: function(response) {
                            if (response) {
                                addMenuItem(tenQuyen);
                            }
                        },
                        error: function() {
                            alert('Error adding privilege');
                        }
                    });
                    hidePopup();
                });
            });

            $("#cancel-btn").click(function(event) {
                event.preventDefault();
                hidePopup();
            });


            $('#confirm-row .btn').click(function() {
                let updatedPrivileges = [];
                let deletedPrivileges = [];
                let roleName = $(".menu-item.active").attr("id");

                $('#privilege-table tbody tr').each(function() {
                    let moduleName = $(this).find('td:first').attr('id');
                    $(this).find('input[type="checkbox"]').each(function() {
                        let actionName = $(this).attr('id').replace(`${moduleName}_`, '');
                        let isChecked = $(this).is(':checked');

                        if (initialPrivileges[moduleName] && initialPrivileges[moduleName][actionName] !== isChecked) {
                            if (isChecked) {
                                updatedPrivileges.push({
                                    module: moduleName.replace(/_/g, ' '),
                                    action: actionName,
                                    allowed: isChecked
                                });
                            } else {
                                deletedPrivileges.push({
                                    module: moduleName.replace(/_/g, ' '),
                                    action: actionName
                                });
                            }
                        } else if (!initialPrivileges[moduleName] && isChecked) {
                            updatedPrivileges.push({
                                module: moduleName.replace(/_/g, ' '),
                                action: actionName,
                                allowed: isChecked
                            });
                        }
                    });
                });

                console.log('Updated Privileges:', updatedPrivileges);
                console.log('Deleted Privileges:', deletedPrivileges);
                console.log('Role Name:', roleName);

                $.ajax({
                    url: './PrivilegeController/updatePhanquyen/' +roleName,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        updated: updatedPrivileges,
                        deleted: deletedPrivileges
                    }),
                    success: function(response) {
                        console.log(response);
                        alert('Phân quyền thành công!');
                    },
                    error: function() {
                        alert('Phân quyền thất bại');
                    }
                });
                // $('#privilege-table').hide();
            });

            $("#leftmenu-privilege").on("click", ".menu-item", function() {
                $(".menu-item").removeClass("active");
                $(this).addClass("active");
            });
        });

    </script>
