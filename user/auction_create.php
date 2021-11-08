<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Create auction</title>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>

        <div class="container-lg">
            <div class="row py-3">
                <div class="col-6">
                    <div class="py-3 border p-3">
                        <select class="form-select" aria-label="Default select example">
                            <option selected value="0">All</option>
                            <option value="1">Clothing</option>
                            <option value="2">Accessories</option>
                            <option value="3">Services</option>
                        </select>

                        <div class="row row-cols-3 py-3">
                            <div class="col pe-1 pb-1 item-pic-box">
                                <img src="../img/about/people-2.jpg" class="img-fluid item-pic" alt="Profile picture">
                            </div>

                            <div class="col pe-1 pb-1 item-pic-box">
                                <img src="../img/about/people-2.jpg" class="img-fluid item-pic" alt="Profile picture">
                            </div>
                        </div>

                        <div class="profile-pic-box">
                            <img src="../img/about/people-2.jpg" class="img-fluid profile-pic float-start" alt="Profile picture" style="width:60px; height:50px;">
                            <div class="row align-content-center py-2">
                                <li class="" style="list-style-type:none;">Yours items:</li>
                                <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you will be putting in auction for bidders to bid.</li>
                            </div>
                        </div>

                        <div class="row" style="height: 250px; width: 100%; background: whitesmoke"></div>
                    </div>
                </div>

                <div class="col-6">
                    <form class="needs-validation border px-3" novalidate>
                        <div class="pt-3" style="font-size: 1.1em;">Auction details</div>

                        <div class="pb-3">
                            <label for="validationCustom01" class="form-label">Title</label>
                            <input type="text" class="form-control " id="validationCustom01" value="Iphone for samsung" required>
                            <div class="valid-feedback ">
                                Looks good!
                            </div>

                            <label for="validationCustom01" class="form-label pt-2">Category</label>
                            <select class="form-select" aria-label="Default select example">
                                <option selected>Choose a category</option>
                                <option value="1">Clothing</option>
                                <option value="2">Accessories</option>
                                <option value="3">Services</option>
                                <option value="4">All</option>
                            </select>

                            <label class="pt-2">End date</label>
                            <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" disabled/>
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label pt-2">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>

                            <div class="">
                                <button type="button" class="btn btn-danger">Cancel</button>
                                <button type="button" class="btn btn-primary">Start auction</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        include '../include/footer.php';
        ?>
    </body>
    <script>
//        //Timepicker
//        $('#timepicker').datetimepicker({
//            format: 'LT'
//        })

        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    <style>
        .bg-navbar{
            background: whitesmoke;
        }

        .item-pic-box{
            /*border-radius: 3996px;*/
        }

        .item-pic{
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .profile-pic-box{
            /*border-radius: 3996px;*/
        }

        .profile-pic{
            width: 70px;
            height: 70px;
            object-fit: cover;
        }

        .trade-desc{
            font-size: 0.82em;
        }
    </style>
</html>
