import { Chart } from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    const yearSelect = document.getElementById("years");
    const ctx = document.getElementById("bookingsStatisticsChart");
    let chartInstance = null;

    // Function to get the chart based on the selected year
    function getChart(selectedYear) {
        if (!ctx) return;

        const bookingsStatistics = JSON.parse(
            document.querySelector('meta[name="statistics"]').content
        );

        const selectedYearBooking = bookingsStatistics.filter(
            (statistic) => statistic.year === selectedYear
        );

        // Create an array for the months of the year
        const months = Array.from({ length: 12 }, (_, i) =>
            new Intl.DateTimeFormat("en", { month: "long" }).format(
                new Date(0, i)
            )
        );

        // Data for each month
        const totalBookings = new Array(12).fill(0);
        const totalBookingPrice = new Array(12).fill(0);

        selectedYearBooking.forEach((statistic) => {
            totalBookings[statistic.month - 1] = statistic.bookings_count;
            totalBookingPrice[statistic.month - 1] =
                statistic.total_booking_price;
        });

        // y's Axis max values suggested
        const yAxisMaxValue = totalBookings.reduce((acc, val) => acc + val, 0);

        // y1 Axis max value suggested
        const maxPrice = Math.max(...totalBookingPrice);
        const magnitude = Math.pow(10, Math.floor(Math.log10(maxPrice)));
        const y1AxisMaxValue = Math.ceil(maxPrice / magnitude) * magnitude;

        // Setup
        const data = {
            labels: months,
            datasets: [
                {
                    label: "Total Bookings",
                    data: totalBookings,
                    borderRadius: 30,
                    borderColor: "rgb(75, 192, 192)",
                    backgroundColor: "rgba(75, 192, 192, 0.08)",
                    fill: true,
                    hoverBorderWidth: 4,
                },
                {
                    label: "Total Booking Price (ALL)",
                    data: totalBookingPrice,
                    borderColor: "rgb(255, 99, 132)",
                    backgroundColor: "rgba(255, 99, 132, 0.08)",
                    fill: true,
                    borderWidth: 2,
                    hoverBorderWidth: 3,
                    yAxisID: "y1",
                },
            ],
        };

        //Config
        const config = {
            type: "line",
            data,
            options: {
                scales: {
                    x: {
                        ticks: { color: "white", font: { style: "italic" } },
                        grid: {
                            color: "rgba(75, 192, 192, 0.3)",
                            lineWidth: 0,
                        },
                        border: { color: "rgba(255, 255, 255, 0.2)" },
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: yAxisMaxValue,
                        ticks: { color: "rgb(75, 192, 192)", stepSize: 1 },
                        grid: {
                            color: "rgba(75, 192, 192, 0.2)",
                            lineWidth: 0,
                        },
                        border: { color: "rgba(255, 255, 255, 0.2)" },
                        title: {
                            display: true,
                            text: "Total Bookings",
                            color: "rgb(75, 192, 192)",
                        },
                    },
                    y1: {
                        type: "linear",
                        position: "right",
                        beginAtZero: true,
                        suggestedMax: y1AxisMaxValue,
                        grid: {
                            drawOnChartArea: true,
                            lineWidth: 0,
                            color: "rgba(125, 8, 220, 0.54)",
                        },
                        ticks: { color: "rgb(255, 99, 132)", stepSize: 50 },
                        title: {
                            display: true,
                            text: "Total Booking Price (Default Currency)",
                            color: "rgb(255, 99, 132)",
                        },
                    },
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: "easeInOutQuad",
                        from: 1,
                        to: 0,
                        loop: true,
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            color: "white",
                            font: { style: "italic" },
                        },
                    },
                },
            },
        };

        // Destroy Chart and create a new one
        if (chartInstance) {
            chartInstance.destroy();
        }
        chartInstance = new Chart(ctx, config);
    }

    // Set the initial value and create the chart
    let selectedYear = parseInt(yearSelect.value);
    getChart(selectedYear);

    // Event Listener when the year is changed
    yearSelect.addEventListener("change", function () {
        selectedYear = parseInt(this.value);
        getChart(selectedYear);
    });
});
