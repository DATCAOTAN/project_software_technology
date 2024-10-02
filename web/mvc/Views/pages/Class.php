<html>
<?php
// echo 2;
?>

<style>
    .dong {
	display: flex;
	justify-content: space-around;
	border: 1px solid #000;
	height: 50px;
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
    padding: 5px 19px 0px 14px;
    border-bottom: 1px solid #ccc;
    margin-bottom: 20px;
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

#dataClass {
        /* border-style:solid ; */
        position: absolute;
        top: 20%;
        left: 7%;
        width: 95%;
        border-collapse: collapse;
    }

.modal-content{
    width: 600px;
    height: 400px;
}

</style>

<section class="mainContent" id="Mainpages">
    <div class="">
        <div class="cauhoi-header">
            <div class="search-container">
                <input type="text" id="searchInput" name="keyword" placeholder="Tìm kiếm lớp học...">
                <button type="button" id="searchbtn">Tìm kiếm</button>
            </div>
            <div class="chucnang">

                <button id="createClass" class="button"> Tạo lớp học</button>
                <button id="editClass" class="button"> Sửa lớp học </button>
                <button id="removeClass" class="button"> Xóa lớp học </button>
                
            </div>

        </div>


        <div class="cross">
            <div class="horizontal-line"></div>
            <div class="vertical-line"></div>
            <div class="labels">
                <span>THÔNG TIN LỚP HOC</span>
                <!-- <span>Tên Môn Hoc</span> -->
                <!-- <span>Độ khó</span> -->
                <!-- <span>Người tạoo</span> -->
            </div>
            <div>
                <div style="display:none;" id="selectedRowInfo"></div>

                <div id="dataClass">

                    
                </div>

            </div>
        </div>
    </div>

    <div class="Sticket" id="create">
        <div class="modal-content">
            <div class="modalheader">
                <button id="closecreateQ"> x<i class="ti-close"></i> </button>
            </div>
            <div id="InforCreate">

            </div>
                <div class="cauhoi">
                    <p>Tên lớp học</p>
                    <input id="contentCreateClass" type="text" name="contentQ">
                </div>

                <button  class="button" id="confirmcreateClass">Tạo lớp học</button>


        </div>
    </div>
    <div class="Sticket" id="edit">
        <div class="modal-content">
            <div class="modalheader">
                <button id="closeedit"> x<i class="ti-close"></i> </button>
            </div>
            <div id="FormEdit">


                
            </div>
                <div class="cauhoi">
                    <p>Tên lớp học mới</p>
                    <input id="contentEditClass" type="text" name="contentQ">
                </div>
            <button type="Classmit" class="button" id="fixClassject">Sửa lớp học</button>


        </div>
    </div>


