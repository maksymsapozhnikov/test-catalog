<div class="row product-card">
    <div class="col-md-6 col-sm-12">Название:</div><div class="col-md-6 col-sm-12"><?= $productData['name']?></div>
    <div class="col-md-6 col-sm-12">Цена:</div><div class="col-md-6 col-sm-12"><?= $productData['price']?> грн</div>
    <div class="col-md-6 col-sm-12">Дата добавления:</div><div class="col-md-6 col-sm-12"><?= date("d.m.y H:i",strtotime($productData['dt_create']))?></div>
</div>