<?//\Yii::$app->pr->print_r2($oneProduct); die();?>

<?if(isset($oneProduct['other_properties']['property']['name'])){?>
    <tr>
        <td class="param_name"><?= $oneProduct['other_properties']['property']['name']; ?></td>
        <td class="param_value"><?= $oneProduct['other_properties']['property']['value']; ?></td>
    </tr>

<?}else{?>
    <?php foreach($oneProduct['other_properties']['property'] as $singleProp){ ?>
        <tr>
            <td class="param_name"><?= $singleProp['name']; ?></td>
            <td class="param_value"><?= $singleProp['value']; ?></td>
        </tr>
    <?php }?>
<?}?>




