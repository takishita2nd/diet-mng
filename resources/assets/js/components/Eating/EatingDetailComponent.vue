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
                        <td class="edit"><a @click="onClickEdit(0, data.id)">Edit</a></td>
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
                        <td class="edit"><a @click="onClickEdit(1, data.id)">Edit</a></td>
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
                        <td class="edit"><a @click="onClickEdit(2, data.id)">Edit</a></td>
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
                        <td class="edit"><a @click="onClickEdit(3, data.id)">Edit</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <eating-input-dialog-component :show="showInputDialogContent" :date="date" :datehold=false @update="invokeUpdateList"></eating-input-dialog-component>
        <eating-edit-dialog-component ref="editDialog" :show="showEditDialogContent" :date="date" :datehold=true @update="invokeUpdateList"></eating-edit-dialog-component>
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
            editid: "",
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
        onClickEdit: function(timezone, id) {
            var editData = {};
            this.datalists[timezone].forEach(element => {
                if(element.id == id){
                    editData.id = id;
                    editData.date = this.date;
                    editData.item = element.item;
                    editData.timezone = timezone + 1;
                    editData.protein = element.protein;
                    editData.liqid = element.liqid;
                    editData.carbo = element.carbo;
                    editData.calorie = element.calorie;
                    return true;
                }
            });
            this.$refs.editDialog.dataSet(editData);
            this.showEditDialogContent = true;
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
                for(var timezone = 0; timezone < 4; timezone++) {
                    if(response.data.dataLists[timezone]) {
                        var data = [];
                        response.data.dataLists[timezone].forEach(element => {
                            data.push({
                                id: element.id,
                                item: element.item,
                                protein: element.protein,
                                liqid: element.liqid,
                                carbo: element.carbo,
                                calorie: element.calorie
                            })
                        });
                        self.datalists.push(data);
                    }else{
                        var data = [];
                        self.datalists.push(data);
                    }
                }
            }).catch(function(error){
            });
        }
    }
}
</script>
