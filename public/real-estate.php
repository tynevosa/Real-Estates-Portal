<?php
require_once("../db/connection.php");
require_once("../helpers/session.php");
require_once("../helpers/utils.php");
$db = new DB();

$record_id = $db->escape(isset($_GET["id"]) ? $_GET["id"] : -1);
$record = $db->first("SELECT *, real_estates.title as estate_title, real_estate_types.title as type_title, real_estate_types_of_construction.title as construction_title, real_estate_level.title as level_title, real_estates.id as estate_id 
FROM real_estates 
JOIN users ON real_estates.user_id=users.id 
JOIN real_estate_types ON real_estates.type_id=real_estate_types.id 
JOIN real_estate_types_of_construction ON real_estates.construction_id=real_estate_types_of_construction.id
JOIN real_estate_level ON real_estates.level_id=real_estate_level.id
WHERE real_estates.id=$record_id;
");
/*
$record = $db->first("SELECT *, real_estates.title as estate_title, real_estate_types.title as type_title, real_estates.id as estate_id FROM real_estates JOIN users ON real_estates.user_id=users.id JOIN real_estate_types on real_estates.type_id=real_estate_types.id WHERE real_estates.id=$record_id");
*/
/* 
$record = $db->first("SELECT *, real_estates.title as estate_title, real_estate_types.title as type_title, real_estate_types_of_construction.title as construction_title, real_estate_level as level_title, real_estates.id as estate_id FROM real_estates JOIN users ON real_estates.user_id=users.id JOIN real_estate_types on real_estates.type_id=real_estate_types.id JOIN real_estate_types_of_construction on real_estates.construction_id=real_estate_types_of_construction.id JOIN real_estates.level_id=real_estate_level.id WHERE real_estates.id=$record_id");
*/
if ($record == false) {
    redirect_to('/');
}
$record_images = $db->fetch("SELECT * FROM real_estate_images WHERE real_estate_id=$record_id");
$is_favorite = false;
if (isset($_SESSION['user_id'])) {
    $fav_record  = $db->first("SELECT * FROM real_estate_user WHERE real_estate_id=$record_id and user_id={$_SESSION['user_id']}");
    $is_favorite = $fav_record !== false;
}

?>
<?php
include_once("header.php");
?>
<!-- ======= Property Single ======= -->
<section class="property-single nav-arrow-b">
    <div class="container" style="margin-top: 142px;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="property-single-carousel" class="swiper">
                    <div class="swiper-wrapper">
                        <?php if (empty($record_images)) {
                            $path = '/assets/img/no-property-img.png'; ?>
                            <div class="carousel-item-b swiper-slide text-center">
                                <img class="img-responsive" style='max-height:600px' src="<?= $path ?>">
                            </div>
                            <?php
                        } else {
                            foreach ($record_images as $image) {
                                $path = $image['path'];
                            ?>
                                <div class="carousel-item-b swiper-slide text-center">
                                    <img class="img-responsive" style='max-height:600px' src="<?= $path ?>">
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="property-single-carousel-pagination carousel-pagination"></div>
            </div>
        </div>

        <div class="row section-b2">
            <div class="col-lg-5">
                <div class="property-price d-flex justify-content-left foo">
                    <div class="card-header-c d-flex">
                        <div class="card-box-ico d-inline-flex">
                            <span class="bi bi-cash">€</span>
                            <div class="card-title-c align-self-center">
                                <h5 class="" style="font-size: 2.5rem"><?= $record['price'] ?></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="float-end">
                    <?php if (isset($_SESSION['loggedin'])) {
                        if ($_SESSION['user_id'] == $record['user_id']) { ?>
                            <form>
                                <a class="btn text-primary" href="/edit-real-estate.php?id=<?= $record['estate_id'] ?>"><i class="bi bi-pencil"></i>&nbsp;Редактирай</a>
                                <a data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn text-danger"><i class="bi bi-trash3"></i>&nbsp;Изтрий</a>
                            </form>
                        <?php } elseif ($_SESSION['user_type'] == CLIENT_ROLE) { ?>
                            <form action="toggle-favorites.php" method="post">
                                <input type="hidden" name="estate_id" value="<?= $record['estate_id'] ?>">
                                
                                <button type="submit" class="btn d-flex">
                                    <i style="font-size: 1.4em" class="bi <?= $is_favorite ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
                                    &nbsp;
                                    <span class="align-self-center"><?= $is_favorite ? 'Премахни от Любими' : 'Добави в Любими' ?></span>
                                </button>
                                <a class="btn d-flex" onclick="window.print();">
                                    <i style="font-size: 1.4em" class="bi bi-filetype-pdf"></i>
                                    &nbsp;
                                    <span class="align-self-center">Изтегли офертата</span>
                                </button>
                            </form>
                    <?php }
                    } ?>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">

                <div class="row justify-content-between">
                    <div class="col-md-5 col-lg-4">
                        <div class="property-summary">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title-box-d section-t">
                                        <h3 class="title-d"><?= $record['estate_title'] ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-list">
                                <ul class="list">
                                    <li class="d-flex justify-content-between">
                                        <strong>Номер на Имота:</strong>
                                        <span><?= $record['estate_id'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Локация:</strong>
                                        <span><?= $record['address'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Вид:</strong>
                                        <span><?= $record['type_title'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Тип строителство:</strong>
                                        <span><?= $record['construction_title'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Етап на завършеност:</strong>
                                        <span><?= $record['level_title'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Квадратура:</strong>
                                        <span><?= $record['area'] ?>m
                                            <sup>2</sup>
                                        </span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Спални:</strong>
                                        <span><?= $record['bedrooms'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Всекидневни:</strong>
                                        <span><?= $record['living_rooms'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Бани:</strong>
                                        <span><?= $record['bathrooms'] ?></span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Гаражи:</strong>
                                        <span><?= $record['garages'] ?></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7 section-md-t3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title-box-d">
                                    <h3 class="title-d">Описание</h3>
                                </div>
                            </div>
                        </div>
                        <div class="property-description">
                            <p class="description color-text-a">
                                <?= $record['description'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row section-t3">
                    <div class="col-sm-12">
                        <div class="title-box-d">
                            <h3 class="title-d">Контакти с Брокера</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <img src="<?= empty($record['profile_picture']) ? 'https://place-hold.it/500x500' : $record['profile_picture'] ?>" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="property-agent">
                            <h4 class="title-agent"><?= $record['first_name'] . ' ' . $record['last_name'] ?></h4>
                            <p class="content-d color-text-a">
                                <?=$record['bio']?>
                            </p>
                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between">
                                    <strong>Телефон:</strong>
                                    <span class="color-text-a"><?= $record['phone_number'] ?></span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Имейл:</strong>
                                    <span class="color-text-a"><?= $record['email'] ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Property Single-->

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="confirmationTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="delete-real-estate.php" method="post">
            
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="confirmationTitle">Изтрий Имота</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Наистина ли искате да изтриeте този имот?
                <input type="hidden" name="estate_id" value="<?= $record['estate_id'] ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Не</button>
                <button type="submit" class="btn btn-success">Да</button>
            </div>
        </div>
    </form>
  </div>
</div>
<?php
include_once("footer.php");
?>