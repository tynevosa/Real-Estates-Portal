<?php
include_once('../db/connection.php');
include_once('../helpers/session.php');
include_once('../helpers/utils.php');
require_once('../helpers/constants.php');

$sort_by_date = (isset($_GET['sort_by_date']) ? $_GET['sort_by_date'] : 'desc');

$db = new DB();
$agent_id = $db->escape(isset($_GET["id"]) ? $_GET["id"] : -1);
$agent = $db->first("SELECT *, users.first_name as first_name, users.last_name as last_name, users.email as email, users.phone_number as phone_number, users.bio as bio, users.profile_picture as profile_picture  FROM users WHERE users.id=$agent_id");
if ($agent == false) {
    redirect_to('/');
}
list($estates_count) = $db->first("SELECT COUNT(id) as count FROM real_estates WHERE user_id=$agent_id");

$page = (isset($_GET['page']) ? $_GET['page'] : 1);
$limit = 6;
$offset = ($page - 1) * $limit;
$maxPage = ceil($estates_count / $limit);

$estates = $db->fetch('SELECT * from real_estates WHERE user_id = ' . $agent_id . ' ORDER BY created_at ' . strtoupper($sort_by_date) . ' LIMIT ' . $limit . ' OFFSET ' . $offset);

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
            <h1 class="title-single"><?=$agent['first_name']?> <?=$agent['last_name']?></h1>
            <span class="color-text-a"></span>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/">Начало</a>
              </li>
              <li class="breadcrumb-item">
                <a href="agents.php">Брокери</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                <?=$agent['first_name']?> <?=$agent['last_name']?>
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section><!-- End Intro Single -->

  <!-- ======= Agent Single ======= -->
  <section class="agent-single">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="row">
            <div class="col-md-6">
              <div class="agent-avatar-box">
                <img src="<?=$agent['profile_picture'] ? $agent['profile_picture'] : "assets/img/500x500.gif" ?>" alt="" class="agent-avatar img-fluid">
              </div>
            </div>
            <div class="col-md-5 section-md-t3">
              <div class="agent-info-box">
                <div class="agent-title">
                  <div class="title-box-d">
                    <h3 class="title-d"><?=$agent['first_name']?>
                      <br> <?=$agent['last_name']?>
                    </h3>
                  </div>
                </div>
                <div class="agent-content mb-3">
                  <p class="content-d color-text-a">
                    <?=$agent['bio']?>
                  </p>
                  <div class="info-agents color-a">
                    <p>
                      <strong>Телефон: </strong>
                      <span class="color-text-a"> <?=$agent['phone_number']?> </span>
                    </p>
                    <p>
                      <strong>Мобилен: </strong>
                      <span class="color-text-a"> <?=$agent['phone_number']?> </span>
                    </p>
                    <p>
                      <strong>Имейл: </strong>
                      <span class="color-text-a"> <?=$agent['email']?></span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 section-t8">
          <div class="title-box-d">
            <h3 class="title-d">Мойте Имоти (<?=$estates_count?>)</h3>
          </div>
        </div>
        <div class="row property-grid grid">
          <div class="col-sm-12">
            <div class="grid-option">
                <form action="" method="GET">
                    <input type="hidden" name="id" value="<?=$_GET["id"]?>">
                    <select class="custom-select" name='sort_by_date' onchange="this.form.submit()">
                        <!-- <option selected>All</option> -->
                        <option value="desc" <?= $sort_by_date == 'desc' ? 'selected' : '' ?>>Най-новите</option>
                        <option value="asc" <?= $sort_by_date == 'asc' ? 'selected' : '' ?>>Най-старите</option>
                    </select>
                </form>
            </div>
          </div>

        <?php
            foreach ($estates as $estate) {
                $estate_id = $estate['id'];
                $estate_first_image = $db->first("SELECT * FROM real_estate_images WHERE real_estate_id=$estate_id");
                if (!$estate_first_image) {
                    $path = '/assets/img/no-property-img.png';
                } else {
                    $path = $estate_first_image['path'];
                }
        ?>
          <div class="col-md-4">
            <div class="card-box-a card-shadow">
              <div class="img-box-a img-box-reset">
                <img src="<?=$path?>" alt="" class="img-a img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-overlay-a-content">
                  <div class="card-header-a">
                    <h2 class="card-title-a">
                      <a href="#"><?=$estate['title']?></a>
                    </h2>
                  </div>
                  <div class="card-body-a">
                    <div class="price-box d-flex">
                      <span class="price-a"> € <?=$estate['price']?></span>
                    </div>
                    <a href="#" class="link-a">Детайли
                      <span class="bi bi-chevron-right"></span>
                    </a>
                  </div>
                  <div class="card-footer-a">
                    <ul class="card-info d-flex justify-content-around">
                      <li>
                        <h4 class="card-info-title">Квадратура</h4>
                        <span><?=$estate['area']?>m
                          <sup>2</sup>
                        </span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Спални</h4>
                        <span><?=$estate['bedrooms']?></span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Бани</h4>
                        <span><?=$estate['bathrooms']?></span>
                      </li>
                      <li>
                        <h4 class="card-info-title">Гаражи</h4>
                        <span><?=$estate['garages']?></span>
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
      </div>
      <?= render_pagination($maxPage, $page) ?>

    </div>
  </section><!-- End Agent Single -->

<?php include_once('footer.php'); ?>
