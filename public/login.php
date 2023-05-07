<?php require_once('../db/connection.php');
require_once('../helpers/session.php');
require_once('../helpers/utils.php');
if (isset($_SESSION['loggedin'])) {
  redirect_to('/');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $db = new DB();
  $user = $db->first("SELECT * from users WHERE email=" . $db->escape($email));
  if (isset($user['password'])) {
    if (password_verify($password, $user['password'])) {
      $_SESSION['loggedin'] = true;
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_type'] =  $user['type_id'];
      $_SESSION['name'] = implode(' ', [$user['first_name'], $user['last_name']]);
      redirect_to('/');
    } else {
      $errorString = 'Грешен имейл или парола!';
    }
  } else {
    $errorString = 'Грешен имейл или парола!';
  }
}
?>

<?php include_once('header.php'); ?>

<section class="intro-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <div class="title-single-box">
          <h1 class="title-single">Влез в профила си</h1>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Intro Single-->

<section class="property-grid grid" style="margin-bottom: 50px;">
  <div class="container">
    <div class="row">
      <div class="offset-sm-3 col-sm-6">
        <form action="/login.php" method="post">
          <div class="row">
            <div class="col-12">
              <label for="email">Имейл</label>
              <input type="email" class="form-control" placeholder="john@example.com" name="email" id="email">
            </div>
          </div>
          <div class='row '>
            <div class="col-12 gy-4">
              <label for="password">Парола</label>
              <input type="password" class="form-control" placeholder="******" name="password" id="password">
            </div>
          </div>
          <?php if (isset($errorString)) { ?><p style="color:red"> <?= $errorString ?> </p> <br> <?php } ?>
          <div class='row '>
            <div class="col-12 gy-4">
              <input type="submit" class="btn btn-b" value="Вход">
            </div>
          </div>
        </form>
      </div>
    </div>
</section>
<?php include_once('footer.php'); ?>