    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> 
    <style>
        /* CSS cho header */
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: arial;
        }
        .header {
            width: 100%;
            display: flex;
            background-color: white;
            align-items: center;
            height: 10vh;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .header #header_left {
            display: flex;
            position: fixed;
            width: 15%;
            background-color: #3162B9;
            align-items: center;
            z-index: 1000;
        }

        .header #header_left #SGU {
            color: white;
            margin: 30px 0px 30px 30px;
        }

        .header #header_left #Quiz {
            margin-left: 5px;
            color: white;
        }

        .header #user {
            border-radius: 10px;
            padding: 12px 14px 12px 14px;
            background-color: #e0e0e0;
            margin-left: auto;
            margin-right: 80px;
            cursor: pointer;
        }

        .header li {
            padding: 5px;
        }

        .header ul {
            list-style-type: none;
        }

        .header a {
            text-decoration: none;
            color: #878787;
        }

        .header #user:hover {
            background-color: #cdcdcd;
        }

        .header #drop_menu {
            position: absolute;
            top: 55px;
            left: 1205px;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hidden {
            display: none;
        }

        /* CSS cho left menu */
        #left_menu {
            width: 15%;
            background-color: #f2f2f2;
            height: 90vh;
            overflow-y: auto;
            float: left;
            display: flex;
            flex-direction: column;
            padding: 20px 10px;
            position: fixed;
            top: 10vh; /* Bắt đầu từ dưới của header */
            z-index: 1000;
        }

        #left_menu h4 {
            color: #878787;
            padding-left: 10px;
        }

        #left_menu ul {
            list-style-type: none;
        }

        #left_menu li {
            margin: 0px 5px;
        }

        #left_menu a {
            margin: 5px 0px;
            border-radius: 5px;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #878787;
        }

        #left_menu a:hover {
            background-color: #cce2fe;
            color: black;
        }

        /* CSS cho phần detail */
        .detail {
            margin-left: 15%;
            padding: 20px;
            height: 100%;
            background-color: #E0E0E0;
            margin-top: 10vh; /* Để tránh việc nội dung bị che phủ bởi header và left menu */
        }
        #cotainer{
            height: 90vh;
            background-color: #FFFFFF;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup-header {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 400px;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            padding: 20px;
            background-color: #FFFFFF;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group img {
            display: block;
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .buttons {
            text-align: right;
        }
        .buttons button {
            padding: 8px 15px;
            margin-left: 10px;
        }
        /* .header {
            width: 100%;
            display: flex;
            background-color: white;
            align-items: center;
            height: 10vh;
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .header #header_left {
            display: flex;
            position: fixed;
            width: 15%;
            background-color: #3162B9;
            align-items: center;
            z-index: 1000;
        }

        .header #header_left #SGU {
            color: white;
            margin: 30px 0px 30px 30px;
        }

        .header #header_left #Quiz {
            margin-left: 5px;
            color: white;
        }

        .header #user {
            border-radius: 10px;
            padding: 12px 14px 12px 14px;
            background-color: #e0e0e0;
            margin-left: auto;
            margin-right: 80px;
            cursor: pointer;
        }

        .header li {
            padding: 5px;
        }

        .header ul {
            list-style-type: none;
        }

        .header a {
            text-decoration: none;
            color: #878787;
        }

        .header #user:hover {
            background-color: #cdcdcd;
        }

        .header #drop_menu {
            position: absolute;
            top: 55px;
            left: 1205px;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hidden {
            display: none;
        } */

        /* CSS cho left menu */
        /* #left_menu {
            width: 15%;
            background-color: #f2f2f2;
            height: 90vh;
            overflow-y: auto;
            float: left;
            display: flex;
            flex-direction: column;
            padding: 20px 10px;
            position: fixed;
            top: 10vh; 
            z-index: 1000;
        }

        #left_menu h4 {
            color: #878787;
            padding-left: 10px;
        }

        #left_menu ul {
            list-style-type: none;
        }

        #left_menu li {
            margin: 0px 5px;
        }

        #left_menu a {
            margin: 10px 0px;
            border-radius: 5px;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #878787;
        }

        #left_menu a:hover {
            background-color: #cce2fe;
            color: black;
        } */

        /* CSS cho phần detail */
        .detail {
            margin-left: 15%;
            padding: 20px;
            height: 100%;
            background-color: #E0E0E0;
            margin-top: 10vh; /* Để tránh việc nội dung bị che phủ bởi header và left menu */
        }
        #cotainer{
            height: 90vh;
            background-color: #FFFFFF;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .popup-header {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 400px;
            transform: translate(-50%, -50%);
            border-radius: 8px;
            padding: 20px;
            background-color: #FFFFFF;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .form-group img {
            display: block;
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }
        .form-group input[type="file"] {
            padding: 3px;
        }
        .buttons {
            text-align: right;
        }
        .buttons button {
            padding: 8px 15px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <?php include("inc/header.php"); ?>
    </div>
    <div class="left-menu">
        <?php include("inc/left_menu.php"); ?>
    </div>
    <div class="detail">
        <?php require_once "./mvc/Views/pages/".$page.".php"; ?>
    </div>
    <div class="overlay" id="overlay"></div>
    <div id="container"></div>
        <div class="popup-header" id="popup">
            <form id="popupForm" >
                <div class="form-group">
                    <label for="name">Tên:</label>
                    <input type="text" id="name-header" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email-header" name="email" required>
                </div>
                <div class="form-group">
                    <label for="dob">Ngày sinh:</label>
                    <input type="date" id="dob-header" name="dob" required>
                </div>
                <div class="form-group">
                    <label for="gender">Giới tính:</label>
                    <select id="gender-header" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <!-- <label for="image">Chọn hình:</label> -->
                    <!-- <input type="file" id="image-header" name="image" accept="image/*" onchange="previewImage(event)"> -->
                    <img id="preview" alt="Preview Image" style="max-width: 100px; max-height: 100px;">
                </div>
                <div class="buttons">
                    <button type="button" id="cancelButton">Hủy</button>
                    <!-- <button type="submit">Sửa</button> -->
                </div>
            </form>
        </div>
    </div>
    <script>
        $('#left_menu ul li').hide();
        $(document).ready(function() {
            var userStr = localStorage.getItem('userData');
            var userObj = JSON.parse(userStr);
            // Gửi yêu cầu Ajax để lấy danh sách quyền của người dùng
            $.ajax({
                url: 'http://localhost/Project_web2/web/HomeController/showLeftmenu', // Đường dẫn đến file PHP của bạn
                method: 'POST',
                data: { userId: userObj.userId },
                dataType: 'json',
                success: function(userPrivileges) {
                    // Ẩn tất cả các mục trong menu nếu không có quyền
                    $('#left_menu ul li a').each(function() {
                        var privilegeName = $(this).data('name');
                        if (userPrivileges.includes(privilegeName)) {
                            $(this).parent().show();
                        }
                    });
                },
                // error: function(jqXHR, textStatus, errorThrown) {
                //     console.error('Lỗi: ', textStatus, errorThrown);
                // }
            });
        });
        http://localhost/Project_web2/web/LoginController 
        $("#hienthongtin").click(function() {
            var userStr = localStorage.getItem('userData');
            var userObj = JSON.parse(userStr);
            console.log(userObj.isLoggedIn,userObj.userId)
            if (userObj.isLoggedIn === false) {
                alert("Bạn cần đăng nhập để thực hiện thao tác này.");
                window.location.href = "/login";
                return;
            }
            $("#overlay").show();
            $("#popup").show();
            $.ajax({
                    type: 'POST',
                    url: "index.php?url=HomeController/showData/"+userObj.userId,
                    success: function(response) {
                        if(response){
                            $("#name-header").val(response.ten);
                            $("#email-header").val(response.email);
                            $("#dob-header").val(response.ngay_sinh);
                            $("#gender-header").val(response.gioi_tinh);
                            // Nếu có trường hình ảnh trong response và URL hình ảnh hợp lệ
                            if (response.hinh) {
                                $("#preview").attr("src", response.hinh).show();
                            } else {
                                $("#preview").hide();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi khi gửi yêu cầu AJAX:", error);
                    }
                });
        });

        $("#cancelButton").click(function() {
            $("#overlay").hide();
            $("#popup").hide();
        });

        $("#overlay").click(function() {
            $(this).hide();
            $("#popup").hide();
        });  
        $(document).ready(function() {
            $(window).on('load', function() {
                var userData = localStorage.getItem('userData');
                userData = JSON.parse(userData);
                if (userData.isLoggedIn) {
                    $('#logout').removeClass('hidden');
                    $('#login').addClass('hidden');
                } else {
                    $('#logout').addClass('hidden');
                    $('#login').removeClass('hidden');
                }
            });

            // Sự kiện click cho phần tử "user"
            $("#user").click(function() {
                var dropMenu = $("#drop_menu");

                if (dropMenu.hasClass("hidden")) {
                    dropMenu.removeClass("hidden");
                } else {
                    dropMenu.addClass("hidden");
                }
            });

            // Sự kiện click cho phần tử "logout"
            $("#logout").click(function() {
                console.log("alo");
                unset($_SESSION['userData']);
                var userData = localStorage.getItem('userData');
                if (userData) {
                    userData = JSON.parse(userData);
                    if (userData.isLoggedIn) {
                        userData.isLoggedIn = false;
                        userData.userId = null;
                        userData.ten = null;
                        userData.tendangnhap = null;
                        localStorage.setItem('userData', JSON.stringify(userData)); // Lưu thay đổi vào localStorage
                    }
                }
            });
        });
    </script>
</body>
<style>
        /* CSS cho phần detail */
        .detail {
            margin-left: 15%; /* Chiều rộng của left menu */
            padding: 20px;
            height: 90vh;
        }

        #Mainpages{
            border: solid 1px black;
            border-radius: 2%;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5);
            height: 100%;
            display: flex;
            justify-content: center;
        }

        #content .mainContent {
            float: left;
            width: 70%;
            text-align: center;
            padding-left: 4%;
            /* border: solid 1px black; */

        }
        /*menubar's properties for menus in sidebar */
        #content .sidebar #menubar {
            text-align: left;
            color: rgba(146,146,146,1.00);
            position: relative;
            left: 0%;
            color: #ff9900;
            font-size: 25px;
            width: 100%;
        }

        #content .sidebar #menubar a{

            color: #3796bf;
            font-size: 18px;
        }
        #content .sidebar #menubar a:hover{

            color: #ff9900;
            /* font-size: 18px; */
        }

        /* Search field in sidebar */
        #content .sidebar #search {
            width: 100%;
            border-radius: 0px;
            height: 42px;
            text-align: center;
            color: rgba(208,207,207,1.00);
            font-size: 14px;
            ;
            margin-bottom: 21px;
        }

        /* Whole page content */
        #mainWrapper {
            width: 100%;
            padding-left: 0%;
            
        }
        /*menu elements */
        .menu ul li {
            list-style-type: none;
            font-size: x-large;
            position: relative;
            left: -35px;
            padding-top: 12px;
        }
        /* ////////// Main ///////// */
        fieldset {
            position: relative;
            min-height: 400px;
            text-align: left;
            min-width: 600px;
        }
        .hide{
            display: none;
        }

        .search-container {
            display: flex;
            align-items: center;
        }
        
        .search-container input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .search-container button {
            padding: 8px 12px;
            background-color: #3796bf;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px;
            width: 20;
            height: 30;
        }
        
        .button{
            padding: 8px 12px;
            background-color: #3796bf;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-container button:hover {
            background-color: #3ec545;
        }
        .button:hover {
            background-color: #ff9900;
            color: white;
        }
        .cauhoi-header{
            display: flex;
            justify-content:space-between;
            margin: 10px;
        }
        .createQ{

        }

        .selectoptionforcreate{
            display: flex;
            justify-content: space-around;
        }

        .chucnang{
            display: flex;
            /* justify-content: ; */
        }

        .cross {
            position: relative;
            width: 800px;
            min-height: 200px;
        }

        .horizontal-line,
        .vertical-line {
            position: absolute;
            background-color: #000;
        }

        .horizontal-line {
            top: 20px;
            left: 0;
            right: 0;
            height: 1px;
            margin-top: -1px;
        }

        .vertical-line {
            left: 20px;
            top: 0;
            bottom: 0;
            width: 1px;
            margin-left: -1px;
        }

        .labels {
            position: absolute;
            z-index: 1;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-around;
            font-size: 17px;
            padding: 12px 25px;
        }

        .labels span {
            color: #333;
            background-color: #fff;
            padding: 0 2px;
            z-index: -10;
        }

        .labels span:nth-child(1){
            /* margin: 0 30px 0 10px; */
        }
        



        .Sticket{
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;   
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            z-index: 5;

        }
        .modal-content{
            top: 0%;
            background-color: white;
            margin: 8% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 800px;
            position: relative;
        }


        .modalheader{
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .select{
            width: 200px;
            height: 40px;
        }

        .cauhoi *{
            padding: 0;
            margin: 5px;
        }

        .dapan *{
            padding: 0;
            margin: 5px;
        }

        .taonoidung{
            display: flex;
            justify-content: space-between;
        }

        .modalheader{
            justify-content: right;
        }

        #dataQ{
            /* border-style:solid ; */
            position: absolute;
            top: 17%;
            left: 5%;
            width: 95%;
            border-collapse: collapse;
        }





        #mainWrapper footer {
            clear: both;
            overflow: auto;
            background-color: rgba(208,207,207,1.00);
            font-family: source-sans-pro, sans-serif;
            font-style: normal;
            font-weight: 200;
            line-height: 1.8;
            padding-top: 22px;
            padding-left: 22px;
            text-align: center;
            padding-bottom: 22px;
            padding-right: 22px;
        }
        /*Each footer content */
        #mainWrapper footer div {
            width: 27%;
            float: left;
            padding-left: 4%;
            padding-right: 2%;
            color: rgba(255,255,255,1.00);
            text-align: justify;
        }
        /* Links in footer */
        footer div a {
            color: rgba(146,146,146,1.00);
            display: block;
            text-decoration: none;
            text-align: center;
        }
        /* Product's images in catalog */
        .productInfo div img {
            width: 100%;
        }
        /*Links in sidebar */
        .sidebar #menubar .menu ul li a {
            color: rgba(146,146,146,1.00);
            text-decoration: none;
        }
        .sidebar #menubar .menu ul li a:hover {
            color: rgba(107,97,97,1.00);
            text-decoration: none;
        }
        /* Menu headings in sidebar */
        #menubar .menu h2 {
            font-size: 20px;
        }
        /*Links under menus in sidebar */
        #menubar .menu ul li a {
            font-size: 14px;
        }
        /* Menus in sidebar */
        .sidebar #menubar .menu {
            margin-bottom: 29px;
        }
        /* Container for links in footer */
        footer .footerlinks {
            margin-top: -15px;
        }

        /* Media query for tablets */
        @media screen and (max-width:700px) {
        /* search field in sidebar */
        #content .sidebar #search {
            display: none;
        }
        /* sidebar */
        #content .sidebar {
            float: none;
            width: 100%;
            height: auto;
            overflow: auto;
            padding-left: 12%;
            padding-top: 0px;
        }
        /* horizontal separators in sidebar */
        #content .sidebar hr {
            display: none;
        }
        /*The sidebar and maincontent of page */
        #content {
            position: relative;
            top: -22px;
            width: 100%;
            overflow: hidden;
        }
        /*menu headings in sidebar */
        #menubar .menu h2 {
            display: inline;
            font-size: medium;
            padding-right: 6%;
        }
        /* Unordered List of links */
        #menubar .menu ul {
            display: inline;
        }
        /*list elements */
        #menubar .menu ul li {
            display: inline;
            font-size: medium;
            padding-left: 0%;
            padding-right: 3%;
        }
        /*The link to be hidden in tablet view */
        .sidebar #menubar .menu ul .notimp {
            display: none;
        }
        /* menus in sidebar */
        .sidebar #menubar .menu {
            width: 100%;
            text-align: center;
            position: relative;
            top: 16px;
        }
        /*menubar in sidebar */
        #content .sidebar #menubar {
            position: relative;
            left: -7%;
            overflow: hidden;
            width: 95%;
            padding-top: 0px;
        }
        /* offer banners content */
        #mainWrapper #offer p {
            font-size: small;
        }
        /* main content region of page */
        #mainWrapper #content .mainContent {
            overflow: hidden;
            width: 95%;
            margin-top: 40px;
        }
        /* Prices of products in catalog view */
        .productRow .productInfo .price {
            font-size: 19px;
        }
        /* Content holders in catalog view */
        .productRow .productInfo .productContent {
            font-size: 16px;
        }
        /* Buy buttons in catalog view */
        .productRow .productInfo .buyButton {
            font-size: 15px;
        }
        /* Container for links in footer */
        #mainWrapper footer .footerlinks {
            float: none;
            width: 100%;
            position: relative;
            top: 17px;
            clear: both;
            text-align: center;
            left: 0%;
            padding-bottom: 19px;
        }
        /* Container for each footer divisions */
        #mainWrapper footer div {
            width: 44%;
            text-align: justify;
            font-size: 15px;
        }
        /* Links in footer */
        .footerlinks p a {
            padding-top: 0px;
            padding-bottom: 0px;
            display: inline;
            padding-right: 35px;
        }
        /* Footer region */
        #mainWrapper footer {
            padding-left: 16px;
            overflow: hidden;
        }
        /* Links in header */
        header #headerLinks a {
            padding-left: 0px;
            padding-right: 30px;
        }
        /* Offer- Text banner */
        #mainWrapper #offer {
            padding-left: 22%;
        }
        /* Paragraphs in footer */
        footer .footerlinks p {
            display: inline;
        }
        }

        /*media query for small screen devices */
        @media screen and (max-width:480px) {
        /*Container for links in header */
        #mainWrapper header #headerLinks {
            width: 100%;
            text-align: center;
            background-color: rgba(190,190,190,1.00);
            padding-bottom: 21px;
        }
        /* Logo placeholder*/

        /* Links in header */
        header #headerLinks a {
            text-align: center;
            padding-right: 15px;
            padding-left: 0px;
        }
        /*Offer - Text Banner */
        #mainWrapper #offer {
            padding-left: 0px;
            text-align: center;
        }
        /* Menubar in sidebar */
        #content .sidebar #menubar {
            position: relative;
            left: -8%;
            text-align: center;
        }
        /*Menu headings in sidebar */
        #menubar .menu h2 {
            width: 100%;
            display: block;
        }
        /* Each product in catalog view */
        .mainContent .productRow .productInfo {
            width: 100%;
            display: block;
            padding-left: 0px;
            padding-right: 0px;
            position: relative;
            left: -2%;
        }
        #mainWrapper footer div {
            width: 100%;
            margin-left: -16px;
            text-align: justify;
            padding-bottom: 16px;
            overflow: auto;
        }
        /* Unordered list for menu elements */
        .menu ul {
            position: relative;
            padding-left: 24%;
        }
        /* Container for links in footer */
        #mainWrapper footer .footerlinks {
            padding-left: 8%;
        }
        /* Main content which excludes the sidebar */
        #mainwrapper #content .mainContent {
            margin-top: -81px;
            text-align: center;
            width: 100%;
            padding-left: 0px;
        }

        /* ////////////////Chapter */


        }


</style>
</html>
