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
        console.log(maxBookingsPercentage);

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

        const colors = bookingsPercentage.map((percentage) =>
            generateColorBasedOnValue(percentage)
        );

        new Chart(ctx, {
            type: "doughnut",
            data: {
                datasets: [
                    {
                        label: "Best Tour",
                        data: bookingsPercentage, // 70% completed, 30% remaining
                        backgroundColor: colors,
                        borderWidth: 0.5,
                        borderColor: "black",
                        borderRadius: 2,
                        hoverOffset: 10,
                    },
                ],
            },
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
        });
    }
});
