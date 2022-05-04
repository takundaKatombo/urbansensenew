$(document).ready(function() {
    "use strict";
    var r=!0;
    $(window).outerWidth()<576&&(r=!1);
    var o=$("#lineCahrt"), e=(new Chart(o, {
        type:"line", options: {
            scales: {
                xAxes:[ {
                    display:!0, gridLines: {
                        display: !1
                    }
                }
                ], yAxes:[ {
                    display:!0, gridLines: {
                        display: !1
                    }
                }
                ]
            }
            , legend: {
                display: r
            }
        }
        , data: {
            labels:["1", "2", "3", "4", "5", "6", "7"], datasets:[ {
                label: "Booking (Last 7 days)", fill: !0, lineTension: 0, backgroundColor: "transparent", borderColor: "#f15765", pointBorderColor: "#da4c59", pointHoverBackgroundColor: "#da4c59", borderCapStyle: "butt", borderDash: [], borderDashOffset: 0, borderJoinStyle: "miter", borderWidth: 1, pointBackgroundColor: "#fff", pointBorderWidth: 1, pointHoverRadius: 5, pointHoverBorderColor: "#fff", pointHoverBorderWidth: 2, pointRadius: 1, pointHitRadius: 0, data: [seventh_day, sixth_day, fifth_day, fourth_day, third_day, second_day, first_day], spanGaps: !1
            }
            , {
                label: "Customer (Last 7 days)", fill: !0, lineTension: 0, backgroundColor: "transparent", borderColor: "#54e69d", pointHoverBackgroundColor: "#44c384", borderCapStyle: "butt", borderDash: [], borderDashOffset: 0, borderJoinStyle: "miter", borderWidth: 1, pointBorderColor: "#44c384", pointBackgroundColor: "#fff", pointBorderWidth: 1, pointHoverRadius: 5, pointHoverBorderColor: "#fff", pointHoverBorderWidth: 2, pointRadius: 1, pointHitRadius: 10, data: [seventh_day_customer, sixth_day_customer, fifth_day_customer, fourth_day_customer, third_day_customer, second_day_customer, first_day_customer], spanGaps: !1
            }
            ]
        }
    }
    ), $("#lineChart1")), a=(new Chart(e, {
        type:"line", options: {
            scales: {
                xAxes:[ {
                    display:!0, gridLines: {
                        display: !1
                    }
                }
                ], yAxes:[ {
                    ticks: {
                        max: 40, min: 0, stepSize: .5
                    }
                    , display:!1, gridLines: {
                        display: !1
                    }
                }
                ]
            }
            , legend: {
                display: !1
            }
        }
        , data: {
            labels:["A", "B", "C", "D", "E", "F", "G"], datasets:[ {
                label: "Total Overdue", fill: !0, lineTension: 0, backgroundColor: "transparent", borderColor: "#6ccef0", pointBorderColor: "#59c2e6", pointHoverBackgroundColor: "#59c2e6", borderCapStyle: "butt", borderDash: [], borderDashOffset: 0, borderJoinStyle: "miter", borderWidth: 3, pointBackgroundColor: "#59c2e6", pointBorderWidth: 0, pointHoverRadius: 4, pointHoverBorderColor: "#fff", pointHoverBorderWidth: 0, pointRadius: 4, pointHitRadius: 0, data: [20, 28, 30, 22, 24, 10, 7], spanGaps: !1
            }
            ]
        }
    }
    ), $("#pieChart")), t=(new Chart(a, {
        type:"doughnut", options: {
            cutoutPercentage:80, legend: {
                display: !1
            }
        }
        , data: {
            labels:["First", "Second", "Third", "Fourth"], datasets:[ {
                data: [300, 50, 100, 60], borderWidth: [0, 0, 0, 0], backgroundColor: ["#44b2d7", "#59c2e6", "#71d1f2", "#96e5ff"], hoverBackgroundColor: ["#44b2d7", "#59c2e6", "#71d1f2", "#96e5ff"]
            }
            ]
        }
    }
    ), $("#barChartHome"));
    new Chart(t, {
        type:"bar", options: {
            scales: {
                xAxes:[ {
                    display: !1
                }
                ], yAxes:[ {
                    display: !1
                }
                ]
            }
            , legend: {
                display: !1
            }
        }
        , data: {
            labels:["January", "February", "March", "April", "May", "June", "July", "August", "September", "November", "December"], datasets:[ {
                label: "Data Set 1", backgroundColor: ["rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)"], borderColor: ["rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)", "rgb(121, 106, 238)"], borderWidth: 1, data: [35, 49, 55, 68, 81, 95, 85, 40, 30, 27, 22, 15]
            }
            ]
        }
    }
    )
}

);