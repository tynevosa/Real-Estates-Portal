<?php
require_once("../db/connection.php");
require_once("../helpers/session.php");
require_once("../helpers/utils.php");
require_once('../helpers/constants.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['user_type'] != BROKER_ROLE) {
  redirect_to('/');
}

$db = new DB();
$estateTypes = $db->fetch('SELECT * from real_estate_types');
$constructionTypes = $db->fetch('SELECT * from real_estate_types_of_construction');
$levels = $db->fetch('SELECT * from real_estate_level');

$missingFields = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $real_estate_id = $_POST['real_estate_id'];
  $title = $_POST['title'];
  $typeId = $_POST['type'];
  $constructionId = $_POST['construction'];
  $levelId = $_POST['level'];
  $address = $_POST['address'];
  $price = $_POST['price'];
  $area = $_POST['area'];
  $finishedAt = $_POST['finishedAt'];
  $garages = $_POST['garages'];
  $bedrooms = $_POST['bedrooms'];
  $bathrooms = $_POST['bathrooms'];
  $livingRooms = $_POST['livingRooms'];
  $bedrooms = $_POST['bedrooms'];
  $description = $_POST['description'];
  $images = transform_multiple_files($_FILES['images']);

  if (empty($title)) $missingFields[] = 'title';
  if (empty($typeId)) $missingFields[] = 'type';
  if (empty($constructionId)) $missingFields[] = 'construction';
  if (empty($levelId)) $missingFields[] = 'level';
  if (empty($address)) $missingFields[] = 'address';
  if (empty($price)) $missingFields[] = 'price';
  if (empty($area)) $missingFields[] = 'area';
  if (empty($finishedAt)) $missingFields[] = 'finishedAt';
  if (!empty($missingFields)) {
    $errorMessage = "Моля, попълнете всички задължителни полета!";
  } else {
    $updatedEstates = [
      "title" => trim($title),
      "type_id" => $typeId,
      "construction_id" => $constructionId,
      "level_id" => $levelId,
      "address" => trim($address),
      "price" => $price,
      "area" => $area,
      "finished_at" => $finishedAt,
      "garages" => $garages,
      "bedrooms" => $bedrooms,
      "bathrooms" => $bathrooms,
      "living_rooms" => $livingRooms,
      "description" => isset($description) ? trim($description) : $description
    ];

    $passed = $db->update('real_estates', $updatedEstates, ['id' => $real_estate_id]);
    if (!$passed) {
      $errorMessage = "Нещо се обърка.";
    } else {
      foreach ($images as $image) {
        $path = save_uploaded_file($image);
        $imgData = [
          "path" => $path,
          "real_estate_id" => $real_estate_id
        ];
        $db->insert('real_estate_images', $imgData);
      }
      redirect_to('/my-real-estates.php');
    }
  }
} else {
  $real_estate_id = $_GET['id'];
  if (empty($real_estate_id)) {
    redirect_to($_SERVER['HTTP_REFERER']);
  }
  $record = $db->first("SELECT * FROM real_estates WHERE id=$real_estate_id AND user_id={$_SESSION['user_id']}");
  if ($record === false) {
    redirect_to($_SERVER['HTTP_REFERER']);
  }

  $title = $record['title'];
  $typeId = $record['type_id'];
  $constructionId = $record['construction_id'];
  $levelId = $record['level_id'];
  $address = $record['address'];
  $price = $record['price'];
  $area = $record['area'];
  $finishedAt = $record['finished_at'];
  $garages = $record['garages'];
  $bathrooms = $record['bathrooms'];
  $livingRooms = $record['living_rooms'];
  $bedrooms = $record['bedrooms'];
  $description = $record['description'];
}

include_once("header.php");
?>
<section class="intro-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <div class="title-single-box">
          <h1 class="title-single">Редакция на Обява</h1>
        </div>
      </div>
      <div class="col-md-12 col-lg-4">
        <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/">Начало</a>
            </li>
            <li class="breadcrumb-item">
              <a href="my-real-estates.php">Мойте Обяви</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Редакция на Обява
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section><!-- End Intro Single-->

