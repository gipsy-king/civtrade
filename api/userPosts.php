<?php
    require ('/var/www/civbeta/other/req.php');
    if (!isset($_GET['user'])) {
        $query = "SELECT poster,COUNT(`poster`) AS totalPosts FROM offers GROUP BY poster ORDER BY totalPosts DESC";
        $result = mysqli_stmt_init($con);
        $result->prepare($query);
        $result->execute();
        $result = $result->get_result();
        $r = array();
        $index = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $rTemp = array("name" => $row['poster'], "amount" => $row['totalPosts']);
            array_push($r, $rTemp);
        }
        echo json_encode($r);
    }
    else {
        $query = "SELECT COUNT(`poster`) AS posts FROM offers WHERE poster = ? GROUP BY poster DESC";
        $stmt = mysqli_stmt_init($con);
        $stmt->prepare($query);
        $stmt->bind_param('s', $_GET['user']);
        $stmt->execute();
        $result = mysqli_fetch_row($stmt->get_result());
        echo $result[0];
    }
?>