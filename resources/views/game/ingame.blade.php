<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('./css/game.css')}}">
    <title>Real Cipher</title>
</head>

<body>
    <div class="contioner">
        <div class="timebox">
            <div class="time" id="countdown"></div>
        </div>
        <div class="contion">
            <div class="box_top">
                <p>{{session('player_name')}} : <span id="score"></span> คะเเนน</p>
                <!-- //////////////////////// -->
                <div class="score" id="ranking">


                </div>
                <!-- //////////////////////// -->


            </div>
            <div class="box_botton">
                <div class="question">
                    <h2 id="ciphertext"></h2>
                    <form autocomplete="off" id="submit">
                        @csrf
                        <input id="answer" style="text-transform: uppercase; text-align: center;" type="text" name="answer" class="answer" placeholder="ใส่คำตอบ" autofocus>
                        <input type="submit" value="ตอบ" class="btn">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script>
    $(document).ready(function() {
        let countdown = setInterval(() => {

            let timed = sessionStorage.getItem("timed");
            let time = "{{session('countdown')}}" - timed;

            document.getElementById('countdown').innerHTML = time;

            if (time <= 0) {
                clearInterval(countdown);

                let url = "{{route('endgame')}}";
                window.location.href = url;
            }
            timed++;
            sessionStorage.setItem("timed", timed);
        }, 1000);

        // ///////////////////////

        $("#submit").submit(function(e) {
            e.preventDefault();

            var _token = $("input[name='_token']").val();
            var answer = $("#answer").val();
            answer = answer.toUpperCase();
            $.ajax({
                url: "{{ route('checkAnswer') }}",
                type: 'POST',
                data: {
                    _token: _token,
                    answer: answer
                },
                success: function(results) {
                    showResult(results);
                }
            });
        });

        function showResult(results) {
            let result = results.result;
            if (result == 'correct') {
                document.getElementById('answer').style.border = "5px solid green";
                let timed = sessionStorage.getItem("timed");
                timed =  timed-30;
                sessionStorage.setItem("timed", timed);
                nextWord();
            } else {
                document.getElementById('answer').style.border = "5px solid red";
            }
            document.getElementById('answer').value = '';
            setTimeout(() => {
                document.getElementById('answer').style.border = "none";
            }, 600);

        }

        function nextWord() {
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('nextWord') }}",
                type: 'POST',
                data: {
                    _token: _token
                },
                success: function(data) {
                    newData(data);
                }
            });
        }

        function newData(data) {
            document.getElementById('score').innerHTML = data.player_score;
            document.getElementById('ciphertext').innerHTML = data.ciphertext;
        }

        let state = false;
        if (!state) {
            nextWord();
            state = true;
        }


        let ranking = setInterval(() => {
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('getRank') }}",
                type: 'POST',
                data: {
                    _token: _token
                },
                success: function(data) {
                    newRanking(data);
                }
            });
        }, 3000);

        function newRanking(data) {

            let no = 1;
            var all_players = new Array();
            for (players in data) {
                data[players].forEach((player) => {

                    let uid = player['uid'];
        
                    let player_name = player['player_name'];
                    let score = player['score'];

                    all_players.push(["#"+no, player_name, score,uid]);
                    no++;
   
                });
            }

            //Create a HTML Table element.
            var table = document.createElement("TABLE");
            table.border = "1";

            //Get the count of columns.
            var columnCount = all_players[0].length;


            //Add the data rows.
            for (var i = 0; i < all_players.length; i++) {
                row = table.insertRow(-1);
                row.id = all_players[i][3];
                for (var j = 0; j < columnCount-1; j++) {
                    var cell = row.insertCell(-1);
                    cell.innerHTML = all_players[i][j];
                }
            }

            var ranking = document.getElementById("ranking");
            ranking.innerHTML = "";
            ranking.appendChild(table);
            
            let uid = "{{session('uid')}}";
            document.getElementById(uid).classList.add("myScore");

        }



        // ///////////////////////

    });
    </script>


</body>

</html>