<?php

function random_num($length) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }
    for ($i = 0; $i < $length; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}

function check_login($con) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];

        $query = "SELECT * FROM login WHERE user_id = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }

    return false;
}
?>
