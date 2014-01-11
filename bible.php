<?php
include_once('config.php');
include_once('BibleDAO.php');

$books = BibleDAO::getBooks();
$defaultChapters = BibleDAO::getChapterNumbers(1);
$defaultVerses = BibleDAO::getVerseNumbers(1, 1);
$defaultVerseText = BibleDAO::getVerseText(1, 1, 1);
?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body style = "background:url('j.jpg')">
	<div style = "margin-top:50px">
		<h1 align = "center" class = "moral">King James Bible</h1>
	</div>
	<div class = "span12">
		<div class = "span8 pull-left">
			<div class = "micah" style = "margin-top:50px;margin-left:20px">
				<form>
					<table>
						<thead>
							<tr>
								<th>Books</th>
								<th>Chapters</th>
								<th>Verses</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<select name="books" id="books">
										<?php foreach($books as $id => $book): ?>
											<option value="<?= $id ?>"><?= $book ?></option>
										<?php endforeach ?>
									</select>
								</td>
								<td>
									<select name="chapters" id="chapters">
										<?php for($i = 1; $i <= $defaultChapters; $i++): ?>
											<option value="<?= $i ?>"><?= $i ?></option>
										<?php endfor ?>
									</select>
								</td>
								<td>
									<select name="verses" id="verses">
										<?php for($i = 1; $i <= $defaultVerses; $i++): ?>
											<option value="<?= $i ?>"><?= $i ?></option>
										<?php endfor ?>
									</select>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
			</div>
			<div id="verse_text" class = "offset1 mic">
				<?= $defaultVerseText ?>
			</div>
		</div>
		<div class = "span3 pull-right">
			<input type = "text" class = "search-query" style = "height:30px" placeholder = "Search ....">
		</div>
	</div>
</body>
</html>


<script type="text/javascript" src="jquery.1.10.2.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	function getVerseText(bid, cid, vid) {
		$.ajax({
			url: 'versetext.php',
			data: {book_id: bid, chapter_id: cid, verse_id: vid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				$('#verse_text').html(response.verse_text);
			}
		});
	}

	$('#books').on('change', function() {
		var bid = $(this).val();
		$.ajax({
			url: 'chapters.php',
			data: {book_id: bid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.chapters; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#chapters').html(str);
				getVerseText(bid, 1, 1);
			},
			error: function(err) {
				alert('NONO');
			}
		});
	});

	$('#chapters').on('change', function() {
		var bid = $('#books').val();
		var cid = $(this).val();
		$.ajax({
			url: 'verses.php',
			data: {book_id: bid, chapter_id: cid},
			dataType: 'JSON',
			method: 'GET',
			success: function(response) {
				var str = '';
				for(i = 1; i <= response.verses; i++) {
					str += '<option value=' + i + '>' + i + '</option>';
				}
				$('#verses').html(str);
				getVerseText(bid, cid, 1);
			},
			error: function(err) {
				alert('NONO');
			}
		});
	});

	$('#verses').on('change', function() {
		var bid = $('#books').val();
		var cid = $('#chapters').val();
		var vid = $(this).val();
		getVerseText(bid, cid, vid);
	});
});
</script>