<!DOCTYPE html>
<html lang="en">
<?php
include_once "core/session.php";
include_once "core/user.php";
include_once "core/db.php";
if (isset($_SESSION['uid']) && $_SESSION['uid'] != '') {

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    include_once 'head.php';
    $daid = $_GET['daid'] ?? '';
    if ($daid) {
        echo "<h2>Change Logs for DA ID: $daid</h2>";

        // Fetch change logs for the selected daid
        $query = "SELECT * FROM change_logs WHERE daid = '$daid' ORDER BY changed_at DESC";
        $result = $mysqli->query($query);
?>

    <body>
        <div class="container-scroller">
            <!-- partial:../../partials/_navbar.html -->
            <?php include_once "../../partials/_navbar.php" ?>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:../../partials/_sidebar.html -->
                <?php include_once "../../partials/_sidebar.php"; ?>
                <!-- partial -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        <div class="page-header">
                            <h3 class="page-title"> Attendance Records </h3>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Attendance Records</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">
                            <!-- <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Basic Table</h4>
                    <p class="card-description"> Add class <code>.table</code>
                    </p>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Profile</th>
                          <th>VatNo.</th>
                          <th>Created</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Jacob</td>
                          <td>53275531</td>
                          <td>12 May 2017</td>
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>
                        <tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> -->
                            <!-- <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Hoverable Table</h4>
                    <p class="card-description"> Add class <code>.table-hover</code>
                    </p>
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>User</th>
                          <th>Product</th>
                          <th>Sale</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Jacob</td>
                          <td>Photoshop</td>
                          <td class="text-danger"> 28.76% <i class="mdi mdi-arrow-down"></i></td>
                          <td><label class="badge badge-danger">Pending</label></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Striped Table</h4>
                    <p class="card-description"> Add class <code>.table-striped</code>
                    </p>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th> User </th>
                          <th> First name </th>
                          <th> Progress </th>
                          <th> Amount </th>
                          <th> Deadline </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="py-1">
                            <img src="../../assets/images/faces-clipart/pic-1.png" alt="image" />
                          </td>
                          <td> Herman Beck </td>
                          <td>
                            <div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </td>
                          <td> $ 77.99 </td>
                          <td> May 15, 2015 </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> -->
                            <div class="col-lg-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <?php
                                            if ($result->num_rows > 0) {
                                                echo'
                                        <div class="table-responsive">
                                            <h4 class="card-title">Change Logs</h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Change ID</th>
                                                        <th>DA ID</th>
                                                        <th>Date</th>
                                                        <th>Changed Field</th>
                                                        <th>Old Value</th>
                                                        <th>New Value</th>
                                                        <th>Changed At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>
                                                                <td>{$row['change_id']}</td>
                                                                <td>{$row['daid']}</td>
                                                                <td>{$row['attendance_date']}</td>
                                                                <td>{$row['changed_field']}</td>
                                                                <td>{$row['old_value']}</td>
                                                                <td>{$row['new_value']}</td>
                                                                <td>{$row['changed_at']}</td>
                                                                </tr>";
                                                    }                                                    
                                                    ?>
                                            </table>
                                        </div>
                                        <?php
                                        } else {
            echo "No changes found for DA ID: $daid";
        }
    }
     else {
        echo "No DA ID provided.";
    }
}
 else {
    echo "
    <meta http-equiv='refresh' content='0;url=login.php'>";
}?>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Inverse table</h4>
                    <p class="card-description"> Add class <code>.table-dark</code>
                    </p>
                    <table class="table table-dark">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> First name </th>
                          <th> Amount </th>
                          <th> Deadline </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td> 1 </td>
                          <td> Herman Beck </td>
                          <td> $ 77.99 </td>
                          <td> May 15, 2015 </td>
                        </tr>
                        <tr>
                          <td> 2 </td>
                          <td> Messsy Adam </td>
                          <td> $245.30 </td>
                          <td> July 1, 2015 </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> -->
                            <!-- <div class="col-lg-12 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Table with contextual classes</h4>
                    <p class="card-description"> Add class <code>.table-{color}</code>
                    </p>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th> # </th>
                          <th> First name </th>
                          <th> Product </th>
                          <th> Amount </th>
                          <th> Deadline </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="table-info">
                          <td> 1 </td>
                          <td> Herman Beck </td>
                          <td> Photoshop </td>
                          <td> $ 77.99 </td>
                          <td> May 15, 2015 </td>
                        </tr>
                        <tr class="table-warning">
                          <td> 2 </td>
                          <td> Messsy Adam </td>
                          <td> Flash </td>
                          <td> $245.30 </td>
                          <td> July 1, 2015 </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div> -->
                        </div>
                    </div>
                <?php
            include_once '../../partials/_footer.php'; ?>
    </body>

</html>