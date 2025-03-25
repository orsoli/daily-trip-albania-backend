import Chart from "chart.js/auto";

const ctx = document.getElementById("myChart");

if (ctx) {
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                "Permet",
                "Blue Eye",
                "Saranda",
                "Gjirokaster",
                "Berat",
                "Boville",
                "Ksamil",
                "Porto romano",
                "Lucove",
                "Himare",
                "Pellumbas",
            ],
            datasets: [
                {
                    label: "Bookings",
                    data: [12, 19, 21, 5, 2, 3, 40, 100, 30, 13, 14],
                    borderRadius: 50,
                },
                {
                    label: "Views",
                    data: [12, 19, 21, 5, 2, 3, 40, 100, 30, 13, 30],
                    borderRadius: 50,
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
                        color: "rgba(255, 255, 255, 0.2)",
                        lineWidth: 0,
                    },
                    border: {
                        color: "rgba(255, 255, 255, 0.2)",
                    },
                },
                y: {
                    beginAtZero: true,
                    suggestedMax: 50,
                    ticks: {
                        color: "white",
                        stepSize: 5,
                    },
                    grid: {
                        color: "rgba(255, 255, 255, 0.2)",
                        lineWidth: 0,
                    },
                    border: {
                        color: "rgba(255, 255, 255, 0.2)",
                    },
                },
            },
            plugins: {
                legend: {
                    labels: {
                        color: "white",
                        font: {
                            size: 16,
                        },
                    },
                },
            },
        },
    });
}
