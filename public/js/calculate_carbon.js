$(document).ready(function(){
    var dateFormat = 'DD-MM-YYYY';
    
    $('input[name="custom_date"]').daterangepicker({
        maxDate:  moment(),
        locale: {
            format: dateFormat
        }
    });

    $('input[name="custom_year"]').yearpicker({ year : new Date().getFullYear() });

    $('input[name="custom_week"]').daterangepicker({
        autoApply: true,
        singleDatePicker: true,
        showWeekNumbers: true,
        showISOWeekNumbers: true,
        locale: {
            firstDay: 1, // Week starts on Monday
            format: 'YYYY-WW' // Display the week in ISO format
        }
    }, function (start, end, label) {
        // Set the input to the start week
        const startOfWeek = start.clone().startOf('isoWeek');
        const endOfWeek = start.clone().endOf('isoWeek');
        $('input[name="custom_week"]').val(
            startOfWeek.format('YYYY-WW')
        );
    });
    
    $(document).on('change', 'input[name=trip_journey]', function(){
        var journey = $(this).val();
        $('.weekDays').hide();
        $('.customMonth').hide();
        $('.customSemester').hide();
        $('.customYear').hide();
        $('.customDates').hide();
        $('.workDays').show();
    
        switch(journey) {
            case "daily":                
                $('.workDays').hide();
                break;
    
            case "weekly":                
                $('.weekDays').show();
                break;
            
            case "monthly":                
                $('.customMonth').show();
            break;
    
            case "semester":                
                $('.customSemester').show();
            break;
    
            case "annual":                
                $('.customYear').show();
            break;
    
            case "custom":
                $('.customDates').show();
                break;
        }
    });
});