import mysql.connector
import random
from faker import Faker
from datetime import datetime, timedelta

# Kết nối tới cơ sở dữ liệu MySQL
conn = mysql.connector.connect(
    host="localhost",     # Thay đổi nếu bạn sử dụng host khác
    user="root",          # Thay đổi nếu bạn có user khác
    password="123456789",  # Thay đổi mật khẩu của bạn
    database="CNPM"
)

cursor = conn.cursor()

# Khởi tạo Faker để tạo dữ liệu ngẫu nhiên
fake = Faker()
#
sl_tkhoan=10
sl_KHang=sl_tkhoan
sl_thucUong=30
sl_Hdon=30


# Hàm thêm dữ liệu ngẫu nhiên vào bảng tai_khoan



def them_tai_khoan_random():
    cursor.execute("INSERT INTO Tai_khoan (ten_tai_khoan, mat_khau) VALUES ('admin', 'password1')")
    conn.commit()

    for i in range(2, sl_tkhoan+1):
        ten_tai_khoan = fake.user_name()
        mat_khau = fake.password()
        query = "INSERT INTO tai_khoan (ten_tai_khoan, mat_khau) VALUES (%s, %s)"
        cursor.execute(query, (ten_tai_khoan, mat_khau))
    conn.commit()

# Hàm thêm dữ liệu ngẫu nhiên vào bảng nhan_vien
def them_nhan_vien_random():
    id_admin=1
    query = "INSERT INTO nhan_vien (ten, so_dien_thoai, email, tai_khoan_id,Trang_thai) VALUES ('admin', '', '',%s,'0')"
    cursor.execute(query, (id_admin,))
    conn.commit()
    for i in range(2, sl_tkhoan+1):
        ten = fake.name()
        so_dien_thoai = f"092345678{i}"
        email = fake.email()
        Trang_thai = random.choice([True, False])
    # Giả sử các ID từ 1 đến 10 đã có trong bảng tai_khoan
        query = "INSERT INTO nhan_vien (ten, so_dien_thoai, email, tai_khoan_id,Trang_thai) VALUES (%s, %s, %s, %s,%s)"
        cursor.execute(query, (ten, so_dien_thoai, email, i,Trang_thai))
    conn.commit()

# Hàm thêm dữ liệu ngẫu nhiên vào bảng khach_hang
def them_khach_hang_random():
    for i in range(1, sl_KHang+1):
        ten_khach_hang = fake.name()
        so_dien_thoai = f"012345678{i}"
        email = fake.email()
        query = "INSERT INTO khach_hang (ten_khach_hang, so_dien_thoai, email) VALUES (%s, %s, %s)"
        cursor.execute(query, (ten_khach_hang, so_dien_thoai, email))
    conn.commit()

def them_du_lieu_thuc_uong():
    sizes = ['S', 'M', 'L']
  

    for i in range(1, sl_thucUong+1):
        ten_thuc_uong = f"Thuc uong {i}"
        Trang_thai = random.choice([True, False])
        mo_ta = f"Mo ta {i}"
        image_url = f"image{i}.jpg"
        cursor.execute(
            f"INSERT INTO Thuc_uong (Ten_thuc_uong, Mo_ta, image_URL,Trang_thai) "
            f"VALUES ('{ten_thuc_uong}', '{mo_ta}', '{image_url}',{Trang_thai})"
        )

        # Lấy ID của thức uống vừa được chèn
        thuc_uong_id = cursor.lastrowid

        gia_tien_s = random.randint(10000, 50000)
        for size in sizes:
            gia_tien = gia_tien_s + (10000 * (sizes.index(size)))
            trang_thai_ban = random.choice(["Dang ban", "Het hang"])
            cursor.execute(
                f"INSERT INTO Chi_tiet_Thuc_uong (Thuc_uong_ID, Size, Gia_tien, Trang_thai_ban) "
                f"VALUES ('{thuc_uong_id}', '{size}', {gia_tien}, '{trang_thai_ban}')"
            )
def lay_so_tien_thuc_uong(thuc_uong_id, size):
    query = f"""
    SELECT Gia_tien 
    FROM Chi_tiet_Thuc_uong 
    WHERE Thuc_uong_ID = {thuc_uong_id} AND Size = '{size}'
    """
    
    cursor.execute(query)
    result = cursor.fetchone()
    
    if result:
        return result[0]  # Trả về giá tiền
    else:
        return None  # Không tìm thấy kết quả
    

