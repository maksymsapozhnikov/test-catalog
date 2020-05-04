<?php
if (!empty($data)) { ?>
    <table border="1" class="products-list">
        <thead>
        <tr>
            <th>#</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Дата добавления</th>
            <th>Купить</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1;
            foreach ($data['products'] as $item) { ?>
                <tr>
                    <td><?= $i ++ ?></td>
                    <td class="title_prod"><?= $item['name'] ?></td>
                    <td class="price_prod"><?= $item['price'] ?> грн</td>
                    <td class="date_prod"><?= date("d.m.y H:i", strtotime($item['dt_create'])) ?></td>
                    <td>
                        <div class="btn btn-primary btn_buy" data-toggle="modal" data-target="#Modal" data-id="<?= $item['id'] ?>">Купить</div>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }else {
    ?>
    <p>По вашему запросу ничего не найдено</p>
<?php } ?>