<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '..\model\App.php';

$db = App::getDB();
require '..\model\ModelReview.php';
require '..\model\ModelUser.php';

?>

<style>
    .comment {
        display: inline-block;
        background-color: #565656;
        color: #fff;
        text-decoration: none;
        margin: 10px 0 0 0;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
        border: 0;
    }
</style>

<?php

// Convert datetime to time elapsed string.
function time_elapsed_string($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// Need product page's ID to determine which reviews are for which page.
if (isset($_GET['product_code'])) {
    if (isset($_SESSION['auth'], $_POST['rating'], $_POST['content'])) {
        $res = ModelUser::getNamebyCode($db, $_SESSION['auth']);
        $name = $res->first_name . " " . $res->last_name;
        // Insert a new review (user submitted form)
        $product_id = $_GET['product_code'];
        $content = $_POST['content'];
        $rating = $_POST['rating'];

        $r = new ModelReview($product_id, $name, $content, $rating);
        $r->save($db);
        exit('Thank you for your review!');
    }
    // Get all reviews by the Page ID ordered by the submit date
    $reviews = ModelReview::getbyProductId($db, $_GET['product_code']);

    // Get the overall rating and total amount of reviews 
    $reviews_info = ModelReview::getRating($db, $_GET['product_code']);
} else {
    exit('Please provide the page ID.');
}
?>

<div class="overall_rating">
    <span class="num"><?= number_format($reviews_info['overall_rating'], 1) ?></span>
    <span class="stars"><?= str_repeat('&#9733;', round($reviews_info['overall_rating'])) ?></span>
    <span class="total"><?= $reviews_info['total_reviews'] ?> reviews</span>
</div>

<?php if (isset($_SESSION['auth'])) : ?>
    <?php
    $res = ModelUser::getNamebyCode($db, $_SESSION['auth']);
    $name = $res->first_name . " " . $res->last_name;
    ?>
    <a href="#" class="write_review_btn">Write Review</a>
    <div class="write_review">
        <form>
            <input value="<?= $name ?>" type="text" readonly>
            <input name="rating" type="number" min="1" max="5" placeholder="Rating (1-5)" required>
            <textarea name="content" placeholder="Write your review here..." required></textarea>
            <br>
            <button type="submit">Submit Review</button>
        </form>
    </div>
<?php endif ?>


<?php foreach ($reviews as $review) : ?>
    <div class="review">
        <h3 class="name"><?= htmlspecialchars($review['name'], ENT_QUOTES) ?></h3>
        <div>
            <span class="rating"><?= str_repeat('&#9733;', $review['rating']) ?></span>
            <span class="date"><?= time_elapsed_string($review['submit_date']) ?></span>
        </div>
        <p class="content" style="color:black"><?= htmlspecialchars($review['content'], ENT_QUOTES) ?></p>
    </div>
<?php endforeach ?>