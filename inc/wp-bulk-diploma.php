<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="https://www.bibleiq.org/quizzes/showCertificate/3049#">
    <title>Certificate</title>
<style>
@font-face {
    font-family: 'Copperplate Gothic Std';
    font-weight: bold;
    font-style: normal;
}

.nameforsirname{
    <?= $_POST["position"]; ?>
}

.wraper-cont {
    width: 97.4%;
    float: none;
    margin: 0 auto;
    padding-left: 15px;
    padding-right: 15px;
    display: inline-block;

}
/*.congrate-content-area {*/

/*    width: 70%;*/
/*    float: right;*/
/*    margin-top: 0;*/
/*    padding-top: 3%;*/

/*}*/
.congrate-content-area {
    /* width: 600px; */
    float: right;
    margin-top: 0;
    padding-top: 3%;
    /* margin-right: 34%; */
    /* margin-right: 20%; */
    float: none;
}
.congrate-content-area h1{
    font-family: 'Copperplate Gothic Std';
    font-weight: 700;
    font-size: 55px;
    letter-spacing: 0;
    color: #060606;
    position: relative;
    text-align: center;
}

.congrate-content-area h1::before {
    content: '';
    position: absolute;
    width: 500px;
    height: 4px;
    background: #000;
    bottom: -6px;
    right:0;
    left:0;
    margin: 0 auto;
}

.congrate-content-area h2{
font-family: 'Copperplate Gothic Std';
font-weight: 700;
font-size: 28px;
color: #000;
margin: 0 auto;
/*direction: rtl;*/
padding-right: 0;
text-align: center;
}
/*.nameforsirname h2::before {
    content: '';
    position: absolute;
    bottom: 0;
    height: 4px;
    background: #000;
    right: 0;
    margin-left: 0;
    left: 0;
    width: 100%;
}*/
.congrate-content-area span{
    color:#f1593a;
    display: block;
}

.nameforsirname h2{
font-family: kunstler Script;

font-size: 93px;

margin-top: 20px;

letter-spacing: 3px;

position: relative;
}

/*.nameforsirname h2::before {*/

/*    content: '';*/
/*    position: absolute;*/
/*    bottom: 0;*/
/*    right: 0;*/
/*    width: 690px;*/
/*    height: 4px;*/
/*    background: #000;*/
/*    right: 22%;*/
/*    margin-left: -20px;*/

/*}*/
.date-signtr-contair{
width: 100%;
padding-left: 0;
padding-right: 0;
margin: 0 auto;
padding-top: 40px;
float: none;
}
.date-signtr-contair .datein {
    float: left;
    width: 104px;
text-align: center;
}
.date-signtr-contair .datein hr{
    
}
.date-signtr-contair .datein p{
    
}
.date-signtr-contair .datein p.datedaily{
    
}

.date-signtr-contair .signaturein {
    float: right;
width: 160px;
text-align: center;
}
.signaturein img {
    float: right;
    width: 100%;
}
.bblogo {
    width: 239px;
    margin-bottom: 100px;
    margin: 0 auto;
    display: block;
}
@media (max-width: 1300px){
    .congrate-content-area{
        width: 60%;
        right: 100px;
    }
    .nameforsirname h2{
        font-size: 50px !important;
    }
}
@media (max-width: 1199px){
    .congrate-content-area h1{
    font-size: 30px;
}
.congrate-content-area h2{
    font-size: 20px;
}
}
@media (max-width: 767px){
    .congrate-content-area{
        width: 100%;
        margin-right:0;
    }
    .congrate-content-area h1{
        font-size:31px;
    }
    .wraper-cont{
        width: 100%;
        padding: 0;
    }
}
@media (max-width: 480px){
.congrate-content-area h1{
    font-size: 27px;
}
}
</style>
  </head>
  <body style="background: url(<?= $_POST['bg_image_url']; ?>)">
         <div class="wraper-cont" >
            <div class="congrate-content-area">
                       <br>
                        <div class="nameforsirname" style="font-family: <?= $_POST['font_family']; ?>; font-size: <?= $_POST['font_size']; ?>">
                            <p class="userdetails" >
                                <?= $_POST['user_name']; ?></p>
                            <br>
                        </div>
               <!-- date here -->
            </div>  
        </div>  
</body></html>