<?php

$mysql =  new PDO('mysql:host=db19.freehost.com.ua;dbname=muash_velo', 'muash_velo', 'kfaWULAym');
$mysql->query('SET CHARSET \'utf8\'');

$postgres =  new PDO('pgsql:host=localhost;port=5432;dbname=velohub', 'homestead', 'secret');


foreach($mysql->query('SELECT * FROM cms_shop_categories ORDER BY id') as $row) {
    $query = "INSERT INTO categories (id, parent_id, sorting, is_active, is_parent, latin, name, name_short, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $postgres->prepare($query);
    $stmt->execute([
        $row['id'],
        $row['pid'],
        $row['ord'],
        ($row['published']) ? 'true' : 'false',
        ($row['parent']) ? 'true' : 'false',
        $row['url'],
        $row['name'],
        $row['menu_name'],
    ]);
}

foreach($mysql->query('SELECT * FROM cms_shop_catalog ORDER BY id') as $row) {
    $query = "INSERT INTO products (category_id, is_stock, is_active, latin, name, brand, model, preview, text, prices, seo_keywords, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

    $stmt = $postgres->prepare($query);
    $stmt->execute([
        $row['cat_id'],
        ($row['presence']) ? 'true' : 'false',
        ($row['published']) ? 'true' : 'false',
        $row['url'],
        $row['denom'],
        $row['firm'],
        $row['model'],
        $row['general'],
        $row['description'] . $row['video'],
        json_encode(['retail' => intval($row['price1']) ]),
        $row['id'],
    ]);

    $id = $postgres->lastInsertId();

    $query2 = "INSERT INTO skus (product_id, category_id, is_active, codes, prices, is_default)
        VALUES (?, ?, ?, ?, ?, true)";

    $stmt2 = $postgres->prepare($query2);
    $stmt2->execute([
        $id,
        $row['cat_id'],
        ($row['published']) ? 'true' : 'false',
        json_encode([$row['pids']]),
        json_encode(['retail' => intval($row['price1']) ]),
    ]);

}
