<?php
function isExamCompleted($baidahoanthanh, $idDeThi, $idLopHoc) {
    foreach ($baidahoanthanh as $baidathis) {
        if ($baidathis['ID_DeThi'] == $idDeThi && $baidathis['ID_LopHoc'] == $idLopHoc) {
            return true;
        }
    }
    return false;
}
?>

<h1>Danh sách đề thi</h1>
<div class="container mt-5">
    <div class="row">
        <?php if (isset($thongbao) && is_array($thongbao)): ?>
            <?php foreach ($thongbao as $item): ?>
                <?php
                    $status = '';
                    $current_date = date('Y-m-d');
                    $current_time = date('H:i:s');
                    $current_time = date('H:i:s', strtotime('+5 hours', strtotime($current_time)));
                    
             
                    
                    
                 echo   $exam_date = $item['Ngay_thi'];
               echo     $exam_start_time = $item['Thoi_gian_bat_dau_thi'];
                    
                    $user_has_done_exam = isExamCompleted($baidahoanthanh, $item['ID_DeThi'], $item['ID_LopHoc']);
                    if($user_has_done_exam) $status = 'Đã hoàn thành';
                    else{
                        if ($current_date == $exam_date) {

                            if ($current_time < $exam_start_time) {
                                $status = 'Chưa tới thời gian làm bài';
                            }
                            else  $status = 'Chưa làm';
                        } elseif ($current_date > $exam_date) {
                            
                             
                                $status = 'Chưa làm';
                            
                        } else {
                       
                                $status = 'Chưa tới thời gian làm bài';
                            
                        }
                    }
                    
                ?>
                <div class="col-12 mb-3">
                    <div class="card" onclick="handleCardClick('<?php echo $status; ?>', <?php echo $item['ID_DeThi']; ?>, '<?php echo $item['Thoi_gian_thi']; ?>', <?php echo $item['ID_LopHoc']; ?>)">
                        <div class="card-body">
                            <h5 class="card-title">ID Đề Thi: <?php echo $item['ID_DeThi']; ?></h5>
                            <p class="card-text">Loại: <?php echo $item['Loai']; ?></p>
                            <p class="card-text">Nội dung: <?php echo $item['Noi_dung']; ?></p>
                            <p class="card-status"><?php echo $status; ?></p>
                            <!-- Thông tin khác đã bị ẩn để giảm chiều cao của thẻ -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không có thông báo nào.</p>
        <?php endif; ?>
    </div>
</div>

<script>
    function handleCardClick(status, idDeThi, thoigianthi, idLopHoc) {
        if (status === 'Chưa tới thời gian làm bài') {
            alert('Chưa tới thời gian làm bài thi.');
        } else if (status === 'Đã hoàn thành') {
            window.location.href = 'http://localhost/Project_web2/web/ReviewQuizController/index/' + idDeThi + '/' + idLopHoc;
        } else {
            window.location.href = 'http://localhost/Project_web2/web/QuizController/index/' + idDeThi  + '/' + idLopHoc;
        }
    }
</script>

<style>
    .container {
        max-height: 600px;
        overflow-y: auto;
    }
    .card {
        width: 100%;
        cursor: pointer;
        position: relative;
    }
    .card + .card {
        margin-top: 30px;
    }
    .card-status {
        position: absolute;
        right: 10px;
        top: 10px;
        background-color: #f0f0f0;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>
