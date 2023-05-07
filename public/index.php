<?php 
require_once('../db/connection.php');
require_once('../helpers/session.php');
require_once('../helpers/utils.php');
require_once('../helpers/constants.php');

$db = new DB();

$latest_estates = $db->fetch("SELECT * FROM real_estates ORDER BY created_at LIMIT 3");

$agents = $db->fetch("SELECT * FROM users WHERE type_id=" . BROKER_ROLE . " LIMIT 3");

include_once("header.php");
?>

  <!-- ======= Intro Section ======= -->
  <div class="intro intro-carousel swiper position-relative">

    <div class="swiper-wrapper">

    <?php
        foreach ($latest_estates as $estate) {
            $estate_id = $estate['id'];
            $estate_first_image = $db->first("SELECT * FROM real_estate_images WHERE real_estate_id=$estate_id");
            if (!$estate_first_image) {
              $path = '/assets/img/no-property-img.png';
            } else {
              $path = $estate_first_image['path'];
            }
    ?>
      <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url(<?=$path?>)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <p class="intro-title-top"><?=$estate['address']?>
                    </p>
                    <h1 class="intro-title mb-4 ">
                        <?=$estate['title']?>
                    </h1>
                    <p class="intro-subtitle intro-price">
                      <a href="real-estate.php?id=<?=$estate['id']?>"><span class="price-a">€ <?=$estate['price']?></span></a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
        }
    ?>
    </div>
    <div class="swiper-pagination"></div>
  </div><!-- End Intro Section -->

    <!-- ======= Services Section ======= -->
    <section class="section-services section-t8">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="title-wrap d-flex justify-content-between">
                <div class="title-box">
                  <h2 class="title-a">Какво предлагаме?</h2>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card-box-c foo">
                <div class="card-header-c d-flex">
                  <div class="card-box-ico">
                    <span class="bi bi-cart"></span>
                  </div>
                  <div class="card-title-c align-self-center">
                    <h2 class="title-c">Начин на Живот</h2>
                  </div>
                </div>
                <div class="card-body-c">
                  <p class="content-c">
                  Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-box-c foo">
                <div class="card-header-c d-flex">
                  <div class="card-box-ico">
                    <span class="bi bi-calendar4-week"></span>
                  </div>
                  <div class="card-title-c align-self-center">
                    <h2 class="title-c">Заеми</h2>
                  </div>
                </div>
                <div class="card-body-c">
                  <p class="content-c">
                  Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card-box-c foo">
                <div class="card-header-c d-flex">
                  <div class="card-box-ico">
                    <span class="bi bi-card-checklist"></span>
                  </div>
                  <div class="card-title-c align-self-center">
                    <h2 class="title-c">Продажба</h2>
                  </div>
                </div>
                <div class="card-body-c">
                  <p class="content-c">
                  Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section><!-- End Services Section -->

          <!-- ======= Latest Properties Section ======= -->
    <section class="section-property section-t8">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="title-wrap d-flex justify-content-between">
                <div class="title-box">
                  <h2 class="title-a">Най-новите Имоти</h2>
                </div>
                <div class="title-link">
                  <a href="real-estates.php">Всички Имоти
                    <span class="bi bi-chevron-right"></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
  
          <div id="property-carousel" class="swiper">
            <div class="swiper-wrapper">
  
            <?php foreach ($latest_estates as $estate) {
                $estate_id = $estate['id'];
                $estate_first_image = $db->first("SELECT * FROM real_estate_images WHERE real_estate_id=$estate_id");
                if (!$estate_first_image) {
                  $path = '/assets/img/no-property-img.png';
                } else {
                  $path = $estate_first_image['path'];
                }
            ?> 
              <div class="carousel-item-b swiper-slide">
                <div class="card-box-a card-shadow">
                  <div class="img-box-a img-box-reset">
                    <img src="<?=$path?>" alt="" class="img-a img-fluid">
                  </div>
                  <div class="card-overlay">
                    <div class="card-overlay-a-content">
                      <div class="card-header-a">
                        <h2 class="card-title-a">
                          <a href="real-estate.php?id=<?=$estate['id']?>"><?=$estate['title']?></a>
                        </h2>
                      </div>
                      <div class="card-body-a">
                        <div class="price-box d-flex">
                          <span class="price-a">$ <?=$estate['price']?></span>
                        </div>
                        <a href="real-estate.php?id=<?=$estate['id']?>" class="link-a">Детайли
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
              </div><!-- End carousel item -->
                <?php
                }
                ?>

            </div>
          </div>
          <div class="propery-carousel-pagination carousel-pagination"></div>
  
        </div>
      </section><!-- End Latest Properties Section -->

          <!-- ======= Agents Section ======= -->
    <section class="section-agents section-t8">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="title-wrap d-flex justify-content-between">
                <div class="title-box">
                  <h2 class="title-a">Брокери</h2>
                </div>
                <div class="title-link">
                  <a href="agents.php">Всички Брокери
                    <span class="bi bi-chevron-right"></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <?php
                foreach ($agents as $agent) {
            ?>
            <div class="col-md-4">
                <div class="card-box-d">
                    <div class="card-img-d">
                        <img src="<?=$agent['profile_picture']?>" alt="" class="img-d img-fluid">
                    </div>
                    <div class="card-overlay card-overlay-hover">
                    <div class="card-header-d">
                        <div class="card-title-d align-self-center">
                            <h3 class="title-d">
                                <a href="agent.php?id=<?=$agent['id']?>" class="link-two"><?=$agent['first_name']?> <?=$agent['last_name']?></a>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body-d">
                        <p class="content-d color-text-a">
                            <?=$agent['bio']?>
                        </p>
                        <div class="info-agents color-a">
                        <p>
                            <strong>Телефон: </strong> <?=$agent['phone_number']?>
                        </p>
                        <p>
                            <strong>Имейл: </strong> <?=$agent['email']?>
                        </p>
                        </div>
                    </div>
                    <div class="card-footer-d">
                        <div class="socials-footer d-flex justify-content-center">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                            <a href="#" class="link-one">
                                <i class="bi bi-facebook" aria-hidden="true"></i>
                            </a>
                            </li>
                            <li class="list-inline-item">
                            <a href="#" class="link-one">
                                <i class="bi bi-twitter" aria-hidden="true"></i>
                            </a>
                            </li>
                            <li class="list-inline-item">
                            <a href="#" class="link-one">
                                <i class="bi bi-instagram" aria-hidden="true"></i>
                            </a>
                            </li>
                            <li class="list-inline-item">
                            <a href="#" class="link-one">
                                <i class="bi bi-linkedin" aria-hidden="true"></i>
                            </a>
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
        </div>
      </section><!-- End Agents Section -->

          <!-- ======= Testimonials Section ======= -->
    <section class="section-testimonials section-t8 nav-arrow-a">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="title-wrap d-flex justify-content-between">
                <div class="title-box">
                  <h2 class="title-a">Какво мислят нашите клиенти?</h2>
                </div>
              </div>
            </div>
          </div>
  
          <div id="testimonial-carousel" class="swiper">
            <div class="swiper-wrapper">
  
              <div class="carousel-item-a swiper-slide">
                <div class="testimonials-box">
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <div class="testimonial-img">
                        <img src="assets/img/testimonial-1.jpg" alt="" class="img-fluid">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="testimonial-ico">
                        <i class="bi bi-chat-quote-fill"></i>
                      </div>
                      <div class="testimonials-content">
                        <p class="testimonial-text">
                  Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове.
                        </p>
                      </div>
                      <div class="testimonial-author-box">
                        <img src="assets/img/mini-testimonial-1.jpg" alt="" class="testimonial-avatar">
                        <h5 class="testimonial-author">Андрей & Люба</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- End carousel item -->
  
              <div class="carousel-item-a swiper-slide">
                <div class="testimonials-box">
                  <div class="row">
                    <div class="col-sm-12 col-md-6">
                      <div class="testimonial-img">
                        <img src="assets/img/testimonial-2.jpg" alt="" class="img-fluid">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                      <div class="testimonial-ico">
                        <i class="bi bi-chat-quote-fill"></i>
                      </div>
                      <div class="testimonials-content">
                        <p class="testimonial-text">
                  Lorem Ipsum е елементарен примерен текст, използван в печатарската и типографската индустрия. Lorem Ipsum е индустриален стандарт от около 1500 година, когато неизвестен печатар взема няколко печатарски букви и ги разбърква, за да напечата с тях книга с примерни шрифтове.
                        </p>
                      </div>
                      <div class="testimonial-author-box">
                        <img src="assets/img/mini-testimonial-2.jpg" alt="" class="testimonial-avatar">
                        <h5 class="testimonial-author">Георги & Ема</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div><!-- End carousel item -->
  
            </div>
          </div>
          <div class="testimonial-carousel-pagination carousel-pagination"></div>
  
        </div>
      </section><!-- End Testimonials Section -->
  
<?php include_once("footer.php"); ?>