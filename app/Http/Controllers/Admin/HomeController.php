<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\SettingRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PostRepository;
use App\Repositories\LogRepository;
use Carbon\Carbon;
use App\Lib\IImage;

class HomeController extends Controller
{
    protected $userRepo;
    protected $settingRepo;
    protected $catRepo;
    protected $productRepo;
    protected $postRepo;
    protected $logRepo;

    function __construct(
        UserRepository $userRepo,
        SettingRepository $settingRepo,
        CategoryRepository $catRepo,
        ProductRepository $productRepo,
        LogRepository $logRepo,
        PostRepository $postRepo
    ) {
        $this->middleware('auth:api');

        $this->userRepo = $userRepo;
        $this->settingRepo = $settingRepo;
        $this->catRepo = $catRepo;
        $this->productRepo = $productRepo;
        $this->postRepo = $postRepo;
        $this->logRepo = $logRepo;
    }

    public function stats(Request $request)
    {
        $dateFrom = new Carbon($request->dateFrom);
        $dateTo = new Carbon($request->dateTo);
        $type = $request->input('type', 'date');

        $byRange = [
            'user' => [],
            'product' => [],
            'post' => []
        ];

        $from = $dateFrom->copy();
        $to = $dateTo->copy();

        while ($dateTo->greaterThanOrEqualTo($dateFrom)) {
            $from = $dateFrom->copy()->startOfDay();
            if ($type == 'date') {
                $key = $from->toDateString();
                $to = $from->copy()->endOfDay();
            } else if ($type == 'week') {
                $to = $from->copy()->endOfWeek();
                $key = $to->weekOfYear . '-' . $to->year;
            } else if ($type == 'month') {
                $key = $from->month . '-' . $from->year;
                $to = $from->copy()->endOfMonth();
            } else {
                break;
            }

            $byRange['product'][$key] = $this->productRepo->countByRange($from, $to);
            $byRange['user'][$key] = $this->userRepo->countByRange($from, $to);
            $byRange['post'][$key] = $this->postRepo->countByRange($from, $to);

            if ($type == 'date') {
                $dateFrom->addDay();
            } else if ($type == 'week') {
                $dateFrom->addWeek();
            } else if ($type == 'month') {
                $dateFrom->addMonth();
            } else {
                break;
            }
        }
        // dd($byRange);

        $stats = [
            'count_user' => $this->userRepo->count(),
            'count_product' => $this->productRepo->count(),
            'count_post' => $this->postRepo->count(),
            'last7days' => $byRange,
        ];

        return response()->json([
            'stats' => $stats,
        ]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');

        if (!$file->isValid()) {
            return response()->json([
                'success' => false,
            ]);
        }

        $originalName = $file->getClientOriginalName();

        $folder = $request->input('folder', '');
        if (!in_array($folder, ['posts', 'products', 'banners', 'brands'])) {
            return response()->json([
                'success' => false,
                'errors' => ['invalid folder'],
            ]);
        }

        if (strtolower($file->getClientOriginalExtension()) == 'gif') {
            $data = IImage::uploadGIF($file, $folder);
            return response()->json([
                'success' => true,
                'file' => [
                    'filename' => $data['filename'],
                    'original' => $originalName,
                    'url' => $data['url'],
                ],
            ]);
        }

        $data = IImage::upload($file, $folder);

        return response()->json([
            'success' => true,
            'file' => [
                'filename' => $data['filename'],
                'original' => $originalName,
                'url' => $data['url'],
            ],
        ]);
    }

    public function productData()
    {
        $categories = $this->catRepo->allByOrder();
        return response()->json([
            'product' => config('product'),
            'category' => $categories,
        ])->withHeaders([
            'Cache-Control' => 'max-age=8640'
        ]);
    }

    public function logs()
    {
        $user = auth('api')->user();
        if (!$user->can('view log')) {
            return response()->json(['errors' => ['unauthorized']]);
        }

        $logs = $this->logRepo->paginate(30);

        return response()->json($logs);
    }
}
