<template>
    <div>
        <div>
            <p id="navi">> <a href="/home">HOME</a> / <a href="/eating">食事管理</a></p>
            <p id="inputbutton">
                <button @click="onClickInput">データ入力</button>
            </p>
            <p>{{date}}</p>
            <table class="eatingdetail">
                <caption>朝</caption>
                <tbody>
                    <tr>
                        <th class="item">品名</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                        <th class="edit"></th>
                    </tr>
                    <tr v-for="data in datalists[0]">
                        <td class="item">{{ data.item}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                        <td class="edit"><a @click="onClickEdit(data.date)">Edit</a></td>
                    </tr>
                </tbody>
            </table>
            <table class="eatingdetail">
                <caption>昼</caption>
                <tbody>
                    <tr>
                        <th class="item">品名</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                        <th class="edit"></th>
                    </tr>
                    <tr v-for="data in datalists[1]">
                        <td class="item">{{ data.item}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                        <td class="edit"><a @click="onClickEdit(data.date)">Edit</a></td>
                    </tr>
                </tbody>
            </table>
            <table class="eatingdetail">
                <caption>夜</caption>
                <tbody>
                    <tr>
                        <th class="item">品名</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                        <th class="edit"></th>
                    </tr>
                    <tr v-for="data in datalists[2]">
                        <td class="item">{{ data.item}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                        <td class="edit"><a @click="onClickEdit(data.date)">Edit</a></td>
                    </tr>
                </tbody>
            </table>
            <table class="eatingdetail">
                <caption>間食</caption>
                <tbody>
                    <tr>
                        <th class="item">品名</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                        <th class="edit"></th>
                    </tr>
                    <tr v-for="data in datalists[3]">
                        <td class="item">{{ data.item}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                        <td class="edit"><a @click="onClickEdit(data.date)">Edit</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <eating-input-dialog-component :show="showInputDialogContent" :date="date" :datehold=false @update="invokeUpdateList"></eating-input-dialog-component>
    </div>
</template>

<script>
export default {
    props: {
        date: String
    },
    data() {
        return {
            showInputDialogContent: false,
            showEditDialogContent: false,
            showDeleteDialogContent: false,
            datalists: [],
            param: {},
            contents: {
                date: "",
            },
        };
    },
    created: function() {
        this.updateList();
    },
    methods: {
        onClickInput: function() {
            this.showInputDialogContent = true;
        },
        onClickEdit: function(date) {
            // var editData = {};
            // this.datalists.forEach(element => {
            //     if(element.id == id){
            //         editData.id = id;
            //         editData.weight = element.weight;
            //         editData.fat_rate = element.fat_rate;
            //         editData.bmi = element.bmi;
            //         return true;
            //     }
            // });
            // this.$refs.editDialog.dataSet(editData);
            // this.showEditDialogContent = true;
        },
        invokeUpdateList: function() {
            this.updateList();
        },
        updateList: function() {
            this.datalists = [];
            this.contents.date = this.date;
            this.param.contents = this.contents;
            var self = this;
            axios.post('/api/eating/detail', this.param).then(function(response){
                response.data.dataLists.forEach(element => {
                    var data = [];
                    element.forEach(element2 => {
                        data.push({
                            item: element2.item,
                            protein: element2.protein,
                            liqid: element2.liqid,
                            carbo: element2.carbo,
                            calorie: element2.calorie
                        })
                    })
                    self.datalists.push(data);
                });
            }).catch(function(error){
            });
        }
    }
}
</script>
