const metaToken= document.getElementsByName('csrf-token')[0].content;
const headers = {
    method: "POST",
    headers: {
        'X-CSRF-TOKEN': metaToken
    }
};

const bodyTable = document.querySelectorAll('#bodyTable');

function searchProducts() {
    fetch(`reports/date/${item.url}`, headers).then(response => {
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
}
