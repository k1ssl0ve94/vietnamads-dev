<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Repositories\BrandRepository;

class BrandController extends Controller
{
    protected $brandRepo;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->middleware('auth:api');
        $this->brandRepo = $brandRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = $this->brandRepo->all();
        return response()->json([
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required',
        ]);

        $data = $request->only('name', 'logo', 'url');

        if ($brand = $this->brandRepo->add($data)) {
            return [
                'status' => 1,
                'brand' => $brand,
            ];
        }

        return ['status' => 0];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        $this->brandRepo->delete($brand);
        return ['status' => 1];
    }

    public function updateOrder(Request $request)
    {
        $data = $request->all();
        foreach ($data as $row) {
            $brand = $this->brandRepo->getById($row['id']);
            if ($brand) {
                $this->brandRepo->update($brand, ['order' => intval($row['order'])]);
            }
        }
        return ['status' => 1];
    }
}
