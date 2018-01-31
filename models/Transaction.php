<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Transaction extends ActiveRecord{

    public function rules()
	{
	    return [
            [['balans'], 'required'],
	    ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function changeStatus($currentTransactions)
    {
        foreach($currentTransactions as $currentTransaction){
            $currentTransaction->status = 'pending';
            $currentTransaction->save();   
        }
    }

    public function addBalans($user_id)
    {
        $this->user_id = $user_id;   
        $this->status = 'new';
        $this->save();  
    }

    public function changeStatusSuccesed(){
        foreach ($transactions as $transaction){
            $transaction->status = 'succesed';
            $transaction->save();
        }
    }
}