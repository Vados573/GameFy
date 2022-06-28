<?php
require('includes/config.php');
require('includes/global_functions.php');
session_start();
?>
<html lang="en">
<head>
    <title>Gamify</title>
    <?php require('includes/head.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="assets/css/main.css">

</head>
<!--oncontextmenu="return false"-->
<body>
<?php require('includes/sidebar.php'); ?>
<div id="beeteam368-site-wrap-parent" class="beeteam368-site-wrap-parent beeteam368-site-wrap-parent-control">
    <?php require('includes/header.php'); ?>
    <div id="beeteam368-primary-cw" class="beeteam368-primary-cw">
        <div class="site__container main__container-control">
            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction">
                <main id="main-content" class="site__col main-content global-post-page-content">
                    <canvas id="myChart2" style="width:100%; background-color: rgb(60,60,65);"></canvas>
                </main>
            </div>
            <div id="sidebar-direction" class="site__row flex-row-control sidebar-direction" style="margin-top: 50px;">
                <main id="main-content" class="site__col main-content global-post-page-content">
                    <canvas id="myChart3" style="width:100%; background-color: rgb(60,60,65);"></canvas>
                </main>
            </div>
        </div>
    </div>
    <?php
    $sql = "SELECT count(*) as counter_user FROM user where is_admin_user <> 1 and is_banned_user <> 1;";
    $result_chart = odbc_exec($con, $sql);
    $count_user = odbc_fetch_object($result_chart);
    $count_user = $count_user->counter_user; // User not banned and not admin
    $sql = "SELECT count(*) as counter_user_admin FROM user where is_admin_user = 1 ;";
    $result_chart = odbc_exec($con, $sql);
    $count_user_admin = odbc_fetch_object($result_chart);
    $count_user_admin = $count_user_admin->counter_user_admin; // Admin users
    $sql = "SELECT count(*) as counter_user_banned FROM user WHERE is_banned_user = 1;";
    $result_chart = odbc_exec($con, $sql);
    $count_user_banned = odbc_fetch_object($result_chart);
    $count_user_banned = $count_user_banned->counter_user_banned; // Banned users
    $sql = "SELECT count(*) as counter_channel FROM channel JOIN user u on channel.id_user = u.id_user WHERE is_admin_user <> 1;";
    $result_chart = odbc_exec($con, $sql);
    $count_channel = odbc_fetch_object($result_chart);
    $count_channel = $count_channel->counter_channel; // Channel created by non admin user
    $sql = "SELECT count(*) as counter_channel_admin FROM channel JOIN user u on channel.id_user = u.id_user WHERE is_admin_user = 1;";
    $result_chart = odbc_exec($con, $sql);
    $count_channel_admin = odbc_fetch_object($result_chart);
    $count_channel_admin = $count_channel_admin->counter_channel_admin; // Channel created by admin user
    $sql = "SELECT count(*) as counter_video FROM stream JOIN channel c on c.id_channel = stream.id_channel JOIN user u on c.id_user = u.id_user WHERE is_admin_user <> 1 AND is_live_stream = 0";
    $result_chart = odbc_exec($con, $sql);
    $count_video = odbc_fetch_object($result_chart);
    $count_video = $count_video->counter_video; // Video created by user
    $sql = "SELECT count(*) as counter_video_admin FROM stream JOIN channel c on c.id_channel = stream.id_channel JOIN user u on c.id_user = u.id_user WHERE is_admin_user = 1 AND is_live_stream = 0";
    $result_chart = odbc_exec($con, $sql);
    $count_video_admin = odbc_fetch_object($result_chart);
    $count_video_admin = $count_video_admin->counter_video_admin; // Video created by admin
    $sql = "SELECT count(*) as counter from stream WHERE YEAR(date_stream) = 2022 GROUP BY YEAR(date_stream), MONTH(date_stream) ORDER BY YEAR(date_stream), month(date_stream)";
    $result_chart = odbc_exec($con, $sql);
    ?>
</div>
<script>
    const ctx = document.getElementById('myChart2').getContext('2d');
    const ctx2 = document.getElementById('myChart3').getContext('2d');
    let labels;
    let labels2;
    labels = [''];
    labels2 = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    let chart_channel = [<?php echo $count_channel?>];
    let chart_channel_admin = [<?php echo $count_channel_admin?>];
    let chart_user = [<?php echo $count_user?>];
    let chart_user_admin = [<?php echo $count_user_admin?>];
    let chart_user_banned = [<?php echo $count_user_banned?>];
    let chart_video = [<?php echo $count_video?>];
    let chart_video_admin = [<?php echo $count_video_admin?>];
    let colorGrid;
    let myChart;
    let myChart2;
    let number_videos = [<?php $array_result = "";
     while ($table_chart = odbc_fetch_object($result_chart)) {
         $array_result .= $table_chart->counter . ',';
     }
     $array_result = rtrim($array_result, ",");
     echo $array_result;
     ?>];
    colorGrid = "rgb(0,0,0)";
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    data: chart_user,
                    label: "Users",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(227,139,23)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
                {
                    data: chart_user_admin,
                    label: "Admins",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(206,110,48)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
                {
                    data: chart_user_banned,
                    label: "Banned Users",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(255,152,0)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
                {
                    data: chart_channel,
                    label: "Channels Users",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(255,0,0)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
                {
                    data: chart_channel_admin,
                    label: "Channels Admins",
                    lineTension: 0,
                    backgroundColor: "rgb(164,10,10)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
                {
                    data: chart_video,
                    label: "Videos Users",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(94,255,0)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
                {
                    data: chart_video_admin,
                    label: "Videos Admins",
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgb(255,0,0)",
                    borderColor: "rgb(0,0,0)",
                    color: "white",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            legend: {display: false},
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colorGrid,
                    }
                },
                x: {
                    grid: {
                        color: colorGrid,
                    }
                }
            }
        }
    });
    myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: labels2,
            datasets: [{
                label: 'Video per month',
                data: number_videos,
                fill: false,
                lineTension: 0,
                backgroundColor: "rgb(255,81,0)",
                borderColor: "rgb(0,0,0)",
                color: "white",
                borderWidth: 1,
            }]
        },
        options: {
            legend: {display: false},
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colorGrid,
                    },
                    min: 20,
                },
                x: {
                    grid: {
                        color: colorGrid,
                    }
                }
            }
        }
    });
</script>
<?php require('includes/footer.php'); ?>
<?php require('includes/popup_add.php'); ?>
<?php require('includes/scripts.php'); ?>
</body>
