<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form of `backend\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    public $globalSearch;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'journal_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['contact_name', 'position', 'company', 'contact_emp', 'contact_number', 'contact_detail', 'document_ref'], 'safe'],
            [['globalSearch'],'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Transaction::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'journal_id' => $this->journal_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        // $query->andFilterWhere(['like', 'contact_name', $this->contact_name])
        //     ->andFilterWhere(['like', 'position', $this->position])
        //     ->andFilterWhere(['like', 'company', $this->company])
        //     ->andFilterWhere(['like', 'contact_emp', $this->contact_emp])
        //     ->andFilterWhere(['like', 'contact_number', $this->contact_number])
        //     ->andFilterWhere(['like', 'contact_detail', $this->contact_detail])
        //     ->andFilterWhere(['like', 'document_ref', $this->document_ref]);

        if($this->globalSearch!=''){
             $query->orFilterWhere(['like', 'contact_name', $this->globalSearch])
                    ->orFilterWhere(['like', 'position', $this->globalSearch])
                    ->orFilterWhere(['like', 'company', $this->globalSearch])
                    ->orFilterWhere(['like', 'contact_emp', $this->globalSearch])
                    ->orFilterWhere(['like', 'contact_number', $this->globalSearch])
                    ->orFilterWhere(['like', 'contact_detail', $this->globalSearch])
                    ->orFilterWhere(['like', 'document_ref', $this->globalSearch]);
        }

        return $dataProvider;
    }
}
