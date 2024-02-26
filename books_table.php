<?php
$host='localhost:4306';
$db='books/publishers/authorsv3';
$user='root';
$pass='';
$charset='utf8mb4';
$dsn="mysql:host=$host;dbname=$db;charset=$charset";
$options=[
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES=>false,
];
try{
    $pdo=new PDO($dsn,$user,$pass,$options);
} catch(\PDOException $e) {
    throw new \PDOException($e->getMessage(),(int)$e->getCode());
}
?>

<html>
    
    <head>
    <link rel="stylesheet" type="text/css" href="books_table.css" />

        <title>
            Books, Authors and Publishers
        </title>
    </head>
    <body>
        <h1>
            Books, Authors and Publishers
        </h1>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="authors">Choose an author:</label>
        <select name="authors" id="authors">
            <?php
            $stmt=$pdo->query('SELECT * FROM `authors`');
            while ($row=$stmt->fetch() ){
                 echo '<option value="'.$row['a_id'].'">'.$row['author'].'</option>';
            }
            ?>
        </select>
        <input type="submit" value="submit">
        </form>
        <?php
 
	
	$a_choice = intval($_GET['authors']);
	
	$sql = "SELECT 
    books.bookname,
    books_authors.book_id,
    authors.author,
    books.b_rating,
    publishers.p_id,
    publishers.publisher,
    publishers.country
    FROM books,authors,publishers
    JOIN books_authors
    WHERE books.book_id=books_authors.book_id AND authors.a_id=books_authors.a_id AND books.p_id=publishers.p_id AND authors.a_id=$a_choice";
	
	$stmt = $pdo->query($sql);
	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	echo '<h4>Books found for '. $rows[0]['author'] .':</h4>'; 
	
	echo '<table style="border:1px solid black;"text-align:center;""align>';
	    echo '<thead style="text-align:center;">';
                echo '<tr style="border: 1px solid;">';
                echo '<th scope="col">Book name  </th>';
                echo '<th scope="col">  Book rating</th>';
                echo '<th scope="col">  author</th>';
                echo '<th scope="col">  b_rating</th>';
                echo '<th scope="col">  p_id</th>';
                echo '<th scope="col">  publisher</th>';
                echo '<th scope="col">  country</th>';


                echo '</tr>';
            echo '</thead>';
	
	  foreach ($rows as $row) {
		echo '<tr>';
		echo '<td style="border:1px solid black;">' . $row['bookname'] . '</td>';
		echo '<td style="border:1px solid black;">' . $row['book_id'] . '</td>';
        echo '<td style="border:1px solid black;">' . $row['author'] . '</td>';
        echo '<td style="border:1px solid black;">' . $row['b_rating'] . '</td>';
        echo '<td style="border:1px solid black;">' . $row['p_id'] . '</td>';
        echo '<td style="border:1px solid black;">' . $row['publisher'] . '</td>';
        echo '<td style="border:1px solid black;">' . $row['country'] . '</td>';


		echo '</tr>';
	}
	echo '</table>';
  
?>
    </body>
</html>