# Hàm thêm dữ liệu ngẫu nhiên vào bảng phuong_thuc_thanh_toan
def them_phuong_thuc_thanh_toan_random():
    payment_methods = ["Tien mat", "Online banking", "E-wallet"]
    for method in payment_methods:
        cursor.execute(f"INSERT INTO Phuong_thuc_thanh_toan (Ten) VALUES ('{method}')")
    conn.commit()

# Hàm thêm dữ liệu ngẫu nhiên vào bảng chi_tiet_phuong_thuc_thanh_toan
def them_chi_tiet_phuong_thuc_thanh_toan_random():
    for i in range (1,4):
        phuong_thuc_thanh_toan_id=i
        if(phuong_thuc_thanh_toan_id==1):continue
        elif(phuong_thuc_thanh_toan_id==2):
            payment_names= ["Vietcombank", "MBank", "Techcombank"]
            for payment_name in payment_names:
                fee = round(random.uniform(1.0, 3.0), 2)
                cursor.execute( 
                    f"INSERT INTO Chi_tiet_phuong_thuc_thanh_toan (phuong_thuc_thanh_toan_id,ten, fee) "
                    f"VALUES ({phuong_thuc_thanh_toan_id},'{payment_name}', {fee})"
                )
        else:
            payment_names=[ "Momo", "ZaloPay"]
            for payment_name in payment_names:
                fee = round(random.uniform(1.0, 3.0), 2)
                cursor.execute(
                    f"INSERT INTO Chi_tiet_phuong_thuc_thanh_toan (phuong_thuc_thanh_toan_id,ten, fee) "
                    f"VALUES ({phuong_thuc_thanh_toan_id},'{payment_name}', {fee})"
                )
    conn.commit()

# Hàm thêm dữ liệu ngẫu nhiên vào bảng hoa_don
def them_hoa_don_cthd_random():
    for i in range(1,sl_Hdon):
        khach_hang_id = random.randint(1, sl_KHang)  # Giả sử có các ID khách hàng từ 1 đến 10
        nhan_vien_id = random.randint(2, sl_tkhoan)   # Giả sử có các ID nhân viên từ 1 đến 10
        data=chi_tiet_hoa_don_random()
        tong_tien = lay_so_tien_thuc_uong(data[0],data[1])*data[2]
        trang_thai = random.choice(["Dang lam", "Da xong"])
        trang_thai_thanh_toan = random.choice([True, False])
        ngay_gio = datetime.now() - timedelta(days=random.randint(1, 30))
        phuong_thuc_thanh_toan_id = random.randint(1, 3)  # Giả sử có ID phương thức thanh toán từ 1 đến 5
        query = """
        INSERT INTO hoa_don (khach_hang_id, nhan_vien_id,ngay_gio, tong_tien, trang_thai, trang_thai_thanh_toan, phuong_thuc_thanh_toan_id)
        VALUES (%s, %s, %s,%s, %s, %s, %s)
        """
        cursor.execute(query, (khach_hang_id, nhan_vien_id,ngay_gio, tong_tien, trang_thai, trang_thai_thanh_toan, phuong_thuc_thanh_toan_id))
        conn.commit()
        #Này là mặt định mua chỉ được 1 món không radom
        query = "INSERT INTO chi_tiet_hoa_don (hoa_don_id, thuc_uong_id, size, so_luong) VALUES (%s, %s, %s, %s)"
        cursor.execute(query, (i,data[0], data[1], data[2]))
        conn.commit()

# Hàm thêm dữ liệu ngẫu nhiên vào bảng chi_tiet_hoa_don
def chi_tiet_hoa_don_random():
    thuc_uong_id = random.randint(1, 10)  # Giả sử có các ID thức uống từ 1 đến 10
    size = random.choice(['S', 'M', 'L'])
    so_luong = random.randint(1, 3)
    return [thuc_uong_id,size,so_luong]

# Hàm thêm dữ liệu ngẫu nhiên vào bảng phan_hoi
def them_phan_hoi_random():
    for i in range(1,sl_Hdon):
        so_sao = random.randint(1, 5)
        noi_dung = fake.sentence()
        query = "INSERT INTO phan_hoi ( hoa_don_id, so_sao, noi_dung) VALUES ( %s, %s, %s)"
        cursor.execute(query, ( i, so_sao, noi_dung))
    conn.commit()

# Thêm nhiều dữ liệu ngẫu nhiên

them_tai_khoan_random()
them_nhan_vien_random()
them_khach_hang_random()
them_phuong_thuc_thanh_toan_random()
them_chi_tiet_phuong_thuc_thanh_toan_random()
them_du_lieu_thuc_uong()
them_hoa_don_cthd_random()

them_phan_hoi_random()

# Đóng kết nối
cursor.close()
conn.close()
