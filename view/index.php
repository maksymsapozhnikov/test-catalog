<?php
require_once __DIR__ . '/../model/Database.php';
?>
<html lang="en">
<head>
    <meta charset="UTF8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="../js/common.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>Product List</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <h2>Категории</h2>
            <table border="1" class="category-list">
                <tr>
                    <th>Название категории</th>
                </tr>
                <?php foreach ($data['category'] as $item){ ?>
                    <tr>
                        <td>
                            <a class="category-item <?= ($data['category_id'] == $item['id']) ? "active" : '' ?>" href="javascript:void(0)" data-id="<?= $item['id'] ?>"><?= $item['name'] ?></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="col-md-9 col-sm-12 products-block">
            <h2>Товары</h2>
            <span class="actions">
                <select id="sort-prod"  size="1" name="sort_product">
                    <option value="">Сортировка</option>
                    <option <?= ($data['sort_id'] == Database::SORT_ALPHABETICAL_UP) ? "selected": '';?> value="<?= Database::SORT_ALPHABETICAL_UP?>">От А-Я</option>
                    <option <?= ($data['sort_id'] == Database::SORT_ALPHABETICAL_DOWN) ? "selected": '';?> value="<?= Database::SORT_ALPHABETICAL_DOWN?>">От Я-А</option>
                    <option <?= ($data['sort_id'] == Database::SORT_DATE_CREATED_UP) ? "selected": '';?> value="<?= Database::SORT_DATE_CREATED_UP?>">Сначала новые</option>
                    <option <?= ($data['sort_id'] == Database::SORT_DATE_CREATED_DOWN) ? "selected": '';?> value="<?= Database::SORT_DATE_CREATED_DOWN?>">Сначала старые</option>
                    <option <?= ($data['sort_id'] == Database::SORT_PRICE_UP) ? "selected": '';?> value="<?= Database::SORT_PRICE_UP?>">Сначала дешовые</option>
                    <option <?= ($data['sort_id'] == Database::SORT_PRICE_DOWN) ? "selected": '';?> value="<?= Database::SORT_PRICE_DOWN?>">Сначала дорогие</option>
                </select>
                <a href="/" class="btn btn-success reset">Очистить поиск</a>
            </span>
            <div class="clear"></div>
            <div id="result">
                <?php require_once __DIR__ . '/../view/_part/product-table.php';?>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>