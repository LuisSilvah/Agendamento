</div>
</body>


<!-- Create the calendar -->
<script type="text/javascript">
    var element = document.getElementById("calendario");

    var dateInput = document.getElementById("data-selecionada");
    var sqlInput = document.getElementById("banco-dados-data");

    function Calendar() {
        if (dateInput.value === "") {

            dateInput.value = jsCalendar.tools.dateToString(new Date(), date_format, "en");
            sqlInput.value = jsCalendar.tools.dateToString(new Date(), date_formate_sql, "en");

            return Calendar = jsCalendar.new(element, new Date(), {
                navigator: true,
                navigatorPosition: "left",
                zeroFill: false,
                monthFormat: "Calendário YYYY",
                language: "en"
            });
        } else {
            return Calendar = jsCalendar.new(element, dateInput.value, {
                navigator: true,
                navigatorPosition: "left",
                zeroFill: false,
                monthFormat: "Calendário YYYY",
                language: "en"
            });
        }
    }

    var date_format = "DD/MM/YYYY";
    var date_formate_sql = "YYYY-MM-DD";

    document.getElementById("btn-day").addEventListener("click", setDateHoje);

    // Selecionar a data de Hoje
    function setDateHoje(e) {
        e.preventDefault()
        dateInput.value = jsCalendar.tools.dateToString(new Date(), date_format, "en");
        sqlInput.value = jsCalendar.tools.dateToString(new Date(), date_formate_sql, "en");
        Calendar.set(new Date());
    }

    // Adicionando eventos
    Calendar().onDateClick(function(event, date) {
        dateInput.value = jsCalendar.tools.dateToString(date, date_format, "en");
        sqlInput.value = jsCalendar.tools.dateToString(date, date_formate_sql, "en");
        Calendar.set(date);
    });
    Calendar().onMonthChange(function(event, date) {
        inputB.value = date.toString();
    });
</script>

</html>