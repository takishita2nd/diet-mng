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
            param: {},
            contents: {
               date: "",
            },
            label: ['タンパク質', '脂質', '炭水化物', 'カロリー'],
            datasets: [],
            sub: 0,
        };
    },
    created: function() {
        this.todayDate = this.getDate(this.sub);
    },
    mounted: function() {
        this.graphUpdate();
    },
    methods: {
        getDate: function(sub) {
            var today = new Date();
            return today.getFullYear() + "-" + ('00'+(today.getMonth() + 1)).slice( -2 ) + "-" + ('00'+(today.getDate() + sub)).slice(-2);
        },
        onClickNext: function() {
            this.sub++;
            this.todayDate = this.getDate(this.sub);
            this.graphUpdate();
        },
        onClickPrev: function() {
            this.sub--;
            this.todayDate = this.getDate(this.sub);
            this.graphUpdate();
        },
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        invokeUpdateList: function() {
            this.graphUpdate();
        },
        graphUpdate: function() {
            var ctx = document.getElementById("eating");
            var self = this;
            this.contents.date = this.todayDate;
            this.param.contents = this.contents;
            this.datasets = [];
            axios.post('api/eating/graph', this.param).then(function(response){
                if(response.data.data != null) {
                    self.datasets.push(response.data.data.protein);
                    self.datasets.push(response.data.data.liqid);
                    self.datasets.push(response.data.data.carbo);
                    self.datasets.push(response.data.data.calorie);
                    var myChart = new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: self.label,
                            datasets: [{
                                label: self.todayDate,
                                data: self.datasets,
                                backgroundColor: 'RGBA(225,95,150, 0.5)',
                                borderColor: 'RGBA(225,95,150, 1)',
                                borderWidth: 1,
                                pointBackgroundColor: 'RGB(46,106,177)'
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: '摂取栄養素'
                            },
                            scale:{
                                ticks:{
                                    suggestedMin: 0,
                                    suggestedMax: 100,
                                }
                            }
                        }
                    });
                } else {
                    var myChart = new Chart(ctx, {
                        type: 'radar',
                        data: {
                            labels: self.label,
                            datasets: [
                            ]
                        },
                    });
                }
            }).catch(function(error){
            });
        }
    }
}
</script>