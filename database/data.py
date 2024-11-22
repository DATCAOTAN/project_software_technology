import mysql.connector
import random
from datetime import datetime, timedelta

def connect():
    user = "root"
    password = "123456789"
    host = "localhost"
    database = "CNPM"

    conn = mysql.connector.connect(
        host=host,
        user=user,
        password=password,
        database=database
    )

    if conn.is_connected():
        print("Kết nối thành công")
    else:
        print("Lỗi kết nối")
    return conn

def insert_data(conn, num_records):
    cursor = conn.cursor()

        # Thêm dữ liệu vào bảng Tai_khoan
    cursor.execute("INSERT INTO Tai_khoan (Ten_tai_khoan, Mat_khau) VALUES ('admin', 'password1')")
    conn.commit()
    for i in range(2, 11):
        cursor.execute(f"INSERT INTO Tai_khoan (Ten_tai_khoan, Mat_khau) VALUES ('user{i}', 'password{i}')")

    conn.commit()  # Cần commit để đảm bảo dữ liệu đã được lưu vào bảng Tai_khoan trước khi thêm vào bảng Nhan_vien

    # Thêm dữ liệu vào bảng Nhan_vien
    for i in range(2, 11):
        cursor.execute(f"INSERT INTO Nhan_vien (ID, Ten_nhan_vien, So_dien_thoai, Email) "
                    f"VALUES ({i}, 'Nhan vien {i}', '012345678{i}', 'nhanvien{i}@example.com')")
    conn.commit()


    # Thêm dữ liệu vào bảng Ban
    vi_tri_list = ["Trong nha", "Ngoai troi", "Phong VIP", "Ban cong"]
    trang_thai_list = ["Trong", "Dang su dung", "Dang don dep", "Da dat"]

    for i in range(1, 21):
        vi_tri = random.choice(vi_tri_list)
        trang_thai = random.choice(trang_thai_list)

        cursor.execute(
            f"INSERT INTO Ban (So_ban, Suc_chua, Trang_thai, Vi_tri, Mo_ta) "
            f"VALUES ({i}, {random.randint(2, 10)}, '{trang_thai}', '{vi_tri}', 'Ban so {i}')"
        )

    # Thêm dữ liệu vào bảng Khach_hang
    for i in range(1, num_records + 1):
        cursor.execute(f"INSERT INTO Khach_hang (Ten_khach_hang, So_dien_thoai, Email) "
                       f"VALUES ('Khach hang {i}', '098765432{i}', 'khachhang{i}@example.com')")

    #Thêm dữ liệu vào bảng Don_dat_mon_Hoa_don
    order_statuses = ["Da dat", "Dang lam", "Da co"]

    for i in range(1, num_records + 1):
        ngay_gio = datetime.now() - timedelta(days=random.randint(1, 30))
        # Format the datetime to a proper string format for SQL (YYYY-MM-DD HH:MM:SS)
        formatted_ngay_gio = ngay_gio.strftime('%Y-%m-%d %H:%M:%S')
        
        trang_thai = random.choice(order_statuses)
        trang_thai_thanh_toan = random.choice([True, False])
        
        cursor.execute(
            f"INSERT INTO Don_dat_mon_Hoa_don (Ngay_Gio, Tong_tien, Trang_thai, Trang_thai_thanh_toan) "
            f"VALUES ('{formatted_ngay_gio}', {random.randint(100000, 1000000)}, '{trang_thai}', {trang_thai_thanh_toan})"
        )

    # Thêm dữ liệu vào bảng Thuc_uong và Chi_tiet_thuc_uong
    sizes = ['S', 'M', 'L']

    for i in range(1, 31):
        ten_thuc_uong = f"Thuc uong {i}"
        mo_ta = f"Mo ta {i}"
        image_url = f"https://example.com/image{i}.jpg"
        cursor.execute(
            f"INSERT INTO Thuc_uong (Ten_thuc_uong, Mo_ta, image_URL) "
            f"VALUES ('{ten_thuc_uong}', '{mo_ta}', '{image_url}')"
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

    # Thêm dữ liệu vào bảng Chi_tiet_phuong_thuc_thanh_toan
    payment_names = ["Vietcombank", "Zalopay", "Momo", "MBank", "Techcombank"]

    for payment_name in payment_names:
        fee = round(random.uniform(1.0, 3.0), 2)
        cursor.execute(
            f"INSERT INTO Chi_tiet_phuong_thuc_thanh_toan (Ten, Fee) "
            f"VALUES ('{payment_name}', {fee})"
        )

    # Thêm ba loại phương thức thanh toán vào bảng Phuong_thuc_thanh_toan
    payment_methods = ["Tien mat", "Online banking", "E-wallet"]
    for method in payment_methods:
        cursor.execute(f"INSERT INTO Phuong_thuc_thanh_toan (Ten) VALUES ('{method}')")

    # Thêm dữ liệu vào bảng Phan_hoi
    for i in range(1, num_records + 1):
        ngay_gio = datetime.now() - timedelta(days=random.randint(1, 30))
        cursor.execute(f"INSERT INTO Phan_hoi (So_sao, Noi_dung, Ngay_Gio) "
                       f"VALUES ({random.randint(1, 5)}, 'Phan hoi {i}', '{ngay_gio}')")

    conn.commit()
    print(f"Thêm {num_records} bản ghi thành công cho mỗi bảng!")

# Kết nối đến cơ sở dữ liệu và thêm dữ liệu
connection = connect()
num_records = 30  # Số lượng bản ghi muốn thêm
insert_data(connection, num_records)

# Đóng kết nối
connection.close()
