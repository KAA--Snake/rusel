<?php

namespace common\modules\catalog\models\mongo;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\mongo\Product;

/**
 * SectionSearch represents the model behind the search form about `common\modules\catalog\models\Section`.
 */
class ProductSearch extends Product
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id', 'name','code','artikul'], 'integer'],
            [['_id','id','name','code','artikul', 'status'], 'safe'],
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

        $query = Product::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        /*$query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'section_id' => $this->section_id,
            'status' => $this->status,
            'artikul' => $this->artikul,
        ]);*/
        /*$query->andFilterWhere([
            'id' => $this->id
        ]);*/

        $query->andFilterWhere(['like', 'name', $this->name])
            //->andFilterWhere(['like', 'section_id', $this->section_id])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'artikul', $this->artikul])
            ->andFilterWhere(['like', 'id', $this->id]);
            //->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
}
