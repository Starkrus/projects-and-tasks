<?php
// Подключаемся к базе данных
$mysqli = require_once '../connect/db.php';

// Получаем параметры поиска и пагинации из URL
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Выполняем запрос к базе данных с учетом поиска и пагинации
$sql = "SELECT acts.id, acts.sent, acts.date, acts.received, acts.comments, act_items.name, act_items.count 
        FROM acts 
        LEFT JOIN act_items ON acts.id = act_items.act_id
        WHERE acts.sent LIKE '%$search%' OR acts.received LIKE '%$search%' OR acts.comments LIKE '%$search%' OR act_items.name LIKE '%$search%'
        ORDER BY acts.id, act_items.id
        LIMIT $limit OFFSET $offset";
$result = $mysqli->query($sql);

// Получаем общее количество записей для расчета количества страниц
$total_sql = "SELECT COUNT(DISTINCT acts.id) as total FROM acts 
              LEFT JOIN act_items ON acts.id = act_items.act_id
              WHERE acts.sent LIKE '%$search%' OR acts.received LIKE '%$search%' OR acts.comments LIKE '%$search%' OR act_items.name LIKE '%$search%'";
$total_result = $mysqli->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Документы</title>
    <link rel="stylesheet" href="../stylesheet/stylesheet.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ЕМ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">---</a>
                </li>
            </ul>
            <form class="d-flex" role="search" method="get" action="">
                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск" name="search" value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form>
        </div>
    </div>
</nav>

<section>
    <!-- Кнопка для открытия модального окна -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createActModal">Создать акт</button>

    <!-- Модальное окно -->
    <div class="modal fade" id="createActModal" tabindex="-1" aria-labelledby="createActModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createActModalLabel">Создать новый акт</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createActForm" action="../templates/create_act.php" method="post">
                        <div id="items">
                            <div class="item row mb-3">
                                <div class="col-md-6">
                                    <label for="itemName" class="form-label">Наименование товара</label>
                                    <input type="text" class="form-control" name="item_name[]" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="itemCount" class="form-label">Количество</label>
                                    <input type="number" class="form-control" name="item_count[]" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-item">Удалить</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" onclick="addItem()">Добавить позицию</button>
                        <div class="mb-3">
                            <label for="itemSent" class="form-label">Куда отгрузили</label>
                            <input type="text" class="form-control" id="itemSent" name="item_sent" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemDate" class="form-label">Дата отгрузки</label>
                            <input type="date" class="form-control" id="itemDate" name="item_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemReceived" class="form-label">Инициатор</label>
                            <input type="text" class="form-control" id="itemReceived" name="item_received" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemComments" class="form-label">Комментарии</label>
                            <textarea class="form-control" id="itemComments" name="item_comments"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">№ П/П</th>
            <th scope="col">Куда отгрузили</th>
            <th scope="col">Дата отгрузки</th>
            <th scope="col">Инициатор</th>
            <th scope="col">Комментарии</th>
            <th scope="col">Наименование товара</th>
            <th scope="col">Количество</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0):
            $currentActId = null;
            $rowCount = 0;
            while ($row = $result->fetch_assoc()):
                if ($currentActId !== $row['id']):
                    $currentActId = $row['id'];
                    $rowCount = 1;
                    $resultTemp = $mysqli->query("SELECT COUNT(*) as count FROM act_items WHERE act_id = $currentActId");
                    $rowCount = $resultTemp->fetch_assoc()['count'];
                    ?>
                    <tr>
                        <th scope="row" rowspan="<?= $rowCount ?>"><?= $row["id"] ?></th>
                        <td rowspan="<?= $rowCount ?>"><?= $row["sent"] ?></td>
                        <td rowspan="<?= $rowCount ?>"><?= $row["date"] ?></td>
                        <td rowspan="<?= $rowCount ?>"><?= $row["received"] ?></td>
                        <td rowspan="<?= $rowCount ?>"><?= $row["comments"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["count"] ?></td>
                        <td rowspan="<?= $rowCount ?>"><a class="btn btn-outline-success" href="../templates/acts.php?id=<?= $row['id'] ?>">Открыть акт</a></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["count"] ?></td>
                    </tr>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">Нет данных для отображения</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Пагинация -->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $page - 1 ?>">Предыдущая</a>
            </li>
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $page ? 'active' : '' ?>"><a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?search=<?= urlencode($search) ?>&page=<?= $page + 1 ?>">Следующая</a>
            </li>
        </ul>
    </nav>
</section>

<script>
    function addItem() {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('item', 'row', 'mb-3');
        itemDiv.innerHTML = `
            <div class="col-md-6">
                <label class="form-label">Наименование товара</label>
                <input type="text" class="form-control" name="item_name[]" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Количество</label>
                <input type="number" class="form-control" name="item_count[]" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-item">Удалить</button>
            </div>
        `;
        document.getElementById('items').appendChild(itemDiv);
        attachRemoveEvent();
    }

    function attachRemoveEvent() {
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.item').remove();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        attachRemoveEvent();
    });
</script>

</body>
</html>

<?php
// Закрытие подключения
$mysqli->close();
?>
