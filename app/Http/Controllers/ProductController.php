<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use App\Models\User;
use Maatwebsite\Excel\Validators\ValidationException as ExcelValidationException;




class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('product_code', 'like', "%{$search}%")
            ->orWhereHas('user', function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('products.index', compact('products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Fetch all users
        return view('products.create', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|integer',
            'product_code' => 'required|string|max:255|unique:products,product_code',
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'The title field is required.',
            'price.required' => 'The price field is required.',
            'price.integer' => 'The price must be an integer.',
            'product_code.required' => 'The product code field is required.',
            'product_code.unique' => 'The product code has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user(); // Get the currently logged-in user

        $up = [
            'title' => $request->title,
            'price' => $request->price,
            'product_code' => $request->product_code,
            'description' => $request->description,
            'user_id' => $user->id, // Use the ID of the logged-in user
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('products')->insert($up);

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'price' => 'required|integer',
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $id,
            'description' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'The title field is required.',
            'price.required' => 'The price field is required.',
            'price.integer' => 'The price must be an integer.',
            'product_code.required' => 'The product code field is required.',
            'product_code.unique' => 'The product code has already been taken.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($id);
        $product->update($request->only(['title', 'price', 'product_code', 'description']));

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('price', 'LIKE', "%{$query}%")
                    ->orWhere('product_code', 'LIKE', "%{$query}%")
                    ->paginate(10);
    
        return view('products.index', compact('products'))->with('query', $query);
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        return Excel::download(new ProductsExport($search), 'products.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));
            return redirect()->route('products.index')->with('success', 'Products imported successfully.');
        } catch (ExcelValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            foreach ($failures as $failure) {
                $errorMessages[] = "Row " . $failure->row() . ": " . implode(", ", $failure->errors());
            }
            return redirect()->route('products.index')->with('error', implode("<br>", $errorMessages));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'An error occurred during import: ' . $e->getMessage());
        }
    }


    
}
