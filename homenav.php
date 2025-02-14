<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CASA MARCOS</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.4;
        font-size: 16px;
    }

    header {
        position: fixed;
        padding: 1.5rem;
        width: 100%;
        display: flex;
        justify-content: center;
        z-index: 1000;
        background-color: transparent;
        transition: background-color 0.5s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    header.scrolled {
        background-color: #2c3e50;
    }

    header.scrolled .logo h1,
    header.scrolled nav ul li a {
        color: rgb(218, 191, 156);
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }

    .logo h1 {
        color: rgb(102, 67, 35);
        font-size: 3.8rem;
        font-family: impact;
        letter-spacing: 1px;
    }

    nav ul {
        display: flex;
        list-style: none;
        gap: 1.5rem;
    }

    nav ul li {
        position: relative;
    }

    nav ul li a {
        color: rgb(102, 67, 35);
        text-decoration: none;
        padding: 0.8rem 1.5rem;
        font-size: 1rem;
        font-family: impact;
        text-transform: uppercase;
        transition: background-color 0.3s, transform 0.3s;
    }

    nav ul li a:hover {
        border-bottom: 2px solid  rgb(102, 67, 35);
        color:  rgb(102, 67, 35);
        transform: translateY(-2px);
    }

    .hero {
        text-align: center;
        padding: 20rem;
        background-image: url('../images/11.jpg');
        background-size: cover;
        background-position: center;
    }

    .hera {
        text-align: center;
        padding: 20rem;
        background-image: url('../images/3.jpg');
        background-size: cover;
        background-position: center;
    }

    .off {
        text-align: center;
        padding: 20rem;
        background-image: url('../images/7.jpg');
        background-size: cover;
        background-position: center;
    }

    footer {
        background-color: #2c3e50;
        color: #fff;
        text-align: center;
        padding: 1.5rem;
    }

    input,
    select {
        font-family: 'Arial', sans-serif;
        padding: 0.8rem;
        border-radius: 4px;
        width: 100%;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    input:focus,
    select:focus {
        border-color: rgb(163, 99, 15);
        outline: none;
    }

    /* Room Section */
    .rooms {
        background-color: #f9f6f2;
        padding: 8  rem 0;
        position: relative;
    }

    .rooms-header {
        margin-bottom: 4rem;
        position: relative;
    }

    .room-cards {
        display: flex;
        justify-content: center;
        gap: 3rem;
        max-width: 1600px;
        margin: 0 auto;
        padding: 0 4rem;
    }

    .room-card {
        background-color: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        width: calc(25% - 2.25rem);
        text-align: center;
        padding: 0;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        position: relative;
    }

    .room-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 15px 40px rgba(102, 67, 35, 0.2);
    }

    .room-img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .room-card:hover .room-img {
        transform: scale(1.1);
    }

    .room-card .room-title {
        margin: 2rem 1.5rem 1rem;
        font-size: 2rem;
        color: rgb(102, 67, 35);
        font-family: 'impact';
        letter-spacing: 1px;
    }

    .room-card .room-description {
        margin: 0 1.5rem 2rem;
        font-size: 1.1rem;
        color: #5d4037;
        line-height: 1.6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        opacity: 0;
        height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .room-card:hover .room-description {
        opacity: 1;
        height: auto;
        margin-bottom: 2rem;
    }

    .btn-room {
        background: linear-gradient(135deg, rgb(102, 67, 35) 0%, rgb(163, 99, 15) 100%);
        color: white;
        border: none;
        border-radius: 30px;
        padding: 1rem 2.5rem;
        cursor: pointer;
        margin: 0 1.5rem 2rem;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-room:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(102, 67, 35, 0.3);
    }

    /* Container for the Carousel */
    .carousel-container {
        width: 80%;
        margin: 50px auto;
        overflow: hidden;
        position: relative;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Carousel Slide Wrapper */
    .carousel-wrapper {
        display: flex;
        transition: transform 1s ease;
    }

    /* Individual Slide */
    .carousel-slide {
        min-width: 100%;
        height: 700px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    /* Title and Description */
    .room-details {
        position: absolute;
        bottom: 20px;
        left: 20px;
        color: white;
        font-family: 'Georgia', serif;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .room-title {
        font-size: 2em;
        font-weight: bold;
    }

    .room-description {
        font-size: 1.1em;
        margin-top: 10px;
    }

    /* Navigation Arrows */
    .prev,
    .next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.4);
        color: white;
        border: none;
        font-size: 2em;
        padding: 10px;
        cursor: pointer;
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }

    /* Dots Navigation */
    .dots-container {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
    }

    .dot {
        height: 10px;
        width: 10px;
        margin: 0 5px;
        background-color: white;
        border-radius: 50%;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .active-dot {
        background-color: gold;
    }

    @media (max-width: 1200px) {
        .room-card {
            width: calc(50% - 2.25rem);
        }

        nav ul {
            flex-direction: column;
            align-items: center;
        }

        nav ul li {
            margin-bottom: 1rem;
        }

        .hero {
            padding: 10rem;
        }

        .hero div {
            padding: 2rem;
        }

        .rooms-header {
            text-align: center;
        }

        .carousel-container {
            width: 90%;
        }

        .btn-room {
            width: 80%;
        }

        h2,
        h3 {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .room-card {
            width: 100%;
        }

        .carousel-container {
            height: auto;
        }

        .hero {
            padding: 6rem 1.5rem;
        }

        .hero div {
            padding: 2rem 1rem;
        }

        .dots-container {
            bottom: 10px;
        }

        .btn-room {
            width: 100%;
            margin: 0 0 2rem 0;
        }

        nav {
            flex-direction: column;
        }

        nav ul {
            width: 100%;
        }

        nav ul li {
            text-align: center;
        }
    }
    
    nav ul li a.active {
        border-bottom: 2px solid rgb(218, 191, 156);
        color:  rgb(218, 191, 156);
        transform: translateY(-2px);
    }
  
    .mobile-menu-btn {
    display: none;
    font-size: 1.5rem;
    color: rgb(102, 67, 35);
    cursor: pointer;
    transition: color 0.3s ease;
}

.mobile-menu-btn:hover {
    color: rgb(163, 99, 15);
}

@media (max-width: 768px) {
    .mobile-menu-btn {
        display: block;
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1001;
    }

    .nav-links {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(44, 62, 80, 0.95);
        flex-direction: column;
        justify-content: center;
        padding: 2rem;
        z-index: 1000;
    }

    .nav-links.active {
        display: flex;
    }

    .nav-links li a, 
    .nav-links .dropbtn {
        color: rgb(218, 191, 156);
        font-size: 1.2rem;
        margin: 10px 0;
    }

    .mobile-logo h1 {
        font-size: 2.5rem;
        color: rgb(218, 191, 156);
    }

    .mobile-logo span {
        font-size: 0.9rem;
    }

   
}


</style>

<body>
<header>
    <nav>
        <div class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </div>
        <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
        <ul class="nav-links" style="width: 100%; align-items: center;">
            <li><a href="roomstry.php" class="<?php echo ($current_page == 'roomstry.php') ? 'active' : ''; ?>">Our Rooms</a></li>
            <li><a href="offers.php" class="<?php echo ($current_page == 'offers.php') ? 'active' : ''; ?>">Food Menu</a></li>
            <a href="home.php" class="logo mobile-logo" style="margin: 0 2rem; text-decoration: none;">
                <h1 style="text-align: center; line-height: 1.2;">CASA MARCOS
                    <span style="display: block; font-size: 1rem;">RESORT AND VILLAS</span>
                </h1>
            </a>
            <li><a href="aboutus.php" class="<?php echo ($current_page == 'aboutus.php') ? 'active' : ''; ?>">About us</a></li>
            <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
        </ul>
    </nav>
</header>
    