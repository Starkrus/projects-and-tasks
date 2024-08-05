<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>

</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ЕМ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Переключатель навигации">
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
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form>
        </div>
    </div>
</nav>

<section>
    <form>
        <button type="button" class="btn btn-primary">Создать акт</button>
    </form>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">№ П/П</th>
            <th scope="col">Наименование товара</th>
            <th scope="col">Количество</th>
            <th scope="col">Куда отгрузили</th>
            <th scope="col">Дата отгрузки</th>
            <th scope="col">Инициатор</th>
            <th scope="col">Комментарии</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>1. XS115PC Палец EM2</td>
            <td>3</td>
            <td>МС</td>
            <td>24.06.24</td>
            <td>Бобров</td>
            <td>По письму от 23.06.24</td>
            <td><button class="btn btn-outline-success" type="submit">Развернуть</button></td>
        </tr>
        </tbody>
    </table>
</section>
</body>
</html>
