<?php 
session_start();
include("MysqliDb.php");
$db = new MysqliDb ('localhost', 'root', '', 'test'); /// Creating Connection Object
?>
<!DOCTYPE <!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Import In DataBase</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">

</head>

<body>
    <div class="container" style="margin-top:50px;">
        <div class="row">
            <h1 style="text-align:center;">Import Excel file in Mysql Database</h1><br>

            <?php if(isset($_SESSION['success'])){?>
            <div class="col-lg-12 alert alert-success">
                <?php echo $_SESSION['success']; ?>
            </div>
            <?php } ?>
            <?php if(isset($_SESSION['error'])){?>
            <div class="col-lg-12 alert alert-danger">
                <?php echo $_SESSION['error']; ?>
            </div>
            <?php } session_destroy(); ?>

            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">User Upload</div>
                    <div class="panel-body">
                        <form action="import.php" method="POST" enctype="multipart/form-data">
                            <p>Upload new files:</p>
                            <label class="btn btn-default">
                                <input type="file" name="uploadFile" hidden="">
                            </label>
                            <button id="upload" type="submit" name="submit" class="btn btn-success">Upload</button>
                            <a href="sample/users-sample.xlsx" class="btn btn-warning">Get Saple Excel File</a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">View User</div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                  $user = $db->get("users");
                                  $i=1;
                                  foreach($user as $users){
                                 ?>
                                <tr>
                                    <td>
                                        <?php echo $i++;?>
                                    </td>
                                    <td>
                                        <?php echo ucwords($users['name']); ?>
                                    </td>
                                    <td>
                                        <?php echo $users['email']; ?>
                                    </td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous">
    </script>

</body>

</html>;