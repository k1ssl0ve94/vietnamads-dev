<?php

namespace App\Repositories;


use App\Campaign;
use App\CampaignCode;
use App\CodeLog;
use Carbon\Carbon;

class CampaignRepository
{

    public function createCampaign($data, $validTimes = 1, $createdBy = null)
    {
        $campaign = new Campaign();
        $campaign->fill($data);
        $campaign->used_codes = 0;
        $campaign->status = Campaign::STATUS_RUNNING;
        $campaign->created_by = $createdBy ? $createdBy->id : null;
        if($campaign->save()) {
            if ($campaign->number_codes > 0) {
                for ($i = 0; $i < $campaign->number_codes; $i++) {
                    $code = new CampaignCode();
                    $code->fill([
                        'campaign_id' => $campaign->id,
                        'from_date' => $campaign->from_date,
                        'end_date' => $campaign->end_date,
                        'value' => $campaign->value,
                        'code' => $this->generateCode($campaign->prefix),
                        'valid_times' => $validTimes,
                        'used_times' => 0,
                        'status' => CampaignCode::STATUS_RUNNING,
                    ]);
                    $code->save();
                }
            }

            return $campaign->id;
        }
        return false;
    }

    public function generateCode($prefix = '')
    {
        $isGenerate = true;
        do {
            $code =  strtoupper(uniqid($prefix));
            $isExist = CampaignCode::query()->where('code', $code)->first();
            if (!$isExist) {
                $isGenerate = false;
            }
        } while ($isGenerate);
        return $code;
    }

    public function getCampaignPagination($options, $page = 1, $npp = 10)
    {
        $builder = Campaign::query();
        if (isset($options['from_date']) && $options['from_date']) {
            $builder->whereDate('from_date', '>=', $options['from_date']);
        }
        if (isset($options['to_date']) && $options['to_date']) {
            $builder->whereDate('to_date', '<=', $options['to_date']);
        }
        if (isset($options['status']) && $options['status']) {
            $builder->where('status', $options['status']);
        }
        if (isset($options['title']) && $options['title']) {
            $builder->where('title', 'LIKE',"%{$options['title']}%");
        }
        $items = $builder->paginate($npp, ['*'], 'page', $page);

        return $items;
    }

    public function getCodePagination($options, $page = 1, $npp = 10)
    {
        $builder = CampaignCode::query();
        if (isset($options['from_date']) && $options['from_date']) {
            $builder->whereDate('from_date', '>=', $options['from_date']);
        }
        if (isset($options['to_date']) && $options['to_date']) {
            $builder->whereDate('to_date', '<=', $options['to_date']);
        }
        if (isset($options['status']) && $options['status']) {
            $builder->where('status', $options['status']);
        }
        if (isset($options['campaign_id']) && $options['campaign_id']) {
            $builder->where('campaign_id', $options['campaign_id']);
        }
        $items = $builder->paginate($npp, ['*'], 'page', $page);

        return $items;
    }

    public function getCampaign($id)
    {
        return Campaign::find($id);
    }

    public function getCode($id)
    {
        return CampaignCode::find($id);
    }

    public function getByCodeStr($code)
    {
        if (!$code) {
            return false;
        }
        return CampaignCode::query()->where('code', strtoupper($code))->first();
    }

    /**
     * @param $code CampaignCode
     * @param $data array
     * @return bool
     */
    public function updateCode($code, $data)
    {
        $code->fill($data);
        return $code->save();
    }

    /**
     * @param $campaign Campaign
     * @return bool
     */
    public function updateCampaignStatus($campaign, $isReactive = false)
    {
        $campaign->status = $isReactive ? Campaign::STATUS_RUNNING : Campaign::STATUS_CLOSE;
        $campaign->save();
        if (!$isReactive) {
            $conditionStatus = CampaignCode::STATUS_RUNNING;
            $targetStatus = CampaignCode::STATUS_CANCEL;
        } else {
            $conditionStatus = CampaignCode::STATUS_CANCEL;
            $targetStatus = CampaignCode::STATUS_RUNNING;
        }
        CampaignCode::query()
            ->where('campaign_id', $campaign->id)
            ->where('status', $conditionStatus)
            ->update([
                'status' => $targetStatus,
            ]);
        return true;
    }

    public function canUseCode($code, $user) {
        if (!$user || !$code) {
            return false;
        }
        $currentDate = new Carbon();

        if ($currentDate->diffInDays($code->from_date, false) > 0
            || $currentDate->diffInDays($code->end_date, false) < 0) {
            return false;
        }
        $codeLog = CodeLog::query()->where('user_id', $user->id)
            ->where(function($query) use ($code) {
                $query->where('code_id', $code->id)
                    ->orWhere('campaign_id', $code->campaign_id);
            })
            ->first();
        if ($codeLog) {
            return false;
        }
        if ($code->used_times >= $code->valid_times) {
            return false;
        }
        return true;
    }

    public function useCode($code, $user) {
        if (!$user || !$code) {
            return false;
        }
        CampaignCode::query()->where('id', $code->id)
            ->increment('used_times');
        $log = new CodeLog();
        $log->fill([
            'campaign_id' => $code->campaign_id,
            'code_id' => $code->id,
            'user_id' => $user->id,
            'created_by' => auth()->user()->id,
        ]);
        $log->save();
        return true;
    }
}