<div class="card">
    <div class="card-body">
        Текущее время: <span class="js-now-time"></span>
        <div class="input-group">
            <input type="number" class="form-control" value="0" id="party-time">
            <select class="form-select" id="unit-time" aria-label="Example select with button addon">
                <option selected="">Choose...</option>
                <option value="minutes">minutes</option>
                <option value="hours">hours</option>
                <option value="days">days</option>
            </select>
            <button class="btn btn-light" type="button" onclick="addTime()">Добавить</button>
        </div>
        <div class="js-events-all"></div>
    </div>
</div>
<script>
    function addTime() {
        const time = $('#party-time').val();
        const unit = $('#unit-time').val();

        $.ajax({
            url: '../api/',
            data: {
                time: time,
                unit: unit,
                type: 'time'
            },
            contentType: 'application/json',
            dataType: 'json',
            success: function(data) {
                $('.js-now-time').text(data.currentDateTime)

                $('.js-events-all').html('');
                for (const [key, value] of Object.entries(data.eventTypes)) {
                    $('.js-events-all').append(`<span>${key}: ${value}</span><br>`);
                }


                console.log(data.eventTypes)
            },
            error: function(error) {
                console.log(error);
            }
        });
    };

    document.addEventListener('DOMContentLoaded', function(){
        addTime();
    })
</script>