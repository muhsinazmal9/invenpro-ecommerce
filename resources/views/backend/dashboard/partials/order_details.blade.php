<div class="card-style mb-30">
    <div class="title d-flex flex-wrap justify-content-between">
        <div class="left">
            <h6 class="text-medium mb-10">Order</h6>
            <h3 class="text-bold">$245,479</h3>
        </div>
        <div class="right">
            <div class="select-style-1">
                <div class="select-position select-sm">
                    <select class="light-bg" id="timeframe-options">
                        <option value="yearly" {{ request()->input('order_statistics_type') == "yearly" ? "selected" :
                            "" }}>Yearly</option>
                        <option value="monthly" {{ ( request()->input('order_statistics_type') == "monthly" ||
                            request()->input('order_statistics_type') == null ) ? "selected" : '' }}>Monthly</option>
                        <option value="weekly" {{ request()->input('order_statistics_type') == "weekly" ? "selected" :
                            '' }}>Weekly</option>
                    </select>
                </div>
            </div>
            <!-- end select -->
        </div>
    </div>
    <!-- End Title -->
    <div class="chart">
        <canvas id="Chart1" style="width: 100%; height: 400px; margin-left: -35px;"></canvas>
    </div>
    <!-- End Chart -->
</div>
<script src="{{ asset('assets/backend/js/Chart.min.js') }}"></script>
<script>
    {

       $('#timeframe-options').change(function() {
        switch ($(this).val()){
            case "yearly":
            // console.log('hello')

                document.location = "{{ route('admin.dashboard.index') }}?order_statistics_type=yearly";
                break;
            case "monthly":
                document.location = "{{ route('admin.dashboard.index') }}?order_statistics_type=monthly";
                break;
            case "weekly":
            document.location = "{{ route('admin.dashboard.index') }}?order_statistics_type=weekly";
            break;
            default:
               document.location = "{{ route('admin.dashboard.index') }}";


        }
        });
        const orderCount = @json($orderCount);

        const label = Object.keys(orderCount);
        const ordercount= Object.values(orderCount);
        // =========== chart one start
        const ctx1 = document.getElementById("Chart1").getContext("2d");
        const chart1 = new Chart(ctx1, {
            type: "line",
            data: {
            labels:label ,
            datasets: [
                {
                label: "",
                backgroundColor: "transparent",
                borderColor: "#365CF5",
                data:ordercount,
                pointBackgroundColor: "transparent",
                pointHoverBackgroundColor: "#365CF5",
                pointBorderColor: "transparent",
                pointHoverBorderColor: "#fff",
                pointHoverBorderWidth: 5,
                borderWidth: 5,
                pointRadius: 8,
                pointHoverRadius: 8,
                cubicInterpolationMode: "monotone", // Add this line for curved line
                },
            ],
            },
            options: {
            plugins: {
                tooltip: {
                callbacks: {
                    labelColor: function (context) {
                    return {
                        backgroundColor: "#ffffff",
                        color: "#171717"
                    };
                    },
                },
                intersect: false,
                backgroundColor: "#f9f9f9",
                title: {
                    fontFamily: "Plus Jakarta Sans",
                    color: "#8F92A1",
                    fontSize: 12,
                },
                body: {
                    fontFamily: "Plus Jakarta Sans",
                    color: "#171717",
                    fontStyle: "bold",
                    fontSize: 16,
                },
                multiKeyBackground: "transparent",
                displayColors: false,
                padding: {
                    x: 30,
                    y: 10,
                },
                bodyAlign: "center",
                titleAlign: "center",
                titleColor: "#8F92A1",
                bodyColor: "#171717",
                bodyFont: {
                    family: "Plus Jakarta Sans",
                    size: "16",
                    weight: "bold",
                },
                },
                legend: {
                display: false,
                },
            },
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: false,
            },
            scales: {
                y: {
                grid: {
                    display: false,
                    drawTicks: false,
                    drawBorder: false,
                },
                ticks: {
                    padding: 35,
                    max: 1200,
                    min: 500,
                },
                },
                x: {
                grid: {
                    drawBorder: false,
                    color: "rgba(143, 146, 161, .1)",
                    zeroLineColor: "rgba(143, 146, 161, .1)",
                },
                ticks: {
                    padding: 20,
                },
                },
            },
            },
        });
    }
      // =========== chart one end
      // =========== chart one end
</script>