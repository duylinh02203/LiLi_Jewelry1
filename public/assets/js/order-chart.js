document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('orderStatusChart');
    const ctx = canvas.getContext('2d');
    const labels = JSON.parse(canvas.dataset.labels);
    const data = JSON.parse(canvas.dataset.data);

    const total = data.reduce((sum, val) => sum + val, 0);

    const orderStatusChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: {
                    display: true,
                    text: 'Thống kê trạng thái đơn hàng'
                },
                tooltip: { enabled: true },
                datalabels: false,
                centerText: {
                    display: true,
                    text: `${total}`
                }
            }
        },
        plugins: [{
            id: 'centerText',
            beforeDraw: function (chart) {
                if (chart.config.options.plugins.centerText.display !== true) return;

                const width = chart.width;
                const height = chart.height;
                const ctx = chart.ctx;
                ctx.restore();

                const fontSize = (height / 100).toFixed(2);
                ctx.font = `${fontSize}em sans-serif`;
                ctx.textBaseline = 'middle';

                const text = chart.config.options.plugins.centerText.text;
                const textX = Math.round((width - ctx.measureText(text).width) / 2);
                const textY = height / 2;

                ctx.fillStyle = '#fff';
                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    });
});

// document.addEventListener('DOMContentLoaded', function () {
//     const ctx = document.getElementById('completedOrdersChart').getContext('2d');
//     const labels = JSON.parse(document.getElementById('completedOrdersChart').dataset.labels);
//     const data = JSON.parse(document.getElementById('completedOrdersChart').dataset.data);

//     new Chart(ctx, {
//         type: 'bar',
//         data: {
//             labels: labels,
//             datasets: [{
//                 label: 'Số đơn đã giao',
//                 data: data,
//                 backgroundColor: '#28a745'
//             }]
//         },
//         options: {
//             responsive: true,
//             plugins: {
//                 title: {
//                     display: true,
//                     text: 'Thống kê đơn hàng đã giao theo ngày'
//                 },
//                 legend: {
//                     display: false
//                 }
//             },
//             scales: {
//                 x: { title: { display: true, text: 'Ngày' } },
//                 y: { title: { display: true, text: 'Số đơn hàng' }, beginAtZero: true }
//             }
//         }
//     });
// });
