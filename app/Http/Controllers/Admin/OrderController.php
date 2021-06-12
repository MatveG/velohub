<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Admin\ImagesUploader;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::get([
            'id',
            'status',
            'payment',
            'delivery',
            'total',
            'email',
            'phone',
            'name',
            'surname',
            'address',
            'created_at',
            'products'
        ]);

        return response()->json($orders);
    }

    public function get($id): JsonResponse
    {
        $order = Order::with('products')->find($id);

        return response()->json($order);
    }

    public function post(Request $request): JsonResponse
    {
//        $request->validate([
//            'category_id' => 'required|integer',
//            'model' => 'required|min:2|max:255|string',
//            'code' => 'max:255|nullable|unique:variants'
//        ]);

        $order = Order::create($request->all());

        return response()->json($order);
    }

    public function patch(Request $request, int $id): JsonResponse
    {
//        $request->validate([
//            'category_id' => 'integer',
//            'model' => 'min:2|max:255|string',
//            'code' => 'max:255|nullable|unique:products,code,' . $id,
//        ]);

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return response()->json($order->getChanges());
    }

    public function delete(int $id): JsonResponse
    {
        Order::findOrFail($id)->delete();

        return response()->json();
    }
}
