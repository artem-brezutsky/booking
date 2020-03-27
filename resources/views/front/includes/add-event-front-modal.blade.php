<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Добавить событие</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-body-inner">
                <div class="form-group">
                    <label for="event-title" class="event-title">Заголовок события</label>
                    <input class="form-control" type="text" name="event-title" id="event-title"/>
                </div>
                <div class="form-group">
                    <label for="textarea-comment">Комментарий</label>
                    <textarea class="form-control" cols="30" id="textarea-comment" name="comment" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <div class="checkbox-group">
                        <div class="confirm-checkbox">
                            <label for="event-checkbox">Повторять событие?</label><input type="checkbox" name="event-checkbox-repeater" id="event-checkbox">
                        </div>
                        <div class="slide-chb">
                            <div class="repeater-checkbox">
                                <div class="weekday"><label for="mon">Пн.</label><input class="weekCheck" type="checkbox" data-weekday="1" name="monday-box[]" id="mon" value="1"></div>
                                <div class="weekday"><label for="tue">Вт.</label><input class="weekCheck" type="checkbox" data-weekday="2" name="monday-box[]" id="tue" value="2"></div>
                                <div class="weekday"><label for="wed">Ср.</label><input class="weekCheck" type="checkbox" data-weekday="3" name="monday-box[]" id="wed" value="3"></div>
                                <div class="weekday"><label for="thu">Чт.</label><input class="weekCheck" type="checkbox" data-weekday="4" name="monday-box[]" id="thu" value="4"></div>
                                <div class="weekday"><label for="fri">Пт.</label><input class="weekCheck" type="checkbox" data-weekday="5" name="monday-box[]" id="fri" value="5"></div>
                                <div class="weekday"><label for="sat">Сб.</label><input class="weekCheck" type="checkbox" data-weekday="6" name="monday-box[]" id="sat" value="6"></div>
                                <div class="weekday"><label for="sun">Вс.</label><input class="weekCheck" type="checkbox" data-weekday="0" name="monday-box[]" id="sun" value="0"></div>
                            </div>
                            <div class="date-picker">
                                <label>Дата: <input type="text" id="datepicker" autocomplete="off"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox-group mail">
                        <div class="confirm-checkbox">
                            <label for="mail-checkbox">Отправить на почту?</label><input type="checkbox" name="mail-checkbox" id="mail-checkbox" >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="submitForm btn btn-success">Добавить</button>
        </div>
    </div>
</div>