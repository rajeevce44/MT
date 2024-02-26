<?php
// app/Http/Controllers/FormController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Config;

class FormController extends Controller
{

    public function submitForm(Request $request)
    {
        $request->validate([
            'symbol' => 'required', // Assuming the symbols are in a "stocks" table
            'start_date' => 'required|date|before_or_equal:end_date|before_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date|before_or_equal:today',
            'email' => 'required|email',
        ]);

        $allData = request()->all();
        $apiKey = env('API_KEY_STOCK'); 
        $endpoint = env('ENDPOINT_STOCK');
        $symbol = $allData['symbol'];
        $region = 'US';
        $url = $endpoint . "?symbol=$symbol&region=$region";
        $headers = [
            'X-RapidAPI-Key: ' . $apiKey,
            'Host: yh-finance.p.rapidapi.com',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        $dataArray = json_decode($response, true);
        $quotes = [];
        if(!empty($dataArray)){
            foreach($dataArray['prices'] as $data){
                $open = $data['open'] ?? 'N/A';
                $high = $data['high'] ?? 'N/A';
                $low = $data['low'] ?? 'N/A';
                $close = $data['close'] ?? 'N/A';
                $volume = $data['volume'] ?? 'N/A';
                $quotes[] = ['date'=>date('Y-m-d', $data['date']),'open'=>$open,'high'=>$high,'low'=>$low,'close'=>$close,'volume'=>$volume];
            }
        }

        return view('quotes', compact('symbol', 'quotes'));
    }
} 