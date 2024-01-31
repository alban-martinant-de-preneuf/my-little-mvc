<?php

namespace App;

use App\Model\Clothing;
use App\Model\Electronic;

require_once 'vendor/autoload.php';

if (!isset($_GET['id_product']) || !isset($_GET['product_type'])) {
    echo 'Paramètre(s) manquant(s)';
    die();
}

$id_product = (int) $_GET['id_product'];
$product_type = $_GET['product_type'];

if (
    (gettype($id_product) !== 'integer' || $id_product === 0)
    ||
    ($_GET['product_type'] !== 'clothing' && $_GET['product_type'] !== 'electronic')
) {
    echo 'Paramètre(s) invalide(s)';
    die();
}

switch ($product_type) {
    case 'clothing':
        $product = new Clothing();
        break;
    case 'electronic':
        $product = new Electronic();
        break;
}

$product = $product->findOneById($_GET['id_product']);

if (!$product) {
    echo "Le produit demandé n'est pas disponible";
    die();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>MY-LITTLE-MVC-SHOP</title>
</head>

<body>

    <h1>MY-LITTLE-MVC-SHOP</h1>

    <h2><?= $product->getName() ?></h2>

    <img src="<?= $product->getPhotos()[0] ?>" alt="image <?= $product->getName() ?>" height=340 width=340>
    <p>Catégorie : <?= $product->getCategory()->getName() ?></p>
    <p>Description : <?= $product->getDescription() ?></p>
    <p>Prix : <?= $product->getPrice() / 100 ?> €</p>
    <p>Quantité : <?= $product->getQuantity() ?></p>
    <p>Créé le : <?= $product->getCreatedAt()->format('d/m/Y') ?></p>
    <?php if ($product->getUpdatedAt()) : ?>
        <p>Modifié le : <?= $product->getUpdatedAt()->format('d/m/Y') ?></p>
    <?php endif; ?>
    <?php if ($product_type === 'clothing') : ?>
        <p>Taille : <?= $product->getSize() ?></p>
        <p>Couleur : <?= $product->getColor() ?></p>
        <p>Type : <?= $product->getType() ?></p>
        <p>Frais de matière : <?= $product->getMaterialFee() / 100 ?> €</p>
    <?php elseif ($product_type === 'electronic') : ?>
        <p>Marque : <?= $product->getBrand() ?></p>
        <p>Frais de garantie : <?= $product->getWarantyFee() / 100 ?></p>
    <?php endif; ?>

</body>

</html>