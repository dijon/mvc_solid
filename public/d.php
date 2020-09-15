<?php
const PENNY_KEY = 'penny_';
const LEV_KEY = 'lev_';
$message = false;

$pennies = [1 => 0, 2 => 0, 5 => 0, 10 => 0, 20 => 0, 50 => 0];
$levs = [1 => 0, 2 => 0, 5 => 0, 10 => 0, 20 => 0, 50 => 0, 100 => 0];

$paid = 0;
$price = 0;
$changeDetails = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paid = $_POST['paid'];
    $price = $_POST['price'];
    foreach ($_POST as $key => $value) {
        if (strpos($key, PENNY_KEY) !== false) {
            $explode = explode('_',$key);
            $pennies[end($explode)] = $value;
        }
        if (strpos($key, LEV_KEY) !== false) {
            $explode = explode('_',$key);
            $levs[end($explode)] = $value;
        }
    }
}

$change = $paid - $price;

if ($change < 0 || $change > 99.99) {
    $message = "Грешно въведена стойност за Платено!";
} else {
    krsort($levs); // descending sorting by key
    foreach ($levs as $lev => $count) {
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                if (($change - $lev) >= 0) {
                    $change -= $lev;
                    $changeDetails[] = $lev;
                    --$levs[$lev];
                } else {
                    break;
                }
            }
        }
    }

    krsort($pennies); // descending sorting by key
    foreach ($pennies as $penny => $count) {
        $lev = $penny / 100;

        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                if (($change - $lev) >= 0) {
                    $change = round($change - $lev, 2);
                    $changeDetails[] = $lev;
                    --$pennies[$penny];
                } else {
                    break;
                }
            }
        }
    }
}

if ($change > 0) {
    $message = "Няма налични средства за ресто в касата!";
}

ksort($levs); // return default sorting by key ASC
ksort($pennies); // return default sorting by key ASC
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Каса</title>
</head>
<body>

<div class="container">
    <?php if ($message) { ?>
        <div class="alert alert-warning" role="alert">
            <?php echo $message; ?>
        </div>
    <?php } ?>
    <?php if (!empty($changeDetails) && $change == 0) { ?>
        <div class="alert alert-success" role="alert">
            <h3>Ресто</h3>
            <?php  foreach ($changeDetails as $detail) { ?>
                <?php echo $detail; ?> лв.<br>
            <?php } ?>
        </div>
    <?php } ?>
    <h1>Каса</h1>
    <div class="">
        <form method="post">
            <h2>Стотинки</h2>
            <div class="form-row">
                <?php foreach ($pennies as $penny => $count){ ?>
                    <div class="form-group col">
                        <label><?php echo $penny; ?> ст.</label>
                        <input type="number" class="form-control"
                               name="<?php echo PENNY_KEY . $penny; ?>" value="<?php echo $count; ?>">
                    </div>
                <?php } ?>
            </div>
            <h2>Левове</h2>
            <div class="form-row">
                <?php foreach ($levs as $lev => $count) { ?>
                    <div class="form-group col">
                        <label><?php echo $lev; ?> лв.</label>
                        <input type="number" class="form-control"
                               name="<?php echo LEV_KEY . $lev; ?>" value="<?php echo $count; ?>">
                    </div>
                <?php } ?>
            </div>
            <h2>Плащане:</h2>
            <div class="form-row">
                <div class="form-group col">
                    <label>Цена</label>
                    <input type="number" class="form-control" name="price" step="0.01" value="<?php echo $price; ?>">
                </div>
                <div class="form-group col">
                    <label>Платено</label>
                    <input type="number" class="form-control" name="paid" step="0.01" value="<?php echo $paid; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary float-right">Сметни ресто</button>
        </form>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>