</section>
<script>
    // alert(1)
    document.addEventListener("DOMContentLoaded", function() {
        /// an hien cac thong tin

        // alert(1); class
        $('#createClass').hide();
            $('#editClass').hide();
            $('#removeClass').hide();
            const userdata = JSON.parse(localStorage.getItem("userData"));
            userID = userdata.userId;
            $.ajax({
                url: './SubController/getchucnang/' + userID+ '/Classes',
                method: 'POST',
                success: function(response) {
                    console.log(response);
                    response.forEach(function(privilege) {
                        if (privilege.cn === 'Add') {
                            $('#createClass').show();
                        }
                        if (privilege.cn === 'Edit') {
                            $('#editClass').show();
                        }
                        if (privilege.cn === 'Remove') {
                            $('#removeClass').show();
                        }
                    });
                },
                error: function() {
                    console.error(error);
                }
            });  
        // select element
        // console.log(closeloggin)
        var searchbtn = document.querySelector("#searchbtn")
        var CreateQ = document.querySelector("#createClass")
        var FixClass = document.querySelector("#editClass")
        var closecreateQ = document.querySelector("#closecreateQ");
        var closeedit = document.querySelector("#closeedit");
        var create =document.querySelector("#confirmcreateClass");
        var fix =document.querySelector("#fixClassject");
        var remove = document.querySelector("#removeClass");

        // TongQuan.addEventListener("click", showTongQuan);

        //show cau hoi
        CreateQ.addEventListener("click", showCreateQ)
        closecreateQ.addEventListener("click", closeQ);
        //login

        FixClass.addEventListener("click", showEdit);
        closeedit.addEventListener("click", closeE)
        //show de thi
        searchbtn.addEventListener("click", searchQ);
        //
        create.addEventListener("click", confirmCreate);
        fix.addEventListener("click", confirmfix);

        remove.addEventListener("click", removeClass);

        loaddata();

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
        
        const userdata = JSON.parse(localStorage.getItem("userData"));
        userID = userdata.userId;

        let form =document.querySelector("#InforCreate")
        while (form.firstChild) {
            form.removeChild(form.firstChild);
        }
        

        let url = `./ClassController/getmysub1/${userID}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    form.innerHTML += this.responseText ;
                    // alert(this.responseText)
                    addeventforrow();

                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();

        
        //// cao data tao div
        console.log(1)

    };

    var loaddata =function(){
        const userdata = JSON.parse(localStorage.getItem("userData"));
        userID = userdata.userId;
        // console.log();
        let data =document.querySelector("#dataClass");
        while (data.firstChild) {
            data.removeChild(data.firstChild);
        }


        let url = `./ClassController/loaddata/${userID}`;
            // let data = document.getElementById("dataQ");
           
    
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
            // reload();

    }

    var confirmCreate =function(){
        // console.log(1)
        
        let input =document.querySelector("#contentCreateClass").value;
        let mon =document.querySelector("#Mainselect").value;
        const userdata = JSON.parse(localStorage.getItem("userData"));
        userID = userdata.userId;
        // console.log(input,mon, userID);

        if(input.trim() == "")alert(" Vui Lòng Nhập Tên Môn")
    
        else if(mon ==0) alert("vui lòng chọn môn")
        else
        {
            
            let url = `./ClassController/create/${input}/${userID}/${mon}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    // data.innerHTML = this.responseText;
                    // alert(this.responseText)
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            reload();
        }
    }

    var showEdit = function() {
        let select = document.querySelector("#selectedRowInfo").textContent;
        console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];

        const userdata = JSON.parse(localStorage.getItem("userData"));
        userID = userdata.userId;
        // console.log(addid)
        let form =document.querySelector("#FormEdit")
        document.querySelector("#contentEditClass").value = name;
        while (form.firstChild) {
                form.removeChild(form.firstChild);
            } 
        


        if (select[0] == undefined) alert(" chọn môn để edit ");
        else {

            modal = document.querySelector("#edit");
            modal.style.display = "block"

            //// cao data tao div 
            
            let url = `./ClassController/getmysub2/${userID}`;
            // let data = document.getElementById("dataQ");
           
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
                    form.innerHTML = this.responseText ;
                    // alert(this.responseText)
                    // addeventforrow();

                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
            console.log(1)
        }
        
        

        


    };


    var confirmfix =function(){

        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];
        let input = document.querySelector("#contentEditClass").value;
        let mon =document.querySelector("#MainselectEdit").value;
        if(input.trim() == "")alert(" Vui Lòng Nhập Tên Môn")
        if(mon == 0 )alert(" Vui lòng chọn môn")
        else
        {
            
            let url = `./ClassController/edit/${id}/${input}/${mon}`;
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

    var removeClass =function(){
        let select = document.querySelector("#selectedRowInfo").textContent;
        // console.log(select.textContent)
        let selected = select.split('/');
        let id = selected[0];
        let name =selected[1];

        if(id.trim() == "")alert(" Vui Lòng chọn Tên Môn")
        else
        {
            
            let url = `./ClassController/remove/${id}`;
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
        // let searchValue = document.getElementById("searchInput").value.trim();

        // if (searchValue === "") {
        //     alert("Nhập dữ liệu để tìm kiếm");
        //     reload();
        //     return;
        // }
        // // Xây dựng URL mới với searchValue được truyền qua query string
        // let url = `./ClassController/search/${searchValue}`;
        // let data = document.getElementById("dataQ");
        // while (data.firstChild) {
        //     data.removeChild(data.firstChild);
        // }

        // var xhttp = new XMLHttpRequest();
        // xhttp.onreadystatechange = function() {
        //     if (this.readyState == 4 && this.status == 200) {
        //         // Hiển thị kết quả trong phần tử HTML với id là 'dataQ'
        //         data.innerHTML = this.responseText;
        //         // alert(this.responseText)
        //         addeventforrow();
        //     }
        // };
        // xhttp.open("GET", url, true);
        // xhttp.send();
}
        // Chuyển hướng tới URL mới
    


    var reload = function() {
        window.location.href = "http://localhost/Project_web2/web/ClassController";
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
            });
        });
    }



    var loadchapter = function() {

    }

</script>

</html>