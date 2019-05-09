<?php
/**
 * Plugin Name:       ming-report
 * Description:       This is for product report !
 * Version:           1.0.0
 * Author:            Niakk from freelancer
 */

/*
 * Plugin constants
 */
//
if(!defined('PLUGIN_URL'))
    define('PLUGIN_URL', plugin_dir_url( __FILE__ ));
if(!defined('PLUGIN_PATH'))
    define('PLUGIN_PATH', plugin_dir_path( __FILE__ ));

add_shortcode( 'ig-report', 'ig_report' );

function ig_report()
{
    $date = "";
    if(isset($_GET['date'])){
        $date =  date('Y-m-d' ,strtotime($_GET['date']));
    }
    ?>
    <style>
        .main-container{
            min-width:954px!important
        }
        .main-container table td{
            text-align:right;
        }
        .row{
            margin-bottom:20px;
        }
        .badge-hide{
            display: none;
        }

    </style>
    <div class='container main-container'>
        <div class='row'>
            <h1>IG Report</h1>
        </div>
        <div class = "row" style="padding-bottom: 20px;border-bottom: 1px solid;">
            <form class="form-inline" action="#" id="date_form" method="get_row" role="form">
                <label for="email2">SEARCH BY DATE : </label>
                <input type="text" class="form-control form-control-lg" id="date" name="date" data-date-format="yyyy-mm-dd" placeholder="date" value="<?php echo $date; ?>">
            </form>
        </div>
        <div class="row">
            <b>DATE</b>: <span class="date"></span>
        </div>
        <!-- <div class='row'>
            <div class='col-md-6'>
                <b>TOTAL ORDER</b>: <span class="total_order"></span>
            </div>
            <div class='col-md-6'>
                <b>TOTAL WIMDOWS</b>: <span class="total_window"></span>
            </div>
        </div>
        <div class="row">
            <div class='col-md-3'>
                <b>TOTAL CASEMENT</b>:  <span class="total_case"></span>
            </div>
            <div class='col-md-3'>
                <b>TOTAL SHAPE</b>: <span class="total_shape"></span>
            </div>

            <div class='col-md-3'>
                <b>TOTAL SLIDERS</b>: <span class="total_slider"></span>
            </div>
            <div class='col-md-3'>
                <b>TOTAL SEALED UNIT</b>: <span class="total_seal"></span>
            </div>
        </div> -->
        <div class="row">
            <?php
            


            global $wpdb;


            $sql = "SELECT
                        *, COUNT(res.ig_unit_id) AS tot_COUNT
                    FROM (
                        SELECT
                            SUM(CASE WHEN `".$wpdb->prefix."frm_fields`.`description` = 'ig_unit_id' THEN `".$wpdb->prefix."frm_item_metas`.`meta_value` ELSE 0 END) AS ig_unit_id,
                            SUM(CASE WHEN `".$wpdb->prefix."frm_fields`.`description` = 'ig_date' THEN `".$wpdb->prefix."frm_item_metas`.`meta_value` ELSE 0 END) AS ig_date,
                            GROUP_CONCAT(CASE WHEN `".$wpdb->prefix."frm_fields`.`description` = 'ig_time' THEN `".$wpdb->prefix."frm_item_metas`.`meta_value` ELSE '' END SEPARATOR '') AS ig_time,
                            GROUP_CONCAT(CASE WHEN `".$wpdb->prefix."frm_fields`.`description` = 'ig_name' THEN `".$wpdb->prefix."frm_item_metas`.`meta_value` ELSE '' END SEPARATOR '') AS ig_name,
                            GROUP_CONCAT(CASE WHEN `".$wpdb->prefix."frm_fields`.`description` = 'ig_rack_num' THEN `".$wpdb->prefix."frm_item_metas`.`meta_value` ELSE '' END SEPARATOR '') AS ig_rack_num
                        FROM
                            `".$wpdb->prefix."frm_items`
                            INNER JOIN `".$wpdb->prefix."frm_item_metas`
                            ON (`".$wpdb->prefix."frm_items`.`id` = `".$wpdb->prefix."frm_item_metas`.`item_id`)
                            INNER JOIN `".$wpdb->prefix."frm_forms`
                            ON (`".$wpdb->prefix."frm_forms`.`id` = `".$wpdb->prefix."frm_items`.`form_id`)
                            INNER JOIN `".$wpdb->prefix."frm_fields`
                            ON (`".$wpdb->prefix."frm_fields`.`id` = `".$wpdb->prefix."frm_item_metas`.`field_id`)
                        WHERE (`".$wpdb->prefix."frm_forms`.`name` = 'IG UNIT REPORT')
                        GROUP BY `".$wpdb->prefix."frm_items`.`id`
                        ORDER BY `".$wpdb->prefix."frm_items`.`id` ASC) AS res
                    GROUP BY
                        res.ig_unit_id
                    ORDER BY
                        res.ig_unit_id";

            $item_ids = $wpdb->get_results($sql);
            // var_dump($item_ids);
            $index = 0;

            echo "<table id='ig-table' class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>SEALED UNIT ID</th>";
            echo "<th>DATE</th>";
            echo "<th>TIME</th>";
            echo "<th>NAME</th>";
            echo "<th>RACK</th>";
            echo "<th>TOTAL</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            // echo '<pre>';
            foreach($item_ids as $row => $value) {
                echo "<tr>
                    <td>".$value->ig_unit_id."</td>
                    <td>".$value->ig_date."</td>
                    <td>".$value->ig_time."</td>
                    <td>".$value->ig_name."</td>
                    <td>".$value->ig_rack_num."</td>
                    <td>".$value->tot_COUNT."</td>
                </tr>";
            }
            echo "</tbody>";
            echo "</table>";

            // $i=0;
            // $total_case = 0 ;
            // $total_slider = 0 ;
            // $total_shape = 0;
            // $total_seal = 0;
            // $total_window = 0;

            ?>

        </div>
    </div>
    <script>

    </script>
    <?php
}
