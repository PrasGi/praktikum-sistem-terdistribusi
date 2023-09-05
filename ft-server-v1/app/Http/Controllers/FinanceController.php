<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceController extends Controller
{
    public function index()
    {
        $data = Finance::where('user_id', auth()->user()->uuid)->get();
        return response()->json([
            'status_error' => false,
            'message' => 'Success get data',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make([
            'needed' => $request->needed,
            'amount' => $request->amount,
        ], [
            'needed' => ['required', 'string', 'max:100'],
            'amount' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_error' => true,
                'message' => $validator->errors(),
            ]);
        }

        $payload = [
            'needed' => $request->needed,
            'amount' => $request->amount,
            'user_id' => auth()->user()->uuid
        ];

        if ($data = Finance::create($payload)) {
            return response()->json([
                'status_error' => false,
                'message' => 'Success create data',
                'data' => $data
            ]);
        }

        return response()->json([
            'status_error' => true,
            'message' => 'Failed create data',
        ]);
    }

    public function destroy(Finance $finance)
    {
        if ($finance->delete()) {
            return response()->json([
                'status_error' => false,
                'message' => 'Success delete data',
            ]);
        }

        return response()->json([
            'status_error' => true,
            'message' => 'Failed delete data',
        ]);
    }

    public function countTotalAmountByMounthCurrent()
    {
        $data = Finance::where('user_id', auth()->user()->uuid)
            ->whereMonth('created_at', date('m'))
            ->sum('amount');

        return response()->json([
            'status_error' => false,
            'message' => 'Success get data',
            'data' => $data
        ]);
    }

    public function countTotalAmountAll()
    {
        $data = Finance::where('user_id', auth()->user()->uuid)
            ->sum('amount');

        return response()->json([
            'status_error' => false,
            'message' => 'Success get data',
            'data' => $data
        ]);
    }

    public function chartFinance()
    {
        $monthlyData = Finance::selectRaw('sum(amount) as total, MONTH(created_at) as month')
            ->where('user_id', auth()->user()->uuid)
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $formattedData = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthData = $monthlyData->where('month', $month)->first();
            $monthTotal = $monthData ? $monthData->total : 0;

            $monthName = date('F', mktime(0, 0, 0, $month, 1));

            $formattedData[] = [
                'name_month' => $monthName,
                'data' => $monthTotal
            ];
        }

        return response()->json([
            'status_error' => false,
            'message' => 'Success get data',
            'data' => $formattedData
        ]);
    }
}
