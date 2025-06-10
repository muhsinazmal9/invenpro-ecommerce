 <div class="card-style mb-30">
  <div class="title d-flex flex-wrap align-items-center justify-content-between">
    <div class="left">
      <h6 class="text-medium mb-30">{{ __('app.sales_revenue') }}</h6>
    </div>
    <div class="right">
        <div class="select-style-1">
            <div class="select-position select-sm">
                <select class="light-bg" id="timeframe-option">
                    <option value="yearly" {{ request()->input('sale_statistics_type') == "yearly" ? "selected" :
                        "" }}>Yearly</option>
                    <option value="monthly" {{ ( request()->input('sale_statistics_type') == "monthly" ||
                        request()->input('sale_statistics_type') == null ) ? "selected" : '' }}>Monthly</option>
                    <option value="weekly" {{ request()->input('sale_statistics_type') == "weekly" ? "selected" :
                        '' }}>Weekly</option>
                </select>
            </div>
        </div>
        <!-- end select -->
    </div>
  </div>
  <!-- End Title -->
  <div class="chart">
    <canvas id="Chart2" style="width: 100%; height: 400px; margin-left: -45px;"></canvas>
  </div>
                <!-- End Chart -->
 </div>


<script src="{{ asset('assets/backend/js/Chart.min.js') }}"></script>
<script>
  {

    $('#timeframe-option').change(function() {
            switch ($(this).val()){
            case "yearly":
            console.log('hello')

            document.location = "{{ route('admin.dashboard.index') }}?sale_statistics_type=yearly";
            break;
            case "monthly":
            document.location = "{{ route('admin.dashboard.index') }}?sale_statistics_type=monthly";
            break;
            case "weekly":
            document.location = "{{ route('admin.dashboard.index') }}?sale_statistics_type=weekly";
            break;
            default:
            document.location = "{{ route('admin.dashboard.index') }}";

            }
      });


  const salesRevenue = @json($salesRevenues);

  const months = Object.keys(salesRevenue);
  const revenues = Object.values(salesRevenue);


  // =========== chart two start
  const ctx2 = document.getElementById("Chart2").getContext("2d");
  const chart2 = new Chart(ctx2, {
    type: "bar",
    data: {
      labels: months,
      datasets: [
        {
          label: "",
          backgroundColor: "#365CF5",
          borderRadius: 30,
          barThickness: 6,
          maxBarThickness: 8,
          data: revenues,
        },
      ],
    },
    options: {
      plugins: {
        tooltip: {
          callbacks: {
            titleColor: function (context) {
              return "#8F92A1";
            },
            label: function (context) {
              let label = context.dataset.label || "";

              if (label) {
                label += ": ";
              }
              label += context.parsed.y;
              return label;
            },
          },
          backgroundColor: "#F3F6F8",
          titleAlign: "center",
          bodyAlign: "center",
          titleFont: {
            size: 12,
            weight: "bold",
            color: "#8F92A1",
          },
          bodyFont: {
            size: 16,
            weight: "bold",
            color: "#171717",
          },
          displayColors: false,
          padding: {
            x: 30,
            y: 10,
          },
      },
      },
      legend: {
        display: false,
        },
      legend: {
        display: false,
      },
      layout: {
        padding: {
          top: 15,
          right: 15,
          bottom: 15,
          left: 15,
        },
      },
      responsive: true,
      maintainAspectRatio: false,
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
            min: 0,
          },
        },
        x: {
          grid: {
            display: false,
            drawBorder: false,
            color: "rgba(143, 146, 161, .1)",
            drawTicks: false,
            zeroLineColor: "rgba(143, 146, 161, .1)",
          },
          ticks: {
            padding: 20,
          },
        },
      },
      plugins: {
        legend: {
          display: false,
        },
        title: {
          display: false,
        },
      },
    },
  });
}

</script>
