<html>
<?php
// echo 2;
?>

<style>
    .dong {
	display: flex;
	justify-content: space-around;
	border: 1px solid #000;
	height: 30px;
    /* margin-left: -20px; */
	margin-top: 2px
	
}
.data-container {
    display: flex;
    flex-direction: column;
}

.dong {
    display: flex;
    justify-content: space-between;
    padding: 5px 190px 0px 140px;
    border-bottom: 1px solid #ccc;
}

.cell {
    flex: 1;
    padding: 5px;
}

.no-data {
    padding: 10px;
}

#dataQ *{
	list-style-type: none;

}

#contentQ{
	height: 70px;
	width: 200px;
	font-size: 20px;
}
</style>

<section class="mainContent" id="Mainpages">
    <div class="">
        <div class="cauhoi-header">
            <div class="search-container">
                <input type="text" id="searchInput" name="keyword" placeholder="Tìm kiếm môn học...">
                <button type="button" id="searchbtn">Tìm kiếm</button>
            </div>
            <div id="chucnang">
                <button  id="createsub" class="button"> Tạo Môn học</button>
                 <button  id="editsub" class="button"> Sửa Môn Học </button>
                 <button  id="removesub" class="button"> Xóa Môn Học </button>
                
            </div>
            

     
        </div>


        <div class="cross">
            <div class="horizontal-line"></div>
            <div class="vertical-line"></div>
            <div class="labels">
                <span>ID</span>
                <span>Tên Môn Hoc</span>
                <!-- <span>Độ khó</span> -->
                <!-- <span>Người tạoo</span> -->
            </div>
            <div>
                <div style="display:none;" id="selectedRowInfo"></div>

                <div id="dataQ">

                    <?php
                    $html = '<table>';
                    

                    if (!empty($data["Sub"])) {
                        foreach ($data["Sub"] as $row) {
                            $html .= '<div class="dong">';
                            $html .= '<div id="ID">' . $row['ID'] . '</div>';
                            $html .= '<div id="name">' . $row['Ten'] . '</div>';
                            $html .= '</div>';
                        }
                    } else {
                        // Nếu không có kết quả, hiển thị thông báo "chưa có câu hỏi nào"
                        $html .= '<tr><td colspan="4">Chưa có câu hỏi nào</td></tr>';
                    }

                    $html .= '</table>';
                    echo $html;
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="Sticket" id="create">
        <div class="modal-content">
            <div class="modalheader">
                <button id="closecreateQ"> x<i class="ti-close"></i> </button>
            </div>
            <div >
                <div class="cauhoi">
                    <p>Tên môn học</p>
                    <input id="contentCreateSub" type="text" name="contentQ">
                </div>

                <button  class="button" id="createSubject">Tạo môn học</button>
            </div>


        </div>
    </div>
    <div class="Sticket" id="edit">
        <div class="modal-content">
            <div class="modalheader">
                <button id="closeedit"> x<i class="ti-close"></i> </button>
            </div>
            <div method="post" action="SubController/edit">


                <div class="cauhoi">
                    <p>Tên môn học mới</p>
                    <input id="contentEditSub" type="text" name="contentQ">
                </div>

                <button type="submit" class="button" id="fixSubject">Sửa môn học</button>
            </div>


        </div>
    </div>


