<div class="jumbotron">
    <h3>Графики</h3>
    <div class="jumbotron" style="max-width: 100%; margin: auto;">
        <div class="form-group" >
            <div style="display:inline-block;">
                <select class="form-control select-stats" id="selectbank">
                    <!-- Загнать каждый элемент массива banks в переменуню bank, несколько раз-->
                    <?php foreach($banks as $bank) { ?>
                    <option value="<?=$bank['id']?>" <?php if ($id_bank_select == $bank['id']) echo "selected"; ?>><?=htmlspecialchars($bank['name'])?></option>
                    <?php } ?>
                </select>
            </div>
            <div style="display:inline-block;" class="divbuttonstats">
                <button type="submit" class="btn btn-default" onclick="banksstats('day')">За сутки</button>
            </div>
            <div style="display:inline-block;" class="divbuttonstats">
                <button type="submit" class="btn btn-default" onclick="banksstats('week')">За неделю</button>
            </div>
            <div style="display:inline-block;" class="divbuttonstats">
                <button type="submit" class="btn btn-default" onclick="banksstats('month')">За месяц</button>
            </div>
        </div>
        <div id="usd"></div>
        <script>
            var chart = c3.generate({
                bindto: '#usd',
                data:
            <?php
                echo json_encode(array(
                'x' => 'x',
                'xFormat' => '%d.%m.%Y %H:%M:%S',
                'columns' => array(
                $time_arr, $usd_buy_arr, $usd_sell_arr
            )
            )); ?>
            ,
            axis: {
                x: {
                    type: 'timeseries',
                        tick: {
                        format: '%d.%m %H:%M'
                    }
                }
            }
            });
        </script>

        <div id="eur"></div>
        <script>
            var chart = c3.generate({
                bindto: '#eur',
                data:
            <?php
                echo json_encode(array(
                'x' => 'x',
                'xFormat' => '%d.%m.%Y %H:%M:%S',
                'columns' => array(
                $time_arr, $eur_buy_arr, $eur_sell_arr
            )
            )); ?>
            ,
            axis: {
                x: {
                    type: 'timeseries',
                        tick: {
                        format: '%d.%m %H:%M'
                    }
                }
            }
            });
        </script>

        <div id="rub"></div>
        <script>
            var chart = c3.generate({
                bindto: '#rub',
                data:
            <?php
                echo json_encode(array(
                'x' => 'x',
                'xFormat' => '%d.%m.%Y %H:%M:%S',
                'columns' => array(
                $time_arr, $rub_buy_arr, $rub_sell_arr
            )
            )); ?>
            ,
            axis: {
                x: {
                    type: 'timeseries',
                        tick: {
                        format: '%d.%m %H:%M'
                    }
                }
            }
            });
        </script>
    </div>
</div>