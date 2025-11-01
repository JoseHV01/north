document.addEventListener('DOMContentLoaded', function(){
    example();
    distributionTransaction();

    let nameMonth;
    const columns = document.querySelectorAll('#column');
    const metaToken= document.getElementsByName('csrf-token')[0].content;
    const headers = {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': metaToken
        }
    };
    const urlList = [
        {
            id: 0,
            url: "/sales/month"
        },
        {
            id: 1,
            url: "/shoppping/month"
        },
        {
            id: 2,
            url: "/distribution/transaction"
        },
    ];
    const informationChartList = [
        {
            id: 'chart_sale_month',
            type: 'bar',
            legend: 'Ventas por mes',
            label: 'Ventas',
            labels: [],
            values: [],
            backgrounds: ['rgb(54, 162, 235)']
        },
        {
            id: 'chart_shopping_month',
            type: 'bar',
            legend: 'Compras por mes',
            label: 'Compras',
            labels: [],
            values: [],
            backgrounds: ['rgb(255, 99, 132)']
        },
        // {
        //     id: 'chart_distribution_transaction',
        //     type: 'doughnut',
        //     legend: 'Distribucion transacciones',
        //     label: 'Transacciones',
        //     labels: [],
        //     values: [],
        //     backgrounds: ['rgb(75, 192, 192)', 'rgb(54, 162, 235)', 'rgb(153, 102, 155)', 'rgb(255, 205, 86)', 'rgb(255, 159, 64)', 'rgb(201, 203, 207)']
        // }
    ];

    generateQuery();

    function generateQuery() {
        urlList.forEach(item => {
            fetch(`reports${item.url}`, headers).then(response => {
                if (response.ok)
                return response.json()
                else
                throw new Error(response.status);
            }).then(data => {
                data.forEach(element => {
                    if(element.month) traslateMonth(element.month);

                    informationChartList[item.id].labels.push(element.month ? nameMonth : element.name);
                    informationChartList[item.id].values.push(element.total);
                });

                createChart(informationChartList[item.id]);
            }).catch(err => {
                console.error("ERROR: ", err.message);
            });
        });
    }

    function createChart(data){
        if(data.type == 'bar'){
            calculateNumberColumns(data.labels.length);
        }

        let chartCreated = new Chart(document.querySelector(`#${data.id}`), {
            type: data.type,
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: data.label,
                        data: data.values,
                        backgroundColor: data.type == 'bar' ? data.backgrounds[0] : data.backgrounds,
                        borderWidth: 1,
                        hoverOffset: 4
                    }
                ]
            },
            options: settingsChart(data.legend)
        });

        if(chartCreated) {
            document.getElementById(`loader_${data.id}`).classList.add('d-none');
            document.getElementById(`${data.id}`).classList.remove('d-none');
        }
    }

    function settingsChart(titulo){
        return {
            plugins: {
                title:{
                    display: true,
                    text: `${titulo}`,
                    padding: {
                        top: 12,
                        bottom: 30
                    },
                    font: {
                        size: 20
                    }
                },
                legend:{
                    labels:{
                        font:{
                            size: 16
                        }
                    }
                }
            }
        }
    }

    function calculateNumberColumns(quantityMonth) {
        if(quantityMonth > 3){
            columns.forEach(item => {
                item.classList.remove('col-md-6');
                item.classList.add('col-12');
            });
        }
    }

    function traslateMonth(month){
        const nameMonths = [
            {
                original: 'January',
                traslate: 'Enero'
            },
            {
                original: 'February',
                traslate: 'Febrero'
            },
            {
                original: 'March',
                traslate: 'Marzo'
            },
            {
                original: 'April',
                traslate: 'Abril'
            },
            {
                original: 'May',
                traslate: 'Mayo'
            },
            {
                original: 'June',
                traslate: 'Junio'
            },
            {
                original: 'July',
                traslate: 'Julio'
            },
            {
                original: 'August',
                traslate: 'Agosto'
            },
            {
                original: 'September',
                traslate: 'Septiembre'
            },
            {
                original: 'October',
                traslate: 'Octubre'
            },
            {
                original: 'November',
                traslate: 'Noviembre'
            },
            {
                original: 'December',
                traslate: 'Diciembre'
            }
        ];

        nameMonths.forEach(item => { if (item.original == month) nameMonth = item.traslate; });
    }
});

function example() {
    console.log('funcionando');
    new Chart(document.querySelector("#chart_example"), {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero'],
            datasets: [{
                label: 'Compras',
                data: [10, 20],
                backgroundColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
                hoverOffset: 4
            },{
                label: 'Ventas',
                data: [8, 31],
                backgroundColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: settings('')
    });
}

function distributionTransaction() {
    new Chart(document.querySelector("#chart_distribution_transaction"), {
        type: 'bar',
        data: {
            labels: ['Febrero'],
            datasets: [{
                label: 'Biopago',
                data: [10],
                backgroundColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
                hoverOffset: 4
            },{
                label: 'Pago Movil',
                data: [5],
                backgroundColor: 'rgb(255, 159, 64)',
                borderWidth: 1,
                hoverOffset: 4
            },{
                label: 'Divisas',
                data: [2],
                backgroundColor: 'rgb(153, 102, 155)',
                borderWidth: 1,
                hoverOffset: 4
            },{
                label: 'Transferencia',
                data: [14],
                backgroundColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                hoverOffset: 4
            },{
                label: 'Divisas',
                data: [12],
                backgroundColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: settings('')
    });
}

function settings(titulo){
    return {
        plugins: {
            title:{
                display: true,
                text: `${titulo}`,
                padding: {
                    top: 12,
                    bottom: 30
                },
                font: {
                    size: 20
                }
            },
            legend:{
                labels:{
                    font:{
                        size: 16
                    }
                }
            }
        }
    }
}
