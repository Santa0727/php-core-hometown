<?php

class ContestWinner
{
    private $connection;

    public function openConnection()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public function closeConnection()
    {
        $this->connection->close();
    }

    public function getItems()
    {
        $this->openConnection();

        $query = $this->connection->query("SELECT * FROM contest_winners ORDER BY `month` DESC");
        $result = [];
        while ($row = $query->fetch_assoc()) {
            $result[] = (object)([
                'id' => $row['id'],
                'month' => $row['month'],
                'name' => $row['name'],
                'comment' => $row['comment']
            ]);
        }
        $this->closeConnection();

        return $result;
    }

    public function deleteItem($id)
    {
        $this->openConnection();
        $query = $this->connection->query("DELETE FROM contest_winners WHERE id = " . $id);
        $result = $query == true;
        $this->closeConnection();

        return $result;
    }

    public function addItem($month, $name, $comment = '')
    {
        $this->openConnection();
        $this->connection->query("INSERT INTO contest_winners (`month`, `name`, `comment`) VALUES ('" . $month . "','" . $name . "','" . $comment . "')");
        $result = $this->connection->insert_id;
        $this->closeConnection();

        return $result;
    }
};
$contestWinner = new ContestWinner();

if (!empty($_POST['action']) && $_POST['action'] == "create_item") {
    $contestWinner->addItem($_POST['month'], $_POST['name'], $_POST['comment']);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}
if (!empty($_GET['action']) && $_GET['action'] == 'delete') {
    $contestWinner->deleteItem($_GET['id']);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

$winners = $contestWinner->getItems();

?>

<style>
    .bordered {
        border: 1px solid black;
        padding: 1rem;
        margin: 1rem;
    }

    .form-group {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .winners-table td {
        text-align: center;
    }
</style>
<div class="title">
    <h2>Contest Winners</h2>
    <div style="float:right;margin:0 2px 0 0;"></div>
    <span>Contest Winners</span>
</div>
<div class="form-table">
    <div class="col-md-12">
        <div class="row">
            <div style="width: 65%;">
                <div class="bordered">
                    <h3 class="text-center">Contest Winners</h3>
                    <table class="winners-table table table-bordered" style="width: 100%;" border="1" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Month</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>DELETE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($winners as $i => $item) { ?>
                                <tr>
                                    <td><?php echo ($i + 1); ?></td>
                                    <td><?php echo $item->month; ?></td>
                                    <td><?php echo $item->name; ?></td>
                                    <td><?php echo $item->comment; ?></td>
                                    <td>
                                        <a href="?route=contest_winners.php&action=delete&id=<?php echo $item->id; ?>" class="btn">DELETE</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bordered">
                    <h3 class="text-center">Add New Contest Winner</h3>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="create_item" />
                        <div class="form-group">
                            <label for="month">Month</label>
                            <select name="month" id="month" class="form-control" required>
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="comment">Type</label>
                            <select name="comment" id="comment" class="form-control" required>
                                <option value="Normal">Normal</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group" style="float: right;">
                            <button type="submit" style="font-weight: bold;" class="btn">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>