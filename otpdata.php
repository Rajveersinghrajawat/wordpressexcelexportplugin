<?php
/*
Plugin Name: lead Data
Description: A simple plugin that allows you to perform Create (INSERT), Read (SELECT), Update, and Delete operations.
Version: 1.0
Author: Rajveer Singh
Author URI: https://www.wscubetech.com/
*/

add_action('admin_menu', 'addAdminPage');

function crudAdminPage() {
    global $wpdb;
    $table_name = 'wp_otpverify_form';

?>

<style>
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
     <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css"/>

   .page-numbers{
    margin-right: 10px !important;
   }
    .page-numbers{
        margin-right: 20px !important;
    }
</style>

    <!-- OTP FORM Data -->
    <h2>OTP FORM Data</h2>

<!-- Add Export Button -->
<!-- <a target="_blank"><button id="exportExcelBtn" class="button">Export to Excel</button></a> -->


    <table id="myDatatableId" class="fs-5 wp-list-table widefat striped">
        <thead>
            <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Number</th>
                <th scope="col">Message</th>
                <th scope="col">Preparing For</th>
                <th scope="col">State</th>
                <th scope="col">City</th>
                <th scope="col">Already Enrolled</th>
                <th scope="col">Exam Type</th>
                <th scope="col">Form Name</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $paged = isset($_GET['paged']) ? max(0, intval($_GET['paged']) - 1) : 0;
            $per_page = 1000;
            $offset = $paged * $per_page;

            $query = "SELECT * FROM $table_name ORDER BY id DESC LIMIT $offset, $per_page";
            $result = $wpdb->get_results($query);
            $counter = $offset + 1;

            foreach ($result as $showrecord) {
            ?>
                <tr>
                    <td><?php echo $counter ?></td>
                    <td><?php echo $showrecord->otp_name; ?></td>
                    <td><?php echo $showrecord->otp_email; ?></td>
                    <td><?php echo $showrecord->otp_number; ?></td>
                    <td><?php echo $showrecord->otp_message; ?></td>
                    <td><?php echo $showrecord->otp_prep; ?></td>
                    <td><?php echo $showrecord->otp_state; ?></td>
                    <td><?php echo $showrecord->otp_city; ?></td>
                    <td><?php echo $showrecord->already_enrolled; ?></td>
                    <td><?php echo $showrecord->otp_examtype; ?></td>
                    <td><?php echo $showrecord->otp_form_name; ?></td>
                    <td><?php echo $showrecord->status; ?></td>
                </tr>
            <?php
                $counter++;
            }
            ?>
        </tbody>
    </table>

    <?php
    $total_rows = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    $total_pages = ceil($total_rows / $per_page);
    $page_links = paginate_links(array(
        'base' => add_query_arg('paged', '%#%'),
        'format' => '',
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;'),
        'total' => $total_pages,
        'current' => $paged + 1,
    ));

    if ($page_links) {
        echo '<div class="tablenav"><div class="tablenav-pages">' . $page_links . '</div></div>';
    }
    ?>

<?php
}

function addAdminPage() {
    $my_hook = add_menu_page('lead Data', 'lead Data', 'manage_options', 'otp-data', 'crudAdminPage', 'dashicons-chart-line', 6);
    add_action('load-' . $my_hook, 'load_scripts');
}

// Enqueue scripts and styles
function load_scripts()
{
    add_action('admin_enqueue_scripts', 'enqueue_bootstrap');
}

function enqueue_bootstrap()
{
    $path = 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap.min.css';
    $path2 = 'https://code.jquery.com/jquery-3.5.1.js';
    $path3 = 'https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js';
    $path4 = 'https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js';
    $path5 = 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js';
    $path6 = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js';
    $path7 = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js';
    $path8 = 'https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js';
    $path9 = 'https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js';
    $path10 = 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js';
    $path11 = 'https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js';
    // $path12 = plugin_dir_url(__FILE__) . 'assets/js/otpfrom.js';

    $dependencies = array();
    $version = false;
    wp_enqueue_style('myplugin-bootstrap', $path, $dependencies, $version);
    wp_enqueue_script('myplugin-jquery', $path2, $dependencies, $version);
    wp_enqueue_script('myplugin-datatable', $path3, $dependencies, $version);
    wp_enqueue_script('myplugin-datatableButton', $path4, $dependencies, $version);
    wp_enqueue_script('myplugin-datatableGzip', $path5, $dependencies, $version);
    wp_enqueue_script('myplugin-datatablePdf', $path6, $dependencies, $version);
    wp_enqueue_script('myplugin-datatablePdfFonts', $path7, $dependencies, $version);
    wp_enqueue_script('myplugin-datatableButtonHtml5', $path8, $dependencies, $version);
    wp_enqueue_script('myplugin-datatableButtonPrint', $path9, $dependencies, $version);
    wp_enqueue_script('myplugin-moment', $path10, $dependencies, $version);
    wp_enqueue_script('myplugin-datatableDatetime', $path11, $dependencies, $version);
    // wp_enqueue_script('myplugin-customjs', $path12, $dependencies, $version);
}


?>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/dataTables.buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.0/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function() {
    $('#myDatatableId').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export to Excel',
                className: 'custom-button'
            }
        ],
        paging: false
    });
});
</script>


<style>
    .paginate_button{
        margin-right: 20px !important;
    }
    .dataTables_info{
        display: none;
    }

    #myDatatableId_filter{
        margin:20px 0px;
    }
    #myDatatableId_filter label input{
        margin-left:20px;
    }
    .custom-button{
        border: 0.5px solid #2699fb !important;
    background: #2699fb !important;
    padding: 5px 10px !important;
    color: white !important;
    }

    .widefat{
        width: 97% !important;
    }
   
</style>




