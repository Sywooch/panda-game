<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "invite".
 *
 * @property int $id
 * @property string $fio
 * @property string $email
 * @property string $date_begin
 * @property string $invite_code
 * @property int $status
 * @property int $dcreated
 */
class Invite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['fio', 'email', 'date_begin', 'invite_code'], 'string', 'max' => 255],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '№'),
            'fio' => Yii::t('app', 'Фамилия Имя'),
            'email' => Yii::t('app', 'Email'),
            'date_begin' => Yii::t('app', 'Дата приема на работу'),
            'invite_code' => Yii::t('app', 'Invite Code'),
            'status' => Yii::t('app', 'Status'),
            'dcreated' => Yii::t('app', 'Время создания'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->dcreated = date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function send(){
        $this->invite_code = md5(time().rand(1,9999));
        $this->status = 0;
        $this->dcreated = date('Y-m-d H:i:s');
        $url = Url::toRoute(['employees/confirm-email', 'email' => $this->email, 'token' => $this->invite_code]);
        $flag = Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' (отправлено роботом)'])
            ->setTo($this->email)
            ->setSubject('Приглашения от '.Yii::$app->name)
            ->setHtmlBody('<b>'.$this->fio.'</b> <a href="'.Yii::$app->getRequest()->serverName.$url.'">Перейти по ссылке</a>')
            ->send();
        return $flag;
    }

    /**
     * @inheritdoc
     */
    public function confirmed($invite_id){
        $invite = Invite::findOne($invite_id);
        return
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.' (отправлено роботом)'])
                ->setTo($this->email)
                ->setSubject('Приглашения подтверждено '.Yii::$app->name)
                ->setHtmlBody('<b>'.$invite->fio.'</b>  <a href="'.Yii::$app->getRequest()->serverName.'">Перейти по ссылке</a>')
                ->send();
    }
}
