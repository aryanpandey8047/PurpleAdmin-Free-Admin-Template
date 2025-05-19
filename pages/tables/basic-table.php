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

  $start_date = $_GET['start_date'] ?? '';
  $end_date = $_GET['end_date'] ?? '';
  include_once 'head.php';
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
                    <form method="get" class="row g-3 mb-4">
                    <div class="col-md-3">
                        <input type="date" class ="form-control bg-transparent border-0" id="start_date" name="start_date" value="<?= $start_date ?>" placeholder="Start Date">
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="end_date" name="end_date" class = "form-control bg-transparent border-0" value="<?= $end_date ?>" placeholder="END DATE">
                    </div>
                    <div class="col-md-3 align-self-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
                    <div class="table-responsive">
                      <h4 class="card-title">Attendance Record</h4>

                      <?php
                      if ($start_date && $end_date) {
                        echo '
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th> DA ID </th>
                            <th>DA Name </th>';
                        $dateQuery = "SELECT DISTINCT attendance_date FROM attendance WHERE attendance_date BETWEEN '$start_date' AND '$end_date' ORDER BY attendance_date";
                        $dateResult = $mysqli->query($dateQuery);
                        $dates = [];
                        while ($row = $dateResult->fetch_assoc()) {
                          $dates[] = $row['attendance_date'];
                        }

                        $dataQuery = "SELECT daid, daname, attendance_date, attendance_status 
                  FROM attendance
                  WHERE attendance_date BETWEEN '$start_date' AND '$end_date' ORDER BY daid";
                        $dataResult = $mysqli->query($dataQuery);

                        $attendance = [];
                        while ($row = $dataResult->fetch_assoc()) {
                          $id = $row['daid'];
                          $name = $row['daname'];
                          $date = $row['attendance_date'];
                          $status = $row['attendance_status'];
                          if (!isset($attendance[$id])) {
                            $attendance[$id] = ['name' => $name];
                          }
                          $attendance[$id][$date] = $status;
                        }
                        foreach ($dates as $date) {
                          echo "<th>$date</th>";
                        } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($attendance as $daid => $record) {
                          echo "<tr>
                            <td><a href='changeloglist.php?daid=$daid'>$daid</a></td>
                            <td><a href='changeloglist.php?daid=$daid'>{$record['name']}</a></td>";
                          foreach ($dates as $date) {
                            $status = $record[$date] ?? '';
                            echo "<td>$status</td>";
                          }
                          echo "</tr>";
                        }
                      }
                        ?>
                        </tbody>
                        </table>
                    </div>
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
      }
      include_once '../../partials/_footer.php'; ?>
  </body>

</html>