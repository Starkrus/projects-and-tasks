<?php
// Подключаемся к базе данных
$mysqli = require_once '../connect/db.php';

// Получаем идентификатор акта из URL
$act_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Подготовленный запрос для получения данных акта и его позиций
$stmt = $mysqli->prepare("SELECT acts.sent, acts.date, acts.received, acts.comments, act_items.name, act_items.count 
                           FROM acts 
                           LEFT JOIN act_items ON acts.id = act_items.act_id 
                           WHERE acts.id = ?");
$stmt->bind_param("i", $act_id);
$stmt->execute();
$result = $stmt->get_result();

// Проверяем, есть ли данные
if ($result->num_rows > 0) {
    $act_data = [];
    while ($row = $result->fetch_assoc()) {
        $act_data[] = $row;
    }
} else {
    die("Акт не найден");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Акт приема-передачи</title>
    <link rel="stylesheet" href="../stylesheet/stylesheet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <h4>Акт </h4>
    <h4> приема-передачи товара</h4>
    <h4>№<?= $_GET['id'] ?></h4>
    <p>от <?= date('d.m.Y', strtotime($act_data[0]['date'])) ?> г.</p>
    <p>ООО "Евразия машинери" передает, а <?= htmlspecialchars($act_data[0]['received']) ?> принимает следующие позиции:</p>

    <div class="details">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>№ п/п</th>
                <th>Наименование товара</th>
                <th>Количество</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($act_data as $index => $item): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= htmlspecialchars($item['count']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <p><p>Всего позиций: <?= count($act_data) ?>.   Общее кол-во:  <?= array_sum(array_column($act_data, 'count')) ?> шт. </p>


    <div class="signatures">
        <div>
            <p>Передает:</p>
            <p>ООО "Евразия машинери"</p>
            <p class="signature-line">___________________________</p>
            <p>(подпись)</p>
            <p>от <?= date('d.m.Y', strtotime($act_data[0]['date'])) ?></p>
        </div>
        <div>
            <p>Принимает:</p>
            <p><?= htmlspecialchars($act_data[0]['received']) ?></p>
            <p class="signature-line">___________________________</p>
            <p>(подпись)</p>
            <p>«___» __________ 20__ г.</p>
        </div>
    </div>

    <button class="print-button" onclick="window.print()">Печать</button>
</div>

</body>
</html>

<?php
// Закрытие подключения
$mysqli->close();
?>
