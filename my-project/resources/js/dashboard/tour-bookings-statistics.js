import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    // Get Elements from Dom
    const tourStatistics = JSON.parse(
        document.querySelector('meta[name="tour_statistics"]').content
    );
    const ctx = document.getElementById("tourBookingsChart");

    if (ctx && tourStatistics) {
        // Store data
        const tourTitles = tourStatistics.map(
            (statistic) => statistic.tour_title
        );
        const tourBookings = tourStatistics.map(
            (statistic) => statistic.total_bookings
        );

        const totalBookings = tourBookings.reduce((acc, val) => acc + val, 0);

        new Chart(ctx, {
            type: "line",
            data: {
                labels: tourTitles,
                datasets: [
                    {
                        label: ["Tot. Bookings"],
                        data: tourBookings,
                        borderRadius: 30,
                        borderColor: "rgb(75, 192, 192)",
                        backgroundColor: "rgba(75, 192, 192, 0.3)",
                        fill: true,
                        hoverBorderWidth: 4,
                    },
                ],
            },
            options: {
                scales: {
                    x: {
                        ticks: {
                            color: "white",
                        },
                        grid: {
                            color: "rgba(75, 192, 192, 0.3)",
                            lineWidth: 0,
                        },
                        border: {
                            color: "rgba(255, 255, 255, 0.2)",
                        },
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: totalBookings,
                        ticks: {
                            color: "white",
                            stepSize: 1,
                        },
                        grid: {
                            color: "rgba(75, 192, 192, 0.2)",
                            lineWidth: 0,
                        },
                        border: {
                            color: "rgba(255, 255, 255, 0.2)",
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
                            font: {
                                style: "italic",
                            },
                        },
                    },
                },
            },
        });
    }
});
