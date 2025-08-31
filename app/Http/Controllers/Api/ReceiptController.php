<?php

namespace App\Http\Controllers\API;

use Illuminate\Routing\Controller;
use App\Models\Receipt;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of receipts
     */
    public function index()
    {
        $receipts = Receipt::with(['customer', 'products'])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $receipts
        ]);
    }

    /**
     * Store a newly created receipt
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'customer_id' => 'required|exists:customer,id',
            'currency_code' => 'nullable|string|size:3',
            'status' => 'nullable|string|max:20',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Generate receipt number
            $receiptNumber = Receipt::generateReceiptNumber();

            // Calculate totals
            $totalAmount = 0;
            $taxAmount = 0;

            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);
                $lineTotal = $productData['quantity'] * $productData['unit_price'];
                $lineTax = $lineTotal * ($product->tax_rate / 100);

                $totalAmount += $lineTotal;
                $taxAmount += $lineTax;
            }

            // Create receipt
            $receipt = Receipt::create([
                'receipt_number' => $receiptNumber,
                'issue_date' => $request->issue_date,
                'due_date' => $request->due_date,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'currency_code' => $request->currency_code ?? 'USD',
                'status' => $request->status ?? 'issued',
                'customer_id' => $request->customer_id,
            ]);

            // Attach products
            foreach ($request->products as $productData) {
                $totalPrice = $productData['quantity'] * $productData['unit_price'];

                $receipt->products()->attach($productData['product_id'], [
                    'quantity' => $productData['quantity'],
                    'unit_price' => $productData['unit_price'],
                    'total_price' => $totalPrice,
                ]);
            }

            DB::commit();

            $receipt->load(['customer', 'products']);

            return response()->json([
                'success' => true,
                'message' => 'Receipt created successfully',
                'data' => $receipt
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error creating receipt',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified receipt
     */
    public function show($id)
    {
        $receipt = Receipt::with(['customer', 'products'])->find($id);

        if (!$receipt) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $receipt
        ]);
    }

    /**
     * Update the specified receipt
     */
    public function update(Request $request, $id)
    {
        $receipt = Receipt::find($id);

        if (!$receipt) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'issue_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'customer_id' => 'required|exists:customer,id',
            'currency_code' => 'nullable|string|size:3',
            'status' => 'nullable|string|max:20',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:product,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Calculate new totals
            $totalAmount = 0;
            $taxAmount = 0;

            foreach ($request->products as $productData) {
                $product = Product::find($productData['product_id']);
                $lineTotal = $productData['quantity'] * $productData['unit_price'];
                $lineTax = $lineTotal * ($product->tax_rate / 100);

                $totalAmount += $lineTotal;
                $taxAmount += $lineTax;
            }

            // Update receipt
            $receipt->update([
                'issue_date' => $request->issue_date,
                'due_date' => $request->due_date,
                'total_amount' => $totalAmount,
                'tax_amount' => $taxAmount,
                'currency_code' => $request->currency_code ?? 'USD',
                'status' => $request->status ?? 'issued',
                'customer_id' => $request->customer_id,
            ]);

            // Detach old products and attach new ones
            $receipt->products()->detach();

            foreach ($request->products as $productData) {
                $totalPrice = $productData['quantity'] * $productData['unit_price'];

                $receipt->products()->attach($productData['product_id'], [
                    'quantity' => $productData['quantity'],
                    'unit_price' => $productData['unit_price'],
                    'total_price' => $totalPrice,
                ]);
            }

            DB::commit();

            $receipt->load(['customer', 'products']);

            return response()->json([
                'success' => true,
                'message' => 'Receipt updated successfully',
                'data' => $receipt
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error updating receipt',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified receipt
     */
    public function destroy($id)
    {
        $receipt = Receipt::find($id);

        if (!$receipt) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt not found'
            ], 404);
        }

        $receipt->delete();

        return response()->json([
            'success' => true,
            'message' => 'Receipt deleted successfully'
        ]);
    }
}