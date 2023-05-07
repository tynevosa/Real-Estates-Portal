<?php
include_once('../db/connection.php');
include_once('../helpers/session.php');
include_once('../helpers/utils.php');
require_once('../helpers/constants.php');

if (!isset($_SESSION['loggedin']) || $_SESSION['user_type'] != BROKER_ROLE) {
    redirect_to('/');
}

include_once('header.php');

$db = new DB();

$sort_by_date = (isset($_GET['sort_by_date']) ? $_GET['sort_by_date'] : 'desc');

$page = (isset($_GET['page']) ? $_GET['page'] : 1);
$limit = 6;
$offset = ($page - 1) * $limit;
list($count) = $db->first('SELECT COUNT(id) as count from real_estates WHERE user_id=' . $_SESSION['user_id']);
$maxPage = ceil($count / $limit);

$records = $db->fetch('SELECT * from real_estates WHERE user_id=' . $_SESSION['user_id'] . ' ORDER BY created_at ' . strtoupper($sort_by_date) . ' LIMIT ' . $limit . ' OFFSET ' . $offset);
?>
<!-- ======= Intro Single ======= -->
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="title-single-box">
                    <h1 class="title-single">Мойте Имоти</h1>
                    <span class="color-text-a">Имоти</span>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="/">Начало</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Мойте Имоти
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->

<section class="property-grid grid">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="grid-option">
                    <form action="" method="GET">
                        <select class="custom-select" name='sort_by_date' onchange="this.form.submit()">
                            <!-- <option selected>All</option> -->
                            <option value="desc" <?= $sort_by_date == 'desc' ? 'selected' : '' ?>>Най-нови</option>
                            <option value="asc" <?= $sort_by_date == 'asc' ? 'selected' : '' ?>>Най-стари</option>
                        </select>
                    </form>
                </div>
            </div>
            <?php
            foreach ($records as $record) {
                $record_id = $record['id'];
                $record_first_image = $db->first("SELECT * FROM real_estate_images WHERE real_estate_id=$record_id");
                if (!$record_first_image) {
                    $path = '/assets/img/no-property-img.png';
                } else {
                    $path = $record_first_image['path'];
                }
            ?>
                <div class="col-md-4">
                    <div class="card-box-a card-shadow">
                        <div class="img-box-a img-box-reset">
                            <img src="<?= $path ?>" alt="" class="img-a img-fluid">
                        </div>
                        <div class="card-overlay">
                            <div class="card-overlay-a-content">
                                <div class="card-header-a">
                                    <h2 class="card-title-a">
                                        <a href="#"><?= $record['title'] ?></a>
                                    </h2>
                                </div>
                                <div class="card-body-a">
                                    <div class="price-box d-flex">
                                        <span class="price-a">$<?= $record['price'] ?></span>
                                    </div>
                                    <a href="/real-estate.php?id=<?= $record['id'] ?>" class="link-a">Детайли
                                        <span class="bi bi-chevron-right"></span>
                                    </a>
                                </div>
                                <div class="card-footer-a">
                                    <ul class="card-info d-flex justify-content-around">
                                        <li>
                                            <h4 class="card-info-title">Квадратура</h4>
                                            <span><?= $record['area'] ?>m
                                                <sup>2</sup>
                                            </span>
                                        </li>
                                        <li>
                                            <h4 class="card-info-title">Спални</h4>
                                            <span><?= $record['bedrooms'] ?></span>
                                        </li>
                                        <li>
                                            <h4 class="card-info-title">Бани</h4>
                                            <span><?= $record['bathrooms'] ?></span>
                                        </li>
                                        <li>
                                            <h4 class="card-info-title">Гаражи</h4>
                                            <span><?= $record['garages'] ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <?= render_pagination($maxPage, $page) ?>
        </div>

</section>

<?php include_once('footer.php'); ?>