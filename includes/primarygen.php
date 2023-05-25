<div class="card">
    <div class="card-body">
        <select class="form-select mb-3" aria-label="Default select example" name="location">
            <option selected="">Локация</option>
            <?php $locs = ['Болото','Город','Горы','Подземье','Арктика','Побережье','Пустыня','Холмы','Луг','Лес',
                'Под водой','ДЕРЕВНЯ','ЗАБРОШЕННАЯ ДОРОГА','КАКАЯ ГАДОСТЬ!'];
            foreach ($locs as $loc) {?>
                <option value="<?=$loc?>"><?=$loc?></option>
            <?php }?>

        </select>
        <?php  $files = glob("../gens/*.*");
        $active = 1;
        foreach ($files as $num=>$filename) {
            $array = explode('/', $filename);
            $name = explode('.',array_pop($array))[0];
            ?>
            <div class="input-group mb-3">
                <button class="btn btn-light js-get-event" type="button" id="<?=md5($filename)?>" data-url="<?=$filename?>"><?=$name?></button>
                <textarea type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="<?=md5($filename)?>"></textarea>
            </div>
        <?php }?>
    </div>
</div>
