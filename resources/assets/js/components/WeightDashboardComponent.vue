<template>
    <div>
        <div class="dashboard">
            <div class="chart">
                <canvas id="weight"></canvas>
            </div>
            <div class="command">
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
        };
    },
    created: function() {
    },
    mounted: function() {
        this.graphUpdate();
    },
    methods: {
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        invokeUpdateList: function() {
            this.graphUpdate();
        },
        graphUpdate: function() {
            this.datetimeList = [];
            this.weightList = [];
            this.fat_rateList = [];
            this.bmiList = [];
            var ctx = document.getElementById("weight");
            var self = this;
            axios.post('api/weight/graph').then(function(response){
                response.data.datas.forEach(element => {
                    self.datetimeList.push(element.datetime);
                    self.weightList.push(element.weight);
                    self.fat_rateList.push(element.fat_rate);
                    self.bmiList.push(element.bmi);
                });
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: self.datetimeList,
                        datasets: [
                            {
                                yAxisID: 'weight',
                                label: '体重(kg)',
                                data: self.weightList,
                                borderColor: "rgba(255,0,0,1)",
                                backgroundColor: "rgba(0,0,0,0)"
                            },
                            {
                                yAxisID: 'fat_rate',
                                label: '体脂肪率(%)',
                                data: self.fat_rateList,
                                borderColor: "rgba(0,255,0,1)",
                                backgroundColor: "rgba(0,0,0,0)"
                            },
                            {
                                yAxisID: 'bmi',
                                label: 'BMI',
                                data: self.bmiList,
                                borderColor: "rgba(0,0,255,1)",
                                backgroundColor: "rgba(0,0,0,0)"
                            },
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
                                {
                                    id: 'weight',
                                    type: 'linear',
                                    position: 'left',
                                    ticks: {
                                        suggestedMax: 100,
                                        suggestedMin: 0,
                                        stepsize: 10,
                                        callback: function(value, index, values){
                                            return value + 'kg';
                                        }
                                    }
                                },
                                {
                                    id: 'fat_rate',
                                    type: 'linear',
                                    position: 'right',
                                    ticks: {
                                        suggestedMax: 100,
                                        suggestedMin: 0,
                                        stepsize: 10,
                                        callback: function(value, index, values){
                                            return value + '%';
                                        }
                                    }
                                },
                                {
                                    id: 'bmi',
                                    type: 'linear',
                                    position: 'left',
                                    ticks: {
                                        suggestedMax: 100,
                                        suggestedMin: 0,
                                        stepsize: 10,
                                        callback: function(value, index, values){
                                            return value;
                                        }
                                    }
                                },
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