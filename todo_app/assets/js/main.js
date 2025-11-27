document.addEventListener("DOMContentLoaded", function () {

    const ctx = document.getElementById('statusChart');

    if (!ctx) return; 

    const pendentes = ctx.dataset.pendentes;
    const concluidas = ctx.dataset.concluidas;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pendentes', 'Concluídas'],
            datasets: [{
                data: [pendentes, concluidas],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
});
