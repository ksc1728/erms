<?php
session_start();
error_reporting(0);
include('includes/config.php');

if(strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit;
}

if(isset($_POST['submit'])) {
    $facultyId = intval($_GET['facultyId']);
    $facultyName = $_POST['facultyName'];
    $facultyEmail = $_POST['facultyEmail'];
    $rollId = $_POST['rollId'];
    // You can add more fields here if needed

    $sql = "UPDATE tblfaculty SET facultyName=:facultyName, facultyEmail=:facultyEmail, RollId=:rollId WHERE facultyId=:facultyId";
    $query = $dbh->prepare($sql);
    $query->bindParam(':facultyName', $facultyName, PDO::PARAM_STR);
    $query->bindParam(':facultyEmail', $facultyEmail, PDO::PARAM_STR);
    $query->bindParam(':rollId', $rollId, PDO::PARAM_STR);
    $query->bindParam(':facultyId', $facultyId, PDO::PARAM_INT);
    $query->execute();

    $msg = "Faculty Record Updated Successfully";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Faculty</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Add other necessary CSS files -->
</head>
<body>
    <!-- Add your HTML content for editing faculty details -->
    <?php include('includes/topbar.php');?> 
    <div class="container">
        <h2>Edit Faculty</h2>
        <?php if(isset($msg)) { ?>
            <div class="alert alert-success"><?php echo htmlentities($msg); ?></div>
        <?php } ?>
        <form method="post">
            <!-- Replace these fields with actual faculty fields -->
            <div class="form-group">
                <label for="facultyName">Faculty Name</label>
                <input type="text" class="form-control" id="facultyName" name="facultyName" value="<?php echo htmlentities($result->facultyName); ?>" required>
            </div>
            <div class="form-group">
                <label for="facultyEmail">Faculty Email</label>
                <input type="email" class="form-control" id="facultyEmail" name="facultyEmail" value="<?php echo htmlentities($result->facultyEmail); ?>" required>
            </div>
            <div class="form-group">
                <label for="rollId">Roll ID</label>
                <input type="text" class="form-control" id="rollId" name="rollId" value="<?php echo htmlentities($result->RollId); ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update Faculty</button>
        </form>
    </div>
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- Add other necessary JS files -->
</body>
</html>
