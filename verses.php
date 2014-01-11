<?php
include_once('config.php');
include_once('BibleDAO.php');

$book_id = (isset($_GET['book_id'])) ? $_GET['book_id']: false;
$chapter_id = (isset($_GET['chapter_id'])) ? $_GET['chapter_id']: false;

$verses = BibleDAO::getVerseNumbers($book_id, $chapter_id);

if ($verses == false) {
	echo json_encode(
			array(
				'status' => 'failed',
				'message' => 'Unable to get verses'
			)
		);
} else {
	echo json_encode(
			array(
				'status' => 'success',
				'verses' => $verses
			)
		);
}