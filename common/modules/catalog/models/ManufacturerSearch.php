<?php

namespace common\modules\catalog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\catalog\models\Manufacturer;


/**
 * SectionSearch represents the model behind the search form about `common\modules\catalog\models\Manufacturer`.
 */
class ManufacturerSearch extends Manufacturer
{
    /**
     * @inheritdoc
     */
   /* public function rules()
    {
        return [
            [['id', 'm_id'], 'integer'],
            [['m_name', 'm_id'], 'safe'],
        ];
    }*/

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
        $query = Manufacturer::find();

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
            'm_id' => $this->m_id,
            'm_name' => $this->m_name,

        ]);

        /*$query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'preview_text', $this->preview_text])
            ->andFilterWhere(['like', 'detail_text', $this->detail_text])
            ->andFilterWhere(['like', 'picture', $this->picture]);*/

        return $dataProvider;
    }
}
