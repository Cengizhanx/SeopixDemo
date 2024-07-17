@extends('layouts.panel')

@section('content')

<head>
    <meta name="user-name" content="{{ auth()->user()->name }}">
</head>


<section id="main" class="col-lg-10 p-4">
    @php
        $positions = [
            'developer' => 'Yazılım Geliştirici',
            'designer' => 'Grafik Tasarımcı',
            'seoExpert' => 'SEO Uzmanı',
            'socialMediaManager' => 'Sosyal Medya Yöneticisi',
            'videoEditor' => 'Video Editörü',
            'projectManager' => 'Proje Yöneticisi',
            'accounting' => 'Muhasebe',
            'intern' => 'Stajyer'
        ];
        $userPosition = Auth::user()->position;
        if ($userPosition === 'CEO') {
            $positions['CEO'] = 'CEO'; // CEO pozisyonunu sadece CEO kullanıcılar için ekliyoruz
        }
    @endphp

    <select id="positionFilter">
        <option value="{{ Auth::user()->position }}" selected>{{ $positions[Auth::user()->position] }}</option>
        @foreach ($positions as $key => $name)
            @if ($key !== Auth::user()->position)
                <option value="{{ $key }}">{{ $name }}</option>
            @endif
        @endforeach
        <option value="all">Tüm Pozisyonlar</option>
    </select>


    <div id="calendar"></div>

    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel">Etkinlik Oluştur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createEventForm">
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Etkinlik Adı</label>
                            <input type="text" class="form-control" id="eventName" name="eventName" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventContent" class="form-label">Etkinlik İçeriği</label>
                            <textarea class="form-control" id="eventContent" name="eventContent" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="eventStartDate" class="form-label">Başlangıç Tarihi</label>
                                <input type="date" class="form-control" id="eventStartDate" name="eventStartDate"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="eventEndDate" class="form-label">Bitiş Tarihi</label>
                                <input type="date" class="form-control" id="eventEndDate" name="eventEndDate" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="eventStartTime" class="form-label">Başlangıç Saati</label>
                                <input type="time" class="form-control" id="eventStartTime" name="eventStartTime"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="eventEndTime" class="form-label">Bitiş Saati</label>
                                <input type="time" class="form-control" id="eventEndTime" name="eventEndTime" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="CEOCheckbox" name="eventVisibleTo[]"
                                    value="CEO">
                                <label class="form-check-label" for="CEOCheckbox">CEO</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="developerCheckbox"
                                    name="eventVisibleTo[]" value="developer">
                                <label class="form-check-label" for="developerCheckbox">Yazılım Geliştirici</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="designerCheckbox"
                                    name="eventVisibleTo[]" value="designer">
                                <label class="form-check-label" for="designerCheckbox">Grafik Tasarımcı</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="seoCheckbox" name="eventVisibleTo[]"
                                    value="seoExpert">
                                <label class="form-check-label" for="seoCheckbox">SEO Uzmanı</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="socialMediaCheckbox"
                                    name="eventVisibleTo[]" value="socialMediaManager">
                                <label class="form-check-label" for="socialMediaCheckbox">Sosyal Medya
                                    Yöneticisi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="projectManagerCheckbox"
                                    name="eventVisibleTo[]" value="projectManager">
                                <label class="form-check-label" for="projectManagerCheckbox">Proje Yöneticisi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="videoEditorCheckbox"
                                    name="eventVisibleTo[]" value="videoEditor">
                                <label class="form-check-label" for="videoEditorCheckbox">Video Editörü</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="accountingCheckbox"
                                    name="eventVisibleTo[]" value="accounting">
                                <label class="form-check-label" for="accountingCheckbox">Muhasebe</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="internCheckbox"
                                    name="eventVisibleTo[]" value="intern">
                                <label class="form-check-label" for="internCheckbox">Stajyer</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="selectAllPositions"
                                    name="selectAllPositions">
                                <label class="form-check-label" for="selectAllPositions">Hepsi</label>
                            </div>
                        </div>
                </div>
                <div class="text-center pb-3">
                    <button type="submit" class="btn btn-pink">Oluştur</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>



    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title p-2 flex-grow-1" id="eventModalTitle"></h5>
                    <button type="button" class="btn-close p-2" aria-label="Close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Oluşturan:</strong> <span id="eventModalCreatedBy"></span></p>
                    <p><strong>Başlangıç:</strong> <span id="eventModalStart"></span></p>
                    <p><strong>Bitiş:</strong> <span id="eventModalEnd"></span></p>
                    <p><strong>İçerik:</strong> <span id="eventModalContent"></span></p>
                    <p><strong>Katılan Pozisyonlar:</strong></p>
                    <ul id="eventModalPositions">
                        <!-- Pozisyonlar burada listelenecek -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-pink" id="deleteEventButton">
                        <i class="bi bi-trash"> Sil</i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="eventToast" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Etkinlik başarıyla oluşturuldu.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js'></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.14/locales-all.global.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var calendarEl = document.getElementById('calendar');
                var currentUserName = document.querySelector('meta[name="user-name"]').getAttribute('content');
                if (calendarEl) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        selectable: true,
                        editable: true,
                        dayMaxEvents: true,
                        eventColor: '#7d00ff',
                        locale: 'tr',
                        events: function (info, successCallback, failureCallback) {
                            var selectedPosition = document.getElementById('positionFilter').value;
                            $.ajax({
                                url: '/etkinlikler/list',
                                data: {
                                    position: selectedPosition,
                                    start: info.startStr,
                                    end: info.endStr
                                },
                                success: function (data) {
                                    successCallback(data);
                                },
                                error: function () {
                                    failureCallback();
                                }
                            });
                        },
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,dayGridWeek,dayGridDay'
                        },
                        dateClick: function (info) {
                            $('#eventStartDate').val(info.dateStr);
                            $('#eventEndDate').val(info.dateStr);
                            $('#createEventModal').modal('show');
                        },
                        eventClick: function (info) {
                            if (info.jsEvent.target.classList.contains('event-status-checkbox')) {
                                return; // Checkbox'a tıklanmışsa işlemi durdur
                            }

                            var eventId = info.event.id;
                            var eventTitle = info.event.title;
                            var eventStart = info.event.start;
                            var eventEnd = info.event.end;
                            var eventContent = info.event.extendedProps.content;
                            var createdBy = info.event.extendedProps.createdBy.trim();
                            var status = info.event.extendedProps.status;

                            // Fetch event positions and display in modal
                            $.ajax({
                                url: '/etkinlikler/' + eventId + '/pozisyon',
                                type: 'GET',
                                success: function (response) {
                                    var positionNames = {
                                        'CEO': 'CEO',
                                        'developer': 'Yazılım Geliştirici',
                                        'designer': 'Grafik Tasarımcı',
                                        'seoExpert': 'SEO Uzmanı',
                                        'socialMediaManager': 'Sosyal Medya Yöneticisi',
                                        'projectManager': 'Proje Yöneticisi',
                                        'videoEditor': 'Video Editörü',
                                        'accounting': 'Muhasebe',
                                        'intern': 'Stajyer'
                                    };

                                    var positionsHtml = '';
                                    response.positions.forEach(function (position) {
                                        var friendlyName = positionNames[position] || position;
                                        positionsHtml += '<li>' + friendlyName + '</li>';
                                    });

                                    $('#eventModalTitle').text(eventTitle);
                                    $('#eventModalStart').text(eventStart.toLocaleString());
                                    $('#eventModalEnd').text(eventEnd.toLocaleString());
                                    $('#eventModalContent').text(eventContent);
                                    $('#eventModalCreatedBy').text(createdBy);
                                    $('#eventModalPositions').html(positionsHtml);
                                    if (createdBy === currentUserName) {
                                        $('#deleteEventButton').show();
                                    } else {
                                        $('#deleteEventButton').hide();
                                    }

                                    $('#eventModal').modal('show');

                                    $('#deleteEventButton').off('click').on('click', function () {
                                        if (confirm('Bu etkinliği silmek istediğinizden emin misiniz?')) {
                                            $.ajax({
                                                url: '/etkinlikler/' + eventId,
                                                type: 'DELETE',
                                                success: function (response) {
                                                    calendar.getEventById(eventId).remove();
                                                    $('#eventModal').modal('hide');
                                                    alert('Etkinlik başarıyla silindi.');
                                                },
                                                error: function (error) {
                                                    if (error.status === 403) {
                                                        alert('Bu etkinliği silme yetkiniz yok.');
                                                    } else {
                                                        alert('Etkinlik silinirken bir hata oluştu.');
                                                    }
                                                }
                                            });
                                        }
                                    });
                                },
                                error: function (error) {
                                    console.error('Pozisyonlar getirilirken hata oluştu:', error);
                                }
                            });
                        },
                        eventDidMount: function (info) {
                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.checked = info.event.extendedProps.status == 1;
                            checkbox.classList.add('event-status-checkbox');
                            checkbox.addEventListener('change', function () {
                                var newStatus = this.checked ? 1 : 0;
                                $.ajax({
                                    url: '/etkinlikler/' + info.event.id + '/durum',
                                    type: 'PATCH',
                                    data: {
                                        status: newStatus
                                    },
                                    success: function (response) {
                                        info.event.setExtendedProp('status', newStatus);
                                    },
                                    error: function (error) {
                                        console.error('Durum güncellenirken hata oluştu:', error);
                                    }
                                });
                            });

                            var eventElement = info.el;
                            eventElement.prepend(checkbox);
                        },
                        eventDrop: function (info) {
                            var newDate = info.event.start;
                            var eventId = info.event.id;

                            $.ajax({
                                url: '/etkinlikler/' + eventId + '/taşı',
                                type: 'PATCH',
                                data: {
                                    date: newDate.toISOString().split('T')[0] // Sadece tarihi gönder
                                },
                                success: function (response) {
                                    console.log('Etkinlik başarıyla taşındı:', response);
                                },
                                error: function (error) {
                                    console.error('Etkinlik taşınırken hata oluştu:', error);
                                    // Orijinal tarihe geri döndür
                                    info.event.setDates(info.oldStart, info.oldEnd);
                                }
                            });
                        }
                    });
                    calendar.render();
                }

                var now = new Date();
                var today = now.toISOString().slice(0, 10);
                var currentTime = now.toTimeString().slice(0, 5);
                var oneHourLater = new Date(now.getTime() + 60 * 60 * 1000).toTimeString().slice(0, 5);

                var eventNameInput = document.getElementById('eventName');
                var eventStartDateInput = document.getElementById('eventStartDate');
                var eventEndDateInput = document.getElementById('eventEndDate');
                var eventStartTimeInput = document.getElementById('eventStartTime');
                var eventEndTimeInput = document.getElementById('eventEndTime');
                var eventContentInput = document.getElementById('eventContent');
                var createEventForm = document.getElementById('createEventForm');

                var selectAllCheckbox = document.getElementById('selectAllPositions');
                var positionCheckboxes = document.querySelectorAll('input[name="eventVisibleTo[]"]');

                selectAllCheckbox.addEventListener('change', function () {
                    var isChecked = this.checked;

                    positionCheckboxes.forEach(function (checkbox) {
                        checkbox.checked = isChecked;
                    });
                });

                document.getElementById('positionFilter').addEventListener('change', function () {
                    var selectedPosition = this.value;
                    calendar.refetchEvents();
                    $.ajax({
                        url: '/etkinlikler/list',
                        data: {
                            position: selectedPosition,
                            start: info.startStr,
                            end: info.endStr
                        },
                        success: function (data) {
                            calendar.removeAllEvents();
                            data.forEach(event => {
                                calendar.addEvent(event);
                            });
                        }
                    });
                });

                if (eventNameInput && eventStartDateInput && eventEndDateInput && eventStartTimeInput && eventEndTimeInput && createEventForm && eventContentInput) {
                    eventStartDateInput.value = today;
                    eventEndDateInput.value = today;
                    eventStartTimeInput.value = currentTime;
                    eventEndTimeInput.value = oneHourLater;

                    createEventForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        var visibleToCheckboxes = document.querySelectorAll('input[name="eventVisibleTo[]"]:checked');
                        var visibleTo = [];
                        visibleToCheckboxes.forEach(function (checkbox) {
                            visibleTo.push(checkbox.value);
                        });

                        var formData = {
                            title: eventNameInput.value,
                            start: eventStartDateInput.value + ' ' + eventStartTimeInput.value,
                            end: eventEndDateInput.value + ' ' + eventEndTimeInput.value,
                            content: eventContentInput.value,
                            visible_to: visibleTo
                        };

                        $.ajax({
                            url: '/etkinlikler/olustur',
                            data: formData,
                            type: 'POST',
                            success: function (response) {
                                calendar.addEvent({
                                    id: response.event_id,
                                    title: formData.title,
                                    start: formData.start,
                                    end: formData.end,
                                    content: formData.content,
                                    extendedProps: {
                                        createdBy: response.created_by
                                    }
                                });
                                $('#createEventModal').modal('hide');

                                location.reload();

                                var eventToast = new bootstrap.Toast(document.getElementById('eventToast'));
                                eventToast.show();
                                $('#createEventModal').on('hidden.bs.modal', function () {
                                    $('#createEventForm').trigger('reset');
                                    $('#eventStartTime').val(currentTime);
                                    $('#eventEndTime').val(oneHourLater);
                                    $('#selectAllPositions').prop('checked', false);
                                    positionCheckboxes.forEach(function (checkbox) {
                                        checkbox.checked = false;
                                    });
                                });
                            },
                            error: function (error) {
                                console.error('Etkinlik oluşturulurken hata oluştu:', error);
                            }
                        });
                    });
                }
            });
        </script>
    @endpush
</section>

@stop