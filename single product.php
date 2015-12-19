<?php
ob_start();
?>
<!doctype html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="stylesheet/fonts/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="stylesheet/reset.css">
        <link rel="stylesheet" type="text/css" href="stylesheet/product.css">
        <link rel="stylesheet" type="text/css" href="stylesheet/icons/style.css">
        <script src="js/jquery.js"></script>
        <script>
            $(document).ready(function () {
                document.title = $('hgroup h1:first').text() + document.title;
            });
        </script>
        <meta charset="utf-8">
        <title> | UAAR Bookstore</title>
    </head>
    <body>
        <?php
        $Keywords = [];
        require 'header.inc.php';
        ?>
        <div id="container">

            <?php
            include('includes/dbconnect.inc.php');
            try {
                $bid = $_GET['pid'];
                $keyword = $checkDatabaseConnection->prepare("SELECT * FROM bookkeywords where Book_id=:id");
                $keyword->bindParam(':id', $bid);
                $keyword->execute();

                while ($tag = $keyword->fetch(PDO::FETCH_ASSOC)) {
                    array_push($Keywords, $tag["Keyword"]);
                }

                if (isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                    if (isset($_POST['addToCart'])) {
                        if (!isset($_SESSION['user'])) {
                            session_start();
                            $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
                            header("Location:register.php");
                            exit;
                        } else {
                            $qty = $_POST['quantity'];
                            $bid = $_GET['pid'];
                            $selectbooks = $checkDatabaseConnection->prepare("SELECT * FROM books where Book_id=:bookid");
                            $selectbooks->bindParam(':bookid', $bid);
                            $selectbooks->execute();
                            if ($selectbooks->rowCount() == 1) {
                                $r = $selectbooks->fetch(PDO::FETCH_ASSOC);
                                if (isset($_SESSION['cart'][$bid])) {
                                    $_SESSION['cart'][$bid]['quantity']+=$qty;
                                    echo"<script>alert(\"Quantity of Book Incremented to Cart Successfully\");</script>";
                                } else {
                                    $_SESSION['cart'][$bid] = array('quantity' => $qty, 'price' => $r['Price']);
                                    echo"<script>alert(\"Book Added to Cart Successfully\");</script>";
                                }
                            }
                        }
                    }
                    $selectbooks = $checkDatabaseConnection->prepare("SELECT * FROM books where Book_id=:bookid");
                    $selectbooks->bindParam(':bookid', $_GET['pid']);
                    $selectbooks->execute();
                    if ($selectbooks) {
                        while ($bookrow = $selectbooks->fetch(PDO::FETCH_ASSOC)) {
                            $GLOBALS['title'] = $bookrow["BookName"];
                            ?>
                            <div id="book">
                                <div id="shortdesc">
                                    <img src="<?php
                            if (file_exists('images/' . md5($bookrow["BookName"]) . '.jpg')) {
                                echo 'images/' . md5($bookrow["BookName"]) . '.jpg';
                            } else if (file_exists('images/' . md5($bookrow["BookName"]) . '.png')) {
                                echo 'images/' . md5($bookrow["BookName"]) . '.png';
                            } else if (file_exists('images/' . md5($bookrow["BookName"]) . '.gif')) {
                                echo 'images/' . md5($bookrow["BookName"]) . '.gif';
                            } else if (file_exists('images/' . md5($bookrow["BookName"]) . '.jpeg')) {
                                echo 'images/' . md5($bookrow["BookName"]) . '.jpeg';
                            } else if (file_exists('/images/' . md5($bookrow["BookName"]) . '.bmp')) {
                                echo 'images/' . md5($bookrow["BookName"]) . '.bmp';
                            } else {
                                die("Fatal Error");
                            }
                            ?>"><hgroup><h1><?php echo $bookrow["BookName"]; ?></h1>
                                        <h2><?php echo $bookrow["Author Name"]; ?></h2>
                                        <h3<?php echo $bookrow["Edition"]; ?> Edition</h3></hgroup>
                                    <p>Price: Rs. <?php echo $bookrow["Price"]; ?></p>
                                    <p>Stock Status: <?php echo $bookrow["Stock Status"]; ?></p>
                                    <form><p><button>Add to Wishlist</button><button formmethod="post" type="submit" name="addToCart" formaction="single product.php?pid=<?php echo $_GET['pid']; ?>" formmethod="post">Add to Cart <span class="icon-cart"></span></button>Quantity:&nbsp;
                                            <select name="quantity">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="11">11</option>
                                                <option value="12">12</option>
                                                <option value="13">13</option>
                                                <option value="14">14</option>
                                                <option value="15">15</option>
                                                <option value="16">16</option>
                                                <option value="17">17</option>
                                                <option value="18">18</option>
                                                <option value="19">19</option>
                                                <option value="20">20</option>
                                            </select>
                                        </p></form>
                                </div>
                                <div id="desc">
                                    <h1>About This Book</h1>
                                    <p><?php echo $bookrow["Book Description"]; ?></p>
                                    <h1>Book Details</h1>
                                    <table>
                                        <tr>
                                            <td>Number of pages</td>
                                            <td><?php echo $bookrow["Number of Pages"]; ?> pages</td>
                                        </tr>
                                        <tr>
                                            <td>Publication Date</td>
                                            <td><?php echo $bookrow["Publication Date"]; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Publisher</td>
                                            <td><?php echo $bookrow["Publisher"]; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Bar Code</td>
                                            <td><?php echo $bookrow["Bar Code"]; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                <?php
            }
        } else {
            echo"<p id=\"sqlerror\">Cannot Retrieve Bookss from Database.</p>";
            exit;
        }
        ?>


                    <?php
                } else {
                    echo"Invalid Approach ";
                    exit;
                }
                ?>
                <aside id="related">
                    <h1>Related books</h1>
                    <ul>
    <?php
    include('includes/dbconnect.inc.php');
    $x = 0;
    $id = array();
    $relatedBooks = array();
    $quantity = array();

    foreach ((array) $Keywords as $v) {
        $related = $checkDatabaseConnection->prepare("SELECT k.Book_id,b.BookName,b.Price FROM books b,bookkeywords k WHERE k.Keyword=:Keyword AND b.Book_id=k.Book_id GROUP BY k.Book_id");
        $k = $v;
        $related->bindParam(':Keyword', $k);
        $related->execute();
        while ($crow = $related->fetch(PDO::FETCH_ASSOC)) {
            $relatedBooks[$x] = $crow["Book_id"];
            $x++;
        }
    }
    $sidebar = array_unique($relatedBooks);
    foreach ($sidebar as $s) {
        $relatedSidebar = $checkDatabaseConnection->prepare("SELECT BookName,Price From books where Book_id=:id");
        $relatedSidebar->bindParam(':id', $s);
        $relatedSidebar->execute();
        while ($srow = $relatedSidebar->fetch(PDO::FETCH_ASSOC)) {
            ?>
                                <li>
                                    <a href="single product.php?pid=<?php echo $s; ?>"><img src="<?php
                                if (file_exists('images/' . md5($srow["BookName"]) . '.jpg')) {
                                    echo 'images/' . md5($srow["BookName"]) . '.jpg';
                                } else if (file_exists('images/' . md5($srow["BookName"]) . '.png')) {
                                    echo 'images/' . md5($srow["BookName"]) . '.png';
                                } else if (file_exists('images/' . md5($srow["BookName"]) . '.gif')) {
                                    echo 'images/' . md5($srow["BookName"]) . '.gif';
                                } else if (file_exists('images/' . md5($srow["BookName"]) . '.jpeg')) {
                                    echo 'images/' . md5($srow["BookName"]) . '.jpeg';
                                } else if (file_exists('/images/' . md5($srow["BookName"]) . '.bmp')) {
                                    echo 'images/' . md5($srow["BookName"]) . '.bmp';
                                } else {
                                    die("Fatal Error");
                                }
                                ?>"><p><?php echo $srow['BookName']; ?></p>
                                        <p>Price: Rs <?php echo $srow['Price']; ?></p></a>
                                </li>


                                        <?php
                                    }
                                }
                                echo '</ul>';
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>

            </aside>
        </div>
                            <?php
                            require 'footer.inc.php';
                            ?>
    </body>
</html>