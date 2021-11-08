<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

        <title>User Profile</title>
    </head>
    <body>
        <header>

            <div class="user">
                <img src="../img/login/login1.png" alt="">
                <h3 class="name" style="color:black">Yew Chee Kin</h3>
                <p class="post">TARC Student</p>
            </div>
            <nav class="navbar">
                <ul>
                    <li><a href="#home">home</a></li>
                    <li><a href="#about">about</a></li>
                    <li><a href="#My Trades">My Trades</a></li>
                    <li><a href="#Revies">Reviews</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </header>
        <!-- header section ends -->
        <!-- content section starts  -->
        <div class="container">
            <section class="home" id="home">
                <h3>Hi There</h3>
                <h3 style="color:black">My name is <span>YEW CHEE KIN</span></h3>
                <h3 class="post">I am a REI STUDENT FROM TARC</h3>
                <a href="#"><button class="btn">ABOUT ME</button></a>
                <div class="share">
                    <a href="#" class="fab fa-facebook-f"></a>
                    <a href="#" class="fab fa-twitter"></a>
                    <a href="#" class="fab fa-instagram"></a>
                    <a href="#" class="fab fa-linkedin"></a>
                </div>
            </section>
            <!-- about section  -->
            <section class="about" id="about">
                <h1 class="heading pb-5" style="color:black;">about me</h1>
                <form id="form" method="post">
                    <div class="row">
                        <div class="col-md-12" style="border-bottom:2px solid #dde0d7">
                            <div class="row">
                                <div class="col-md-12 pb-5">
                                    <h3 class="m-0 text-dark">Personal Details</h3>
                                </div>
                                <div class="col-md-4 pb-2">
                                    <label>Name : </label>
                                    <div class="form-group">                                             
                                        <input type="text" class="form-control" id="name" name="name" readonly value="">
                                    </div>
                                </div>
                                <div class="col-md-4 pb-2">
                                    <label>Email : </label>
                                    <div class="form-group">                                             
                                        <input type="text" class="form-control" id="email" name="email" readOnly value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Contact :</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control"  id="contact" name="contact" readOnly value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pb-2"  style="border-bottom:2px solid #dde0d7 ">
                            <div class="row">
                                <div class="col-md-12 pb-5 pt-5">
                                    <h3 class="m-0 text-darkc">Address Details</h3>
                                </div>

                                <div class="col-md-6 pb-5">
                                    <label>Address 1 : </label>
                                    <div class="form-group">                                             
                                        <input type="text" class="form-control" id="address1" name="address1" >
                                    </div>
                                </div>
                                <div class="col-md-6 pb-5">
                                    <label>Address 2 : </label>
                                    <div class="form-group">                                             
                                        <input type="text" class="form-control" id="address2" name="address2" readOnly value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>City :</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="city" name="city" readOnly value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>State :</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control"  id="state" name="state" readOnly value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Post code :</label>
                                    <div class="form-group">
                                        <input type="email" class="form-control"  id="postcode" name="postcode" readOnly value="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label>Country :</label>
                                    <div class="form-group">
                                        <select class="form-control" name="country" id="country" disabled>

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="border-bottom:2px solid #dde0d7">
                            <div class="row">
                                <div class="col-md-12 pt-5">
                                    <h3 class="m-0 text-dark">Security</h3>
                                </div>

                                <div class="col-md-4 pt-5">
                                    <label>Old password : </label>
                                    <div class="form-group">                                             
                                        <input type="password" class="form-control" id="old_ps" readOnly>
                                    </div>
                                </div>
                                <div class="col-md-4 pt-5">
                                    <label>New password : </label>
                                    <div class="form-group">                                             
                                        <input type="password" class="form-control" id="new_ps" name="ps" readOnly>
                                    </div>
                                </div>
                                <div class="col-md-4 pt-5 pb-2">
                                    <label>Re-password :</label>
                                    <div class="form-group">
                                        <input type="password" class="form-control"  id="re_ps" readOnly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding-top:50px">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">                                             
                                        <button class="btn" style="width:100%" id="btnback" onclick="back()">Back</button>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-2">
                                    <div class="form-group">                                             
                                        <button class="btn btn-danger" style="width:100%; text-align:left" id="btncancel" onclick="cancel()" disabled>Cancel</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">                                             
                                        <button class="btn btn-primary" style="width:100%" id="btnsave" onclick="save()">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
            <!-- service section  -->
            <section class="service" id="service">
            </section>
            <section class="education" id="education">
                <h1 class="heading">my education</h1>
                <div class="box-container">
                    <div class="box">
                        <div class="year">2017 - 2018</div>
                        <h3>front end development</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore ut quis nam eos deserunt veritatis adipisci, beatae odio rerum doloribus?</p>
                    </div>
                    <div class="box">
                        <div class="year">2018 - 2019</div>
                        <h3>front end development</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore ut quis nam eos deserunt veritatis adipisci, beatae odio rerum doloribus?</p>
                    </div>
                    <div class="box">
                        <div class="year">2019 - 2020</div>
                        <h3>front end development</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore ut quis nam eos deserunt veritatis adipisci, beatae odio rerum doloribus?</p>
                    </div>
                    <div class="box">
                        <div class="year">2020 - 2021</div>
                        <h3>front end development</h3>
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempore ut quis nam eos deserunt veritatis adipisci, beatae odio rerum doloribus?</p>
                    </div>
                </div>
            </section>
            <!-- contact section  -->
            <section class="contact" id="contact">
                <h1 class="heading">contact me</h1>
                <div class="row">
                    <form action="">
                        <input type="text" class="box" placeholder="first name">
                        <input type="text" class="box" placeholder="last name">
                        <input type="email" class="box" placeholder="your email">
                        <input type="text" class="box" placeholder="your project">
                        <textarea name="" id="" cols="30" rows="10" class="box message" placeholder="message"></textarea>
                        <input type="submit" value="message" class="btn">
                    </form>
                    <div class="content">
                        <div class="icons">
                            <h3><i class="fas fa-map-marker-alt"></i> address </h3>
                            <p>mumbai, india 400104</p>
                        </div>
                        <div class="icons">
                            <h3><i class="fas fa-envelope"></i> email </h3>
                            <p>shaikh@gmail.com</p>
                        </div>
                        <div class="icons">
                            <h3><i class="fas fa-phone"></i> phone </h3>
                            <p>+123-456-7890</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- content section ends -->
        <!-- theme toggler  -->
        <!-- type.js cdn link  -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
        <script>

                                            var type = new Typed('.typing-text', {
                                                strings: ['web designer', 'front end developer', 'graphic designer', 'photographer'],
                                                typeSpeed: 120,
                                                loop: true
                                            });

                                            let themeColor = document.querySelectorAll('.theme-toggler span');
                                            themeColor.forEach(color => color.addEventListener('click', () => {
                                                    let background = color.style.background;
                                                    document.querySelector('body').style.background = background;
                                                }));

        </script>
    </body>
    <style>
        *{
            margin:0; padding:0;
            box-sizing: border-box;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            text-transform: capitalize;
            outline: none; border:none;
            text-decoration: none;
            font-weight: normal;
        }

        html{
            font-size: 62.5%;
            overflow: hidden;
        }

        body{
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            background:linear-gradient(#83eaf1, #63a4ff);
            padding:5.5rem;
            color:black;
        }

        section{
            padding:1rem 7%;
            min-height: 100%;
        }

        .btn{
            font-size: 2rem;
            padding:.7rem 4rem;
            background:rgba(255,255,255,.2);
            color:#fff;
            border-radius: 1rem;
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            margin-top: 1rem;
            cursor: pointer;
            transition:.2s linear;
        }

        .btn:hover{
            background:rgba(255,255,255,.5);
            color:#555;
        }

        .heading{
            font-size: 3rem;
            text-align: center;
            padding:1rem;
            color:#fff;

        }

        header{
            width:35rem;
            background:rgba(255,255,255,.2);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.3);
            backdrop-filter: blur(.4rem);
            text-align: center;
            padding:1rem;
            border-radius: 1rem;
        }

        header .user{
            padding-top: 2rem;
        }

        header .user img{
            margin:1rem 0;
            height:15rem;
            width:15rem;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 0 1rem rgba(255,255,255,.2);
        }

        header .user .name{
            font-size: 3rem;
            color:#fff;
            padding:.5rem 0;
        }

        header .user .post{
            font-size: 1.8rem;
            color:#eee;
            font-weight: lighter;
        }

        header .navbar{
            padding-left:80px;
            padding-top:60px;
        }

        header .navbar ul li{
            margin:1rem 0;
            list-style: none;
        }

        header .navbar ul li a{
            display: block;
            padding:1rem;
            font-size: 2rem;
            color:#fff;
            background:rgba(255,255,255,.2);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            border-radius: 1rem;
            transition: all .2s linear;
        }

        header .navbar ul li a:hover{
            background:rgba(255,255,255,.5);
            color:#555;
            transition: none;
        }

        .container{
            height:68rem;
            width:100rem;
            background:rgba(255,255,255,.2);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.3);
            backdrop-filter: blur(.4rem);
            border-radius: 1rem;
            overflow: hidden;
        }

        .home{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-flow: column;
            position: relative;
            padding-bottom: 10rem;
        }

        .home h3{
            font-size: 2.5rem;
            font-weight: lighter;
            color:#eee;
        }

        .home .name span{
            font-size: 4rem;
            color:#fff;
        }

        .home .post{
            padding:1rem 0;
        }

        .home .post span{
            font-size: 3rem;
            color:#fff;
        }

        .home .share{
            position: absolute;
            left:50%; bottom:5rem;
            transform: translateX(-50%);
            display: flex;
            padding:1rem;
            border-radius: 1rem;
            background: rgba(255,255,255,.1);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            transition: .2s linear;
        }

        .home .share a{
            background: rgba(255,255,255,.2);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            padding:1rem 2rem;
            margin:1rem;
            color:#fff;
            font-size: 2rem;
            border-radius: 1rem;
        }

        .home .share a:hover{
            background:rgba(255,255,255,.5);
            color:#555;
        }

        .about .content h3{
            font-size: 2.5rem;
            color:#eee;
        }

        .about .content h3 span{
            color:#fff;
        }

        .about .content p{
            font-size: 1.5rem;
            color:#eee;
            padding:.5rem 0;
        }

        .about .skills{
            padding:1rem 0;
        }

        .about .skills .progress{
            margin:1.5rem 0;
            padding:1rem;
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            background: rgba(255,255,255,.2);
            border-radius: 1rem;
        }

        .about .skills .progress h3{
            display: flex;
            justify-content: space-between;
            font-size: 2rem;
            color:#fff;
        }

        .about .skills .progress .bar{
            position: relative;
            width: 100%;
            height:.3rem;
            margin:1rem 0;
            background:#555;
        }

        .about .skills .progress .bar span{
            position: absolute;
            top:0; left: 0;
            height:100%;
            width:100%;
            background:#fff;
        }

        .about .skills .progress:nth-child(1) .bar span{
            width:95%;
        }

        .about .skills .progress:nth-child(2) .bar span{
            width:85%;
        }

        .about .skills .progress:nth-child(3) .bar span{
            width:65%;
        }

        .about .skills .progress:nth-child(4) .bar span{
            width:70%;
        }

        .service .box-container{
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .service .box-container .box{
            margin:1rem;
            padding:1rem;
            border-radius: 1rem;
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            background: rgba(255,255,255,.2);
            text-align: center;
            width:32rem;
        }

        .service .box-container .box i{
            color:#fff;
            font-size: 4.5rem;
            padding:1rem 0;
        }

        .service .box-container .box p{
            color:#eee;
            font-size: 1.3rem;
            padding:.5rem 5rem;
        }

        .education .box-container{
            display: flex;
            /* align-items: center; */
            justify-content: space-between;
            flex-wrap: wrap;
            padding:2rem 0;
        }

        .education .box-container .box{
            width:30rem;
            padding:0 2rem;
            padding-bottom: 4rem;
            border-left: .2rem solid #eee;
        }

        .education .box-container .box .year{
            font-size: 2rem;
            color:#eee;
            position: relative;
        }

        .education .box-container .box .year::before{
            content:'';
            position: absolute;
            top:.3rem; left: -3.1rem;
            height:2rem;
            width:2rem;
            border-radius: 50%;
            background:#fff;
        }

        .education .box-container .box h3{
            font-size: 2rem;
            color:#fff;
            padding-top: 1rem;
        }

        .education .box-container .box p{
            font-size: 1.3rem;
            color:#eee;
            padding: 1rem 0;
        }

        .contact .row{
            display: flex;
            justify-content: space-between;
            padding-top: 7rem;
            align-items: center;
        }

        .contact .row form{
            background:rgba(255,255,255,.1);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            border-radius: 1rem;
            display: flex;
            justify-content: space-between;
            padding:1rem 2rem;
            flex-wrap: wrap;
        }

        .contact .row form .box{
            background:white;
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            border-radius: 1rem;
            padding:0 1rem;
            margin:1rem 0;
            height:4rem;
            width:49%;
            font-size: 1.7rem;
            color:#fff;
            text-transform: none;
        }

        .contact .row form .box::placeholder{
            text-transform: capitalize;
            color:#eee;
        }

        .contact .row form .message{
            padding:1rem;
            height:15rem;
            resize: none;
            width:100%;
        }

        .contact .row form .btn{
            margin-bottom: 1rem;
        }

        .contact .row .content{
            padding:0 5rem;
        }

        .contact .row .content .icons{
            padding:1rem 0;
        }

        .contact .row .content .icons h3{
            padding:1rem 0;
            font-size: 2rem;
            color:#fff;
            display: flex;
        }

        .contact .row .content .icons h3 i{
            padding-right: .5rem;
        }

        .contact .row .content .icons p{
            font-size: 1.5rem;
            color:#eee;
        }

        .theme-toggler{
            background:rgba(255,255,255,.2);
            box-shadow: 0 1rem 2rem rgba(0,0,0,.2);
            border-radius: 1rem;
            backdrop-filter: blur(.4rem);
        }

        .theme-toggler span{
            display: block;
            height:3rem;
            width:3rem;
            border-radius: 50%;
            cursor: pointer;
            margin:2rem 2.5rem;
            box-shadow: 0 0 0 .5rem rgba(255,255,255,.2),
                0 1rem 2rem rgba(0,0,0,.4);
        }

        a:link {
            text-decoration: none;
        }
        a:visited {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        a:active {
            text-decoration: underline;
        }

    </style>
</html>