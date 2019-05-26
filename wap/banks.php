<?php
# Отсылаем заголовок который "обьясняет" клиенту ,что это wml документ 
header("Content-type: text/vnd.wap.wml");
#Выводим саму страницу
print  '<?xml version="1.0" encoding="UTF-8"?> 
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">';
?>
<?php
$arr_banks = file_get_contents("../js/table.json");
$arr_banks = json_decode($arr_banks, true);

usort($arr_banks, function($a, $b) {
    return $a['name'] > $b['name'];
});
?>
<wml>
    <template>
        <do type="prev" label="Назад">
            <prev/>
        </do>
    </template>
    <card id="bank-select" title="Показать курс в банке">
        <do type="reset" label="Clear">
            <refresh>
                <setvar name="svar" value=""/>
            </refresh>
        </do>
        <p>Выберите банк:
            <select name="svar" title="Сделайте выбор">
<?php foreach ($arr_banks as $bank) { ?>
<option value="item-<?= $bank['id'] ?>" onpick="bank.wml?bank=<?= $bank['id'] ?>"><?= htmlspecialchars(str_replace('№', '', $bank['name'])) ?></option>
<?php } ?>
            </select>
        </p>
    </card>
</wml>
