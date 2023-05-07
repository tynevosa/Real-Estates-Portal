<?php
include_once('../db/connection.php');
include_once('../helpers/session.php');
include_once('../helpers/utils.php');

$db = new DB();
$page = (isset($_GET['page']) ? $_GET['page'] : 1);
$limit = 6;
$offset = ($page - 1) * $limit;

$query = "";
$criteria = [];
$keyword = $_GET['keyword'];
if (!empty($keyword)) {
    $keyword = $db->escape("%$keyword%");
    $criteria[] = "title LIKE $keyword";
    $criteria[] = "description LIKE $keyword";
}

if (!empty($criteria)) {
    $criteria = ['(' . implode(" OR ", $criteria) . ')'];
}

$real_estate_type = $_GET['real_estate_type'];
if (!empty($real_estate_type) && $real_estate_type !== 'any') {
    $criteria[] = 'type_id=' . intval($real_estate_type);
}

$real_estate_type_of_construction = $_GET['real_estate_type_of_construction'];
if (!empty($real_estate_type_of_construction) && $real_estate_type_of_construction !== 'any') {
    $criteria[] = 'construction_id=' . intval($real_estate_type_of_construction);
}

$real_estate_level = $_GET['real_estate_level'];
if (!empty($real_estate_level) && $real_estate_level !== 'any') {
    $criteria[] = 'level_id=' . intval($real_estate_level);
}

$bedrooms = $_GET['bedrooms'];
if (!empty($bedrooms) && $bedrooms !== 'any') {
    $criteria[] = 'bedrooms=' . intval($bedrooms);
}
$bathrooms = $_GET['bathrooms'];
if (!empty($bathrooms) && $bathrooms !== 'any') {
    $criteria[] = 'bathrooms=' . intval($bathrooms);
}
$living_rooms = $_GET['living_rooms'];
if (!empty($living_rooms) && $living_rooms !== 'any') {
    $criteria[] = 'living_rooms=' . intval($living_rooms);
}
$garages = $_GET['garages'];
if (!empty($garages) && $garages !== 'any') {
    $criteria[] = 'garages=' . intval($garages);
}

$min_price = $_GET['min_price'];
if (!empty($min_price) && $min_price !== 'unlimited') {
    $criteria[] = 'price >= ' . intval($min_price);
}

$max_price = $_GET['max_price'];
if (!empty($max_price) && $max_price !== 'unlimited') {
    $criteria[] = 'price <= ' . intval($max_price);
}

if (!empty($criteria)) {
    $query = 'WHERE ' . implode(' AND ', $criteria);
}

list($count) = $db->first('SELECT COUNT(id) as count from real_estates ' . $query);
$maxPage = ceil($count / $limit);
// /
$records = $db->fetch('SELECT * from real_estates ' . $query . ' LIMIT ' . $limit . ' OFFSET ' . $offset);

?>
<?php
include_once('header.php');
?>

<!-- ======= Intro Single ======= -->
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="title-single-box">
                    <h1 class="title-single">Резултати от Търсенето</h1>
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
                            Резултати от Търсенето
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
            
            <?php
            // TODO: add as many as returned from server
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