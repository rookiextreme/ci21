(function (window, document, $) {
  'use strict';

  /*******  Flatpickr  *****/
  var basicPickr = $('.flatpickr-basic'),
    timePickr = $('.flatpickr-time'),
    dateTimePickr = $('.flatpickr-date-time'),
    multiPickr = $('.flatpickr-multiple'),
    rangePickr = $('.flatpickr-range'),
    humanFriendlyPickr = $('.flatpickr-human-friendly'),
    disabledRangePickr = $('.flatpickr-disabled-range'),
    inlineRangePickr = $('.flatpickr-inline');

  // Default
  if (basicPickr.length) {
    basicPickr.flatpickr();
  }

  // Time
  if (timePickr.length) {
    timePickr.flatpickr({
      enableTime: true,
      dateFormat: "d-m-Y h:i K",
      noCalendar: true
    });
  }

  // Date & TIme
  if (dateTimePickr.length) {
    dateTimePickr.flatpickr({
      dateFormat: "d-m-Y h:i K",
      enableTime: true
    });
  }

  // Multiple Dates
  if (multiPickr.length) {
    multiPickr.flatpickr({
      weekNumbers: true,
      mode: 'multiple',
      minDate: 'today'
    });
  }

  // Range
  if (rangePickr.length) {
    rangePickr.flatpickr({
      mode: 'range'
    });
  }

  // Human Friendly
  if (humanFriendlyPickr.length) {
    humanFriendlyPickr.flatpickr({
      altInput: true,
      altFormat: 'F j, Y',
      dateFormat: 'Y-m-d'
    });
  }

  // Disabled Range
  if (disabledRangePickr.length) {
    disabledRangePickr.flatpickr({
      dateFormat: 'Y-m-d',
      disable: [
        {
          from: new Date().fp_incr(2),
          to: new Date().fp_incr(7)
        }
      ]
    });
  }

  // Inline
  if (inlineRangePickr.length) {
    inlineRangePickr.flatpickr({
      inline: true
    });
  }
  /*******  Pick-a-date Picker  *****/
  // Basic date
  $('.pickadate').pickadate();

  // Format Date Picker
  $('.format-picker').pickadate({
    format: 'mmmm, d, yyyy'
  });

  // Date limits
  $('.pickadate-limits').pickadate({
    min: [2019, 3, 20],
    max: [2019, 5, 28]
  });

  // Disabled Dates & Weeks

  $('.pickadate-disable').pickadate({
    disable: [1, [2019, 3, 6], [2019, 3, 20]]
  });

  // Picker Translations
  $('.pickadate-translations').pickadate({
    formatSubmit: 'dd/mm/yyyy',
    monthsFull: [
      'Janvier',
      'Février',
      'Mars',
      'Avril',
      'Mai',
      'Juin',
      'Juillet',
      'Août',
      'Septembre',
      'Octobre',
      'Novembre',
      'Décembre'
    ],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
    weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
    today: "aujourd'hui",
    clear: 'clair',
    close: 'Fermer'
  });

  // Month Select Picker
  $('.pickadate-months').pickadate({
    selectYears: false,
    selectMonths: true
  });

  // Month and Year Select Picker
  $('.pickadate-months-year').pickadate({
    selectYears: true,
    selectMonths: true
  });

  // Short String Date Picker
  $('.pickadate-short-string').pickadate({
    weekdaysShort: ['S', 'M', 'Tu', 'W', 'Th', 'F', 'S'],
    showMonthsShort: true
  });

  // Change first weekday
  $('.pickadate-firstday').pickadate({
    firstDay: 1
  });

  /*******    Pick-a-time Picker  *****/
  // Basic time
  $('.pickatime').pickatime();

  // Format options
  $('.pickatime-format').pickatime({
    // Escape any “rule” characters with an exclamation mark (!).
    format: 'T!ime selected: h:i a',
    formatLabel: 'HH:i a',
    formatSubmit: 'HH:i',
    hiddenPrefix: 'prefix__',
    hiddenSuffix: '__suffix'
  });

  // Format options
  $('.pickatime-formatlabel').pickatime({
    formatLabel: function (time) {
      var hours = (time.pick - this.get('now').pick) / 60,
        label = hours < 0 ? ' !hours to now' : hours > 0 ? ' !hours from now' : 'now';
      return 'h:i a <sm!all>' + (hours ? Math.abs(hours) : '') + label + '</sm!all>';
    }
  });

  // Min - Max Time to select
  $('.pickatime-min-max').pickatime({
    // Using Javascript
    min: new Date(2015, 3, 20, 7),
    max: new Date(2015, 7, 14, 18, 30)

    // Using Array
    // min: [7,30],
    // max: [14,0]
  });

  // Intervals
  $('.pickatime-intervals').pickatime({
    interval: 150
  });

  // Disable Time
  $('.pickatime-disable').pickatime({
    disable: [
      // Disable Using Integers
      3,
      5,
      7,
      13,
      17,
      21

      /* Using Array */
      // [0,30],
      // [2,0],
      // [8,30],
      // [9,0]
    ]
  });

  // Close on a user action
  $('.pickatime-close-action').pickatime({
    closeOnSelect: false,
    closeOnClear: false
  });


  var bsStepper = document.querySelectorAll('.bs-stepper'),
    select = $('.select2'),
    modernWizard = document.querySelector('.dict-bank-wizard');

    for (var el = 0; el < bsStepper.length; ++el) {
      bsStepper[el].addEventListener('show.bs-stepper', function (event) {
        var index = event.detail.indexStep;
        var numberOfSteps = $(event.target).find('.step').length - 1;
        var line = $(event.target).find('.step');

        // The first for loop is for increasing the steps,
        // the second is for turning them off when going back
        // and the third with the if statement because the last line
        // can't seem to turn off when I press the first item. ¯\_(ツ)_/¯

        for (var i = 0; i < index; i++) {
          line[i].classList.add('crossed');

          for (var j = index; j < numberOfSteps; j++) {
            line[j].classList.remove('crossed');
          }
        }
        if (event.detail.to == 0) {
          for (var k = index; k < numberOfSteps; k++) {
            line[k].classList.remove('crossed');
          }
          line[0].classList.remove('crossed');
        }
      });
    }
    
    select.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  
    var modernStepper = new Stepper(modernWizard, {
      linear: false
    });

    $(modernWizard)
      .find('.btn-next')
      .on('click', function () {
        modernStepper.next();
      });
    $(modernWizard)
      .find('.btn-prev')
      .on('click', function () {
        modernStepper.previous();
      });
      
})(window, document, jQuery);