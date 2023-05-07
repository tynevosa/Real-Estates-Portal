<?php
require_once('../db/connection.php');
require_once('../helpers/session.php');
require_once('../helpers/utils.php');
if (isset($_SESSION['loggedin'])) {
  redirect_to('/');
}
$db = new DB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $profile_picture = $_FILES['profile_picture'];

  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $type_id = $_POST['type_id'];
  $bio = $_POST['bio'];
  $phone_number = $_POST['phone_number'];
  $user = $db->first("SELECT * from users WHERE email=" . $db->escape($email));

  $extension = strtolower(pathinfo(basename($profile_picture["name"]), PATHINFO_EXTENSION));

  if (isset($user['id'])) {
    $error_message = 'Потребителят вече съществува.';
  } else {
    if (strlen($password) < 6) {
      $error_message = 'Паролата трябва да е поне 6 символа!';
    } elseif ($password !== $confirm_password) {
      $error_message = 'Паролите не съвпадат.';
    } elseif (empty($first_name) || empty($last_name) || empty($phone_number) || empty($profile_picture)) {
      $error_message = 'Всички полета са задължителни!';
    } else {

      $profile_picture_path = save_uploaded_file($profile_picture);

      $user = [
        "email" => $email,
        "password" => password_hash($password, PASSWORD_BCRYPT),
        "first_name" => $first_name,
        "last_name" => $last_name,
        "profile_picture" => $profile_picture_path,
        "phone_number" => $phone_number,
        "type_id" => $type_id,
      ];
      if (!empty($bio)) {
        $user['bio'] = $bio;
      }
      $user_id = $db->insert('users', $user);

      if ($user_id) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] =  $user['type_id'];
        $_SESSION['name'] = implode(' ', [$user['first_name'], $user['last_name']]);
        redirect_to('/');
      }
    }
  }
}
?>
<?php include_once('header.php'); ?>

<section class="intro-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <div class="title-single-box">
          <h1 class="title-single">Регистрация</h1>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Intro Single-->

<section class="property-grid grid" style="margin-bottom: 50px;">
  <div class="container">
    <div class="row">
      <div class="offset-sm-3 col-sm-6 gy-4">
        <form action="/register.php" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12 ">
              <label for="profile_picture" class="form-label">Снимка:</label>
              <input class="form-control" type="file" id="profile_picture" name="profile_picture">
            </div>
          </div>
          <div class="row  ">
            <div class="col-12 gy-4">
              <label for="type_id">Аз съм:</label>
              <select name="type_id" class="form-select" id='type_selector'>
                <option value="<?= CLIENT_ROLE ?>" selected>Купувач</option>
                <option value="<?= BROKER_ROLE ?>">Продавач</option>
              </select>
            </div>
          </div>
          <div class='row '>
            <div class="col-6 gy-4 ">
              <label for="first_name">Име</label>
              <input type="text" class="form-control" placeholder="Име" name="first_name" id='first_name'>
            </div>
            <div class="col-6 gy-4">
              <label for="last_name">Фамилия</label>
              <input type="text" class="form-control" placeholder="Фамилия" name="last_name" id="last_name">
            </div>
          </div>
          <div class='row' id='bio_container' style="display: none;">
            <div class="col-12 gy-4">
              <label for="bio">За вас</label>
              <textarea class="form-control" placeholder="Кратко описание" maxlength="255" name="bio" id="bio"></textarea>
            </div>
          </div>
          <div class='row '>
            <div class="col-6 gy-4">
              <label for="email">Имейл</label>
              <input type="email" class="form-control" placeholder="Имейл" name="email" id="email">
            </div>
            <div class="col-6 gy-4">
              <label for="phone_number">Телефон</label>
              <input type="text" class="form-control" placeholder="Телефон" name="phone_number" id="phone_number">
            </div>
          </div>
          <div class='row '>
            <div class="col-6 gy-4">
              <label for="password">Парола</label>
              <input type="password" class="form-control" placeholder="Парола" minlength="6" name="password" id="password">
            </div>
            <div class="col-6 gy-4">
              <label for="confirm_password">Повторете паролата</label>
              <input type="password" class="form-control" placeholder="Повторете паролата" minlength="6" name="confirm_password" id="confirm_password">
            </div>
          </div>
          <?php if (isset($error_message)) { ?><p style="color:red"> <?= $error_message ?> </p> <br> <?php } ?>
          <div class='row'>
            <div class="col-3 gy-4">
              <input type="submit" class="btn btn-b" value="Регистрирай се">
            </div>
          </div>
        </form>
      </div>
    </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    let bioc = document.querySelector('#bio_container');
    let typeSelector = document.querySelector('#type_selector');
    typeSelector.addEventListener('change', (e) => {
      console.log(e.target.value)
      if (e.target.value == '<?= CLIENT_ROLE ?>') {
        bioc.style.display = 'none';
      } else if (e.target.value == '<?= BROKER_ROLE ?>') {
        bioc.style.display = 'inherit';
      }
    })
  })
</script>

<?php include_once('footer.php'); ?>