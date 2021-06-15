<?php

function getItems()
{
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = $connection->query("SELECT * FROM contest_winners ORDER BY `month` DESC");
    $result = [];
    while ($row = $query->fetch_assoc()) {
        if (empty($result[$row['month']])) $result[$row['month']] = [];
        array_push($result[$row['month']], [
            'name' => $row['name'],
            'comment' => $row['comment']
        ]);
    }
    return $result;
}
$items = getItems();
$monthLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
?>

<style>
    @media only screen and (min-width: 600px) {
        .info-lr {
            justify-content: space-between;
            display: flex;
        }
    }

    .info-lr h1,
    .info-lr p {
        white-space: normal !important;
        word-break: break-word;
    }

    .info-r {
        display: flex;
        align-items: center;
        flex-direction: column;
        align-content: center;
        padding: 3% 10px 3% 10px;
    }
</style>

<div class="page-intro">
    <div class="page-intro-content">
        <h1>Contest Winners</h1>
    </div>
</div>

<div class="container pt50 pb50">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Month</th>
                <th>Name</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 12; $i > 0; $i--) if (!empty($items[$i])) {
                foreach ($items[$i] as $j => $x) {
            ?>
                    <tr>
                        <?php if ($j == 0) echo "<td rowspan=" . count($items[$i]) . ">" . $monthLabels[$i - 1] . "</td>"; ?>
                        <td><?php echo $x['name']; ?></td>
                        <td><?php echo $x['comment'] ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>