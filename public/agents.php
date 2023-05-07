<?php
include_once('../db/connection.php');
include_once('../helpers/session.php');
include_once('../helpers/utils.php');
require_once('../helpers/constants.php');

$db = new DB();
$page = (isset($_GET['page']) ? $_GET['page'] : 1);
$limit = 6;

$agentTypeId = BROKER_ROLE;

$offset = ($page - 1) * $limit;
list($count) = $db->first("SELECT COUNT(id) as count from users WHERE type_id = $agentTypeId ");
$maxPage = ceil($count / $limit);

$agents = $db->fetch('SELECT * from users WHERE type_id = ' . $agentTypeId . ' LIMIT ' . $limit . ' OFFSET ' . $offset);
?>
<?php
include_once('header.php');
?>
<!-- =======Intro Single ======= -->
<section class="intro-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <div class="title-single-box">
          <h1 class="title-single">Нашите Брокери</h1>
          <span class="color-text-a">С удоволствие ще Ви помогнат да изберете мечтания дом</span>
        </div>
      </div>
      <div class="col-md-12 col-lg-4">
        <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="/">Начало</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Брокери
            </li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section><!-- End Intro Single-->

<!-- ======= Agents Grid ======= -->
<section class="agents-grid grid">
  <div class="container">
    <div class="row">
      <?php
      foreach ($agents as $agent) {
      ?>
        <div class="col-md-4">
          <div class="card-box-d">
            <div class="card-img-d" style="max-height: 500px;">
              <img src="<?php
                        $profilePic = $agent['profile_picture'];
                        if (is_null($profilePic)) {
                          echo "assets/img/500x500.gif";
                        } else {
                          echo $profilePic;
                        }
                        ?>" class="img-d img-fluid">
            </div>
            <div class="card-overlay card-overlay-hover">
              <div class="card-header-d">
                <div class="card-title-d align-self-center">
                  <h3 class="title-d">
                    <a href="agent.php?id=<?=$agent['id']?>" class="link-two"><?= $agent['first_name'] ?>
                      <br> <?= $agent['last_name'] ?></a>
                  </h3>
                </div>
              </div>
              <div class="card-body-d">
                <p class="content-d color-text-a">
                  <?= is_null($agent['bio']) ? '' : $agent['bio'] ?>
                </p>
                <div class="info-agents color-a">
                  <p>
                    <strong>Телефон: </strong> <?= $agent['phone_number'] ?>
                  </p>
                  <p>
                    <strong>Имейл: </strong> <?= $agent['email'] ?>
                  </p>
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
</section><!-- End Agents Grid-->

<?php include_once('footer.php'); ?>