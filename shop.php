<?php

namespace App;

require_once 'vendor/autoload.php';

use App\Model\Clothing;
use App\Model\Electronic;

$cloting = new Clothing();
$clothingsList = $cloting->findAll();

$electronic = new Electronic();
$electronicsList = $electronic->findAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MY-LITTLE-MVC-SHOP</title>
</head>

<body>
  <h1>MY-LITTLE-MVC-SHOP</h1>
  <h2>Clothing</h2>
  <ul>
    <?php foreach ($clothingsList as $clothing) :
      $clothingImages = $clothing->getPhotos();
    ?>
      <li>
        <h3><?= $clothing->getName() ?></h3>
        <p><?= $clothing->getPrice() / 100 ?> €</p>
        <p><?= $clothing->getDescription() ?></p>
        <p><?= $clothing->getQuantity() ?></p>
        <p><?= $clothing->getCategory()->getName() ?></p>
        <img src="<?= $clothingImages[0] ?>" alt="image <?= $clothing->getName() ?>" height=340 width=340>

      </li>
    <?php endforeach; ?>
  </ul>
  <h2>Electronic</h2>
  <ul>
    <?php foreach ($electronicsList as $electronic) :
      $electronicImages = $electronic->getPhotos();
    ?>

      <li>
        <h3><?= $electronic->getName() ?></h3>
        <p><?= $electronic->getPrice() / 100 ?> €</p>
        <p><?= $electronic->getDescription() ?></p>
        <p><?= $electronic->getQuantity() ?></p>
        <p><?= $electronic->getCategory()->getName() ?></p>
        <img src="<?= $electronicImages[0] ?>" alt="image <?= $electronic->getName() ?>" height=340 width=340>
      </li>
    <?php endforeach; ?>
  </ul>

</body>

</html>