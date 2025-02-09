<div >
  <h2>All Customers</h2>
  <table class="table ">
    <thead>
      <tr>
        <th class="text-center">S.N.</th>
        <th class="text-center">Full Name </th>
        <th class="text-center">Email</th>
        <th class="text-center">Address</th>
        <th class="text-center">Date of Birth</th>
      </tr>
    </thead>
    <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * from user where pname=0";
      $result=$conn-> query($sql);
      $count=1;
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
           
    ?>
    <tr>
      <td><?=$count?></td>
      <td><?=$row["pname"]?></td>
      <td><?=$row["pemail"]?></td>
      <td><?=$row["paddress"]?></td>
      <td><?=$row["pdob"]?></td>
    </tr>
    <?php
            $count=$count+1;
          
        }
    }
    ?>
  </table>