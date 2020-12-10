<template>
    <div>
        <div>
            <p id="navi"> <a href="/home">HOME</a></p>
            <p id="inputbutton">
                <button @click="onClickSubmit">選択したデータを登録</button>
            </p>
            <table class="eatinghistory">
                <tbody>
                    <tr>
                        <th class="check">
                            <input type="checkbox" v-model="all" @click="onAllCheck" />
                        </th>
                        <th class="date">日時</th>
                        <th class="item">アイテム</th>
                        <th class="protein">タンパク質</th>
                        <th class="liqid">脂質</th>
                        <th class="carbo">炭水化物</th>
                        <th class="calorie">カロリー</th>
                    </tr>
                    <tr v-for="data in datalists">
                        <td class="check">
                            <input type="checkbox" v-model="data.check" />
                        </td>
                        <td class="date">{{ data.date}}</td>
                        <td class="item">{{ data.item}}</td>
                        <td class="protein">{{ data.protein}}</td>
                        <td class="liqid">{{ data.liqid}}</td>
                        <td class="carbo">{{ data.carbo}}</td>
                        <td class="calorie">{{ data.calorie}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            datalists: [],
            param: {},
            contents: {
                page: "",
            },
            ids: [],
            all: false,
        };
    },
    created: function() {
        this.updateList();
    },
    methods: {
        updateList: function() {
            var self = this;
            self.datalists = [];
            self.param.contents = self.contents;
            axios.post('/api/eating/history', self.param).then(function(response){
                response.data.dataLists.forEach(element => {
                    self.datalists.push({
                        id: element.id,
                        check: false,
                        date: element.created_at,
                        item: element.item,
                        protein: element.protein,
                        liqid: element.liqid,
                        carbo: element.carbo,
                        calorie: element.calorie
                    })
                });
            }).catch(function(error){
            });
        },
        onClickSubmit: function() {
            var self = this;
            this.datalists.forEach(element => {
                if(element.check == true){
                    this.ids.push(element.id);
                }
            });
            this.param.contents = this.ids;
            axios.post('/api/eating/regist', this.param).then(function(response){
                self.updateList();
            }).catch(function(error){
            });
        },
        onAllCheck: function() {
            if(this.all == false) {
                this.datalists.forEach(element => {
                    element.check = true;
                });
            }else{
                this.datalists.forEach(element => {
                    element.check = false;
                });
            }
        }
    }
}
</script>