</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // alert(1)
    document.addEventListener("DOMContentLoaded", function() {
        /// an hien cac thong tin

        // alert(1);
        // select element
        addbutton();
        // console.log(closeloggin)
        var searchbtn = document.querySelector("#searchbtn")
        var CreateQ = document.querySelector("#createsub")
        var FixSub = document.querySelector("#editsub")
        var closecreateQ = document.querySelector("#closecreateQ");
        var closeedit = document.querySelector("#closeedit");
        var create =document.querySelector("#createSubject");
        var fix =document.querySelector("#fixSubject");
        var remove = document.querySelector("#removesub");

        // TongQuan.addEventListener("click", showTongQuan);

        //show cau hoi

        CreateQ.addEventListener("click", showCreateQ)
        closecreateQ.addEventListener("click", closeQ);
        //login

        FixSub.addEventListener("click", showEdit);
        closeedit.addEventListener("click", closeE)
        //show de thi
        searchbtn.addEventListener("click", searchQ);
        //
        create.addEventListener("click", confirmCreate);
        fix.addEventListener("click", confirmfix);

        remove.addEventListener("click", removesub);
        addeventforrow();
    });

    var closeQ = function() {
        modal = document.querySelector("#create");
        modal.style.display = "none";
        // showcauhoi();
    }
    var closeE = function() {
        modal = document.querySelector("#edit");
        modal.style.display = "none";
        // showcauhoi();
    }

    var showCreateQ = function() {
        modal = document.querySelector("#create");
        modal.style.display = "block"

        //// cao data tao div
        console.log(1)

    };

    var confirmCreate =function(){

        let input =document.querySelector("#contentCreateSub").value;
        // console.log(input);

        if(input.trim() == "")alert(" Vui Lòng Nhập Tên Môn")
        else
        {
            
            let url = `./SubController/create/${input}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }
    }

    var showEdit = function() {
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];
        // console.log(addid)

        document.querySelector("#contentEditSub").value = name;

        if (select[0] === "") alert(" chọn môn để edit ");
        else {

            modal = document.querySelector("#edit");
            modal.style.display = "block"

            //// cao data tao div
            console.log(1)
        }


    };


    var confirmfix =function(){
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];
        let input = document.querySelector("#contentEditSub").value;

        if(input.trim() == "")alert(" Vui Lòng Nhập Tên Môn")
        else
        {
            
            let url = `./SubController/edit/${id}/${input}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }
    }

    var removesub =function(){
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];

        if(id.trim() == "")alert(" Vui Lòng chọn Tên Môn")
        else
        {
            
            let url = `./SubController/remove/${id}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }
    }

    var searchQ = function() {
        let searchValue = document.getElementById("searchInput").value.trim();

        if (searchValue === "") {
            alert("Nhập dữ liệu để tìm kiếm");
            reload();
            return;
        }
        // Xây dựng URL mới với searchValue được truyền qua query string
        let url = `./SubController/search/${searchValue}`;
        let data = document.getElementById("dataQ");
        while (data.firstChild) {
            data.removeChild(data.firstChild);
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                data.innerHTML = this.responseText;
                // alert(this.responseText)
                addeventforrow();
            }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
}
        // Chuyển hướng tới URL mới
    


    var reload = function() {
        window.location.href = "http://localhost/Project_web2/web/SubController";
    }
    var addbutton = function(){
        $('#createsub').hide();
            $('#editsub').hide();
            $('#removesub').hide();
            const userdata = JSON.parse(localStorage.getItem("userData"));
            userID = userdata.userId;
            $.ajax({
                url: './SubController/getchucnang/' + userID+ '/Subject',
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    response.forEach(function(privilege) {
                        if (privilege.cn === 'Add') {
                            $('#createsub').show();
                        }
                        if (privilege.cn === 'Edit') {
                            $('#editsub').show();
                        }
                        if (privilege.cn === 'Remove') {
                            $('#removesub').show();
                        }
                    });
                },
                error: function() {
                    console.error(error);
                }
            });   
       
    }

    var addeventforrow = function() {
        var selectedRowInfo = document.querySelector('#selectedRowInfo');
        var rows = document.querySelectorAll('.dong');

        // Lặp qua từng dòng và thêm sự kiện click
        rows.forEach(row => {
            row.addEventListener('click', function() {
                // Loại bỏ màu nền của tất cả các dòng
                rows.forEach(row => {
                    row.style.backgroundColor = '';
                    row.style.color = 'black';
                });

                // Đặt màu nền cho dòng được click
                this.style.backgroundColor = '#ff9900';
                this.style.color = 'white'

                // In ra thông tin của dòng được chọn
                selectedRowInfo.textContent = this.querySelector('#ID').textContent +'/' +this.querySelector('#name').textContent;
                let remove =document.querySelector("#idremove");
                remove.value = this.querySelector('#ID').textContent;

                console.log(this.querySelector('#ID').textContent)
            });
        });
    }



    var loadchapter = function() {

    }

</script>

</html>