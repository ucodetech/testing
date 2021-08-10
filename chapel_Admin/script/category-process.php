<?php
require_once '../../core/init.php';
$category = new Category();
$show = new Show();
if (isset($_POST['action']) && $_POST['action'] == 'add_cate') {
  $parent = $show->test_input($_POST['parent']);
  $categorys = $show->test_input($_POST['category']);

  if (empty($_POST['category'])) {
      echo $show->showMessage('danger', 'Category is Required!', 'warning');
      return false;
  }

  if ($category->checkCate($categorys, $parent)){ 
    echo $show->showMessage('danger', $categorys.' Already exist in the database!', 'warning');
    return false;
   }else{
      $cate = $category->insertCate($parent, $categorys);
        echo $show->showMessage('success', $categorys.' Added Successfully!', 'check');
   }
  



}


// Fetch categpory
if (isset($_POST['action']) && $_POST['action'] == 'FetchCate') {
  $data = $category->fetchCateParent();
  echo $data;
}


// Fetch categpory
if (isset($_POST['action']) && $_POST['action'] == 'FetchCateSlect') {
  $data = $category->fetchCateParentSelect();
  echo $data;
}


if (isset($_POST['del_id'])) {
  $id = $_POST['del_id'];
  $one  = 1;
  $data = $category->cateAction($one, $id);
  // $category->cateChildAction(1,'parent', $id);
}

// if (isset($_POST['delchild_id'])) {
//   $id = $_POST['delchild_id'];
//   $category->cateChildAction(1,'id', $id);
// }

if (isset($_POST['edit_id'])) {
  $id = $_POST['edit_id'];
  $data = $category->cateById($id);
  echo json_encode($data);
}

//edit category
if (isset($_POST['action']) && $_POST['action'] == 'update_cate') {
    $edit_id = $show->test_input($_POST['editId']);
    $category = $show->test_input($_POST['category']);
    $category = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($category)));

    if (empty($_POST['category'])) {
        echo $category->showMessage('danger', 'Category is required!', 'warning');
        return false;
    }
      $category->cateUpdate($category, $edit_id);

}


// add tags
if (isset($_POST['action']) && $_POST['action'] == 'add_tags') {
  $tagc = '';
  $tag = $_POST['tags'];

  if (empty($_POST['tags'])) {
      echo $show->showMessage('danger', 'tag is Required!', 'warning');
      return false;
  }

  if ($category->checkTag($tag)) {
    echo $show->showMessage('danger', $tag.' Already exist in the database!', 'warning');
    return false;
  }else{

        $category->addTag($tag);
        echo $show->showMessage('success', $tag.' Added Successfully!', 'check');
  }



}

// Fetch categpory
if (isset($_POST['action']) && $_POST['action'] == 'FetchTag') {
  $data = $category->fetchTag();
  echo $data;

}
