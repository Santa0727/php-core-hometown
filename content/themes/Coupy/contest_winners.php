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

    .winners-table th {
        color: black;
        font-size: larger;
        font-weight: bolder;
        background-color: #4d8c2a;
    }

    .winners-table tr.even td.no {
        background-color: lightblue;
        color: black;
    }

    .winners-table tr.odd td.no {
        background-color: lightpink;
        color: black;
    }
</style>

<div class="page-intro">
    <div class="page-intro-content">
        <h1>Contest Winners</h1>
    </div>
</div>

<div class="container pt50 pb50">
    <h2 class="text-center">Congratulations to all our winners. Please call 949-200-7518 to claim your prize.</h2>
    <table class="table table-bordered winners-table">
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
                    <tr class="<?php echo ($i % 2 == 0 ? 'even' : 'odd'); ?>">
                        <?php if ($j == 0) echo "<td rowspan=" . count($items[$i]) . " class='no'>" . $monthLabels[$i - 1] . "</td>"; ?>
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