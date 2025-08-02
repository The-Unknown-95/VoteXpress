<?php
session_start();
if (!isset($_SESSION['userdata'])) {
    header("Location: ../");
    exit();
}

$userdata = $_SESSION['userdata'];
$groupsdata = $_SESSION['groupsdata'];

if ($_SESSION['userdata']['status'] == 0) {
    $status = '<span class="status-not-voted" style="padding: 5px 10px; border-radius: 10px;">Not Voted</span>';
} else {
    $status = '<span class="status-voted" style="padding: 5px 10px; border-radius: 10px;">Voted</span>';
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Online Voting System - Dashboard</title>
    <!-- Materialize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/stylesheet.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="../" class="left"><i class="material-icons">arrow_back</i></a>
            <a href="#" class="brand-logo center">Dashboard</a>
            <a href="../api/logout.php" class="right"><i class="material-icons">exit_to_app</i></a>
        </div>
    </nav>

    <main class="container">
        <div class="row">
            <!-- Profile Section -->
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content center">
                        <?php
                        $imagePath = '../uploads/' . $userdata['photo'];
                        if (file_exists($imagePath)) {
                            echo '<img src="' . $imagePath . '" class="circle responsive-img" style="border: 3px solid #4caf50">';
                        } else {
                            echo '<i class="material-icons large" style="color: #2e7d32">account_circle</i>';
                        }
                        ?>
                        <table class="striped">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td><?php echo $userdata['name'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Mobile:</strong></td>
                                <td><?php echo $userdata['mobile'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td><?php echo $userdata['address'] ?></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><?php echo $status ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Groups Section -->
            <div class="col s12 m8">
                <?php if ($_SESSION['groupsdata']) { ?>
                    <?php foreach ($groupsdata as $group) { ?>
                        <div class="card">
                            <div class="card-content">
                                <div class="row valign-wrapper">
                                    <div class="col s3">
                                        <?php
                                        $groupImagePath = '../uploads/' . $group['photo'];
                                        if (file_exists($groupImagePath)) {
                                            echo '<img src="' . $groupImagePath . '" class="circle responsive-img" style="border: 2px solid #81c784">';
                                        } else {
                                            echo '<i class="material-icons medium" style="color: #2e7d32">group</i>';
                                        }
                                        ?>
                                    </div>
                                    <div class="col s6">
                                        <h5><?php echo $group['name'] ?></h5>
                                        <p>Votes: <?php echo $group['votes'] ?></p>
                                    </div>
                                    <div class="col s3">
                                        <form action="../api/vote.php" method="post">
                                            <input type="hidden" name="gvotes" value="<?php echo $group['votes'] ?>">
                                            <input type="hidden" name="gid" value="<?php echo $group['id'] ?>">
                                            <?php if ($_SESSION['userdata']['status'] == 0) { ?>
                                                <button class="btn waves-effect waves-light" type="submit">Vote</button>
                                            <?php } else { ?>
                                                <button class="btn disabled" style="background-color: #bf360c">Voted</button>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </main>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            M.AutoInit();
        });
    </script>
</body>

</html>