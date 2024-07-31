import {searchParams, setURL} from "../components/set-url-query.js";
import {lang} from "../../common/global.js";
import {showErrorMessage} from "../../common/modals.js";

const dashboardPage = document.querySelector('#dashboardPage');
let chartOptions, annotationOptions, charts;


export default function init() {
    if (dashboardPage) {
        charts = [
            {
                container: '#salesAmountChart',
                data: 'salesAmount',
                color: '#bb9bf1',
                decimal: 2,
            },
            {
                container: '#ordersCountChart',
                data: 'ordersCount',
                color: '#9a98f1',
                decimal: 0,
            },
            {
                container: '#skusAddedCountChart',
                data: 'skusAddedCount',
                color: '#9baff1',
                decimal: 0,
            },
            {
                container: '#registeredUsersCountChart',
                data: 'registeredUsersCount',
                color: '#abe7da',
                decimal: 0,
            },
            {
                container: '#reviewsAddedCountChart',
                data: 'reviewsAddedCount',
                color: '#a3d2ea',
                decimal: 0,
            },
        ];


        chartOptions = {
            bars: 'vertical',
            legend: { position: 'none' },
            chartArea: {
                top: 10,
                left: 50,
                width: '90%',
                height: '80%',
            },
            hAxis: {
                maxTextLines: 1,
                gridlines: {
                    color: '#e7e7e7',
                },
                textStyle: {
                    color: '#8c8c8c',
                },
            },
            vAxis: {
                textStyle: {
                    color: '#8c8c8c',
                },
                format: 'short',
            },
            fontSize: 11,
        };

        annotationOptions = {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        };

        const queryKeys = {
            period: 'period',
            category: 'category',
            currency: 'currency',
        };


        const dashboardPeriod = document.querySelector('#dashboardPeriod');
        dashboardPeriod.addEventListener('change', () => {
            setUrlQuery(queryKeys.period, dashboardPeriod.value);
            getDashboard();
        });

        const dashboardCategory = document.querySelector('#dashboardCategory');
        dashboardCategory.addEventListener('change', () => {
            setUrlQuery(queryKeys.category, dashboardCategory.value);
            getDashboard();
        });

        const dashboardCurrency = document.querySelector('#dashboardCurrency');
        dashboardCurrency.addEventListener('change', () => {
            setUrlQuery(queryKeys.currency, dashboardCurrency.value);
            getDashboard();
        });

        const resetFiltersBtn = document.querySelector('#resetFiltersBtn');
        resetFiltersBtn.addEventListener('click', () => {
            dashboardPeriod.value = '';
            dashboardCategory.value = '';
            dashboardCurrency.value = '';
            for (const key in queryKeys) searchParams.delete(key);
            getDashboard();
        });


        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawAllCharts);
    }
}


function drawAllCharts() {
    charts.forEach(chart => {
        const chartCont = document.querySelector(chart.container);
        if (chartCont) {
            drawChart(chartCont, chartsData[chart.data], chart.color);
            countTotal(chartsData[chart.data], chartCont, lang, chart.decimal);
        }
    });
}


function drawChart(cont, dataArray, color) {
    const data = google.visualization.arrayToDataTable(dataArray);

    const view = new google.visualization.DataView(data);
    view.setColumns([0, 1, annotationOptions]);

    const chart = new google.visualization.ColumnChart(cont);

    chartOptions.colors = [color];
    chart.draw(view, chartOptions);
}


function countTotal(data, chartCont, locale, decimals = 0) {
    let sum = 0;
    data.forEach((month, index) => {
        if (index) sum += month[1];
    });
    sum = decimals ? parseFloat(sum.toFixed(decimals)) : parseInt(sum, 10);

    chartCont.closest('.dashboard-chart_item').querySelector('[data-role="total"]').innerText = `(${sum.toLocaleString(locale)})`;
}


function setUrlQuery(key, value) {
    if (value) {
        searchParams.set(key, value);

    } else if (searchParams.has(key)) {
        searchParams.delete(key);
    }
}


function getDashboard() {
    showPreloaders();

    fetch(`/${lang}/admin/dashboard/charts?${searchParams}`, {
        method: 'get',
        headers: {
            'Accept': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            const error = new Error();
            error.status = response.status;
            error.statusText = response.statusText;
            throw error;
        }
        return response.json();
    })
    .then(result => {
        chartsData = result;

        drawAllCharts();
        setSalesAmountCurrencySymbol();
        setURL();
        hidePreloaders();
    })
    .catch(err => showErrorMessage(err));
}


function setSalesAmountCurrencySymbol() {
    const salesAmountCurrencyCont = document.querySelector('#salesAmountCurrency');
    salesAmountCurrencyCont.innerHTML = document.querySelector('#dashboardCurrency').selectedOptions[0].dataset.symbol;
}


function showPreloaders() {
    const preloaderConts = document.querySelectorAll('.dashboard-chart_preloader-cont');
    preloaderConts.forEach(cont => {
        cont.classList.remove('hidden');
    });
}

function hidePreloaders() {
    const preloaderConts = document.querySelectorAll('.dashboard-chart_preloader-cont');
    preloaderConts.forEach(cont => {
        cont.classList.add('hidden');
    });
}