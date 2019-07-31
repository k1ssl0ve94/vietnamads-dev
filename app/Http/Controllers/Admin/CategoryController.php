<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\ClassCategory;
use App\Validators\RegexRuleCommon;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{

    protected $catRepo;

    function __construct(CategoryRepository $catRepo)
    {
        $this->middleware('auth:api');

        $this->catRepo = $catRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params = request()->only('keyword', 'parent_id');
        $cats = $this->catRepo->paginate2($params, 20);

        return response()->json($cats);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'parent_id' => 'integer|in:1,2,3,4,5,6|required',
            'name' => 'required|string|min:1|max:500',
            'slug' => 'required|string|min:1|max:500|unique:categories',
            'name_en' => 'string|min:1|max:500',
            'slug_en' => 'string|min:1|max:500|unique:categories',
            'description' => 'string',
            'content' => 'string',
            'meta_title' => 'string',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'meta_canonical' => 'string',
        ]);
        $data = $request->only('name', 'name_en', 'slug', 'slug_en', 'description','content',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'parent_id'
        );
        $this->catRepo->add($data);
        return response()->json(['status' => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        //
        //
        $data = $request->all();
        $this->validate($request, [
            'parent_id' => 'integer|in:1,2,3,4,5,6|required',
            'name' => 'required|string|min:1|max:500',
            'slug' => 'regex:'.RegexRuleCommon::REGEX_SLUG.'|'
                .'required|string|min:1|max:500|unique:categories,slug,'.$category->id,
            'name_en' => 'string|min:1|max:500',
            'slug_en' => 'regex:'.RegexRuleCommon::REGEX_SLUG.'|'
                .'string|min:1|max:500|unique:categories,slug_en,'.$category->id,
            'description' => 'string',
            'content' => 'string', 
            'meta_title' => '',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'meta_canonical' => 'string',
        ]);
        $data = $request->only('name', 'name_en', 'slug', 'slug_en', 'description','content',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'parent_id'
        );
        $this->catRepo->update($category, $data);
        return response()->json(['status' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    public function classCategory(Request $request)
    {
        $page = $request->input('page', 1);
        $items = $this->catRepo->getClassCategoryPagination([
            'keyword' => $request->input('keyword'),
            'category_id' => $request->input('category_id'),
            'sub_category_id' => $request->input('sub_category_id'),
            'status' => $request->input('status'),
            'type' => $request->input('type'),
        ], $page, 10);

        return response()->json($items);
    }

    public function createClassCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'category_id' => 'required|integer',
            'contact_name' => 'string',
            'contact_mobile' => 'string',
            'type' => 'required|in:1,2',
            'productIds' => 'array',
            'meta_title' => '',
            'meta_description' => 'string',
            'meta_keywords' => 'string',
            'meta_canonical' => 'string',
            'description' => 'string',   

        ]);
        $data = $request->only('type', 'name',
            'contact_name', 'contact_mobile', 'category_id' , 'sub_category_id', 'status', 'productIds',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'description'
        );
//        $data['status'] = ClassCategory::STATUS_ACTIVE;
        list ($status, $message) = $this->catRepo->addClassCategory($data);
        return response()->json([
           'status' => $status,
           'message' => $message,
        ]);
    }

    public function updateClassCategory(Request $request)
    {

        $this->validate($request, [
            'name' => 'string|required',
            'category_id' => 'required|integer',
            'contact_name' => 'string',
            'contact_mobile' => 'string',
            'type' => 'required|in:1,2',
            'id' => 'integer|required|exists:class_categories',
            'productIds' => 'array',
           'meta_title' => 'string',
           'meta_description' => 'string',
           'meta_keywords' => 'string',
           'meta_canonical' => 'string',
            'description' => 'string',
        ]);
        $id = $request->input('id');
        $classCate = $this->catRepo->getClassCategoryById($id);
        $data = $request->only('type', 'name', 'id',
            'contact_name', 'contact_mobile', 'category_id' , 'sub_category_id', 'status', 'productIds',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_canonical', 'description'
        );
        list ($status, $message) = $this->catRepo->updateClassCategory($data, $classCate);
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function classCategoryDetail(Request $request, $id)
    {
        $classCategory = $this->catRepo->getClassCategoryById($id, true);
        return response()->json($classCategory);
    }
}
