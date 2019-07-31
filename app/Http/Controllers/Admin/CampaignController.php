<?php

namespace App\Http\Controllers\Admin;


use App\CampaignCode;
use App\Repositories\CampaignRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    protected $campaignRepository;
    public function __construct(CampaignRepository $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function index(Request $request)
    {
//        $this->validate($request, [
//            'from_date' => 'date',
//            'to_date' => 'date',
//            'title' => 'string',
//            'page' => 'numeric',
//        ]);
        $page = $request->input('page', 1);
        $items = $this->campaignRepository->getCampaignPagination($request->all(), $page, 10);
        return response()->json([
                'items' => $items,
            ]
        );
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required|max:1000|unique:campaign',
            'prefix' => 'string|max:5',
            'number_codes' => 'integer|required|min:1',
            'value' => 'required|min:1|numeric',
            'from_date' => 'required|date',
            'end_date' => 'required|date',
            'valid_times' => 'required|numeric|min:1',
        ]);
        $data = $request->only('title', 'prefix', 'number_codes', 'value', 'from_date', 'end_date');
        $validTimes = $request->input('valid_times', 1);
        $status = $this->campaignRepository->createCampaign($data, $validTimes, Auth::user());
        return response()->json([
            'status' => $status,
        ]);
    }

    public function codes(Request $request, $id)
    {
        $campaign = $this->campaignRepository->getCampaign($id);
        if (!$campaign) {
            abort(404);
        }

        $page = $request->input('page', 1);
        $options = $request->all();
        $options['campaign_id'] = $id;
        $items = $this->campaignRepository->getCodePagination($options, $page, 10);
        return response()->json([
                'items' => $items,
                'campaign' => $campaign,
                'page' => $page,
            ]
        );
    }

    public function cancelCode(Request $request, $id)
    {
        $code = $this->campaignRepository->getCode($id);
        if (!$code) {
            abort(404);
        }

        $status = $this->campaignRepository->updateCode($code, [
            'status' => CampaignCode::STATUS_CANCEL,
        ]);
        return response()->json([
                'status' => $status,
            ]
        );
    }

    public function cancelCampaign(Request $request, $id)
    {
        $isReactive = $request->input('reactive', false);
        $campaign = $this->campaignRepository->getCampaign($id);
        if (!$campaign) {
            abort(404);
        }

        $status = $this->campaignRepository->updateCampaignStatus($campaign, $isReactive);
        return response()->json([
                'status' => $status,
            ]
        );
    }

}