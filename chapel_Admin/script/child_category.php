<?php
require_once '../../core/init.php';
$category = new Category();
if (isset($_POST['parent_id'])) {
  $parentID = (int)$_POST['parent_id'];
  $selected = (int)$_POST['selected'];
  $data = $category->childCate($parentID);
  ob_start();
  ?>
  <?php foreach ($data as $child): ?>
    <option value="<?= $child->id;?>" <?= (($selected == $child->id)? ' selected' : ''); ?>><?= $child->category;?></option>
  <?php endforeach; ?>

  <?php echo ob_get_clean() ?>
<?php
}
