import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    // Get Elements from Dom
    const tourStatistics = JSON.parse(
        document.querySelector('meta[name="tour_statistics"]').content
    );
    const ctx = document.getElementById("bestTourChart").getContext("2d");

    if (ctx && tourStatistics) {
        // Store data
        const tourTitles = tourStatistics.map(
            (statistic) => statistic.tour_title
        );

        const tourBookings = tourStatistics.map(
            (statistic) => statistic.total_bookings
        );

        const totalBookings = tourBookings.reduce((acc, val) => acc + val, 0);

        const bookingsPercentage = tourBookings
            .map((nrTourBooking) => (nrTourBooking / totalBookings) * 100)
            .sort((a, b) => b - a);

        // Get the max percntage of bookings
        const maxBookingsPercentage = Math.max(...bookingsPercentage);

        const bestToursTitles = tourStatistics
            .filter(
                (tour) =>
                    (tour.total_bookings / totalBookings) * 100 ===
                    maxBookingsPercentage
            )
            .map((tour) => tour.tour_title);

        // Function to set colors based on values
        function generateColorBasedOnValue(value) {
            if (value < maxBookingsPercentage * 0.25)
                return "rgba(67, 167, 167, 0.25)";
            if (value < maxBookingsPercentage * 0.5)
                return "rgba(67, 167, 167, 0.5)";
            if (value < maxBookingsPercentage * 0.75)
                return "rgba(67, 167, 167, 0.75)";

            return "rgb(67, 167, 167)";
        }

        // Get chart colors
        const colors = bookingsPercentage.map((percentage) =>
            generateColorBasedOnValue(percentage)
        );

        // Chart Setup
        const data = {
            labels: bestToursTitles,
            datasets: [
                {
                    data: bookingsPercentage, //  completed, remaining
                    backgroundColor: colors,
                    borderWidth: 0.5,
                    borderColor: "black",
                    borderRadius: 2,
                    hoverOffset: 10,
                },
            ],
        };

        // Text in chart function
        const chartText = {
            id: "chartText",
            beforeDatasetsDraw(chart) {
                const { ctx } = chart;

                const datasetMeta = chart.getDatasetMeta(0);

                if (!datasetMeta || datasetMeta.data.length === 0) {
                    return;
                }

                const xCenter = datasetMeta.data[0].x;
                const yCenter = datasetMeta.data[0].y;

                ctx.save();
                ctx.font = "italic 14px Arial";
                ctx.fillStyle = "rgb(0, 255, 255)";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                ctx.fillText("Best Tours", xCenter, yCenter - 50);

                ctx.save();
                ctx.font = "bold 40px Arial";
                ctx.fillStyle = "rgb(0, 255, 255)";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                ctx.fillText(`${maxBookingsPercentage} % `, xCenter, yCenter);

                ctx.save();
                ctx.font = "italic 14px Arial";
                ctx.fillStyle = "rgb(0, 255, 255)";
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                ctx.fillText("of all Bookings", xCenter, yCenter + 50);

                ctx.restore();
            },
        };

        // Chart Config
        const config = {
            type: "doughnut",
            data,
            options: {
                responsive: true,
                cutout: "60%", // To make the ring thinner
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            color: "white",
                            font: {
                                style: "italic",
                            },
                        },
                        display: true,
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function (tooltipItem) {
                                let index = tooltipItem.dataIndex;
                                let tourName = tourTitles[index];
                                // Obtain the percentage for each section
                                let percentage = tooltipItem.raw;
                                return `${tourName} ${percentage.toFixed()}%`;
                            },
                        },
                    },
                },
            },
            plugins: [chartText],
        };

        // Create chart
        new Chart(ctx, config);
    }
});
