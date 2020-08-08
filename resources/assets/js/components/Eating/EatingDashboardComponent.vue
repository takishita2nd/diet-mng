<template>
    <div>
        <div class="dashboard">
            <div class="chart">
                <canvas id="eating"></canvas>
            </div>
            <div class="command">
                <ul>
                    <li><a @click="onClickPrev">prev</a></li>
                    <li><a @click="onClickNext">next</a></li>
                </ul>
                <ul>
                    <li><a @click="onClickInput">クイック入力</a></li>
                    <li><a href="/eating">詳細</a></li>
                </ul>
            </div>
        </div>
        <eating-input-dialog-component :show="showInputDialogContent" :date="todayDate" :datehold=true @update="invokeUpdateList"></eating-input-dialog-component>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showInputDialogContent: false,
            todayDate: "",
            //param: {},
            //contents: {
            //    interval: 1,
            //},
            //graphNum: 1,
            // dataset: {},
            // datasetWeight: {
            //     yAxisID: 'weight',
            //     label: '体重(kg)',
            //     data: [],
            //     borderColor: "rgba(255,0,0,1)",
            //     backgroundColor: "rgba(0,0,0,0)"
            // },
            // datasetFat_Rate: {
            //     yAxisID: 'fat_rate',
            //     label: '体脂肪率(%)',
            //     data: [],
            //     borderColor: "rgba(0,255,0,1)",
            //     backgroundColor: "rgba(0,0,0,0)"
            // },
            // datasetBMI: {
            //     yAxisID: 'bmi',
            //     label: 'BMI',
            //     data: [],
            //     borderColor: "rgba(0,0,255,1)",
            //     backgroundColor: "rgba(0,0,0,0)"
            // },
            // yAxis: {},
            // yAxisWeight: {
            //     id: 'weight',
            //     type: 'linear',
            //     position: 'left',
            //     ticks: {
            //         suggestedMax: 120,
            //         suggestedMin: 40,
            //         stepsize: 10,
            //         callback: function(value, index, values){
            //             return value + 'kg';
            //         }
            //     }
            // },
            // yAxisFaT_Rate: {
            //     id: 'fat_rate',
            //     type: 'linear',
            //     position: 'left',
            //     ticks: {
            //         suggestedMax: 40,
            //         suggestedMin: 0,
            //         stepsize: 10,
            //         callback: function(value, index, values){
            //             return value + '%';
            //         }
            //     }
            // },
            // yAxisBMI: {
            //     id: 'bmi',
            //     type: 'linear',
            //     position: 'left',
            //     ticks: {
            //         suggestedMax: 40,
            //         suggestedMin: 0,
            //         stepsize: 10,
            //         callback: function(value, index, values){
            //             return value;
            //         }
            //     }
            // },
        };
    },
    created: function() {
        var today = new Date();
        this.todayDate = today.getFullYear() + "-" + ('00'+(today.getMonth() + 1)).slice( -2 ) + "-" + ('00'+(today.getDate())).slice(-2);
    },
    mounted: function() {
        //this.graphUpdate(this.graphNum);
    },
    methods: {
        onClickNext: function() {
            //this.graphUpdate(this.graphNum);
        },
        onClickPrev: function() {
            //this.graphUpdate(this.graphNum);
        },
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        invokeUpdateList: function() {
            //this.graphUpdate(this.graphNum);
        },
        // graphUpdate: function($id) {
        //     var ctx = document.getElementById("weight");
        //     var self = this;
        //     this.param.contents = this.contents
        //     axios.post('api/weight/graph', this.param).then(function(response){
        //         var max = 0;
        //         var min = 1000;
        //         response.data.datas.forEach(element => {
        //             switch($id) {
        //                 case 1:
        //                     if(max < element.weight) {
        //                         max = element.weight;
        //                     }
        //                     if(min > element.weight) {
        //                         min = element.weight;
        //                     }
        //                     break;
        //                 case 2:
        //                     if(max < element.fat_rate) {
        //                         max = element.fat_rate;
        //                     }
        //                     if(min > element.fat_rate) {
        //                         min = element.fat_rate;
        //                     }
        //                     break;
        //                 case 3:
        //                     if(max < element.bmi) {
        //                         max = element.bmi;
        //                     }
        //                     if(min > element.bmi) {
        //                         min = element.bmi;
        //                     }
        //                     break;
        //             }
        //             self.datetimeList.push(element.datetime);
        //             self.weightList.push(element.weight);
        //             self.fat_rateList.push(element.fat_rate);
        //             self.bmiList.push(element.bmi);
        //         });
        //         switch($id) {
        //             case 1:
        //                 self.dataset = self.datasetWeight;
        //                 self.dataset.data = self.weightList;
        //                 self.yAxis = self.yAxisWeight;
        //                 break;
        //             case 2:
        //                 self.dataset = self.datasetFat_Rate;
        //                 self.dataset.data = self.fat_rateList;
        //                 self.yAxis = self.yAxisFaT_Rate;
        //                 break;
        //             case 3:
        //                 self.dataset = self.datasetBMI;
        //                 self.dataset.data = self.bmiList;
        //                 self.yAxis = self.yAxisBMI;
        //                 break;
        //         }
        //         self.yAxis.ticks.suggestedMax = max + 10;
        //         self.yAxis.ticks.suggestedMin = min - 10;
        //         var myChart = new Chart(ctx, {
        //             type: 'line',
        //             data: {
        //                 labels: self.datetimeList,
        //                 datasets: [
        //                     self.dataset
        //                 ]
        //             },
        //             options: {
        //                 title: {
        //                     display: true,
        //                     text: '最近の記録',
        //                 },
        //                 elements: {
        //                     line: {
        //                         tension: 0,
        //                     }
        //                 },
        //                 scales: {
        //                     yAxes: [
        //                         self.yAxis
        //                     ]
        //                 }
        //             }
        //         });
        //     }).catch(function(error){
        //     });
        // }
    }
}
</script>