<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Trade T00001 - Refund</title>
    </head>
    <body>
        <?php
        include '../include/header.php';
        ?>

        <div class="bg-navbar mb-3">
            <div class="container-lg">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb py-2 mb-0">
                        <li class="breadcrumb-item"><a href="#">Refund</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Trade offer</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-lg pb-2">
            <div>
                <div class="row">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item me-0" style="font-size: 0.9em;">This trade: You are trading with</li>
                        <li class="list-inline-item" style="font-size: 0.9em;">The Username</li>
                    </ul>
                    <div class="col-md-2 col-sm-6 col-12 align-content-center">
                        <li class="list-inline-item me-0 trade-desc">Joined:</li>
                        <li class="list-inline-item trade-desc">1/1/2021</li>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12 align-content-center">
                        <li class="list-inline-item me-0 trade-desc">Rating:</li>
                        <li class="list-inline-item trade-desc">5.1</li>
                    </div>
                    <div class="col-md-2 col-sm-6 col-12 align-content-center">
                        <li class="list-inline-item me-0 trade-desc">Trade count:</li>
                        <li class="list-inline-item trade-desc">10</li>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12 align-content-center">
                        <li class="list-inline-item me-0 trade-desc">Last trade:</li>
                        <li class="list-inline-item trade-desc">28/6/2021</li>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-lg py-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="border p-2">
                        <div class="border-bottom pb-3">
                            <div class="row pt-1 pb-2">
                                <div class="profile-pic-box">
                                    <img src="../img/about/people-2.jpg" class="img-fluid profile-pic float-start" alt="Profile picture">
                                    <div class="row align-content-center">
                                        <li class="" style="list-style-type:none;">Items selected:</li>
                                        <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you selected for refund.</li>
                                    </div>
                                </div>
                            </div>

                            <div class="" style="height:200px; background: whitesmoke">

                            </div>
                        </div>

                        <div class="py-2">
                            <div class="row py-2">
                                <div class="profile-pic-box">
                                    <img src="../img/about/people-1.jpg" class="img-fluid profile-pic float-start" alt="Profile picture">
                                    <div class="row align-content-center">
                                        <li class="" style="list-style-type:none;">Items selected:</li>
                                        <li class="" style="list-style-type:none; font-size:0.82em;">These are the items you would like a refund from your trading partner.</li>
                                    </div>
                                </div>
                            </div>

                            <div class="" style="height:200px; background: whitesmoke">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border p-2">
                        <div class="" style="font-size: 0.9em; font-weight: bolder;">
                            Your trading partner would like to see what went wrong with the item. 
                            Please put some pictures as a proof that the items traded have a problem and it is a 
                            valid reason for a refund.
                        </div>

                        <div class="pt-2" style="font-weight: bolder;">
                            <li class="list-inline-item">Trade ID:</li>
                            <li class="list-inline-item">T000001</li>
                        </div>

                        <div class="py-2">
                            <label for="validationEnquiry" class="form-label">Reason</label>
                            <select class="form-select" id="validationEnquiry" required>
                                <option value="">-Select reason-</option>
                                <option value="1">Payments & Escrow</option>
                                <option value="2">Shipping & Delivery</option>
                                <option value="1">Campaigns & Seller Related</option>
                                <option value="2">Web & App Performance</option>
                                <option value="1">General Enquiries</option>
                                <option value="2">Account & Security</option>
                                <option value="1">Returns & Refunds</option>
                                <option value="2">Product Content & Legal</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid state.
                            </div>
                        </div>

                        <div class="py-2">
                            <div class="" style="height:400px; background: whitesmoke">

                            </div>

                            <div class="py-2">
                                <input class="form-control" type="file" id="formFileMultiple" multiple>
                            </div>
                        </div>

                        <div class="py-2">
                            <div class="">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    <!--I agree that the above following proof is real-->
                                    I agree to the terms and conditions
                                </label>
                            </div>
                        </div>

                        <div class="py-2">
                            <button type="button" class="btn btn-danger">Cancel</button>
                            <button type="button" class="btn btn-primary float-end">Submit refund</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include '../include/footer.php';
        ?>
    </body>
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