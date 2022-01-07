<?php
ini_set('display_errors', 1);
$database_adress = "localhost";
$database_name = "";
$database_user = "";
$database_password = "";
$theme = 'united'; // Themes: Cerulean, Cosmo, Cyborg, Darkly, Flatly, Journal, Lumen, Paper, Readable, Sandstone, Simplex, Slate, Spacelab, Superhero, United, Yeti
$how_many = 1000;
$title = "Top 1000 돈 순위";
$page_title = $title;
$show_uuid = false;
$padding_top = "100px";
$money_format = "$ {balance}";
$head_size = 30;

$con = mysqli_connect($database_adress, $database_user, $database_password, $database_name);

if (mysqli_connect_errno()) {
    die("<h3 class='text-center'>접속 실패. 관리자에게 문의하세요. 에러코드: #ER_MYSQL0: " . mysqli_connect_error() . "</h3>");
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta content="Wruczek" name="author">
    <title>버드서버 - 개인순위</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/<?php echo strtolower($theme) ?>/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: <?php echo $padding_top ?>;
        }
    </style>
</head>
<body>

<div class="container">

    <h2 class="text-center">개인순위</h2>

    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>머리</th>
            <th>닉네임</th>
            <?php if ($show_uuid) { ?>
                <th>UUID</th>
            <?php } ?>
            <th>돈</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $num = 0;

        $result = mysqli_query($con, "SELECT * FROM `iconomy` ORDER BY `balance` DESC LIMIT $how_many");

        if (!$result) {
            die("오류: 어떤 데이터도 가져오지 못했습니다. 관리자에게 문의하세요. 에러코드: #ER_MYSQL1 " . mysqli_error($con));
        }

        while ($row = mysqli_fetch_array($result)) {
            $num++;
            $uuid = $row['id'];
            $nick = $row['username'];
            $money = $row['balance'];
            $img = sprintf('<img src="https://minotar.net/helm/%s/%d.png">', $nick, $head_size);

            echo "<tr><td>$num</td><td>$img</td><td>$nick</td>";

            if ($show_uuid)
                echo "<td>$uuid</td>";

            echo "<td>" . str_replace("{balance}", $money, $money_format) . "</td></tr>";
        }

        mysqli_close($con);
        ?>
        </tbody>
    </table>

    <div class="footer">
        &copy; <a href="https://www.birdsv.tk">BIRD NETWORK</a>
    </div>
</div>

</body>
</html>