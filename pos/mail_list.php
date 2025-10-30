<br><br>
<?php
global $wpdb;

$category_name = '';
$category_description = '';
$category_id = '';
$form_value = 'Add';
$message = '';
?>
<div class="wrap">
  <div class="col-md-12">

<div class="col-md-12 stltab_header">
  <div class="col-md-12 ">
    <div class="row stltab_title">
      <span>Mail List</span>
     
    </div>
  </div>
	<div class="col-md-12">
    	<table class="widefat steps_list">
        <thead>
          <tr>
            <th>S.no</th>
            <th>Receiver Name</th>
            <th>EmailID</th>
            <th>Phone No</th>
            <th>Message</th>
            <th>Client IP</th>
            <th>PDF</th>
            <th>Send Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $maillists = $wpdb->get_results("select * from customer_mail order by created_on desc");
         
          if($maillists) {
            $count = 0;
          foreach ($maillists as $maillist ) 
          {
            $count++;
          //  $category_idss = $maillist->category_id;
            $created_on = $maillist->created_on;
            $pdf_name = $maillist->pdf_name;
            $created_on = date('d/m/Y H:i:s',strtotime($created_on));
          ?>
          <tr>
            <td><?php echo $count; ?></td>
            <td><?php echo $maillist->customer_name; ?></td>
            <td><?php echo $maillist->emailid; ?></td>
            <td><?php echo $maillist->phoneno; ?></td>
            <td><?php echo $maillist->message; ?></td>
            <td><?php echo $maillist->client_ip; ?></td>
            <td><?php if($pdf_name !=''){
              echo '<a href="'.site_url().'/wp-content/uploads/pos/'.$pdf_name.'" target="_blank">View PDF</a>';
            } else {echo "--"; } ?></td>
            <td><?php echo $created_on; ?></td>


          </tr>
        <?php } } else { echo "<tr><td>No category found</td></tr>"; }?>
        </tbody>
      </table>

  	</div>
</div>


</div>
</div>
<!-- <script type='text/javascript' src='http://localhost/pos/wp-content/plugins/pos/datatable/jquery.dataTables.min.js?ver=4.9.6'></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script> -->


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {


    // jQuery('.steps_list').DataTable( {
    //     dom: 'Bfrtip',
    //     buttons: [
    //         'copyHtml5',
    //         'excelHtml5',
    //         'csvHtml5',
    //         'pdfHtml5'
    //     ]
    // } );



    var table = jQuery('.steps_list').DataTable( {

          "language": {"lengthMenu": "Show _MENU_ per page"}, 
      "bFilter": true,"bDestroy": true,
dom: 'Bfrtip',
       buttons: [
       {
           extend: 'pdf',
           footer: true,
           exportOptions: {
                columns: [0,1,2,3,4,5]
            }
       },
       {
           extend: 'csv',
           footer: false,
           exportOptions: {
                columns: [0,1,2,3,4,5]
            }
          
       },
       {
           extend: 'excel',
           footer: false,
           exportOptions: {
                columns: [0,1,2,3,4,5]
            }
       }         
    ]  
} );
     




  });
</script>