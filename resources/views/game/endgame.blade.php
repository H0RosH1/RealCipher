<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/end.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <title>Real Cipher</title>
</head>

<body>
    <div class="contioner">
        <div class="contion">
            <div class="box">
                <h1>หมดเวลา</h1>
                <h3>คุณได้อันดับที่ {{$rank}}</h3>
                <h3>{{$player_score}} คะแนน</h3>

                <a href="{{route('logout')}}"><button>เล่นอีกครั้ง</button></a>
            </div>
        </div>

        <footer>
            <a href="#test"><i class="fas fa-question"></i></a>
            <div class="online_player">

                <p><i class="fas fa-user"></i> ออนไลน์ {{$numplayers}}</p>
            </div>
        </footer>
        <div class="test" id="test">
            <div id="popup" class="popup">
                <a href="#" class="close">&times;</a>
                <div class="content">
                    <h3>วิธีการเล่น</h3>
                    <p>การถอดรหัสของเกม Real Cipher คือ ผู้เล่นต้องถอดรหัสแบบCaesar Cinher
                        โดยจะต้องนับตัวอักษรภาษาอังกฤษ ถอยหลังกลับไป 3 ตัวอักษร เช่น
                    </p>
                    <p class="pw">WAHQWLHWHWK</p>
                    <p class="bid">คำตอบ : Twentieth</p>
                    <p style="color: red;text-decoration: underline;">ตัวอักษร</p>
                    <p>'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','I',
                        'J', 'K', 'L', 'M, 'N', 'O', 'P', 'Q', 'R',
                        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
                    </p>
                </div>

            </div>
        </div>
    </div>
</body>

</html>