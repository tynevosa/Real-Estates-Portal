<?php 
require_once('../db/connection.php');
$db = new DB();
$realEstateTypes = $db->fetch('SELECT * FROM real_estate_types');
$constructionTypes = $db->fetch('SELECT * from real_estate_types_of_construction');
$levels = $db->fetch('SELECT * from real_estate_level');
?>
<!--/ Form Search Star /-->
 <div class="box-collapse">
     <div class="title-box-d">
         <h3 class="title-d">Търсене на Имот</h3>
     </div>
     <span class="close-box-collapse right-boxed bi bi-x"></span>
     <div class="box-collapse-wrap form">
         <form class="form-a" action="search-results.php" method="GET">
             <div class="row">
                 <div class="col-md-12 mb-2">
                     <div class="form-group">
                         <input type="text" id="keyword" name="keyword" class="form-control form-control-lg form-control-a" placeholder="Апартамент">
                     </div>
                 </div>
                 <div class="col-md-4 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="real_estate_type">Вид на Имота</label>
                         <select class="form-control form-select form-control-a" id="real_estate_type" name='real_estate_type'>
                             <option selected value="any">Вички</option>
                             <?php foreach($realEstateTypes as $realEstateType){ ?>
                             <option value="<?=$realEstateType['id']?>"><?=$realEstateType['title']?></option>
                             <?php } ?>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-4 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="real_estate_type_of_construction">Вид строителство</label>
                         <select class="form-control form-select form-control-a" id="real_estate_type_of_construction" name='real_estate_type_of_construction'>
                             <option selected value="any">Вички</option>
                             <?php foreach($constructionTypes as $constructionType){ ?>
                             <option value="<?=$constructionType['id']?>"><?=$constructionType['title']?></option>
                             <?php } ?>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-4 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="real_estate_level">Етап на завършеност</label>
                         <select class="form-control form-select form-control-a" id="real_estate_level" name='real_estate_level'>
                             <option selected value="any">Всички</option>
                             <?php foreach($levels as $level){ ?>
                             <option value="<?=$level['id']?>"><?=$level['title']?></option>
                             <?php } ?>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-6 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="bedrooms">Спални</label>
                         <select class="form-control form-select form-control-a" id="bedrooms" name='bedrooms'>
                             <option selected value="any">Всички</option>
                             <option value="1">1</option>
                             <option value="2">2</option>
                             <option value="3">3</option>
                             <option value="4">4</option>
                             <option value="5">5</option>
                             <option value="6">6</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-6 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="garages">Гаражи</label>
                         <select class="form-control form-select form-control-a" id="garages" name="garages">
                             <option selected value="any">Всички</option>
                             <option value="1">1</option>
                             <option value="2">2</option>
                             <option value="3">3</option>
                             <option value="4">4</option>
                             <option value="5">5</option>
                             <option value="6">6</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-6 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="bathrooms">Бани</label>
                         <select class="form-control form-select form-control-a" id="bathrooms" name="bathrooms">
                             <option selected value="any">Всички</option>
                             <option value="1">1</option>
                             <option value="2">2</option>
                             <option value="3">3</option>
                             <option value="4">4</option>
                             <option value="5">5</option>
                             <option value="6">6</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-6 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="living_rooms">Всекидневни</label>
                         <select class="form-control form-select form-control-a" id="living_rooms" name="living_rooms">
                             <option selected value="any">Всички</option>
                             <option value="1">1</option>
                             <option value="2">2</option>
                             <option value="3">3</option>
                             <option value="4">4</option>
                             <option value="5">5</option>
                             <option value="6">6</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-6 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="min_price">Минимална Цена</label>
                         <select class="form-control form-select form-control-a" id="min_price" name="min_price">
                             <option selected value='unlimited'>Неограничена</option>
                             <option value="50000">€50,000</option>
                             <option value="100000">€100,000</option>
                             <option value="150000">€150,000</option>
                             <option value="200000">€200,000</option>
                             <option value="250000">€250,000</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-6 mb-2">
                     <div class="form-group mt-3">
                         <label class="pb-2" for="max_price">Максимална Цена</label>
                         <select class="form-control form-select form-control-a" id="max_price" name="max_price">
                             <option selected value='unlimited'>Неограничена</option>
                             <option value="50000">€50,000</option>
                             <option value="100000">€100,000</option>
                             <option value="150000">€150,000</option>
                             <option value="200000">€200,000</option>
                             <option value="250000">€250,000</option>
                         </select>
                     </div>
                 </div>
                 <div class="col-md-12">
                     <button type="submit" class="btn btn-b">Търси</button>
                 </div>
             </div>
         </form>
     </div>
 </div><!-- End Property Search Section -->