<section class="news-single nav-arrow-b" style="margin-bottom: 2.5rem">
  <div class="container">
    <div class="row">
      <div class="col-md-10 offset-md-1 col-lg-10 offset-lg-1">
        <div class="form-comments">
          <!-- <div class="title-box-d"> -->
          <!-- <h3 class="title-d"></h3> -->
          <!-- </div> -->
          <?php if (isset($errorMessage)) {
          ?>
            <div class="alert alert-danger" role="alert">
              <?= $errorMessage ?>
            </div>
          <?php
          } ?>
          <form class="form-a" method="post" enctype="multipart/form-data">
            <input type="hidden" name="real_estate_id" value="<?= $real_estate_id ?>">
            <div class="row">
              <div class="col-md-12 mb-3">
                <div class="form-group">
                  <label for="inputTitle">Заглавие*</label>
                  <input type="text" class="form-control form-control-lg form-control-a <?= in_array('title', $missingFields) ? 'is-invalid' : '' ?>" id="inputTitle" name="title" placeholder="Заглавие" <?= isset($title) ? 'value="' . $title . '"' : '' ?> required>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="form-group">
                  <label for="inputType">Вид*</label>
                  <select type="text" class="form-control form-control-lg form-control-a <?= in_array('type', $missingFields) ? 'is-invalid' : '' ?>" id="inputType" name="type" <?= isset($typeId) ? 'value="' . $typeId . '"' : '' ?> required>
                    <option selected disabled>Избери</option>
                    <?php
                    foreach ($estateTypes as $estateType) {
                    ?>
                      <option value="<?= $estateType['id'] ?>" <?php if (isset($typeId) && $typeId == $estateType['id']) {
                                                                ?> selected <?php
                                                                          } ?>> <?= $estateType['title'] ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- construction type -->
              <div class="col-md-4 mb-3">
                <div class="form-group">
                  <label for="inputConstructionType">Тип строителство*</label>
                  <select type="text" class="form-control form-control-lg form-control-a <?= in_array('construction', $missingFields) ? 'is-invalid' : '' ?>" id="inputConstructionType" name="construction" <?= isset($constructionId) ? 'value="' . $constructionId . '"' : '' ?> required>
                    <option selected disabled>Избери</option>
                    <?php
                    foreach ($constructionTypes as $constructionType) {
                    ?>
                      <option value="<?= $constructionType['id'] ?>" <?php if (isset($constructionId) && $constructionId == $constructionType['id']) {
                                                                ?> selected <?php
                                                                          } ?>> <?= $constructionType['title'] ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <!-- level -->
              <div class="col-md-4 mb-3">
                <div class="form-group">
                  <label for="inputLevel">Завършеност*</label>
                  <select type="text" class="form-control form-control-lg form-control-a <?= in_array('level', $missingFields) ? 'is-invalid' : '' ?>" id="inputLevel" name="level" <?= isset($levelId) ? 'value="' . $levelId . '"' : '' ?> required>
                    <option selected disabled>Избери</option>
                    <?php
                    foreach ($levels as $level) {
                    ?>
                      <option value="<?= $level['id'] ?>" <?php if (isset($levelId) && $levelId == $level['id']) {
                                                                ?> selected <?php
                                                                          } ?>> <?= $level['title'] ?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-md-8 mb-3">
                <div class="form-group">
                  <label for="inputAddress">Адрес*</label>
                  <input type="text" class="form-control form-control-lg form-control-a <?= in_array('address', $missingFields) ? 'is-invalid' : '' ?>" id="inputAddress" name="address" placeholder="Адрес" <?= isset($address) ? 'value="' . $address . '"' : '' ?> required>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="form-group">
                  <label for="inputPrice">Цена*</label>
                  <input type="number" min="0" class="form-control form-control-lg form-control-a <?= in_array('price', $missingFields) ? 'is-invalid' : '' ?>" id="inputPrice" name="price" placeholder="€ 10000" <?= isset($price) ? 'value="' . $price . '"' : '' ?> required>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="form-group">
                  <label for="inputArea">Квадратура*</label>
                  <input type="number" min="0" class="form-control form-control-lg form-control-a <?= in_array('area', $missingFields) ? 'is-invalid' : '' ?>" id="inputArea" name="area" placeholder="10 m&sup3;" <?= isset($area) ? 'value="' . $area . '"' : '' ?>>
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <div class="form-group">
                  <label for="inputFinishedDate">Дата на Строеж*</label>
                  <input type="date" class="form-control form-control-lg form-control-a <?= in_array('finishedAt', $missingFields) ? 'is-invalid' : '' ?>" id="inputFinishedDate" name="finishedAt" <?= isset($finishedAt) ? 'value="' . $finishedAt . '"' : '1900-01-01' ?>>
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="form-group">
                  <label for="inputGarages">Гаражи</label>
                  <input type="number" min="0" class="form-control form-control-lg form-control-a" id="inputGarages" name="garages" value="<?= $garages ?>">
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="form-group">
                  <label for="inputBedrooms">Спални</label>
                  <input type="number" min="0" class="form-control form-control-lg form-control-a" id="inputBedrooms" name="bedrooms" value="<?= $bedrooms ?>">
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="form-group">
                  <label for="inputBathrooms">Бани</label>
                  <input type="number" min="0" class="form-control form-control-lg form-control-a" id="inputBathrooms" name="bathrooms" value="<?= $bathrooms ?>">
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <div class="form-group">
                  <label for="inputLivingRooms">Всекидневни</label>
                  <input type="number" min="0" class="form-control form-control-lg form-control-a" id="inputLivingRooms" name="livingRooms" value="<?= $livingRooms ?>">
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="form-group">
                  <label for="textDescription">Описание</label>
                  <textarea id="textDescription" class="form-control" placeholder="Опишете имота.." name="description" cols="45" rows="8"><?= $description ?></textarea>
                </div>
              </div>
              <div class="col-md-12 mb-3">
                <div class="form-group">
                  <label for="inputImages">Снимки</label>
                  <input type="file" id="inputImages" class="form-control" name="images[]" accept="image/*" multiple>
                </div>
              </div>
              <div class="col-md-12">
                <button type="submit" class="btn btn-a">Публикувай</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


<?php
include_once("footer.php");
?>