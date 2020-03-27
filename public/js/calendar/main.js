$(function () {
    // Get the add event Modal
    let modal = document.getElementById("myModal");
    // Get the info event Modal
    let infoModal = document.getElementById("eventInfoModal");
    // Get the <span> element that closes the modal
    let span = document.getElementsByClassName("close")[0];
    // Get the <span> element that closes the info event Modal
    let infoModalSpan = document.getElementsByClassName("closeInfoModal")[0];

    // Чекбокс "Повторющиеся события"
    let recurCheck = $('input[name="event-checkbox-repeater"]');

    let sendMailCheck = $('input[name="mail-checkbox"]');

    // Получаем инпут дейтпикер
    let modalDatepicker = $('#datepicker');

    // modalDatepicker.datepicker();
    // Access instance of plugin
    // modalDatepicker.data('datepicker');

    // Инициализируем дейтпикер
    modalDatepicker.datepicker({
        dateFormat: "dd.mm.yy",
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
        dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
        dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        firstDay: 1,
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        hideModal();
    };
    // When the user clicks on <span> (x), close the event info modal
    infoModalSpan.onclick = function () {
        hideModal();
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        // Add event modal & Info event modal
        if (event.target === modal || event.target === infoModal) {
            hideModal();
        }
    };

    // Скрыть модальное окно добавления события и очистить форму
    function hideModal() {
        // Hide add modal
        $('#myModal').hide();
        // Hide info modal
        $('#eventInfoModal').hide();

        $('#myModal input:text').val('');
        $('#myModal textarea').val('');
        $('#myModal input:checkbox').prop('checked', false).removeAttr('disabled', true).attr('data-check-mail', false);
        $('.slide-chb').slideUp();
    }

    // Проверяем чекбоксы отмеченых дней
    function checkBox() {
        let allValues = [];
        let check = $("input.weekCheck:checked");
        $(check).each(function () {
            allValues.push($(this).val());
        });
        return allValues;
    }

    // Элемент для рендера календаря
    let calendarEl = document.getElementById('calendar');
    // Параметры для рендера календаря
    let paramObj = {
        pageEl: calendarEl,
        plugins: ['dayGrid', 'timeGrid', 'interaction'],
        selectable: true,
        height: 'auto',
        locale: 'ru',
        timeZone: 'UTC',
        fixedWeekCount: true,
        selectOverlap: false,
        header: {
            left: 'title',
            right: 'today prev,next timeGridDay,timeGridWeek,dayGridMonth'
        },
        allDayText: 'Весь день',
        slotDuration: '00:15:00',
        slotLabelInterval: '00:15',
        slotLabelFormat: {
            hour: 'numeric',
            minute: '2-digit'
        },
        buttonText: {
            today: 'Сегодня',
            month: 'Месяц',
            week: 'Неделя',
            day: 'День',
            list: 'Список'
        },
        defaultView: 'timeGridWeek',
        scrollTime: '00:00:00',
        firstDay: 1,
        //Url в роуте
        events: 'events/load?studio_id=' + studio_id,
        // events: [
        //     {
        //         title: 'BCH237',
        //         start: '2019-12-02T10:30:00',
        //         end: '2019-12-02T11:30:00',
        //         extendedProps: {
        //             department: 'BioChemistry'
        //         },
        //         description: 'Lecture'
        //     },],
        eventColor: '#ff822a',
    };

    // Класс для рендера календаря
    class LaravelCalendar {
        constructor(paramObj) {
            this.pageEl = paramObj.pageEl;
            this.plugins = paramObj.plugins;
            this.selectable = paramObj.selectable;
            this.height = paramObj.height;
            this.locale = paramObj.locale;
            this.fixedWeekCount = paramObj.fixedWeekCount;
            this.selectOverlap = paramObj.selectOverlap;
            this.customButtons = paramObj.customButtons;
            this.header = paramObj.header;
            this.allDayText = paramObj.allDayText;
            this.slotDuration = paramObj.slotDuration;
            this.slotLabelInterval = paramObj.slotLabelInterval;
            this.slotLabelFormat = paramObj.slotLabelFormat;
            this.buttonText = paramObj.buttonText;
            this.defaultView = paramObj.defaultView;
            this.scrollTime = paramObj.scrollTime;
            this.firstDay = paramObj.firstDay;
            this.events = paramObj.events;
            this.eventColor = paramObj.eventColor;
        }

        init() {
            let calendar_info = {};
            const calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: this.plugins,
                selectable: this.selectable,
                height: this.height,
                locale: this.locale,
                fixedWeekCount: this.fixedWeekCount,
                selectOverlap: this.selectOverlap,
                customButtons: this.customButtons,
                header: this.header,
                allDayText: this.allDayText,
                slotDuration: this.slotDuration,
                slotLabelInterval: this.slotLabelInterval,
                slotLabelFormat: this.slotLabelFormat,
                buttonText: this.buttonText,
                defaultView: this.defaultView,
                scrollTime: this.scrollTime,
                firstDay: this.firstDay,
                events: this.events,
                // Add events description
                // eventRender: function (info) {
                //     console.log(info.el);
                //     let el = info.el;
                //     el.append(info.event.extendedProps.description);
                // },
                eventColor: this.eventColor,
                select: function (info) {
                    let currentView = info.view.type;
                    if (currentView === "dayGridMonth") {
                        calendar.changeView('timeGridWeek');
                    } else {
                        $('#myModal').show();
                        calendar_info = info;
                    }
                },
                eventClick: function (info) {
                    let id = info.event.id;
                    let eventModalTitle = $('.event-info-title');
                    let eventModalDescription = $('.event-info-description');
                    let eventModalAuthor = $('.event-info-author');
                    let submitInfoForm = $('.submitInfoForm');

                    eventModalTitle.text(info.event.title);

                    if (info.event.extendedProps.description) {
                        eventModalDescription.text(info.event.extendedProps.description);
                    } else {
                        eventModalDescription.text('-');
                    }
                    eventModalAuthor.text(info.event.extendedProps.author);

                    $('#eventInfoModal').show();

                    // Если ID текущего пользователя не равно ID автора события то события нельза удалить
                    if (info.event.extendedProps.author_id === currentUserID || accessDelete === true) {
                        submitInfoForm.attr('disabled', false);
                    } else {
                        submitInfoForm.attr('disabled', true);
                    }


                    submitInfoForm.off('click').on('click', function (e) {
                        e.preventDefault();

                        if (confirm("Вы действительно хотите удалить событие?")) {
                            $.ajax({
                                //Url в роуте
                                url: ('events/destroy'),
                                type: "DELETE",
                                data: {
                                    id: id,
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                },
                                success: function () {
                                    hideModal();
                                    calendar.refetchEvents();
                                    toastr.success("Событие удалено");
                                }
                            });
                        }

                    });
                },
            });
            calendar.render();

            $(".submitForm").on('click', function () {
                // Поле для ввода заголовака события
                let title = $("#event-title").val();
                // Ставим в инпут текущую дату если там пусто
                if (!modalDatepicker.val()) {
                    modalDatepicker.datepicker('setDate', 'today');
                }

                if (title) { // Если поле заголвка не пустое
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let start = calendar_info.startStr; // Начальная дата
                    let end = calendar_info.endStr; // Конечная дата
                    let allDay = +calendar_info.allDay;
                    let author = currentUser; // Текущий пользователь WP
                    let days_of_week = checkBox(); // Выбраные дни для повторения
                    //@TODO Должно братся только если это повторяющееся событие
                    let endRecurDate = $("#datepicker").datepicker({dateFormat: 'dd:mm:yy'}).val();
                    let send_mail = sendMailCheck.prop('checked');
                    let description = $('textarea#textarea-comment').val();

                    $(this).prop('disabled', true);

                    $.ajax({
                        //Url в роуте
                        url: 'events/create', // Ссылка на файл для добавления события в БД
                        type: "POST", // Тип запроса
                        data: { // Данные, которые будут отправлены на сервер
                            _token: token,
                            title: title, // Заголовок
                            start: start, // Начало события
                            end: end, // Конец события
                            all_day: allDay, // Событие на весь день
                            author: author, // Автор события
                            author_id: currentUserID, // Автор события
                            description: description, // Описание события
                            studio_id: studio_id, // ИД "комнаты" в которую добавили событие
                            days_of_week: days_of_week, // Дни недели для повторения события
                            end_recur_day: endRecurDate, // Конечная дата повторений события
                            send_mail: send_mail, // Отправлять ли на почту уведомление о добавлении события
                        },
                        success: function (json) { // Если удачное завершение запроса
                            calendar.refetchEvents(); // Обновляем календарь
                            hideModal(); // Скрываем модальное окно
                            if (json.status) {
                                toastr.success(json.message);
                            } else {
                                toastr.error(json.message);
                            }
                            $(".submitForm").prop('disabled', false);
                        },
                        error: function (req, err) {
                            console.log('my message' + err);
                        }
                    })
                } else {
                    toastr.warning('Название события обязательно!');
                }
            });

            recurCheck.click(function () {
                var selectWeekDay = calendar_info.start.getDay();

                if ($(this).prop('checked')) {
                    let checkWeekBox = $(`input[data-weekday=${selectWeekDay}]`);
                    checkWeekBox.prop("checked", true);
                    checkWeekBox.prop('disabled', true);
                } else {
                    let checkWeekBox = $(`input[data-weekday=${selectWeekDay}]`);
                    checkWeekBox.prop("checked", false);
                    checkWeekBox.prop('disabled', false);
                }
            });

            $('#event-checkbox').on('change', function () {
                let chbox = $('#event-checkbox');
                if (chbox.prop('checked')) {
                    $('.slide-chb').slideDown();
                    modalDatepicker.datepicker('setDate', calendar_info.start);
                } else {
                    $('.slide-chb').slideUp();
                }
            });

            // Send current view data to pdfGenerator
            $('#pdfGenerator').on('click', function () {
                let viewObj = calendar.view;
                $('#activeDateStart').val(viewObj.activeStart.toLocaleString());
                $('#activeDateEnd').val(viewObj.activeEnd.toLocaleString());
                $('#calendarViewType').val(viewObj.type);
            });
        }
    }

    // Иннициализация календаря
    let laravelCalendar = new LaravelCalendar(paramObj);
    // Вызов календаря
    laravelCalendar.init();
});
