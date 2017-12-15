<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.12.17
 * Time: 15:32
 */

namespace common\modules\catalog\models\search\searches\byFiles;

use Yii;

use PHPExcel_IOFactory;

class XlsxSearch extends BaseFileSearch
{

    /**
     * Возвращает список найденных товаров
     * @return array
     */
    public function search(): array
    {
        $xls = PHPExcel_IOFactory::load($this->filePath);
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();

        $rowIterator = $sheet->getRowIterator();
        foreach ($rowIterator as $row) {
            // Получили ячейки текущей строки и обойдем их в цикле
            $cellIterator = $row->getCellIterator();

            foreach ($cellIterator as $cell) {

                $artikle = $cell->getCalculatedValue();

                $artikle = trim($artikle);
                $artikle = str_replace("\r\n", "", $artikle);
                $artikle = str_replace("\n", "", $artikle);

                //проверка на минимальную(максимальную) длину артикула
                if(!$this->_isLengthIsGood($artikle)) continue;

                if(!empty($artikle)){
                    $this->productArticles[] = $artikle;
                }
            }
        }

        return $this->getProducts();
    }
}