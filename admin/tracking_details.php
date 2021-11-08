<?php
include 'navbar.php';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Trade details</title>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed"  onload="loadform()">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Delivery ID: D001</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="tracking_list.php">Tracking list</a></li>
                                <li class="breadcrumb-item active">Tracking details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <form id="form" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary" >
                                            <div class="card-header" style="background: #21B6A8">
                                                <h3 class="card-title">User detail</h3>
                                                <div class="card-tools" style="padding-top:10px">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Delivery id</label>
                                                            <input class="form-control" id="name" name="name" readonly value="D001">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Trading id</label>
                                                            <input class="form-control" id="phone" name="phone" readonly value="T001">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Delivery request status</label>
                                                            <input class="form-control" id="email" name="email" readonly value="Accepted">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Estimated pickup date:</label>
                                                            <input class="form-control" id="email" name="email" readonly value="30/7/2021">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Delivery status</label>
                                                            <input class="form-control" id="phone" name="phone" readonly value="Delivered">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row" style="padding-bottom: 10px; padding-top:50px;">
                                                    <div class="col-md-8"></div>
                                                    <div class="col-md-2" style="padding-bottom: 10px">

                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-primary" style="width:100%;  background:#FFD580" onclick="editorsave()" id="btnsave">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                </div>
        </div>
        <?php include 'footer.php'; ?>
