<?php
require_once '../../core/init.php';

$student = new User();
$show = new Show();
$db = Database::getInstance();
$book = new Book();
if (isset($_POST['action']) && $_POST['action'] == 'makeRequeset') {

	$book_title = $_POST['borrowBook'];
	$book_author = $_POST['book_author'];
	$book_isbn = $_POST['book_isbn'];

	$user_id = $student->getId();

	$sql = "SELECT * FROM books WHERE book_title = '$book_title'";
	$query = $db->query($sql);
	if ($query->count()) {
		$get = $query->first();
		if ($get->borrow_status == 2) {
      $pending = 1;

				$sql3 = "SELECT * FROM request_book WHERE book_isbn = '$book_isbn'";
				$query3 = $db->query($sql3);

				if ($query3->count()) {
						echo 'You have already made a request for:  ->' .$book_title;
						return false;
				}

	$book->sendRequest(array(
		'user_id' => $user_id,
		'book_title' => $book_title,
		'book_author' => $book_author,
		'book_isbn' =>  $book_isbn,
		'pending' => $pending
	));
		echo 'success';

		}else{
			if ($get->borrow_status == 1) {
				echo 'You can not borrow this particular book!';
			}
		}
	}



}


if (isset($_POST['request_id']) && !empty($_POST['request_id'])) {
	$requestid = (int)$_POST['request_id'];

	$requests = $book->getRequestById($requestid);
	if ($requests) {
		echo json_encode($requests);
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'approveNow') {

	if (Input::exists()) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'requestid'   => array(
					'required' => true
				),
			'booktitle'   => array(
					'required' => true
				),
			'bookisbn'   => array(
					'required' => true
				),
			'bookauthor'   => array(
					'required' => true
				),
			'userid'   => array(
					'required' => true
				),
			'collectDate'   => array(
					'required' => true
				),
			'returnDate'   => array(
					'required' => true
				),
			'returnTime'   => array(
					'required' => true
				)
		));
		if ($validation->passed()) {
			$userid = Input::get('userid');

			$sql12 = "SELECT * FROM borrowed_books WHERE user_id = '$userid' AND retured = 1";
			$query12 = $db->query($sql12);
			if ($query12->count()){
				$returnedBook = $query12->first();
				$book_title  = $returnedBook->book_title;
				$book_isbn = $returnedBook->book_isbn;
				$book_author = $returnedBook->book_author;
				$user_id = $returnedBook->user_id;
				$borrowed_Date = $returnedBook->borrowed_Date;
				$toBeRetured_Date = $returnedBook->toBeRetured_Date;
				$date_returned = $returnedBook->date_returned;

				//move the retured books to borrowed log
				$book->sendIn('borrowed_log',array(
					'book_title'  => $book_title,
					'book_isbn'  => $book_isbn,
					'book_author'  => $book_author,
					'user_id'  => $user_id,
					'borrowed_Date'  => $borrowed_Date,
					'toBeRetured_Date'  => $toBeRetured_Date,
					'date_returned' => $date_returned
				));
				//delete data from database
				$sql123 = "DELETE FROM borrowed_books  WHERE user_id = '$userid' AND retured = 1";
				$query123 = $db->query($sql123);

			}


			//add newly borrowed book to database
			$book->sendIn('borrowed_books',array(
				'book_title'  => Input::get('booktitle'),
				'book_isbn'  => Input::get('bookisbn'),
				'book_author'  => Input::get('bookauthor'),
				'user_id'  => Input::get('userid'),
				'borrowed_Date'  => Input::get('collectDate'),
				'toBeRetured_Date'  => Input::get('returnDate'),
				'time_before_log'  => Input::get('returnTime')

			));

			//update quantity
            $sql1230 = "UPDATE books SET book_quantity = -1 WHERE book_isbn = '$book_isbn'";
            $query1230 = $db->query($sql1230);

			$requestid = Input::get('requestid');
			$book->updateRequest($requestid);//update request table
			$userid = Input::get('userid');
			$book->updateGreenCard($userid); //update greencard

			echo 'success';

		}else{
			foreach ($validation->errors() as $error) {
				echo $show->showMessage('warning', $error, 'warning');
				return false;
			}
		}
	}
}


if (isset($_POST['delRequest_id'])) {
	$delRequest_id = $_POST['delRequest_id'];
	$book->deletedRequest($delRequest_id);
}
