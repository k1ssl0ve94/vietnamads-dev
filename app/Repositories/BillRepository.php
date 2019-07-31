<?php

namespace App\Repositories;


use App\Bill;
use App\DayOption;
use App\Product;
use App\Service;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BillRepository
{
    public function getById($id)
    {
        return Bill::find($id);
    }
    public function addBill($data, $user = null)
    {
        $bill = new Bill();
        $bill->fill($data);
        if ($user) {
            $bill->created_by = $user->id;
        }
        $bill->save();
        return $bill;
    }

    /**
     * @param $product Product
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
     */
    public function isAddBill($product)
    {
        $bill = Bill::query()->where('product_id', $product->id)
            ->whereDate('from', $product->from->format('Y-m-d'))
            ->whereDate('to', $product->to->format('Y-m-d'))
            ->where('service_id', $product->level)
            ->where('option_id', $product->package_option)
            ->orderBy('id', 'desc')
            ->first();
        return $bill;
    }

    /**
     * @param $bill Bill
     * @param null $user
     * @return mixed
     */
    public function addRefundFrom($bill, $user = null)
    {
        $refundBill = clone $bill;
        $refundBill->id = null;
        $refundBill->type = Bill::TYPE_ADD;
        $refundBill->mode = $bill->mode;
        $refundBill->date = Carbon::now()->format('Y-m-d');
        $refundBill->created_by = $user ? $user->id : null;
        $refundBill->status = Bill::STATUS_DONE;
        return $refundBill->save();
    }

    public function getPagination($condition = [], $npp = 10,$page = 1)
    {
        $query = Bill::query();
        if (isset($condition['id']) && $condition['id']){
            $query->where('bills.id', $condition['id']);
        }
        if (isset($condition['user_id']) && $condition['user_id']){
            $query->where('bills.user_id', $condition['user_id']);
        }
        if (isset($condition['product_id']) && $condition['product_id']){
            $query->where('bills.product_id', $condition['product_id']);
        }
        if (isset($condition['service_id']) && $condition['service_id']){
            $query->where('bills.service_id', $condition['service_id']);
        }
        if (isset($condition['option_id']) && $condition['option_id']){
            $query->where('bills.option_id', $condition['option_id']);
        }
        if (isset($condition['type']) && $condition['type']){
            $query->where('bills.type', $condition['type']);
        }
        if (isset($condition['mode']) && $condition['mode']){
            $query->where('bills.mode', $condition['mode']);
        }
        if (isset($condition['status']) && $condition['status']){
            $query->where('bills.status', $condition['status']);
        }
        if (isset($condition['from_date']) && $condition['from_date']){
            $query->whereDate('bills.date', '>=', $condition['from_date']);
        }
        if (isset($condition['to_date']) && $condition['to_date']){
            $query->whereDate('bills.date', '<=', $condition['to_date']);
        }
        if (isset($condition['note']) && $condition['note']){
            $query->where('bills.note', 'LIKE',"%{$condition['note']}%");
        }
        if (isset($condition['user_email']) && $condition['user_email']){
            $userIds = User::query()->where('email', $condition['user_email'])->pluck('id')->toArray();
            if (count($userIds)) {
                $query->whereIn('bills.user_id', $userIds);
            } else {
                $query->whereRaw('1 = 2');
            }
        }
        if(!empty($condition['user_level']) || !empty($condition['user_type'])) {
            $query->join('users', 'users.id', '=', 'bills.user_id');
            if (!empty($condition['user_level'])) {
                $query->where('users.level', $condition['user_level']);
            }
            if (!empty($condition['user_type'])) {
                $query->where('users.type', $condition['user_type']);
            }
        }
        $query->orderBy('bills.id', 'desc');

        $items = $query->paginate($npp, ['bills.*'], 'page', $page);
        $userIds = [];
        $productIds = [];
        $serviceIds = [];
        $optionIds = [];
        foreach ($items as $item){
            $userIds[$item->user_id] = $item->user_id;
            if ($item->created_by) {
                $userIds[$item->created_by] = $item->created_by;
            }
            if ($item->updated_by) {
                $userIds[$item->updated_by] = $item->updated_by;
            }
            if ($item->product_id) {
                $productIds[$item->product_id] = $item->product_id;
            }
            if ($item->service_id) {
                $serviceIds[$item->service_id] = $item->service_id;
            }
            if ($item->option_id) {
                $optionIds[$item->option_id] = $item->option_id;
            }
        }
        $userArray = [];
        $productArray = [];
        $serviceArray = [];
        $optionArray = [];
        if (count($userIds)) {
//            $userArray = User::query()->whereIn('id', $userIds)
//                ->selectRaw(DB::raw("CONCAT(name, ' - ', email) as name, id"))
//                ->pluck('name', 'id')->toArray();
            $userList = User::query()->whereIn('id', $userIds)->get();
            if ($userList) {
                foreach ($userList as $u) {
                    $userArray[$u->id] = $u;
                }
            }
        }
        if (count($productIds)) {
            $productArray = Product::query()->whereIn('id', $productIds)
                ->pluck('title', 'id')->toArray();
        }
        if (count($serviceIds)) {
            $serviceArray = Service::query()->whereIn('id', $serviceIds)
                ->pluck('name', 'id')->toArray();
        }
        if (count($optionIds)) {
            $optionArray = DayOption::query()->whereIn('id', $optionIds)
                ->pluck('name', 'id')->toArray();
        }
        foreach ($items as $item){
            if ($item->user_id && isset($userArray[$item->user_id])) {
                $item->user = $userArray[$item->user_id];
            }
            if ($item->created_by && isset($userArray[$item->created_by])) {
                $item->createdByUser = $userArray[$item->created_by];
            }
            if ($item->updated_by && isset($userArray[$item->updated_by])) {
                $item->updatedByUser = $userArray[$item->updated_by];
            }
            if ($item->product_id && isset($productArray[$item->product_id])) {
                $item->product = $productArray[$item->product_id];
            }
            if ($item->service_id && isset($serviceArray[$item->service_id])) {
                $item->service = $serviceArray[$item->service_id];
            }
            if ($item->option_id && isset($optionArray[$item->option_id])) {
                $item->option = $optionArray[$item->option_id];
            }
        }
        return $items;
    }

    /**
     * @param $bill Bill
     * @param $data array
     * @return bool
     */
    public function update($bill, $data)
    {
        if ($bill && count($data)) {
            $bill->fill($data);
            return $bill->save();
        }
        return false;
    }
}