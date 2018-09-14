 <?php
if (!isset($date_debut)) {
  $date_debut = '';
}
if (!isset($date_fin)) {
  $date_fin = '';
}
if (!isset($max_choix_PFE)) {
  $max_choix_PFE = '';
}
if (!isset($min_choix_PFE)) {
  $min_choix_PFE = '';
}
if (!isset($max_choix_master)) {
  $max_choix_master = '';
}
if (!isset($min_choix_master)) {
  $min_choix_master = '';
}
  ?>


  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Date Debut</label>
    <div class="col-sm-4 date">
      <input type="Date" name="date_debut" value="<?= $date_debut?>" class="form-control" id="datetimepicker1" placeholder="date debut">
    </div>
  </div>
   <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Date Fin</label>
    <div class="col-sm-4 date">
      <input type="Date" name="date_fin" value="<?= $date_fin?>" class="form-control datetimepicker" id="datetimepicker1" placeholder="date fin">
    </div>
  </div>
   <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Max choix PFE</label>
    <div class="col-sm-4 date">
      <input type="text" name="max_choix_PFE" value="<?= $max_choix_PFE?>" class="form-control" id="inputEmail3" placeholder="max_choix_PFE">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Min choix PFE</label>
    <div class="col-sm-4">
      <input type="text" name="min_choix_PFE" value="<?= $min_choix_PFE?>" class="form-control" id="inputPassword3" placeholder="min_choix_PFE">
    </div>
  </div>
     <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Max choix Master</label>
    <div class="col-sm-4 date">
      <input type="text" name="max_choix_master" value="<?= $max_choix_master?>" class="form-control" id="inputEmail3" placeholder="max_choix_master">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Min choix Master</label>
    <div class="col-sm-4">
      <input type="text" name="min_choix_master" vvalue="<?= $min_choix_master?>" class="form-control" id="inputPassword3" placeholder="min_choix_master">
    </div>
  </div>


  
  