<template>
    <div>
        <div class="dashboard">
            <div class="chart">
                <canvas id="weight"></canvas>
            </div>
            <div class="command">
                <ul>
                    <li><a @click="onClickWeight">体重</a></li>
                    <li><a @click="onClickFat_Rate">体脂肪</a></li>
                    <li><a @click="onClickBMI">BMI</a></li>
                </ul>
                <ul>
                    <li><a @click="onClickDay">day</a></li>
                    <li><a @click="onClickWeek">week</a></li>
                    <li><a @click="onClickMonth">month</a></li>
                </ul>
                <ul>
                    <li><a @click="onClickInput">クイック入力</a></li>
                    <li><a href="/weight">詳細</a></li>
                </ul>
            </div>
        </div>
        <weight-input-dialog-component :show="showInputDialogContent" @update="invokeUpdateList"></weight-input-dialog-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showInputDialogContent: false,
            datetimeList: [],
            weightList: [],
            fat_rateList: [],
            bmiList: [],
            param: {},
            contents: {
                interval: 1,
            },
            graphNum: 1,
            dataset: {},
            datasetWeight: {
                yAxisID: 'weight',
                label: '体重(kg)',
                data: [],
                borderColor: "rgba(255,0,0,1)",
                backgroundColor: "rgba(0,0,0,0)"
            },
            datasetFat_Rate: {
                yAxisID: 'fat_rate',
                label: '体脂肪率(%)',
                data: [],
                borderColor: "rgba(0,255,0,1)",
                backgroundColor: "rgba(0,0,0,0)"
            },
            datasetBMI: {
                yAxisID: 'bmi',
                label: 'BMI',
                data: [],
                borderColor: "rgba(0,0,255,1)",
                backgroundColor: "rgba(0,0,0,0)"
            },
            yAxis: {},
            yAxisWeight: {
                id: 'weight',
                type: 'linear',
                position: 'left',
                ticks: {
                    suggestedMax: 120,
                    suggestedMin: 40,
                    stepsize: 10,
                    callback: function(value, index, values){
                        return value + 'kg';
                    }
                }
            },
            yAxisFaT_Rate: {
                id: 'fat_rate',
                type: 'linear',
                position: 'left',
                ticks: {
                    suggestedMax: 40,
                    suggestedMin: 0,
                    stepsize: 10,
                    callback: function(value, index, values){
                        return value + '%';
                    }
                }
            },
            yAxisBMI: {
                id: 'bmi',
                type: 'linear',
                position: 'left',
                ticks: {
                    suggestedMax: 40,
                    suggestedMin: 0,
                    stepsize: 10,
                    callback: function(value, index, values){
                        return value;
                    }
                }
            },
        };
    },
    created: function() {
    },
    mounted: function() {
        this.graphUpdate(this.graphNum);
    },
    methods: {
        onClickWeight: function() {
            this.graphNum = 1;
            this.graphUpdate(this.graphNum);
        },
        onClickFat_Rate: function() {
            this.graphNum = 2;
            this.graphUpdate(this.graphNum);
        },
        onClickBMI: function() {
            this.graphNum = 3;
            this.graphUpdate(this.graphNum);
        },
        onClickDay: function() {
            this.contents.interval = 1;
            this.graphUpdate(this.graphNum);
        },
        onClickWeek: function() {
            this.contents.interval = 7;
            this.graphUpdate(this.graphNum);
        },
        onClickMonth: function() {
            this.contents.interval = 30;
            this.graphUpdate(this.graphNum);
        },
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        invokeUpdateList: function() {
            this.graphUpdate(this.graphNum);
        },
        graphUpdate: function($id) {
            this.datetimeList = [];
            this.weightList = [];
            this.fat_rateList = [];
            this.bmiList = [];
            var ctx = document.getElementById("weight");
            var self = this;
            this.param.contents = this.contents
            axios.post('api/weight/graph', this.param).then(function(response){
                response.data.datas.forEach(element => {
                    self.datetimeList.push(element.datetime);
                    self.weightList.push(element.weight);
                    self.fat_rateList.push(element.fat_rate);
                    self.bmiList.push(element.bmi);
                });
                switch($id) {
                    case 1:
                        self.dataset = self.datasetWeight;
                        self.dataset.data = self.weightList;
                        self.yAxis = self.yAxisWeight;
                        break;
                    case 2:
                        self.dataset = self.datasetFat_Rate;
                        self.dataset.data = self.fat_rateList;
                        self.yAxis = self.yAxisFaT_Rate;
                        break;
                    case 3:
                        self.dataset = self.datasetBMI;
                        self.dataset.data = self.bmiList;
                        self.yAxis = self.yAxisBMI;
                        break;
                }
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: self.datetimeList,
                        datasets: [
                            self.dataset
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            text: '最近の記録',
                        },
                        elements: {
                            line: {
                                tension: 0,
                            }
                        },
                        scales: {
                            yAxes: [
                                self.yAxis
                            ]
                        }
                    }
                });
            }).catch(function(error){
            });
        }
    }
}
</script>