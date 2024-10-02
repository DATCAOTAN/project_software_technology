<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./public/css/login_layout.css">
</head>
<body>
    <div id="container">
        <div id="left">
            <h1>SGU Quiz</h1>
            <h5>Đăng nhập</h5>
            <form action="./LoginController" method="POST">
                <input type="text" id="username" name="username" placeholder="Tên đăng nhập"> <br>
                <input type="password" id="password" name="password" placeholder="Mật khẩu" autocomplete="current-password"> <br>
                <button type="submit" class="button" name="submitbtn"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</button>
            </form>
        </div>
        <div id="right">
            <h1>Welcome to SGU Quiz</h1>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".button").click(function(event){
                event.preventDefault();
                var username = $("#username").val();
                var password = $("#password").val();
                if(username.trim() === "") {
                    alert("Vui lòng nhập tên đăng nhập.");
                    $("#username").focus();
                    return; // Stop further execution
                }
                if(password.trim() === "") {
                    alert("Vui lòng nhập mật khẩu.");
                    $("#password").focus();
                    return; // Stop further execution
                }
                $.ajax({
                    url: "LoginController/check",
                    type: "POST",
                    data: {
                        username: username,
                        password: password
                    },
                    success: function(response){
                        console.log(response);
                        console.log(typeof(response));
                        if(response!=""){
                            response = JSON.parse(response);
                        }
                        if(response.isLoggedIn) {
                            localStorage.setItem('userData', JSON.stringify(response));
                            window.location.href = "./HomeController";
                        } else {
                            alert("Tên đăng nhập hoặc mật khẩu sai");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>