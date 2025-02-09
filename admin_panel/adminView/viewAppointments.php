<div id="ordersBtn" >
  <h2>Appointments</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>A.N.</th>
        <th>Name</th>
        <th>Contact</th>
        <th>Appointment Date</th>
        <th>Appointment Time</th>
        <th>Address</th>
        <th>Vehicle</th>
        <th>Service</th>
     </tr>
    </thead>
     <?php
      include_once "../config/dbconnect.php";
      $sql="SELECT * from appointment";
      $result=$conn-> query($sql);
      
      if ($result-> num_rows > 0){
        while ($row=$result-> fetch_assoc()) {
    ?>
       <tr>
          <td><?=$row["id"]?></td>
          <td><?=$row["Name"]?></td>
          <td><?=$row["Phone"]?></td>
          <td><?=$row["cin"]?></td>
          <td><?=$row["time"]?></td>
          <td><?=$row["Address"]?></td>
          <td><?=$row["Vehicle"]?></td>
          <td><?=$row["Service"]?></td>
        </tr>
    <?php
            
        }
      }
    ?>
     
  </table>
   
</div>
<!-- Modal -->
<div class="modal fade" id="viewModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          
          <h4 class="modal-title">Appointments</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="order-view-modal modal-body">
        
        </div>
      </div><!--/ Modal content-->
    </div><!-- /Modal dialog-->
  </div>
<script>
     //for view order modal  
    $(document).ready(function(){
      $('.openPopup').on('click',function(){
        var dataURL = $(this).attr('data-href');
    
        $('.order-view-modal').load(dataURL,function(){
          $('#viewModal').modal({show:true});
        });
      });
    });
 </script>