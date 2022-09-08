<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\Words;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RealCipherController extends Controller
{
    //
    public function index()
    {
        return view('index');
    }

    //
    public function home()
    {
        $time = time() - 600;
        $date = date("Y-m-d H:i:s", $time);
        $players = Players::where('updated_at', '<', $date);
        $players->forceDelete();
        
        $players = Players::all();
        $numplayers = count($players);
        return view('game.home',compact('numplayers'));
    }

    public function saveplayer(Request $request)
    {
        $ok = 0;
        do {
            $idLength = 6;
            $str = "1234567891234567890";
            $uid = substr(str_shuffle($str), 0, $idLength);
            if (!($alluid = Players::where('uid', $uid)->first())) {
                $ok = 1;
            }
        } while ($ok == 0);

        session()->put('uid', $uid);
        session()->put('player_name', $request->player_name);
        session()->put('countdown', 120);

        $player = new Players;
        $player->uid = $uid;
        $player->player_name = $request->player_name;
        $player->score = 0;

        $player->save();

        return redirect()->route('ingame');
    }

    public function ingame()
    {
        return view('game.ingame');
    }

    public function CheckAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['result'=>'notanswer']);
        } else {
            if ($request->answer == session('plaintext')) {
                $uid = session('uid');
                $player_score = Players::where('uid',$uid)->first()->score;

                $array = str_split($request->answer);
                $score = count($array)*12;

                $player = Players::where('uid',$uid);
                $player->update([
                    'score' => $player_score+$score,
                ]);
                return response()->json(['result'=>'correct']);
            }
            return response()->json(['result'=>'incorrect']);
        }
    }

    public function nextWord(Request $request){
        $uid = session('uid');
        $player_score = Players::where('uid',$uid)->first()->score;
        $words = Words::all();
        $maxindex = count($words);
        $index = rand(1, $maxindex);

        $plaintext = Words::find($index)->word;

        $letter = [
            '3' => 'D',
            '4' => 'E',
            '5' => 'F',
            '6' => 'G',
            '7' => 'H',
            '8' => 'I',
            '9' => 'J',
            '10' => 'K',
            '11' => 'L',
            '12' => 'M',
            '13' => 'N',
            '14' => 'O',
            '15' => 'P',
            '16' => 'Q',
            '17' => 'R',
            '18' => 'S',
            '19' => 'T',
            '20' => 'U',
            '21' => 'V',
            '22' => 'W',
            '23' => 'X',
            '24' => 'Y',
            '25' => 'Z',
            '26' => 'A',
            '27' => 'B',
            '28' => 'C',
        ];
        $letterindex = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $plaintext = strtoupper($plaintext);
        session()->put('plaintext', $plaintext);
        $ciphertext = "";

        $array = str_split($plaintext);

        foreach ($array as $item) {
            $oldindex = array_search($item, $letterindex);
            $newindex = $oldindex + 3;
            $ciphertext .= $letter[$newindex];
        }

        return response()->json(['player_score'=>$player_score,'ciphertext'=>$ciphertext]);
    }

    public function getRank(Request $request){

        $time = time() - 600;
        $date = date("Y-m-d H:i:s", $time);
        $players = Players::where('updated_at', '>=', $date)->orderByDesc('score')->skip(0)->take(5)->get();

        return response()->json(['players'=>$players]);

    }

    public function endgame()
    {
        $uid = session('uid');
        $player_score = Players::where('uid',$uid)->first()->score;
        $players = Players::orderByDesc('score')->get();
        $numplayers = count($players);
        $rank = 1;
        foreach($players as $row){
            if($uid==$row->uid){
                break;
            }
            $rank++;
        }
        if (session()->has('uid')){
            $uid = session('uid');
            $player = Players::where('uid',$uid);
            $player->forceDelete();
            session()->flush();
        }
        return view('game.endgame',compact('rank','player_score','numplayers'));
    }

    public function logout(){
        return redirect()->route('home');
    }
}
