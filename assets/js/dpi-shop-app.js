(function ($) {
    $(document).ready(function () {
        /**
         * Days
         *
         */

        var days = [
            "sunday",
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday",
        ];

        /**
         * Get cookie function.
         *
         */

        function getCookie(name) {
            let value = `; ${document.cookie}`;
            let parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(";").shift();
        }

        /**
         * Handle pickup date changes.
         *
         */

        $("#dpi_pickup_date").on("change", function (e) {
            document.cookie = `dpi_pickup_date=${e.target.value}; path=/;`;

            var date = new Date(e.target.value);

            $(".dpi_daily_stock_quantity").map(function (index, element) {
                var stock = parseInt($(element).data(days[date.getDay()]));

                var parent = $(element).parent(".product")[0];

                if (stock == 0) {
                    //

                    $(element).css({ color: "red" });

                    //

                    $($(parent).find(".add_to_cart_button ")[0]).css({
                        pointerEvents: "none",
                        opacity: "50%",
                    });
                } else {
                    //

                    $(element).css({ color: "#717f8c" });

                    //

                    $($(parent).find(".add_to_cart_button ")[0]).css({
                        pointerEvents: "auto",
                        opacity: "100%",
                    });
                }

                $(element).html("Stock " + stock);
            });
        });

        /**
         * Handle pickup time changes.
         *
         */

        $("#dpi_pickup_time").on("change", function (e) {
            document.cookie = `dpi_pickup_time=${e.target.value}; path=/;`;
        });

        //

        $("#dpi_pickup_date").on("click", function () {
            this.showPicker();
        });

        /**
         * Set min date.
         *
         */

        var todayInstance = new Date();

        var now = new Date();

        if (parseInt(now.getHours()) > 14 || parseInt(now.getHours()) === 0) {
            todayInstance.setDate(todayInstance.getDate() + 1);
        }

        var today = todayInstance.toISOString().split("T")[0];

        $("#dpi_pickup_date").attr("min", today);

        if (
            (parseInt(now.getHours()) > 14 || parseInt(now.getHours()) === 0) &&
            !getCookie("dpi_pickup_date")
        ) {
            document.cookie = `dpi_pickup_date=${today}; path=/;`;
        }

        /**
         * Set detault pickup date.
         *
         */

        document.cookie = `dpi_pickup_date=${
            getCookie("dpi_pickup_date") ? getCookie("dpi_pickup_date") : today
        }; path=/;`;

        $("#dpi_pickup_date").attr("value", getCookie("dpi_pickup_date"));

        $("#dpi_pickup_time").val(getCookie("dpi_pickup_time"));

        /**
         * Display daily stock quantity.
         *
         */

        var pickupDate = getCookie("dpi_pickup_date")
            ? getCookie("dpi_pickup_date")
            : today;

        var date = new Date(pickupDate);

        $(".dpi_daily_stock_quantity").map(function (index, element) {
            var stock = parseInt($(element).data(days[date.getDay()]));

            if (stock == 0) {
                $(element).css({ color: "red" });

                var parent = $(element).parent(".product")[0];

                //

                $($(parent).find(".add_to_cart_button ")[0]).css({
                    pointerEvents: "none",
                    opacity: "50%",
                });

                $($(parent).find(".add_to_cart_button")[0]).attr("href", "#");

                //

                $($("button[name='add-to-cart']")[index]).parent().css({
                    pointerEvents: "none",
                    opacity: "50%",
                });
            }

            $(element).html("Stock " + stock);
        });
    });
})(jQuery);
