<?php

namespace App\Http\Controllers;

use App\Exports\ExportOrders;
use Illuminate\Http\Request;
use App\Models\Api;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Order;

class FinancialController extends Controller
{

    public $idApi;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.financial.index', $this->getDataIndex());
    }

    public function getDataIndex() {
        $accounts = Api::find(Cache::get('user_system_id'))
            ->where('status', 'active')
            ->get();

        return [
            'accounts' => $accounts,
        ];
    }

    public function report(Request $request)
    {
        $this->idApi = $request->id_api;
        $account = Api::find($this->idApi);

        $orders = Order::where('user_id', $account->user_id)->get();

        return Excel::download(new ExportOrders($orders), 'orders.xlsx');
    }
}
