<div class='min-vh-100 vw-100 d-flex flex-column justify-content-center align-items-center'>

    <h1><?php echo $table; ?> Table</h1>

    <?php
    $records = $db->query("SELECT * FROM ".$table, []);
    $pdo = $db->getPdo();
    $stmt = $pdo->prepare('SHOW KEYS FROM '.$table.' WHERE Key_name = "PRIMARY"');
    $stmt->execute();
    $keys = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <table border=1>
        <tr>
            <?php
            $columns = array_keys($records[0]);
            for($i=0;$i<sizeof($columns);$i++){
                $columnName = $columns[$i];
                $content = '
                <th>'.$columnName.'</th>';
                echo $content;
            }
            ?>
            <th>Actions</th>
        </tr>
        <?php 
        for($i=0;$i<sizeof($records);$i++){
           $content = '<tr class="clickable-row">';
            for($j=0;$j<sizeof($columns);$j++){
                $data = $records[$i][$columns[$j]];
                $content .= '
                <td>'.$data.'</td>';
            }

            $content .= '
                <td>
                    <a href="'.UrlHelper::contructHref($records[$i], $table, $keys).'" style="text-decoration:none">
                        <button class="btn btn-warning">Edit</button>
                    </a>
                    <button class="btn btn-danger">Delete</button>
                </td>
            </tr>';    

            echo $content;
        }
        ?>
            
    </table>
    
    <button class="btn btn-success">Add new record</button>
</div>



<?php 

/*
$table = $_GET["table"];
$filter = $_GET["filter"];
$id = $_GET["id"];
$multifilter = $_GET["multi"];
*/

?>
