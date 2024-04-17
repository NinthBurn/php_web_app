<?php
require "config.php";

$items_per_page = 4;
$author_id = 0;
$searched_type = "any";
$searched_severity = "any";

$page = 1;
$output = "";

$_POST = json_decode(file_get_contents('php://input'), true);
if(isset($_POST["page"])){
    $page = $_POST["page"];
}else $page = 1;

$author_id = $_POST["author_id"];
$searched_type = $_POST["searched_type"];
$searched_severity = $_POST["searched_severity"];
$start_from = ($page - 1) * $items_per_page;

if($start_from < 0)
    $start_from = 0;

$sql_query = "SELECT * FROM UserLogs ";
if($author_id != 0 || $searched_severity != "any" || $searched_type != "any"){
    $sql_query .= "WHERE ";
    $append_and = 0;

    if($author_id != 0){
        $sql_query .= "user_id = {$author_id} ";
        $append_and = 1;
    }
        
    if($searched_severity != "any"){
        if($append_and == 1)
            $sql_query .= "AND ";
        
        $sql_query .= "log_severity = '{$searched_severity}' ";
        $append_and = 1;
    }

    if($searched_type != "any"){
        if($append_and == 1)
            $sql_query .= "AND ";
        
        $sql_query .= "log_type = '{$searched_type}' ";
        $append_and = 1;
    }
}

$sql_statement = $connection->prepare($sql_query . "ORDER BY log_id ASC LIMIT $start_from, $items_per_page");
$sql_statement->execute();
$row_query_result = $sql_statement->get_result();

$output = array();

$row_count = 0;

if ($row_query_result->num_rows > 0) {
    while($row = $row_query_result->fetch_assoc()){
        $log_entry = [
            "log_id" => $row["log_id"],
            "log_type" => $row["log_type"],
            "log_severity" => $row["log_severity"],
            "log_date" => $row["log_date"],
            "log_content" => $row["log_content"],
            "log_author_id" => $row["user_id"]
        ];

        $sql_statement = $connection->prepare("SELECT user_name FROM Users WHERE user_id = " . $row['user_id']);
        $sql_statement->execute();
        $log_entry["log_author"] = ($sql_statement->get_result())->fetch_assoc()["user_name"];
        array_push($output, $log_entry);
        $row_count++;
    }
}

// Page count
$sql_statement = $connection->prepare(str_replace("*", "COUNT(log_id)", $sql_query));
$sql_statement->execute();
$total_records = $sql_statement->get_result()->fetch_all()[0][0];
$total_pages = ceil($total_records/$items_per_page);

$res = array(
    "rows" => $output,
    "pages" => $total_pages,
    "records" => $total_records
);

echo json_encode($res);
$connection->close();
?>