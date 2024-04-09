<?php
$connection = new mysqli("localhost", "root", "", "lab7") or die("Connection failed:" . mysqli_connect_error());

$items_per_page = 4;
$author_id = 0;
$searched_type = "any";
$searched_severity = "any";

$page = 1;
$output = "";

if(isset($_POST["page"])){
    $page = $_POST["page"];
}else $page = 1;

if(isset($_POST["author_id"])){
    $author_id = $_POST["author_id"];
}

if(isset($_POST["searched_type"])){
    $searched_type = $_POST["searched_type"];
}

if(isset($_POST["searched_severity"])){
    $searched_severity = $_POST["searched_severity"];
}


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

$output .= '

';

$row_count = 0;

if ($row_query_result->num_rows > 0) {
    while($row = $row_query_result->fetch_assoc()){
        $log_id = $row["log_id"];
        $log_type = $row["log_type"];
        $log_severity = $row["log_severity"];
        $log_date = $row["log_date"];
        $log_content = $row["log_content"];
        $log_author = $row["user_id"];

        $sql_statement = $connection->prepare("SELECT user_name FROM Users WHERE user_id = $log_author");
        $sql_statement->execute();
        $log_author = ($sql_statement->get_result())->fetch_assoc()["user_name"];

        $output .= '
            <tr class="tableRow">
                <td>' . $log_author . '</td>
                <td>' . strtoupper($log_type) . '</td>
                <td>' . strtoupper($log_severity) . '</td>
                <td>' . date("d/M/Y", strtotime($log_date)) . '</td>
                <td>' . $log_content . '</td>
                <td>' . '<div style="display: flex; justify-content: space-evenly; width: 100%">'
                . '<button style="width: 60px" type="button" onclick="deleteLog(' . $log_id . ')">Delete</button>'
                . '<button style="width: 60px" type="button" onclick="onEditButtonClick(' . $log_id . ')">Edit</button>'
                // . '<div class="editButton"> <a href="edit_log_page.php">Edit</a></div>'
                 . '</div></td>
            </tr>
        ';

        $row_count++;
    }
}

while($row_count < 4){
    $output .= '
            <tr class="tableRow">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        ';
    $row_count++;
}

// Page count
$sql_statement = $connection->prepare(str_replace("*", "COUNT(*)", $sql_query));
$sql_statement->execute();
$total_records = $sql_statement->get_result()->fetch_all()[0][0];
$total_pages = ceil($total_records/$items_per_page);

// echo $output;

$res = array(
    "rows" => $output,
    "pages" => $total_pages,
    "records" => $total_records
);

echo json_encode($res);

?>