<?php

require_once '../../core/init.php';

$book = new Book();
$show = new Show();
$db = Database::getInstance();
if (isset($_POST['action']) && $_POST['action'] == 'fetch_book') {

	$books = $book->fetchBooks(0);
	if ($books) {
		echo $books;
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'fetch_borrowedbook') {

	$books = $book->fetchBorrowedBooks(0);
	if ($books) {
		echo $books;
	}
}



if (isset($_POST['action']) && $_POST['action'] == 'add_book') {

	if (Input::exists()) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'bookTitle' => array(
				'required' => true,
				'min' => 5

			),
			'bookAuthor' => array(
				'required' => true,
				'min' => 5

			),
			'bookEdition' => array(
				'required' => false


			),
			'bookQuantity' => array(
				'required' => true,
			),
			'bookISBN' => array(
				'required' => true,
				'min' => 10,
				'max' => 20
			),
			'bookDateOfPublication' => array(
				'required' => true

			),
			'bookSection' =>array(
				'required' => true
			),
			'bookStatus' => array(
				'required' => true

			),
			'bookChild' => array(
				'required' => true
			)

		));

		if ($validation->passed()) {
			$bookisbn = Input::get('bookISBN');
			$sql = "SELECT * FROM books WHERE book_isbn = '$bookisbn' ";
			$query = $db->query($sql);
			if ($query->count()) {
				echo $show->showMessage('danger', 'The book you are adding already exists!' ,'times');
				return false;
			}

			if (!preg_filter('/[^a-z0-9]+/i', '-', Input::get('bookISBN'))) {
        echo $show->showMessage('danger', 'Please add - where neccessary on ISBN! ' ,'times');
					return false;
            }

			try {

				$book->addBook(array(
					'book_title'		=> Input::get('bookTitle'),
					'book_isbn'			=> Input::get('bookISBN'),
					'book_edition'		=> Input::get('bookEdition'),
					'book_author'		=> Input::get('bookAuthor'),
					'book_dateOfPub'	=> Input::get('bookDateOfPublication'),
					'book_categories'	=> Input::get('bookChild'),
					'book_quantity'		=> Input::get('bookQuantity'),
					'book_section'		=> Input::get('bookSection'),
					'borrow_status'		=> Input::get('bookStatus')
				));
				echo 'success';

			} catch (Exception $e) {
				echo $show->showMessage('danger', $e->getMessage() ,'times');
				return false;
			}

		}else{
			foreach ($validation->errors() as $error) {
				echo $show->showMessage('danger', $error ,'times');
				return false;
			}

		}

	}

}

if (isset($_POST['book_id'])) {
	$book_id = (int)$_POST['book_id'];
	$books = $book->getBookDetail($book_id);
	if ($books) {
		echo $books;
	}
}



// move book to trash

if (isset($_POST['del_id'])) {
	$del_id = (int)$_POST['del_id'];
	$book->trashBook($del_id);

}




if (isset($_POST['action']) && $_POST['action'] == 'fetch_returnedBook') {

	$books = $book->fetchReturnedBooks(1);
	if ($books) {
		echo $books;
	}
}


if (isset($_POST['bookReturned_id'])) {
	$bookReturned_id = (int)$_POST['bookReturned_id'];
	$book->updateBookStatus($bookReturned_id);

}
