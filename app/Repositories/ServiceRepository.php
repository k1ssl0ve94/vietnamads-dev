<?php

namespace App\Repositories;


use App\DayOption;
use App\Product;
use App\Service;
use App\ServiceOption;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ServiceRepository
{
    public function getOptionById($id)
    {
        return DayOption::find($id);
    }

    public function add($data, $user = null)
    {
        if (isset($data['id']) && $data['id']) {
            $item = Service::find($data['id']);
            if (!$item) {
                return false;
            }
        } else {
            $item = new Service();
        }
        $item->fill($data);
        if (!$item->id) {
            $item->created_by = $user ? $user->id : null;
        } else {
            $item->updated_by = $user ? $user->id : null;
        }
        $item->min_days = 0; // @TODO add default min day
        $item->icon = $item->icon ? 1 : null;
        $item->save();
        // Update all product color and fee with service
        Product::query()->where('level', $item->id)
            ->update([
                'title_color' => $item->title_color,
                'parameter_color' => $item->parameter_color,
                'price_color' => $item->price_color,
                'icon' => $item->icon,
                'manual_refresh' => $item->manual_refresh,
                'auto_refresh' => $item->auto_refresh,
                'refresh_fee' => $item->refresh_fee,
                'backup_time' => $item->backup_time,
                'allow_sms' => $item->allow_sms,
                'images_number' => $item->images_number,
                'allow_promotion' => $item->allow_promotion,
                'allow_send_author' => $item->allow_send_author,
                'icon' => $item->icon ? 1 : 0,
            ]);
        if ($data['options'] && count($data['options'])) {
            foreach ($data['options'] as $optionId) {
                $itemOption = ServiceOption::where('service_id', $item->id)
                    ->where('option_id', $optionId)->first();
                if (!$itemOption) {
                    $itemOption = new ServiceOption();
                    $itemOption->fill([
                        'service_id' => $item->id,
                        'option_id' => $optionId,
                    ]);
                    $itemOption->save();
                }
            }
            //
            ServiceOption::where('service_id', $item->id)
                ->whereNotIn('option_id', $data['options'])->delete();
        } else {
            ServiceOption::where('service_id', $item->id)->delete();
        }
        return $item->id;
    }

    public function getAllServicePackages($isAddProduct = false, $user = null)
    {
        $builder = Service::query();
        if ($isAddProduct) {
            if (!$user || $user->group != config('user.group.backend')) {
                if (!$user || $user->level != User::LEVEL_VIP) {
                    $builder->where('vip_only', '<>', 1);
                }
            }
        }
        $items = $builder->orderBy('priority', 'desc')->get();
        $serviceOptions = ServiceOption::join('day_options', 'service_options.option_id', 'day_options.id')
            ->orderBy('day_options.days', 'desc')
            ->get();
        $serviceOptionArray = [];
        if ($serviceOptions) {
            foreach ($serviceOptions as $serviceOption) {
                if (!isset($serviceOptionArray[$serviceOption->service_id])) {
                    $serviceOptionArray[$serviceOption->service_id] = [];
                }
                $serviceOptionArray[$serviceOption->service_id][] = $serviceOption;
            }
        }
        foreach ($items as $item) {
            if (isset($serviceOptionArray[$item->id])) {
                $item->options = $serviceOptionArray[$item->id];
                foreach ($item->options as $option){
                    $option->totalFee = number_format($option->days * $item->fee_point);
                }
            }
        }
        return $items;
    }

    public function getDetail($id)
    {
        $item = Service::find($id);
        if (!$item) {
            return null;
        }
        $serviceOptions = ServiceOption::where('service_id', $id)
            ->pluck('option_id')->toArray();
        $item->options = $serviceOptions;
        return $item;
    }

    public function getAllOptions()
    {
        return DayOption::orderBy('days', 'acs')->get();
    }

    public function getOptionOfService($serviceId)
    {
        return ServiceOption::join('day_options')
            ->on('day_options.id', '=', 'service_options.option_id')
            ->where('service_options.service_id', $serviceId)
            ->groupBy(['day_options.*'])
            ->select(['day_options.*'])->get();
    }

    public function addDayOption($data)
    {
        $option = DayOption::where('name', $data['name'])->first();
        if ($option) {
            return false;
        }
        $option = new DayOption();
        $option->fill($data);
        return $option->save();
    }

    /**
     * @param $option DayOption
     * @param $data
     * @return bool
     */
    public function updateDayOption($option, $data)
    {
        $isExisted = DayOption::where('name', $data['name'])
            ->where('id', '<>', $option->id)
            ->first();
        if ($isExisted) {
            return false;
        }
        $option->fill($data);
        return $option->save();
    }

    /**
     * @param $option DayOption
     * @return bool|null
     * @throws \Exception
     */
    public function removeDayOption($option)
    {
        return $option->delete();
    }

    /**
     * @param $item Service
     * @return bool|null
     * @throws \Exception
     */
    public function remove($item)
    {
        ServiceOption::where('service_id', $item->id)->delete();
        return $item->delete();
    }

    public function prepareDataForProductAndBill($serviceId, $optionId, $user)
    {
        $service = Service::find($serviceId);
        $option = DayOption::find($optionId);
        if (!$service || !$option || !$user) {
            return [false, 'Gói dịch vụ/ lựa chọn không hợp lệ. 1', 0];
        }
        $isAllowVip = $user->group == config('user.group.backend') ||
            $user->level == User::LEVEL_VIP ? true : false;
        if (!$isAllowVip && $service->vip_only) {
            return [false, 'Gói dịch vụ chỉ dành cho tài khoản VIP.', 0];
        }
        // Check day option
        $isValidOption = ServiceOption::where('service_id', $serviceId)
            ->where('option_id',$optionId)->first();
        if (!$isValidOption) {
            return [false, 'Lựa chọn không hợp lệ. 2', 0];
        }
        // Calculate fee
        $fee = $option->days * $service->fee_point;
        $promotionPoint = 0;
        $point = $fee;
        $userRemainPoint = $user->remain_point + (
            $service->allow_promotion ? $user->promotion_point : 0
            );
        if ($service->allow_promotion) {
            if ($user->promotion_point >= $fee) {
                $promotionPoint = $fee;
                $point = 0;
            } else {
                $promotionPoint = $user->promotion_point;
                $point -= $promotionPoint;
            }
        }
        if ($fee > $userRemainPoint) {
            return [false, "Bạn không có đủ tiền. Chi phí: ".number_format($fee)
                .", Bạn còn ". number_format($userRemainPoint), 0];
        }
        $toDate = Carbon::now();
        $toDate->addDay($option->days);
        $data = [
            'level' => $serviceId,
            'option_id' => $optionId,
            'active_days' => $option->days,
            'from' => Carbon::now(),
            'to' => $toDate,
            'point' => $point,
            'promotion_point' => $promotionPoint,
            'status' => $service->auto_active ?
                config('product.status.active') : config('product.status.pending'),
            'auto_active' => $service->auto_active,
            'icon' => $service->icon,
            'images_number' => $service->images_number,
            'max_content' => $service->max_content,
            'max_title' => $service->max_title,
            'allow_sms' => $service->allow_sms,
            'allow_promotion' => $service->allow_promotion,
            'allow_management' => $service->allow_management,
            'allow_send_author' => $service->allow_send_author,
            'manual_refresh' => $service->manual_refresh,
            'auto_refresh' => 0, //$service->auto_refresh,
            'backup_time' => $service->backup_time,
            'allow_direct_link' => $service->direct_link,
            'priority' => $service->priority,
            'display_in_search' => $service->display_in_search,
            'display_in_trend' => $service->display_in_trend,
            'display_in_tags' => $service->display_in_tags,
            'refresh_fee' => $service->refresh_fee ? : 0,
            'edit_times' => $service->edit_times,
            'keep_alive' => $service->keep_alive,
            'title_color' => $service->title_color,
            'parameter_color' => $service->parameter_color,
            'price_color' => $service->price_color,
        ];

        return [$data, $service->allow_promotion, $point, $promotionPoint];
    }

    public function isOptionBelongToService($optionId, $serviceId) {
        return ServiceOption::where('service_id', $serviceId)
            ->where('option_id', $optionId)->first();
    }
}