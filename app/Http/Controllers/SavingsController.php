<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Income;
use \App\Update_history;
use \App\Monthly_payment;
use \App\Year_payment;
use \App\Income_and_expenditure;
use \App\Category;

class SavingsController extends Controller
{
    // 全データ取得処理
    public function getAll(){
        $where = [
            'is_deleted' => 0,
        ];
        $columns = [
            'id',
            'item',
            'price',
            'remark'
         ];
        $income = Category::find(1)
            ->Income_and_expenditures()
            ->where($where)
            ->get($columns);
        $monthly_payment = Category::find(2)
            ->Income_and_expenditures()
            ->where($where)
            ->get($columns);
        $year_payment = Category::find(3)
            ->Income_and_expenditures()
            ->where($where)
            ->get($columns);
        return array($income, $monthly_payment, $year_payment);

    }

    // 登録処理
    public function store(Request $request){
        $store = new Income_and_expenditure;
        $store->item = $request->item;
        $store->price = $request->price;
        $store->remark = $request->remark;
        $store->category_id = $request->category_id;
        $store->save();

    }

    // 更新処理
    public function update(Request $request){
        $target = Income_and_expenditure::find($request->id);
        $target->item = $request->item;
        $target->price = $request->price;
        $target->remark = $request->remark;
        $target->save();
    }

    // 削除処理(論理削除)
    public function delete($id){
        $target = Income_and_expenditure::find($id);
        $target->is_deleted = True;
        $target->save();
        return 'OK!';
    }
}